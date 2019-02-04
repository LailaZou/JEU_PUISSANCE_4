<?php
require_once("hautlarg.php");

class affichage{

private $_board ;

	function __construct(){
	}

	//function print_line
	private function affiche_line($line) {
	$board = $_SESSION["board"];
	echo "<tr>\n";
	for ($i=0; $i<LARG; $i++) {
	    $c = $board[$i][$line];
	    echo '<td><img src="../img/';
	    echo (($c == 0) ? "vide.png" : (($c == 1) ? "joueur1.png" : "joueur2.png"));
	    echo '" alt="';
	    echo (($c == 0) ? "0" : (($c == 1) ? "j1" : "j2"));
	    echo '" /></td>'; 
	}
	echo "\n</tr>\n";
    }

    // attention : pour faire plus joli, on nomme les colonnes de 1 a 7.
    // Il faut donc faire attention lorsque l'on recupere la valeur de la colonne jouee.
    //function print_line_form() {
    function affiche_choix(){
	echo '<tr class="lastline">'."\n";
	for ($i=0; $i<LARG; $i++) {
	    echo '<td><input type="submit" name="col" value="'.($i + 1).'" class="numCol" /></td>';
	}
	echo "\n</tr>\n";
    }

    //affichage de tout le plateau {
    function affiche_plateau() {
	echo '<form class="intable" action="../controleur/p4.php" method="post">'."\n";
	echo '<table>'."\n";
	for ($i=(HAUT - 1); $i>=0; $i--) $this->affiche_line($i);
	$this->affiche_choix();
	echo "</table>\n</form>\n";
    }

    //affichage lors de la fin de la partie
    function print_board_final() {
	echo '<table>'."\n";
	for ($i=(HAUT - 1); $i>=0; $i--) $this->affiche_line($i);
	echo "</table>\n";
    }

    //affichage dans le cas de jeu contre la machine
    function print_board_AI() {
	echo '<form class="intable" action="../controleur/p4AI.php" method="post">'."\n";
	echo '<table>'."\n";
	for ($i=(HAUT - 1); $i>=0; $i--) $this->affiche_line($i);
	$this->affiche_choix();
	echo "</table>\n</form>\n";
    }



}
