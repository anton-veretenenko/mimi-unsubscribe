<?php

	require_once 'config.php';

	$email = '';
	$args = $_POST;
	if (!empty($_GET['email'])) {
		$args['email'] = $_GET['email'];
		if (!empty($_SESSION['email'])) {
			unset($_SESSION['email']);
		}
	}
	if (!empty($_GET['p'])) {
		$args['p'] = intval($_GET['p']);
	}

	if (!empty($args['email']) && empty($args['p'])) {
		$email = addslashes($args['email']);
		include 'template_preload.php';
		die();
	}

	if ((!empty($args) && !empty($args['email'])) &&
			(($mimi_main->Authenticate() && ($mimi_main->HaveUser($args['email']) || $mimi_main->IsSuppressed($args['email']))) ||
			($admin_mode && $mimi_main->IsSuppressed($args['email'])))) {
		if (!empty($_SESSION['email'])) {
			$email = $_SESSION['email'];
		} else {
			$email = addslashes($args['email']);
			$_SESSION['email'] = $email;
		}
		$lists_main = new SimpleXMLElement($mimi_main->Lists(true));
		$lists_2 = new SimpleXMLElement($mimi_2->Lists(true));
		$user_suppressed = $mimi_main->IsSuppressed($email);
		$user_lists = array();
		$user_lists['main'] = prepareLists(new SimpleXMLElement($mimi_main->Memberships($email)), 'main');
		$user_lists['2'] = prepareLists(new SimpleXMLElement($mimi_2->Memberships($email)), '2');
		$lists = prepareListsByNames($lists_main, $lists_2, $show_lists);

		$email = $_SESSION['email'];
		$email2 = addslashes($args['email']);
		if (strcmp($email, $email2) === 0) {
			if (!empty($args['audience_list_ids']) && is_array($args['audience_list_ids'])) {
				$edit_lists = $args['audience_list_ids'];
				$current_user = new SimpleXMLElement($mimi_main->Search($email));
				// process subscribe and unsubscribe
				// but before we start
				if ($user_suppressed) {
					// if user suppressed, let's unsuppress him
					$user = array();
					$user['email'] = $email;
					$user['opt_out'] = 0;
					$mimi_main->AddUser($user);
				}
				foreach ($lists as $id => $name) {
					list($id_clear, $mimi_acc) = explode('_', $id);
					if ($edit_lists[$id] === '0' && !empty($user_lists[$mimi_acc][$id])) {
						//echo 'Remove: '.$mimi_acc.' '.$email.' from '.$name.PHP_EOL.'<br />';
						if ($mimi_acc == 'main') {
							$mimi_main->RemoveUser($email, $name);
						} else
						if ($mimi_acc == '2') {
							$mimi_2->RemoveUser($email, $name);
						}
					} else
					if ($edit_lists[$id] === '1' && empty($user_lists[$mimi_acc][$id])) {
						$user = array();
						$user['email'] = $email;
						$user['add_list'] = $name;
						//echo 'Add: '.$mimi_acc.' '.$email.' to '.$name.PHP_EOL.'<br />';
						if ($mimi_acc == 'main') {
							$mimi_main->AddUser($user);
						} else
						if ($mimi_acc == '2') {
							$mimi_2->AddUser($user);
						}
					}
				}
				$user_lists['main'] = prepareLists(new SimpleXMLElement($mimi_main->Memberships($email)), 'main');
				$user_lists['2'] = prepareLists(new SimpleXMLElement($mimi_2->Memberships($email)), '2');
			}

			// admin mode handling suppressed list
			if ($admin_mode) {
				$user_suppressed = $mimi_main->IsSuppressed($email);
				if ($user_suppressed !== null) {
					if (isset($args['suppressed'])) {
						$suppressed = intval($args['suppressed']);
						if ($suppressed == 0 && $user_suppressed) {
							// unsuppress user
							$user = array();
							$user['email'] = $email;
							$user['opt_out'] = 0;
							$mimi_main->AddUser($user);
						} else
						if ($suppressed == 1 && !$user_suppressed) {
							// suppress user
							$user = array();
							$user['email'] = $email;
							$user['opt_out'] = 1;
							$mimi_main->AddUser($user);
						}
						$user_suppressed = $mimi_main->IsSuppressed($email);
					}
				} else {
					$error = 'not-found';
					$_SESSION['email'] = '';
				}
			}
		} else {
			if ($admin_mode) {
				// change email
				$_SESSION['email'] = $email2;
				$email = $email2;
				$user_lists['main'] = prepareLists(new SimpleXMLElement($mimi_main->Memberships($email)));
				$user_lists['2'] = prepareLists(new SimpleXMLElement($mimi_2->Memberships($email)), '2');
				$user_suppressed = $mimi_main->IsSuppressed($email);
			} else {
				// if emails does not match then show error
				$error = 'not-found';
				$_SESSION['email'] = '';
			}
		}

	} else
	if ($admin_mode && empty($args['email'])) {
		$show_form = true;
		$_SESSION['email'] = '';
	} else {
		// if no data posted or mimi authentication failed or
		// mimi have not such email then show error
		// just error code defined, error message for error code should
		// be defined in template
		$error = 'not-found';
		$_SESSION['email'] = '';
	}

	function prepareLists(SimpleXMLElement $lists, $mimi_acc)
	{
		$new_lists = array();
		foreach ($lists as $list) {
			$new_lists[(string)$list['id'].'_'.$mimi_acc] = (string)$list['name'];
		}
		return $new_lists;
	}

	function prepareListsByNames(SimpleXMLElement $lists_main, SimpleXMLElement $lists_2, $lists_names)
	{
		$new_lists = array();
		$lists_main = prepareLists($lists_main, 'main');
		$lists_2 = prepareLists($lists_2, '2');
		//$temp_lists = array_merge($lists_main, $lists_2);
		foreach ($lists_names as $mimi_acc => $lists) {
			foreach ($lists as $name) {
				if ($mimi_acc == 'main') {
					foreach ($lists_main as $list_id => $list_name) {
						if (strcmp($list_name, $name) === 0) {
							$new_lists[$list_id] = $list_name;
							unset($lists_main[$list_id]);
						}
					}
				} else
				if ($mimi_acc == '2') {
					foreach ($lists_2 as $list_id => $list_name) {
						if (strcmp($list_name, $name) === 0) {
							$new_lists[$list_id] = $list_name;
							unset($lists_2[$list_id]);
						}
					}
				}
			}
		}
		return $new_lists;
	}

	include "template.php";