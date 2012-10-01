<?php

// display subgroups in listings?
echo elgg_view('input/dropdown', array(
   'name' => 'params[display_subgroups]',
    'value' => $vars['entity']->display_subgroups ? $vars['entity']->display_subgroups : 'no',
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    )
));

echo " " . elgg_echo('au_subgroups:setting:display_subgroups');

echo "<br><br>";

// display alphabetically?
// display subgroups in listings?
echo elgg_view('input/dropdown', array(
   'name' => 'params[display_alphabetically]',
    'value' => $vars['entity']->display_alphabetically ? $vars['entity']->display_alphabetically : 'yes',
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    )
));

echo " " . elgg_echo('au_subgroups:setting:display_alphabetically');

echo "<br><br>";