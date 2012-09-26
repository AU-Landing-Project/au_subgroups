<?php

/**
 * when groups are created/updated, make sure subgroups have
 * access only by parent group acl
 */
function au_subgroups_group_permissions($event, $type, $object) {
  
  // if we have an input, then we're setting the parent
  $parent_guid = get_input('au_subgroups_parent_guid', false);
  if ($parent_guid !== false) {
    au_subgroups_set_parent_group($object->guid, $parent_guid);
  }
  
  $parent = au_subgroups_get_parent_group($object);
  
  if (!$parent) {
    return TRUE;
  }
  
  // we know it's a sub-group, make sure the permissions are that of the parent acl
  if ($object->access_id == $parent->group_acl) {
    return TRUE;
  }
  
  // we need to update it
  $q = "UPDATE " . elgg_get_config('dbprefix') . "entities SET access_id = {$parent->group_acl} WHERE guid = {$object->guid}";
  update_data($q);
}


function au_subgroups_join_group($event, $type, $object) {
  if ($object instanceof ElggRelationship) {
    $user = get_entity($object->guid_one);
    $group = get_entity($object->guid_two);
    $parent = au_subgroups_get_parent_group($group);
    
    if ($parent) {
      if (!$parent->isMember($user)) {
        register_error(elgg_echo('au_subgroups:error:notparentmember'));
        return false;
      }
    }
  }
}