<?php

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
}


function au_subgroups_river_permissions($hook, $type, $return, $params) {
  $group = get_entity($return['object_guid']);
  
  $parent = au_subgroups_get_parent_group($group);
  
  if ($parent) {
    // it is a group, and it has a parent
    $return['access_id'] = $parent->group_acl;
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

