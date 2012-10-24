<?php

$all_link = elgg_view('output/url', array(
	'href' => 'groups/subgroups/' . $vars['entity']->guid . '/all',
	'text' => elgg_echo('au_subgroups:subgroups:more'),
	'is_trusted' => true,
));

$subgroups = au_subgroups_get_subgroups($vars['entity'], 5);
$body = '';

if (!$subgroups) {
  $body = '<div class="elgg-subtext">' . elgg_echo('au_subgroups:nogroups') . '</div>';
}
else {
  foreach ($subgroups as $subgroup) {
    
    $body .= elgg_view_image_block(
        elgg_view_entity_icon($subgroup, 'tiny'),
        elgg_view('output/url', array(
            'href' => $subgroup->getURL(),
            'text' => $subgroup->name,
            'is_trusted' => true))
     );
  }
}

$title = elgg_echo('au_subgroups:subgroups');

if ($vars['entity']->canEdit()) {
  $create_link = elgg_view('output/url', array(
     'text' => elgg_echo('au_subgroups:add:subgroup'),
      'title' => elgg_echo('au_subgroups:add:subgroup'),
      'href' => 'groups/subgroups/add/' . $vars['entity']->guid
  ));
  
  $body .= "<div class='center mts'>$create_link</div>";
}

if ($subgroups) {
  $body .= "<div class='center mts'>$all_link</div>";
}

echo elgg_view_module('aside', $title, $body);
