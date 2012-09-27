<?php

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