<?php
/**
 * Leave a group action.
 *
 * @package ElggGroups
 */

$user_guid = get_input('user_guid');
$group_guid = get_input('group_guid');

$user = NULL;
if (!$user_guid) {
	$user = elgg_get_logged_in_user_entity();
} else {
	$user = get_user($user_guid);
}

$group = get_entity($group_guid);

elgg_set_page_owner_guid($group->guid);

if ($user && ($group instanceof ElggGroup)) {
	if ($group->getOwnerGUID() != elgg_get_logged_in_user_guid()) {
		// Don't allow leaving a parent group if owner of a subgroup
		$nb_of_groups_to_leave = \AU\SubGroups\can_leave_group($group, $user);
		if ($nb_of_groups_to_leave) {
			if ($group->leave($user)) {
				if($nb_of_groups_to_leave > 1) {
					system_message(elgg_echo("au_subgroups:left", array($nb_of_groups_to_leave-1)));
				} else {
					system_message(elgg_echo("groups:left"));				    
				}
			} else {
				register_error(elgg_echo("groups:cantleave"));
			}
		} else {
			register_error(elgg_echo("au_subgroups:cantleave"));
		}
	} else {
		register_error(elgg_echo("groups:cantleave"));
	}
} else {
	register_error(elgg_echo("groups:cantleave"));
}

forward(REFERER);
