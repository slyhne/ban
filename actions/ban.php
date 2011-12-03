<?php
$reason = get_input('reason');
$length = (int) get_input('length', 0);
$guid = (int) get_input('guid');
$notify = get_input('notify');

$user = get_user($guid);
if (!$user) {
	register_error('ban:add:failure');
	forward(REFERER);
}
if (!$reason) {
	register_error('ban:add:failure:missing:reason');
	forward(REFERER);
}

if ($length < 1) {
	$time = elgg_echo('ban:body:forever');
	$release = 0;
} elseif ($length < 2) {
	$time = elgg_echo('ban:body:hourleft');
	$release = time() + $length * 60*60;
} else {
	$time = elgg_echo('ban:body:hoursleft', array($length));
	$release = time() + $length * 60*60;
}

$user->annotate('ban_release', $release);

$user->ban($reason);

if ($notify !== '0') {
	$subject = elgg_echo('ban:subject', array(elgg_get_config('sitename')));
	$message = elgg_echo('ban:body', array($user->name, $reason, $time));
	notify_user($user->guid, get_loggedin_userid(), $subject, $message, null, 'email');
}

system_message(sprintf(elgg_echo('ban:add:success'), $user->name));
forward('admin/users/banned');
