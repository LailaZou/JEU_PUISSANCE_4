<?php
	require_once("affichageClass.php");
	$affich = new affichage();
	if($_SESSION["finish"]==false)//si la partie n'est pas terminee
	{
		$affich->affiche_plateau(); //on affiche le plateau
	}
	else{
	$affich->print_board_final();//si la partie est termiée on affiche l'etat finale
	unset($_SESSION["board"]); //on supprime le platau de la session
	$nomGagnant = (($_SESSION["turn"] == 1)? $_SESSION["nomj1"] : $_SESSION["nomj2"]);//le gagnant
	}
	//on modifie les variables de session
	$turnNom = (($_SESSION["turn"] == 1)? $_SESSION["nomj1"] : $_SESSION["nomj2"]);
	$turnPion = $_SESSION["turnPion"];
	$j1 = $_SESSION["nomj1"];
	$j2 = $_SESSION["nomj2"];
?>
