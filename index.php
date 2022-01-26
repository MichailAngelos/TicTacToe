<?php

require_once('class.game.php');
require_once('class.tictactoe.php');

session_start();

if (!isset($_SESSION['game']['tictactoe']))
	$_SESSION['game']['tictactoe'] = new tictactoe();

?>
<html>
	<head>
		<title>Tic Tac Toe</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body style="background-color: aquamarine">
		<div id="content">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<h2>Let's Play Tic Tac Toe!</h2>
		<?php
			$_SESSION['game']['tictactoe']->playGame($_POST);
		?>
		</form>
		</div>
	</body>
</html>
