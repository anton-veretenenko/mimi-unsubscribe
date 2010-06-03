<?php

	require_once 'config.php';

	$args = $_POST;

	if (!empty($args) && !empty($args['email']) && $mimi->Authenticate() && $mimi->HaveUser($args['email'])) {
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
						$user['firstname'] = $current_user['first_name'];
						$user['lastname'] = $current_user['lastname'];
						$user['email'] = $email;
						$user['add_list'] = $name;
						$mimi->AddUser($user);
					}/* else {
						// if parameneters are bad then redirect to index
						header('Location: index.php');
					}*/
				}
				$user_lists = prepareLists(new SimpleXMLElement($mimi->Memberships($email)));
			} else {
				// if emails does not match then redirect to index
				//header('Location: index.php');
			}
		}
	} else {
		// if no data posted or mimi authentication failed or
		// mimi have not such email then redirect to index
		header('Location: index.php');
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
		foreach($all_lists as $list) {
			foreach ($lists_names as $name) {
				if (strcmp($list['name'], $name) === 0) {
					$new_lists[(string)$list['id']] = (string)$list['name'];
				}
			}
		}
		return $new_lists;
	}

	include "template.php";