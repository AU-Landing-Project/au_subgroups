<?php

// formats a replacement array of breadcrumbs
// note that the array is built backwards due to the recursive
// getting of parents
function au_subgroups_breadcrumb_override($params) {
  switch ($params['segments'][0]) {
    case 'profile':
      $group = get_entity($params['segments'][1]);
      
      $breadcrumbs[] = array('title' => elgg_echo('groups'), 'link' => elgg_get_site_url() . 'groups/all');
      $parentcrumbs = au_subgroups_parent_breadcrumbs($group, false);
      
      foreach ($parentcrumbs as $parentcrumb) {
        $breadcrumbs[] = $parentcrumb;
      }
      
      $breadcrumbs[] = array(
          'title' => $group->name,
          'link' => NULL
      );
      
      set_input('au_subgroups_breadcrumbs', $breadcrumbs);
      break;
      
    case 'edit':
      $group = get_entity($params['segments'][1]);
      
      $breadcrumbs[] = array('title' => elgg_echo('groups'), 'link' => elgg_get_site_url() . 'groups/all');
      $parentcrumbs = au_subgroups_parent_breadcrumbs($group, false);
      
      foreach ($parentcrumbs as $parentcrumb) {
        $breadcrumbs[] = $parentcrumb;
      }
      $breadcrumbs[] = array('title' => $group->name, 'link' => $group->getURL());
      $breadcrumbs[] = array('title' => elgg_echo('groups:edit'), 'link' => NULL);
      
      set_input('au_subgroups_breadcrumbs', $breadcrumbs);
      break;
  }
}


function au_subgroups_delete_entities($result, $getter, $options) {
  $result->delete();
}

/**
 * recursively travels down all routes to gather all guids of
 * groups that are children of the supplied group
 * 
 * @param type $group
 * @param type $guids
 * @return type
 */
function au_subgroups_get_all_children_guids($group, $guids = array()) {
  // get children and delete them
  $children = au_subgroups_get_subgroups($group, 0);
  
  if (!$children) {
    return $guids;
  }
  
  foreach ($children as $child) {
    $guids[] = $child->guid;
  }
  
  foreach ($children as $child) {
    $guids = au_subgroups_get_all_children_guids($child, $guids);
  }
  
  return $guids;
}

/**
 * Determines if a group is a subgroup of another group
 * 
 * @param type $group
 * return ElggGroup | false
 */
function au_subgroups_get_parent_group($group) {
  if (!elgg_instanceof($group, 'group')) {
    return false;
  }
  
  $parent = elgg_get_entities_from_relationship(array(
            'types' => array('group'),
            'limit' => 1,
            'relationship' => AU_SUBGROUPS_RELATIONSHIP,
            'relationship_guid' => $group->guid,
          ));
  
  if (is_array($parent)) {
    return $parent[0];
  }
  
  return false;
}


function au_subgroups_get_subgroups($group, $limit = 10, $sortbytitle = false) {
  $options = array(
    'types' => array('group'),
    'relationship' => AU_SUBGROUPS_RELATIONSHIP,
    'relationship_guid' => $group->guid,
    'inverse_relationship' => true,
    'limit' => $limit,
  );
  
  if ($sortbytitle) {
    $options['joins'] = array("JOIN " . elgg_get_config('dbprefix') . "groups_entity g ON e.guid = g.guid");
    $options['order_by'] = "g.name ASC";
  }
  
  return elgg_get_entities_from_relationship($options);
}


function au_subgroups_list_subgroups($group, $limit = 10, $sortbytitle = false) {
  $options = array(
    'types' => array('group'),
    'relationship' => AU_SUBGROUPS_RELATIONSHIP,
    'relationship_guid' => $group->guid,
    'inverse_relationship' => true,
    'limit' => $limit,
    'full_view' => false
  );
  
  if ($sortbytitle) {
    $options['joins'] = array("JOIN " . elgg_get_config('dbprefix') . "groups_entity g ON e.guid = g.guid");
    $options['order_by'] = "g.name ASC";
  }
  
  return elgg_list_entities_from_relationship($options);
}


function au_subgroups_move_content($result, $getter, $options) {
  switch ($options['au_subgroups_content_policy']) {
    case 'owner':
      $result->container_guid = $result->owner_guid;
      $result->save();
      break;
    
    case 'parent':
      $result->container_guid = $options['au_subgroups_parent_guid'];
      $result->save();
      break;
  }
}

/**
 * Sets breadcrumbs from 'All groups' to current parent
 * iterating through all parent groups
 * @param type $group
 */
function au_subgroups_parent_breadcrumbs($group, $push = true) {
  $parents = array();
  
  while($parent = au_subgroups_get_parent_group($group)) {
    $parents[] = array('title' => $parent->name, 'link' => $parent->getURL());
    $group = $parent;
  }
  
  $parents = array_reverse($parents);
  
  if ($push) {
    elgg_push_breadcrumb(elgg_echo('groups'), elgg_get_site_url() . 'groups/all');
    foreach ($parents as $breadcrumb) {
      elgg_push_breadcrumb($breadcrumb['title'], $breadcrumb['link']);
    }
  }
  else {
    return $parents;
  }
}


// links the subgroup with the parent group
function au_subgroups_set_parent_group($group_guid, $parent_guid) {
  add_entity_relationship($group_guid, AU_SUBGROUPS_RELATIONSHIP, $parent_guid);
}