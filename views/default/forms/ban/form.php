<?php

$user = get_user_by_username(get_input('user'));

echo elgg_view_entity($user);

echo '<p>';
echo '<label>' . elgg_echo('ban:user:reason') . '</label>';
echo elgg_view('input/text', array('name' => 'reason'));
echo '</p>';

echo '<p>';
echo '<label>' . elgg_echo('ban:length') . '</label>';
echo elgg_view('input/text', array('name' => 'length'));
echo '</p>';

echo '<p>';
$options = array(elgg_echo('ban:notify') => 'yes');
echo elgg_view('input/checkboxes', array('name' => 'notify', 'options' => $options));
echo '</p>';

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));

echo elgg_view('input/submit', array('value' => elgg_echo('ban')));
