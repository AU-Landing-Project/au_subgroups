<?php

$group = $vars['entity'];
$au_subgroup = get_input('au_subgroup', false);
$parent_guid = get_input('au_subgroup_parent_guid', false);

// determine if we are editing or adding a subgroup
if ($group && !$au_subgroup) {
  $parent = au_subgroups_get_parent_group($group);
  
  if ($parent) {
    $au_subgroup = true;
    $parent_guid = $parent->guid;
  }
}

if ($au_subgroup) {
  
  echo elgg_view('input/hidden', array('name' => 'au_subgroups_parent_guid', 'value' => $parent_guid));
?>

<script>
  $(document).ready( function() {
    $('.elgg-form-groups-edit select[name=vis]').parent().remove();
  });
</script>

<?php
}