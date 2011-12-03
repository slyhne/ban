<?php

elgg_register_event_handler('init', 'system', 'ban_init');

function ban_init() {

	// admin interface to manage banned users
	elgg_register_admin_menu_item('administer', 'banned', 'users');

	// User hover/profile menu setup
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'ban_hover_menu');
	elgg_register_plugin_hook_handler('display', 'view', 'ban_user_menu');

	// Register cron hook
	elgg_register_plugin_hook_handler('cron', 'hourly', 'ban_cron');

	elgg_extend_view('css/admin', 'ban/css');

	$action_path = elgg_get_plugins_path() . "ban/actions";
	elgg_register_action("ban", $action_path . "/ban.php", "admin");
	elgg_register_action("admin/user/unban", $action_path . "/unban.php", "admin");
}

// Add to the user hover menu
function ban_hover_menu($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	if (!elgg_instanceof($entity, 'user')) {
		return $return;
	}

	if (!$entity->isBanned()) {
		$url = "admin/users/ban?user={$entity->username}";
		$item = new ElggMenuItem('ban', elgg_echo('ban:profile_link'), $url);
		$item->setSection('admin');
		$return[] = $item;
	} else {
		$url = "action/admin/user/unban?guid={$entity->guid}";
		$url = elgg_add_action_tokens_to_url($url);
		$item = new ElggMenuItem('unban', elgg_echo('unban'), $url);
		$item->setSection('admin');
		$item->setLinkClass('elgg-requires-confirmation');
		$return[] = $item;
	}

	return $return;
}
// Cron job for auto unban of users with timeput
function ban_cron($hook, $entity_type, $returnvalue, $params) {

	global $CONFIG;

	$ia = elgg_set_ignore_access(TRUE);
	$hidden_entities = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);

	$params = array(
		'type'   => 'user',
		'annotation_names' => array('ban_release'),
		'joins'  => array("JOIN {$CONFIG->dbprefix}users_entity u on e.guid = u.guid"),
		'wheres' => array("u.banned='yes'"),
	);

	$now = time();
	$users = elgg_get_entities_from_annotations($params);

	foreach ($users as $user) {

		$releases = $user->getAnnotations('ban_release', 1, 0, "desc");

		foreach ($releases as $release) {
			if ($release->value < $now && $release->value !== 0) {
				if ($user->unban()) {
					// Don't remove old ban annotations so we can see how many times a ban has been given
					//$release->delete();
				}
			}
		}
	}

	access_show_hidden_entities($hidden_entities);
	elgg_set_ignore_access($ia);
}
