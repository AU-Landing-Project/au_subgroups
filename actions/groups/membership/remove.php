<?php
/**
 * Remove a user from a group
 *
 * @package ElggGroups
 */

$user_guid = get_input('user_guid');
$group_guid = get_input('group_guid');

$user = get_user($user_guid);
$group = get_entity($group_guid);

elgg_set_page_owner_guid($group->guid);

if ($user && ($group instanceof ElggGroup) && $group->canEdit()) {
	// Don't allow removing group owner
	if ($group->getOwnerGUID() != $user->getGUID()) {
		// Don't allow removing a subgroup owner
		$nb_of_groups_to_leave = \AU\SubGroups\can_leave_group($group, $user);
		if ($nb_of_groups_to_leave) {
			if ($group->leave($user)) {
				if($nb_of_groups_to_leave > 1) {
					system_message(elgg_echo("au_subgroups:removed", array($user->name, $nb_of_groups_to_leave-1)));
				} else {
					system_message(elgg_echo("groups:removed", array($user->name)));				    
				}
			} else {
				register_error(elgg_echo("groups:cantremove"));
			}
		} else {
			register_error(elgg_echo("au_subgroups:cantremove"));
		}
	} else {
		register_error(elgg_echo("groups:cantremove"));
	}
} else {
	register_error(elgg_echo("groups:cantremove"));
}

forward(REFERER);
