<?php

	session_start();

	require_once 'MadMimi.class.php';
	$mimi_account = 2;
	$mimi_main = new MadMimi('api username', 'api key', false);
	$mimi_2 = new MadMimi('api username', 'api key', false);

	// show Suppresed pseudo list to suppress/unsuppress user
	$admin_mode = false;
	
	// page title
	$title = 'Title';
	// custom page logo, for example your company logo
	// just image url/file
	$logo = '';

	// show all lists on unsubscribe page
	$show_all_lists = false;

	// if $show_all_lists == false then show this lists only
	// i.e. $show_lists[] = 'List name';
	$show_lists = array();
	$show_lists['main'][] = 'List 1';
	$show_lists['main'][] = 'List 2';
	$show_lists['2'][] = 'List 3 from another account';