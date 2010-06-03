<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo $title; ?> : Mad Mimi Email Marketing</title>
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
        	<tr>
        		<td>
                <p>Enter your email address</p>
        		</td>
	        </tr>
        	<tr>
        		<td></td>
        	</tr>
        	<tr>
        		<td class="unsubscribe">
          		<input id="email" name="email" type="text" value="" />
        		</td>
        	</tr>
          <tr>
        		<td>
        		  <input name="commit" type="submit" value="Edit subscriptions" />
        		</td>
      	  </tr>
		    </table>
		  </td>
    </tr>
		<tr>
			<td>
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