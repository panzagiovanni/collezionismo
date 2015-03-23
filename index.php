<?php
session_start();

if(isset($_GET['mode']))
{
	if($_GET['mode'] == 'logout')
	{
		session_destroy();
		header("Location: index.php");
	}
}

if(!isset($_SESSION['login']))
{
	$_SESSION['login'] = array(false, "");
}
?>
<html>
	<head>
		<title>Index - Website</title>
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
		<div id="login-box">
			<?php
			if($_SESSION['login'][0])
			{
				print "Logged as <i>".$_SESSION['login'][1]."</i> - <a href=\"?mode=logout\">logout</a>";
			}
			else
			{
				print '<a href="login.php">Login</a>';
			}
			?>
		</div>
		<div id="header">Feedback Website</div>
		Website di presentazione per gestire i feedback. Dalla email ho potuto determinare questi punti:
		<ul>
			<li>Inserimento dei feedback</li>
			<li>Cerca per ditta</li>
			<li>Cerca ditte per prodotto</li>
			<li>Profilo di una ditta con percentuale affidabilit&agrave;</li>
			<li>Possibilit&agrave; di un utente di lasciare una recensione sul profilo della ditta</li>
		</ul>
		Piano piano cercher&ograve; di implementarli tutti, ma &egrave; solo una versione di prova!<br />
		
		Profili di aziende:
		<ul>
			<li><a href="company_profile.php?id=1">Azienda1</a></li>
			<li><a href="company_profile.php?id=2">Azienda2</a></li>
			<li><a href="company_profile.php?id=3">Azienda3</a></li>
		</ul>
	</body>
</html>
