<?php

$form_vars = array('name' => 'banForm', 'action' => 'action/ban', 'class' => 'elgg-form-settings');

echo elgg_view_form("ban/form", $form_vars);
