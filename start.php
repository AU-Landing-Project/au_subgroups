<?php

namespace AU\SubGroups;

const AU_SUBGROUPS_RELATIONSHIP = 'au_subgroup_of';
const PLUGIN_ID = 'au_subgroups';
const PLUGIN_VERSION = 20150912;

// include our functions
require_once 'lib/events.php';
require_once 'lib/functions.php';
require_once 'lib/hooks.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');


function init() {
  // add in our own css
  elgg_extend_view('css/elgg', 'au_subgroups/css');
  elgg_extend_view('forms/groups/edit', 'forms/au_subgroups/edit');
  elgg_extend_view('navigation/breadcrumbs', 'au_subgroups/breadcrumb_override', 1);
  elgg_extend_view('group/elements/summary', 'au_subgroups/group/elements/summary');
  elgg_extend_view('groups/tool_latest', 'au_subgroups/group_module');
  elgg_extend_view('groups/sidebar/members', 'au_subgroups/sidebar/subgroups');
  elgg_extend_view('groups/edit', 'au_subgroups/group/transfer');

  // after group creation or editing we need to check the permissions
  elgg_register_event_handler('update', 'group', __NAMESPACE__ . '\\group_visibility');
  elgg_register_event_handler('create', 'member', __NAMESPACE__ . '\\join_group', 0);
  elgg_register_event_handler('leave', 'group', __NAMESPACE__ . '\\leave_group');
  // break up the create/update events to be more manageable
  elgg_register_event_handler('create', 'group', __NAMESPACE__ . '\\add_parent', 1000);
  elgg_register_event_handler('create', 'group', __NAMESPACE__ . '\\clone_layout_on_create', 1000);
  elgg_register_event_handler('create', 'group', __NAMESPACE__ . '\\group_visibility', 1000);
  elgg_register_event_handler('pagesetup', 'system', __NAMESPACE__ . '\\pagesetup');

  // replace the existing groups library so we can push some display options
  elgg_register_library('elgg:groups', __DIR__ . '/lib/groups.php');
  
  add_group_tool_option('subgroups', elgg_echo('au_subgroups:group:enable'));
  add_group_tool_option('subgroups_members_create', elgg_echo('au_subgroups:group:memberspermissions'));
  
  // route some urls that go through 'groups' handler
  elgg_register_plugin_hook_handler('route', 'groups', __NAMESPACE__ . '\\groups_router', 499);
  
  // make sure river entries have the correct access
  elgg_register_plugin_hook_handler('creating', 'river', __NAMESPACE__ . '\\river_permissions');
  
  // admins of the parent group can edit the sub-group
  elgg_register_plugin_hook_handler('permissions_check', 'group', __NAMESPACE__ . '\\group_canedit');
  
  // sort out what happens when a parent group is deleted
  elgg_register_plugin_hook_handler('action', 'groups/delete', __NAMESPACE__ . '\\delete_group');
  
  // prevent users from being invited into a subgroup they can't join
  elgg_register_plugin_hook_handler('action', 'groups/invite', __NAMESPACE__ . '\\group_invite');
  
  // remove 'join' and 'request membership' title links on subgroups for people not members of the parent
  elgg_register_plugin_hook_handler('register', 'menu:title', __NAMESPACE__ . '\\titlemenu');
  
  // register our widget
  elgg_register_widget_type('au_subgroups', elgg_echo('au_subgroups'), elgg_echo('au_subgroups:widget:description'), array('groups'));
  
  elgg_register_ajax_view('au_subgroups/search_results');
  
  
  // actions
  elgg_register_action('au_subgroups/move', __DIR__ . '/actions/move.php');
  
  elgg_register_event_handler('upgrade', 'system', __NAMESPACE__ . '\\upgrades');
}
