<?php
/**
 * Admin area to manage banned users
 */

global $CONFIG;

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);

$ia = elgg_set_ignore_access(TRUE);
$hidden_entities = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);

$joins = array(
	"JOIN {$CONFIG->dbprefix}users_entity u on e.guid = u.guid",
);

$options = array(
	'type'   => 'user',
	'joins'  => $joins,
	'wheres' => array("u.banned='yes'"),
	'limit' => $limit,
	'offset' => $offset,
	'count' => TRUE,
);
$count = elgg_get_entities_from_metadata($options);

if (!$count) {
	access_show_hidden_entities($hidden_entities);
	elgg_set_ignore_access($ia);

	echo elgg_echo('ban:none');
	return TRUE;
}

$options['count']  = FALSE;

$users = elgg_get_entities_from_metadata($options);

access_show_hidden_entities($hidden_entities);
elgg_set_ignore_access($ia);

// setup pagination
$pagination = elgg_view('navigation/pagination',array(
	'baseurl' => 'admin/users/banned',
	'offset' => $offset,
	'count' => $count,
	'limit' => $limit,
));

if (is_array($users) && count($users) > 0) {
	$html = '<ul class="elgg-list elgg-list-distinct">';
	foreach ($users as $user) {
		$html .= "<li class='elgg-item'>";
		$html .= elgg_view('ban/banned_user', array('user' => $user));
		$html .= '</li>';
	}
	$html .= '</ul>';
}

echo $html;

