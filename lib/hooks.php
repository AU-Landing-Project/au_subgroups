<?php

/*
 * Called when a group is attempting to be deleted
 * Check if there are subgroups and sort out what happens them and content
 */
function au_subgroups_delete_group($hook, $type, $return, $params) {
  $guid = get_input('guid');
  if (!$guid) {
    $guid = get_input('group_guid');
  }
  
  $group = get_entity($guid);
  
  if (elgg_instanceof($group, 'group')) {
    // determine if the group has any child groups
    $child = au_subgroups_get_subgroups($group, 1);
    $parent = au_subgroups_get_parent_group($group);
    
    if ($child || $parent) {
      // here we are, we're deleting something with subgroups or a parent
      // if we've already sorted out what happens to content
      // we'll have a special input
      $content_policy = get_input('au_subgroups_content_policy', false);
      
      if (!$content_policy) {
        forward(elgg_get_site_url() . "groups/subgroups/delete/{$group->guid}");
      }

      // this is the top level to delete, so if transferring content to parent, it's the parent of this
      // apply content policy recursively, then delete all subgroups recursively
      // this could take a while...
      set_time_limit(0);
      $guids = au_subgroups_get_all_children_guids($group);
      
      if (is_array($guids) && count($guids)) {
        if ($content_policy != 'delete' && is_array($guids) && count($guids)) {
          $options = array(
            'container_guids' => $guids,
            'au_subgroups_content_policy' => $content_policy,
            'au_subgroups_parent_guid' => $parent->guid,
            'limit' => 0
          );
      
          $batch = new ElggBatch('elgg_get_entities', $options, 'au_subgroups_move_content', 25);
        }

        // now delete the groups themselves
        $options = array(
            'guids' => $guids,
            'types' => array('group'),
            'limit' => 0
        );
        $batch = new ElggBatch('elgg_get_entities', $options, 'au_subgroups_delete_entities', 25, false);
      }
    }
  }
}


function au_subgroups_group_canedit($hook, $type, $return, $params) {
  $group = $params['entity'];
  $user = $params['entity'];
  
  $parent = au_subgroups_get_parent_group($group);
  
  if ($parent) {
    if ($parent->canEdit($user->guid)) {
      return true;
    }
  }
}


/**
 * prevent users from being invited to subgroups they can't join
 */
function au_subgroups_group_invite($hook, $type, $return, $params) {
  $user_guid = get_input('user_guid');
  $group_guid = get_input('group_guid');
  $group = get_entity($group_guid);
  
  $parent = au_subgroups_get_parent_group($group);
  
  // if $parent, then this is a subgroup they're being invited to
  // make sure they're a member of the parent
  if ($parent) {
    if (!is_array($user_guid)) {
      $user_guid = array($user_guid);
    }
  
    $invalid_users = array();
    foreach($user_guid as $guid) {
      $user = get_user($guid);
      if ($user && !$parent->isMember($user)) {
        $invalid_users[] = $user;
      }
    }
    
    if (count($invalid_users)) {
      $error_suffix = "<ul>";
      foreach($invalid_users as $user) {
        $error_suffix .= "<li>{$user->name}</li>";
      }
      $error_suffix .= "</ul>";
      
      register_error(elgg_echo('au_subgroups:error:invite') . $error_suffix);
      return false;
    }
  }
}

/**
 * re/routes some urls that go through the groups handler
 */
function au_subgroups_groups_router($hook, $type, $return, $params) {
  au_subgroups_breadcrumb_override($return);
  
  // subgroup options
  if ($return['segments'][0] == 'subgroups') {
    
    switch ($return['segments'][1]) {
      case 'add':
        elgg_set_context('groups');
        set_input('au_subgroup', true);
        set_input('au_subgroup_parent_guid', $return['segments'][2]);
        elgg_set_page_owner_guid($return['segments'][2]);
        if (include(elgg_get_plugins_path() . 'au_subgroups/pages/add.php')) {
          return true;
        }
        break;
        
      case 'delete':
        elgg_set_context('groups');
        elgg_set_page_owner_guid($return['segments'][2]);
        if (include(elgg_get_plugins_path() . 'au_subgroups/pages/delete.php')) {
          return true;
        }
        break;
    }
    
    
    // assume that we're listing
    $group = get_entity($return['segments'][1]);
    
    if (elgg_instanceof($group, 'group')) {
      elgg_set_context('groups');
      elgg_set_page_owner_guid($group->guid);
      
      if (include(elgg_get_plugins_path() . 'au_subgroups/pages/list.php')) {
        return true;
      }
    }
  }
  
  // need to redo closed/open tabs provided by group_tools - if it's installed
  if ($return['segments'][0] == 'all' && elgg_is_active_plugin('group_tools')) {
    $filter = get_input('filter', false);
    
    if(empty($filter) && ($default_filter = elgg_get_plugin_setting("group_listing", "group_tools"))){
			$filter = $default_filter;
			set_input("filter", $default_filter);
		}
    
    if(in_array($filter, array("open", "closed", "alpha"))){
      au_subgroups_handle_openclosed_tabs();
      return true;
		}
  }
}


function au_subgroups_river_permissions($hook, $type, $return, $params) {
  $group = get_entity($return['object_guid']);
  
  $parent = au_subgroups_get_parent_group($group);
  
  if ($parent) {
    // it is a group, and it has a parent
    $return['access_id'] = $group->access_id;
  }
  
  return $return;
}

/**
 * Add a menu item to an ownerblock
 */
function au_subgroups_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
    // sections ordered alphabetically, we want ours last
    $section = 'z-au_subgroups';
    
    // link to subgroups page
    if ($params['entity']->subgroups_enable != "no") {
      $url = "groups/subgroups/{$params['entity']->guid}/all";
      $item = new ElggMenuItem('au_subgroups', elgg_echo('au_subgroups:subgroups'), $url);
      $item->setSection($section);
      $return[] = $item;
    }
    
    // link to parent group page
    if ($parent = au_subgroups_get_parent_group($params['entity'])) {
      $item = new ElggMenuItem('au_subgroups_parent', elgg_echo('au_subgroups:parent'), $parent->getURL());
      $item->setSection($section);
      $return[] = $item;
    }
	}

	return $return;
}

