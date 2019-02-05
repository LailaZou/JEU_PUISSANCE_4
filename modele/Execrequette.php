<?php 

	require_once("../modele/gestion_BD.php");
	require_once("../controleur/header.php");
	
	/**
	 * la classs qui va executer les requettes
	 */
	class Execrequette
	{
		private $connexion;
		public function __construct()
		{
			$this->connexion = new gestion_BD();
		}

		/**
		 * method pren comme parametre
		 * un tableau des post 
		 *pour valider l'authentification
		*/
		
		public  function auth($tab)
		{
			$rep=false;
			$requete = $this->connexion->getConnexion()->query("SELECT * FROM joueurs");
				while($cherche=$requete->fetch())
				{
					if($cherche['login']==$tab['login'] && $cherche['pass']==$tab['mdp'])
					{
						$_SESSION["connecte"] = true;
						$_SESSION["login"] = $cherche['login'];
						$rep=true;
						break;
					}	
			    }
			   
			if ($rep) {
				return true;
			} else {
				return false;
			}
		}
		public  function AugmentScore()
		{
			$b=$_SESSION["login"];
			$requete = $this->connexion->getConnexion()->query("SELECT * FROM joueurs");
			//puisqu'on a une seule ligne on utilise if au lieux de while
			while($cherche=$requete->fetch())
			{
				if($cherche['login']==$b)
				{
					$score=$cherche['score'];
					$score++;
					$q = $this->connexion->getConnexion()->prepare("UPDATE joueurs SET score=:sc WHERE login=:Log");
					$q->bindParam(':sc', $score);
					$q->bindParam(':Log', $b);
					$q->execute();
					break;
				}
			}
		}

		public function Inscription($tab)
		{
			$nom = $tab['nom'];
			$prenom = $tab['prenom'];
			$login = $tab['login'];
			$pass=$tab['mdp'];
			if($nom=="" || $prenom=="" || $login=="" || $pass=="") return false;
		    try{
				    	if($requete = $this->connexion->getConnexion()->exec("INSERT INTO joueurs(login,pass,nom,prenom) VALUES('$login','$pass','$nom','$prenom')"))
		    		{
			    			return true;
			    	}	    		
			    	else
			    	{
			    			return false;
							
			    	}
		    }	
		    catch(PDOException $e){
		      printf("Échec de la connexion : %s\n", $e->getMessage()); exit();
		      }
		   
		}
		//fonction pour recuperer la listes des scores selon les joueurs gagnant
		public function RecupererListe()
		{

			$requete = $this->connexion->getConnexion()->prepare("SELECT * FROM joueurs ORDER BY score DESC");
	    	$requete->execute();
	    	$res = $requete -> fetchall();
	    	
	        return $res;
	            
		}

		
	}
?>
