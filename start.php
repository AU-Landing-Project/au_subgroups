<?php

// definitions
define('AU_SUBGROUPS_RELATIONSHIP', 'au_subgroup_of');

// include our functions
require_once 'lib/events.php';
require_once 'lib/functions.php';
require_once 'lib/hooks.php';

elgg_register_event_handler('init', 'system', 'au_subgroups_init');

// after group creation or editing we need to check the permissions
elgg_register_event_handler('create', 'group', 'au_subgroups_group_permissions');
elgg_register_event_handler('update', 'group', 'au_subgroups_group_permissions');
elgg_register_event_handler('create', 'member', 'au_subgroups_join_group');
elgg_register_event_handler('leave', 'group', 'au_subgroups_leave_group');

function au_subgroups_init() {
  // add in our own css
  elgg_extend_view('css/elgg', 'au_subgroups/css');
  elgg_extend_view('forms/groups/edit', 'forms/au_subgroups/edit');
  elgg_extend_view('navigation/breadcrumbs', 'au_subgroups/breadcrumb_override', 1);
  elgg_extend_view('group/elements/summary', 'au_subgroups/group/elements/summary');
  elgg_extend_view('groups/tool_latest', 'au_subgroups/group_module');

  // replace the existing groups library so we can push some display options
  elgg_register_library('elgg:groups', elgg_get_plugins_path() . 'au_subgroups/lib/groups.php');
  
  add_group_tool_option('subgroups', elgg_echo('au_subgroups:group:enable'));
  
  // add links to group owner_block
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'au_subgroups_owner_block_menu');
  
  // route some urls that go through 'groups' handler
  elgg_register_plugin_hook_handler('route', 'groups', 'au_subgroups_groups_router', 499);
  
  // make sure river entries have the correct access
  elgg_register_plugin_hook_handler('creating', 'river', 'au_subgroups_river_permissions');
  
  // admins of the parent group can edit the sub-group
  elgg_register_plugin_hook_handler('permissions_check', 'group', 'au_subgroups_group_canedit');
  
  // sort out what happens when a parent group is deleted
  elgg_register_plugin_hook_handler('action', 'groups/delete', 'au_subgroups_delete_group');
  
  // register our widget
  elgg_register_widget_type('au_subgroups', elgg_echo('au_subgroups'), elgg_echo('au_subgroups:widget:description'), 'groups');
}


