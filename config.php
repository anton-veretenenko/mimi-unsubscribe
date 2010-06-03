<?php

	session_start();

	require_once 'MadMimi.class.php';
	$mimi = new MadMimi('api username', 'api key', false);

	// show Suppresed pseudo list to suppress/unsuppress user
	$admin_mode = false;
	
	// page title
	$title = 'Title';
	// custom page logo, for example your company logo
	// just image url/file
	$logo = '';

	// show all lists on unsubscribe page
	$show_all_lists = true;

	// if $show_all_lists == false then show this lists only
	// i.e. $show_lists[] = 'List name';
	$show_lists = array();
