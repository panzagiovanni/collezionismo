<?php
session_start();

if(!isset($_SESSION['login']))
{
	$_SESSION['login'] = array(false, "");
}
?>
<html>
	<head>
		<title>Login - Website</title>
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
		<form name="login" method="post" action="">
			Nome utente: <input type="text" name="user" /><br />
			Password: <input type="password" name="password" /><br />
			<input type="submit" value="Log In" />
		</form>
		<?php
		if(isset($_POST['user']))
		{
			$user = htmlentities($_POST['user']);
			$pass = md5(htmlentities(trim($_POST['password'])));
			
			$db = new mysqli("localhost", "root", "", "test");
			if ($db->connect_error) {
				die("Connection failed: " . $db->connect_error);
			}
			
			$sql = "SELECT * FROM users WHERE password = '".$pass."'";
			$result = $db->query($sql);
			if($result->num_rows == 1)
			{
				echo "Logged in successfully as ".$user.". Back to <a href=\"index.php\">home page</a>";
				$_SESSION['login'] = array(true, $user);
			}
			else
			{
				echo "Name or password are incorrect";
			}
			echo "<br />";
		}
		?>
	</body>
</html>
