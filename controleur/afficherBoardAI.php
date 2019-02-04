<?php
	require_once("affichageClass.php");
	require_once("C4AI.php");
	require_once("hautlarg.php");
	require_once("validateClass.php");

	function reverse($board){
		//$board[$i][$line];
			$boardRes = array(
			array(0, 0, 0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0, 0, 0)
			);

		$boardRes = array(
			array($board[0][5], $board[1][5], $board[2][5], $board[3][5], $board[4][5], $board[5][5], $board[6][5]),
			array($board[0][4], $board[1][4], $board[2][4], $board[3][4], $board[4][4], $board[5][4], $board[6][4]),
			array($board[0][3], $board[1][3], $board[2][3], $board[3][3], $board[4][3], $board[5][3], $board[6][3]),
			array($board[0][2], $board[1][2], $board[2][2], $board[3][2], $board[4][2], $board[5][2], $board[6][2]),
			array($board[0][1], $board[1][1], $board[2][1], $board[3][1], $board[4][1], $board[5][1], $board[6][1]),
			array($board[0][0], $board[1][0], $board[2][0], $board[3][0], $board[4][0], $board[5][0], $board[6][0])
			);
		return $boardRes;
	}


	$affich = new affichage();

	if($_SESSION["finish"]==false){
		//Jouer par computer
		if($_SESSION["turn"] == 2){
			$board = $_SESSION["board"];
			$boardR = reverse($board);
			if($_SESSION["mode"]=="easy"){
				$bestPos = rand(0 , 6);
				$valide = new validate();
				$continue = true;
				while($continue){
					if($valide->est_valide($bestPos)){
						$continue = false;
					}
				}
			} 
			else{
				$ai = C4AI::getInstance();
				$bestPos = $ai->getBestPos($boardR ,2);
			}

			require_once("jouerComputer.php");
			$affich->print_board_AI();
		}
		 else{
		    $affich->print_board_AI();
		}
	//Afficher encor
	}
	else{
		$affich->print_board_final();
		$gagne = (($_SESSION["turn"] == 1)? "Vous avez gagné!!" : "Game over");
		unset($_SESSION["board"]); 
	}

	$turnNom = (($_SESSION["turn"] == 1)? $_SESSION["nomj1"] : $_SESSION["nomj2"]);
	//$turnPion = $_SESSION["turnPion"];
	$j1 = $_SESSION["nomj1"];
	$j2 = $_SESSION["nomj2"];
?>