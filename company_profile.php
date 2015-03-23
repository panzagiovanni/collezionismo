<?php
session_start();

function getCompanyReliability($id)
{
	$db = new mysqli("localhost", "root", "root", "test");

	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	
	$res = $db->query("SELECT vote FROM feedback_percentage WHERE company_id = ".$id);
	if($res->num_rows == 0)
	{
		return array(0, 0);
	}
	$avg = 0;
	while($row = $res->fetch_array(MYSQLI_NUM))
	{
		$avg += $row[0] * 20;
	}
	$avg /= $res->num_rows;
	
	return array(round($avg, 2), $res->num_rows);
}

if(!isset($_SESSION['login']))
{
	$_SESSION['login'] = array(false, "");
}

$db = new mysqli("localhost", "root", "root", "test");

if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}

if(!isset($_GET['id']) || !is_numeric($_GET['id']))
{
?>
<html>
	<head>
		<title>Company Profile - Website</title>
	</head>
	<body>
		Error: page must be specified a company id.<br />
		<a href="index.php">Home page</a>
	</body>
</html>
<?php
}
else
{
	$result = $db->query("SELECT * FROM companies WHERE id = ".$_GET['id']);
	if($result->num_rows == 0)
	{
?>
<html>
	<head>
		<title>Company Profile - Website</title>
	</head>
	<body>
		Company with id <?php echo htmlentities($_GET['id']); ?> cannot be found. <br />
		<a href="index.php">Home page</a>
	</body>
</html>
<?php
	}
	else
	{
		$row = $result->fetch_array(MYSQLI_NUM);
?>
<html>
	<head>
		<title>Company Profile - <?php echo $row[1]; ?> - Website</title>
		<style>
			body {
				margin: 0 40px 0 40px;
			}
			
			a, a:visited {
				color: #555555;
			}
			
			a:hover {
				color: #A9A9A9;
			}
			
			div#header {
				font-size: 45px;
				text-align: center;
				margin: 5px 0 20px 0;
			}
			
			div#login-box {
				float: right;
				margin-right: 15px;
			}
		</style>
	</head>
	<body>
		<div id="header">Company Profile - <?php echo $row[1]; ?></div>
		Name: <?php echo $row[1]; ?> <br />
		Address: <?php echo $row[2]; ?> <br />
		Description: <?php echo $row[3]; ?> <br />
		Reliability: <?php $a = getCompanyReliability($_GET['id']); print $a[0]."% (".$a[1]." votes)"; ?><br />
		Comments: <br />
		<?php
		$res = $db->query("SELECT id, feedback FROM company_feedbacks WHERE company_id = ".$_GET['id']);
		if($res->num_rows == 0)
		{
			print "No comments inserted yet";
		}
		else
		{
			echo "<ul>";
			while($row = $res->fetch_array(MYSQLI_NUM))
			{
				echo "<li>Comment #".$row[0].": ".$row[1]."</li>";
			}
			echo "</ul>";
		}
		?>
		<br />
		<?php
		if($_SESSION['login'][0])
		{
		?>
		<form name="vote" method="post" action="">
			Rate the company reliability:
			Not reliable <input type="radio" value="1" name="vote">
			Hardly reliable <input type="radio" value="2" name="vote">
			Averagely reliable <input type="radio" value="3" name="vote">
			Very reliable <input type="radio" value="4" name="vote">
			Totally reliable <input type="radio" value="5" name="vote">
			<input type="submit" value="Vote" />
		</form>
		<?php
			if(isset($_POST['vote']))
			{
				if($db->query("INSERT INTO feedback_percentage(company_id, vote) VALUES(".$_GET['id'].", ".$_POST['vote'].");"))
				{
					print "Voted correctly. <a href=\"company_profile.php?".$_SERVER['QUERY_STRING']."\">Refresh</a>";
				}
				else
				{
					print "Error in placing the vote.";
				}
			}
		?>
		<form name="comment" method="post" action="">
			Leave your comment:<br />
			<textarea name="comment" cols="50" rows="10"></textarea><br /><br />
			<input type="submit" value="Send" />
		</form>
		<?php
			if(isset($_POST['comment']))
			{
				$cmt = htmlentities($_POST['comment']);
				
				if($db->query("INSERT INTO company_feedbacks(company_id, feedback) VALUES(".$_GET['id'].", '".$cmt."')"))
					print "Comment inserted successfully";
				else
					print "Error in inserting comment";
				echo " <a href=\"company_profile.php?".$_SERVER['QUERY_STRING']."\">Refresh</a>";
			}
		}
		?>
		<a href="index.php">Home page</a>
	</body>
</html>
<?php
	}
}
?>
