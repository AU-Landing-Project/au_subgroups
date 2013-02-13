<?php

  $group = elgg_get_page_owner_entity();
  
if (elgg_instanceof($group, 'group')) {
  
  $title = elgg_echo('au_subgroups:move:edit:title');
  
  $form = elgg_view_form('au_subgroups/transfer');
  
  echo "<div>";
  echo elgg_view_module('info', $title, $form);
  echo "</div>";
}