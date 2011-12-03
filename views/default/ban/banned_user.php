<?php

$user = $vars['user'];

$icon = elgg_view_entity_icon($user, 'small');

$num_bans = $user->countAnnotations("ban_release");

$details = $user->getAnnotations('ban_release', 1, 0, "desc");

if ($details) {
	if ($details[0]->value !== 0) {
		$expires = htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $details[0]->value));			} else {
		$time_left = elgg_echo('ban:forever');
		if ($num_bans == 0) {
			$num_bans = 1;
		}
	}
}
$alt = elgg_view('output/confirmlink', array(
		'href' => "action/admin/user/unban?guid={$user->guid}",
		'text' => elgg_echo("unban"),
		'class' => 'elgg-button elgg-button-action mrm',
		'is_action' => true
));

$content = "<b>" . elgg_echo('ban:user:reason') . " :</b> {$user->ban_reason}<br>";
$subtitle = "<b>" . elgg_echo('ban:user:expires') . " :</b> {$expires}<br>";
$subtitle .= "<b>" . elgg_echo('ban:user:num:bans') . " :</b> {$num_bans}";

$params = array(
		'entity' => $user,
		'subtitle' => $subtitle,
		'content' => $content,
);
$list_body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($icon, $list_body, array('image_alt' => $alt));
