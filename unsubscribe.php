<?php

	require_once 'config.php';

	$args = $_POST;
	if (!empty($_GET['email'])) {
		$args['email'] = $_GET['email'];
		if (!empty($_SESSION['email'])) {
			unset($_SESSION['email']);
		}
	}

	if (!empty($args) && !empty($args['email']) &&
			(($mimi->Authenticate() && $mimi->HaveUser($args['email'])) ||
			($admin_mode && $mimi->IsSuppressed($args['email'])))) {
		if (!empty($_SESSION['email'])) {
			$email = $_SESSION['email'];
		} else {
			$email = addslashes($args['email']);
			$_SESSION['email'] = $email;
		}
		$all_lists = new SimpleXMLElement($mimi->Lists(true));
		$user_lists = prepareLists(new SimpleXMLElement($mimi->Memberships($email)));
		if ($show_all_lists) {
			$lists = prepareLists($all_lists);
		} else {
			$lists = prepareListsByNames($all_lists, $show_lists);
		}
		if (!empty($args['audience_list_ids']) && is_array($args['audience_list_ids'])) {
			$edit_lists = $args['audience_list_ids'];
			$email = $_SESSION['email'];
			$email2 = addslashes($args['email']);
			if (strcmp($email, $email2) === 0) {
				$current_user = new SimpleXMLElement($mimi->Search($email));
				// process subscribe and unsubscribe
				foreach ($lists as $id => $name) {
					if ($edit_lists[$id] === '0' && !empty($user_lists[$id])) {
						// process unsubscribe
						$mimi->RemoveUser($email, $name);
					} else
					if ($edit_lists[$id] === '1' && empty($user_lists[$id])) {
						// process subscribe
						$user = array();
						$user['email'] = $email;
						$user['add_list'] = $name;
						$mimi->AddUser($user);
					}/* else {
						// if parameneters are bad then show error
						$error = 'not-found';
					}*/
				}
				$user_lists = prepareLists(new SimpleXMLElement($mimi->Memberships($email)));
			} else {
				// if emails does not match then show error
				$error = 'not-found';
			}
		}

		// admin mode handling suppressed list
		if ($admin_mode) {
			$user_suppressed = $mimi->IsSuppressed($email);
			if (isset($args['suppressed'])) {
				$suppressed = intval($args['suppressed']);
				if ($suppressed == 0 && $user_suppressed) {
					// unsuppress user
					$user = array();
					$user['email'] = $email;
					$user['opt_out'] = 0;
					$mimi->AddUser($user);
				} else
				if ($suppressed == 1 && !$user_suppressed) {
					// suppress user
					$user = array();
					$user['email'] = $email;
					$user['opt_out'] = 1;
					$mimi->AddUser($user);
				}
			}
			$user_suppressed = $mimi->IsSuppressed($email);
			if ($user_suppressed) {
				$lists = array();
				$user_lists = array();
			}
		}
		
	} else {
		// if no data posted or mimi authentication failed or
		// mimi have not such email then show error
		// just error code defined, error message for error code should
		// be defined in template
		$error = 'not-found';
	}

	function prepareLists(SimpleXMLElement $lists)
	{
		$new_lists = array();
		foreach ($lists as $list) {
			$new_lists[(string)$list['id']] = (string)$list['name'];
		}
		return $new_lists;
	}

	function prepareListsByNames(SimpleXMLElement $all_lists, $lists_names)
	{
		$new_lists = array();
		$temp_lists = $all_lists;
		foreach ($lists_names as $name) {
			foreach ($temp_lists as $i => $list) {
				if (strcmp($list['name'], $name) === 0) {
					$new_lists[(string)$list['id']] = (string)$list['name'];
					unset($temp_lists[$i]);
				}
			}
		}
		return $new_lists;
	}

	include "template.php";