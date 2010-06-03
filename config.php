<?php

	require_once 'MadMimi.class.php';
	$mimi = new MadMimi('api username', 'api key', false);

	// page title
	$title = 'Title';

	// show all lists on unsubscribe page
	$show_all_lists = false;

	// if $show_all_lists == false then show this lists only
	// i.e. $show_lists[] = 'List name';
	$show_lists = array();
