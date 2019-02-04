<?php
define("MAX_DEPTH", 5);

class C4AI{
	private $a, $b;
    private $bestMove = NULL;//entier entre 0 et 6
    private $allMoves = array();
	private $ref = array();//relie entre les colonne et l'indexe superieur vides
	private $score = 0;
	private static $instance = NULL;
	private function __construct(){}
	public static function getInstance(){
		if(C4AI::$instance == NULL){
			C4AI::$instance = new C4AI();
		}
		return C4AI::$instance;
	}


	private function min(&$board, $depth, $alpha, $beta){
		$min = NULL;
		$won = false;
		$beta = INF;
		for($i = 0; $i < 7; $i++){
			if($board[0][$i] != 0){
				//toute la colnne est vide
				continue;
			}
			//on joue et calcule le max
			$this->doMove($board, $i, $this->b);
			if($this->hasWon($board, $this->ref[$i]+1, $i, $this->b)){
				$val = -10000 + $depth;
				$won = true;
			}
			else if($depth+1 >= MAX_DEPTH){
				$val = $this->score($board);
			}
			else{
				$val = $this->max($board, $depth+1, $alpha, $beta);
			}
			$this->undoMove($board, $i, $this->b);
			if($min == NULL || $val < $min){
				$min = $val;
				$beta = $val;
			}
			if($won){
				break;
			}
			if($beta < $alpha){
				//si ce partent a une valeur inferieur à best alpha => no chance
				return $beta;
			}
		}
		if($min == NULL){
			//aucun best move
			return $this->score($board);
		}
		else{
			return $min;
		}
	}

	private function max(&$board, $depth, $alpha, $beta){
		$max = NULL;
		$won = false;
		$alpha = -1 * INF; 
		for($i = 0; $i < 7; $i++){
			//printf("Max d%d, a%d, b%d\n", $depth, $alpha, $beta);
			if($board[0][$i] != 0){
				continue;
			}
			//joue et calcule le min
			$this->doMove($board, $i, $this->a);
			if($this->hasWon($board, $this->ref[$i]+1, $i, $this->a)){
				$val = 10000 - $depth; //la logueeur pour reussir
				$won = true;
			}
			else if($depth+1 >= MAX_DEPTH){
				$val = $this->score($board);
			}
			else{
				$val = $this->min($board, $depth+1, $alpha, $beta);
            }
            if ($depth == 0){
                $this->allMoves[$i] = $val;
            }

			$this->undoMove($board, $i, $this->a);
			if($max == NULL || $val > $max){
				$max = $val;
				$alpha = $val;
				if($depth == 0){
					$this->bestMove = $i;
				}
			}
			if($won){ break; }
			if($alpha > $beta && $depth != 0){
				//max val  > beta = > aucune chance
				return $alpha;
			}
		}
		if($max == NULL){
			//auncun move
			return $this->score($board);
		}
		else{
			return $max;
		}
	}

	//jouer
	public function doMove(&$board, $i, $player){
		if($this->ref[$i] < 0){
			throw new Exception("Cannot make move");
		}
		$board[$this->ref[$i]][$i] = $player;
		$this->ref[$i] = $this->ref[$i] - 1;
    }

    //retour
	public function undoMove(&$board, $i, $player){
		if($this->ref[$i] > 6 || $board[$this->ref[$i]+1][$i] != $player){
			throw new Exception("Cannot undo move, unexpected player");
		}
		$board[$this->ref[$i]+1][$i] = 0;
		$this->ref[$i] = $this->ref[$i] + 1;
    }

    //semblable à est_gagnat
	public function hasWon(&$board, $iStart, $jStart, $player){
		//horizontal
		$hCount = 1;
		$i = $iStart;
		$j = $jStart-1;
		while($j >= 0){
			if($board[$i][$j] == $player){
				$hCount++;
			}	
			else{break;}
			$j--;
		}
		$j = $jStart+1;
		while($j < 7){
			if($board[$i][$j] == $player){
				$hCount++;
			}	
			else{break;}
			$j++;
		}
		//vertical
		$vCount = 1;
		$i = $iStart-1;
		$j = $jStart;
		while($i >= 0){
			if($board[$i][$j] == $player){
				$vCount++;
			}	
			else{break;}
			$i--;
		}
		$i = $iStart+1;
		while($i < 6){
			if($board[$i][$j] == $player){
				$vCount++;
			}	
			else{break;}
			$i++;
		}
		//diagonal
		$d1Count = 1;
		$i = $iStart-1;
		$j = $jStart+1;
		while($i >= 0 && $j < 7){
			if($board[$i][$j] == $player){
				$d1Count++;
			}	
			else{break;}
			$i--;
			$j++;
		}
		$i = $iStart+1;
		$j = $jStart-1;
		while($i < 6 && $j >= 0){
			if($board[$i][$j] == $player){
				$d1Count++;
			}	
			else{break;}
			$i++;
			$j--;
		}
		// diagonal 
		$d2Count = 1;
		$i = $iStart-1;
		$j = $jStart-1;
		while($i >= 0 && $j >= 0){
			if($board[$i][$j] == $player){
				$d2Count++;
			}	
			else{break;}
			$i--;
			$j--;
		}
		$i = $iStart+1;
		$j = $jStart+1;
		while($i < 6 && $j < 7){
			if($board[$i][$j] == $player){
				$d2Count++;
			}	
			else{break;}
			$i++;
			$j++;
		}
		if($hCount >= 4 || $vCount >= 4 || $d1Count >= 4 || $d2Count >= 4){
			return true;
		}
		else{
			return false;
		}

	}
	private function scoreDiff(&$board, $i, $j, $player){

	}
	//Qui le joueur
	private function playerWeight($player){
		return $player == $this->a ? 1 : -1;
    }
    
	
	private function scorePath(&$board, $iStart, $jStart, $iStep, $jStep){
		$score = 0;
		//pour chaque ligne, on compte les possibilite de reussir
		$lspaces = 0;
		$rspaces = 0;
		$curPlayer = -1;
		$curPlayerCount = 0;
		$end = false;
		$i = $iStart;
		$j = $jStart;
		while($i < 6 && $j < 7 && $i >= 0 && $j >= 0){
			//printf("i%d,j%d,is%d,js%d\n", $i,$j, $iStep,$jStep);
			if($board[$i][$j] == 0){
				if($curPlayer != -1){
					//la fin
					$end = true;
				}
				else{
					$lspaces++;
				}
			}
			else{
				if($curPlayer != -1){
					if($curPlayer != $board[$i][$j]){
						//fin
						$end = true;
					}
					else{
						//continuer
						$curPlayerCount++;
					}
				}
				else{
					//1 er
					$curPlayer = $board[$i][$j];
					$curPlayerCount++;
				}
			}

			if($end){
				$ip = $i;
				$jp = $j;//i prime, j prime
				while($ip < 6 && $jp < 7 && $ip >= 0 && $jp >= 0){
					if($board[$ip][$jp] == 0){
						$rspaces++;
					}
					else{
						break;
					}
					$ip += $iStep;
					$jp += $jStep;
				}
				if($rspaces + $lspaces + $curPlayerCount >= 4){

						$score +=  $curPlayerCount * $this->playerWeight($curPlayer);
					
				}
				$curPlayerCount = 0;
				$curPlayer = -1;
				$lspaces = 0;//reset 
				$rspaces = 0;
				$end = false;
				$j -= $jStep;
				$i -= $iStep;
			}
			$i += $iStep;
			$j += $jStep;
		}

		return $score;

	}

	public function score(&$board){
		$score = 0;
		$curPlayer = -1;
		//pour chaque colonne calcule le max chemin
		for($j = 0; $j < 7; $j++){
			if($this->ref[$j] >= -1 && $this->ref[$j] < 5){
				$pathLength = 0;
				$curPlayer = $board[$this->ref[$j]+1][$j];
				for($i = $this->ref[$j]+1; $i < 6; $i++){
					if($board[$i][$j] != $curPlayer){
						break;
					}
					else{
						$pathLength++;
					}
				}
				if(4 - $pathLength < $this->ref[$j] + 1){

				}
				else{
					if($pathLength >= 4){
						//reusii
						$score += 1000 * $this->playerWeight($curPlayer);
					}
					else{
						//n'a pas reussi
						$score += $pathLength * $this->playerWeight($curPlayer);
					}
				}
			}
		}
		//lignes
		for($i = 0; $i < 6; $i++){
			$score += $this->scorePath($board, $i, 0, 0, 1);
		}
		//diagonals
		for($i = 3; $i < 6; $i++){
			$score += $this->scorePath($board, $i, 0, -1, 1);
		}
		for($j = 1; $j <= 3; $j++){
			$score += $this->scorePath($board, 6, $j, -1, 1);
		}

		for($i = 0; $i <= 3; $i++){
			$score += $this->scorePath($board, $i, 0, 1, 1);
		}
		for($j = 1; $j <= 3; $j++){
			$score += $this->scorePath($board, 0, $j, 1, 1);
		}

		return $score;
    }

	public function findAllMoves(&$board, $mainPlayer){
		$this->a = $mainPlayer;
		if($this->a != 1 && $this->a != 2){
			throw new Exception("Player should be integer, 1 or 2");
		}
		if($this->a == 1){
			$this->b = 2;
		}
		else{
			$this->b = 1;
		}

		if(sizeof($board) != 6 || sizeof($board[0]) != 7){
			throw new InvalidArgumentException("Board must be 6x7");	
		}
		$this->ref = array(-1,-1,-1,-1,-1,-1,-1);
		for($j = 0; $j < 7; $j++){
			for($i = 5; $i >= 0; $i--){
				if($board[$i][$j] == 0){
					$this->ref[$j] = $i;
					break;
				}
			}
		}
        $this->max($board, 0, 0, 0);
        return $this->allMoves;
    }

    public function findBestMove(&$board, $mainPlayer){
        findAllMoves($board, $mainPlayer);
		return $this->bestMove;
    }

	public function printBoard(&$board){
		for($i = 0; $i < 6; $i++){
			for($j = 0; $j < 7; $j++){
				printf("%d ", $board[$i][$j]);
			}
			printf("\n");
		}
	}
	public function getBestPos($board , $joueur){

	$move = $this->findAllMoves($board , $joueur);
	$bestPos=0;
	for ($i=0; $i < sizeof($move); $i++) {
		if($move[$i] >= $move[$bestPos]) $bestPos = $i;
		echo $move[$i]."<br>";
	} 


	return $bestPos;
	}

}




?>
