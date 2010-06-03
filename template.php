<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>ForexPeaceArmy.com : Mad Mimi Email Marketing</title>
	<link href="http://go.madmimi.com/stylesheets/base.css" media="screen" rel="stylesheet" type="text/css" />
<link href="http://go.madmimi.com/stylesheets/screen.css" media="screen" rel="stylesheet" type="text/css" />
	<style>
	body {
		padding: 0;
		border: 0;
		background: #efefef;
		color: #000;
		font-family: "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif;
	}

	table#wrapper {
			margin: 100px auto;
			border: 0;
			font-size: 13px;
	}

	table#inner {
		border:1px solid #ccc;
		padding: 10px 20px 20px 20px;
	}

	table#inner thead tr.underlined th {
		border-bottom: 1px solid #ccc;
		text-align: left;
		padding-bottom: 5px;
		padding-right: 10px;
		padding-top: 20px;
	}

	table#inner td {
		padding-top: 4px
	}

	td.unsubscribe {
	padding-bottom: 5px;
	}

	h4 {
		color: #000;
	}

	p {
		font-family: georgia, serif;
		font-style: italic;
		line-height: 1.5em;
		margin: 10px 0 0 0;
	}

	a {

	}

	a:hover, a:focus {

	}

	</style>
</head>
	<body>

<form action="unsubscribe.php" method="post">
<table id="wrapper" width="520" height="100%" cellspacing="0" cellpadding="0">
	 <tr>
	    <td align="center">
		    <table id="inner" width="520" cellspacing="0" bgcolor="#FFFFFF">
					<thead>
						<?php if (!empty($logo)) { ?>
						<tr>
							<th colspan="3">
								<img src="<?php echo $logo; ?>" alt="" />
							</th>
						</tr>
						<?php } ?>
						<?php if (empty($error)) { ?>
						<tr class="underlined">
							<th width="25%">Subscribed</th>
							<th width="25%">Unsubscribed</th>
							<th>List Name</th>
						</tr>
						<?php } ?>
					</thead>
					<?php if (empty($error)) { ?>
					<?php foreach ($lists as $id => $name) { ?>
					<tr>
						<td>
							<input name="audience_list_ids[<?php echo $id; ?>]" type="radio" value="1" <?php if (!empty($user_lists[$id])) { ?>checked="checked"<?php } ?> />
						</td>
						<td>
							<input name="audience_list_ids[<?php echo $id; ?>]" type="radio" value="0" <?php if (empty($user_lists[$id])) { ?>checked="checked"<?php } ?> />
						</td>
						<td>
							<?php echo $name; ?>
						</td>
           </tr>
					<?php } ?>
					<?php if ($admin_mode) { ?>
					<tr>
						<td>
							<input name="suppressed" type="radio" value="1" <?php if ($user_suppressed) { ?>checked="checked"<?php } ?> />
						</td>
						<td>
							<input name="suppressed" type="radio" value="0" <?php if (!$user_suppressed) { ?>checked="checked"<?php } ?> />
						</td>
						<td>
							Suppressed
						</td>
           </tr>
					<?php } ?>
        	<tr>
						<td colspan="3">
                <p>Subscription will be updated for this email address</p>
        		</td>
	        </tr>
        	<tr>
        		<td></td>
        	</tr>
        	<tr>
						<td class="unsubscribe" colspan="3">
							<input id="email" name="email" type="text" value="<?php echo $email; ?>" readonly="readonly" />
        		</td>
        	</tr>
          <tr>
						<td colspan="3">
        		  <input name="commit" type="submit" value="Save" />
        		</td>
      	  </tr>
					<?php } else {
						if ($error == 'not-found') {
							$error = 'The email you are trying to change subscription option is not in our database.';
						}
					?>
					<tr>
						<td colspan="3">
							<p><?php echo $error; ?></p>
						</td>
					</tr>
					<?php } ?>
		    </table>
		  </td>
    </tr>
		<tr>
			<td colspan="3">
		    <p style='font-size:11px;color:#999;text-align:center;'>
		      On behalf of this sender, Mad Mimi<sup>&reg;</sup> ensures prompt and permanent<br /> handling of each and every removal request.<br />
		      To contact Mad Mimi<sup>&reg;</sup> or to report abuse, send an email <a style='color:#666' href="mailto:support@madmimi.com">here</a>.
		    </p>
		</td>
	</tr>
</table>

</form>
	</body>
</html>