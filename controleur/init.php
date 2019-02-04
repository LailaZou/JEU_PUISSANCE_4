<?php
require_once("hautlarg.php");
//Initialise le plateau de jeu
class init{

	function __construct(){
	
	}

	function init() {
	$board = array();
		for ($i=0; $i<LARG; $i++) 
		{
		    for ($j=0; $j<HAUT; $j++) 
		    {
				$board[$i][$j]=0;
		    }
		}
	return $board;
    }
}
?>
