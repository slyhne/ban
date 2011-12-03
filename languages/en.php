<?php

$english = array(
	'admin:users:banned' => 'Banned users',
	'admin:users:ban' => 'Ban user',
	'admin:ban' => 'Banned users',
	'admin:ban:banned' => 'List',

	'ban:profile_link' => 'Ban/Timeout',
	'ban:add:title' => 'Banning %s',

	'ban:user:reason' => 'Ban reason',
	'ban:user:num:bans' => 'Number of bans',
	'ban:user:expires' => 'Ban expires',
	'ban:length' => 'Length of time in hours (default 0 = forever)',
	'ban:notify' => 'Notify user',

	'ban:forever' => 'Forever',
	'ban:none' => 'No banned users',

	'ban:add:success' => "Banned %s",
	'ban:add:failure' => 'Failed to ban this user!',
	'ban:add:failure:missing:reason' => 'No reason for ban given!',

	'ban:subject' => "You have been banned from %s",
	'ban:body:hourleft' => '1 hour',
	'ban:body:hoursleft' => '%s hours',
	'ban:body:forever' => 'forever',
	'ban:body' => "Hi %s\n\n\nYou have been banned for the following reason: \n\n\n %s \n\n\n The ban will last %s.",
);

add_translation("en", $english);