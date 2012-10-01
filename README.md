au_subgroups
============

Allows creation of groups within groups

Properties of Subgroups
-----------------------
- subgroups are only visible to members of the parent group
- only members of the parent group can join a sub-group
- sub-groups are fully qualified groups in their own right, may have sub-groups of their own
- infinite depth of sub-groups
- breadcrumb navigation on group pages shows path from parent to current group
- groups owner block contains link to parent group
- groups owner block contains link to subgroups (if you're a member of the parent group)
- when users leave a parent group, they are removed from all subgroups

Events
-------
Creating a subgroup
- subgroup automatically has visibility set to the parent group only
- subgroup automatically inherits colors/backgrounds from parent if group custom layout is used

Deletion of a group
- if the group has subgroups, all subgroups will be deleted
- content within subgroups can be reassigned to the original owner, to the parent group, or deleted
