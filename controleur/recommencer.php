<?php
//Detruit la session
    session_start();
	session_destroy();
	require_once("header.php");
	header("Location: ".$server."vue/ff.php");
?>
