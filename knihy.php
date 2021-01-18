<?php
class Knihy
	{
		private $servername = "eu-cdbr-west-03.cleardb.net";
		private $username   = "b04b42a934c174";
		private $password   = "748e6c6c";
		private $database   = "heroku_db3c94d1d9b65dd";
		public  $con;


		// Vytvorenie pripojenia k databáze
		public function __construct()
		{
		    $this->con = new mysqli($this->servername, $this->username,$this->password,$this->database);
			if(mysqli_connect_error()) 
			{
			 trigger_error("Nepodarilo sa pripojiť na DB: " . mysqli_connect_error());
			}else
			{
			return $this->con;
		    }
		}

        //Vložiť novú knihu do datábazy knihy(nazov, autor, pocet_stran, pocet_na_sklade) id je AI
		public function vlozitZaznam($post)
		{
			$nazov = $this->con->real_escape_string($_POST['nazov']);
			$autor = $this->con->real_escape_string($_POST['autor']);
            $pocet_stran = $this->con->real_escape_string($_POST['pocet_stran']);
            $pocet_na_sklade = $this->con->real_escape_string($_POST['pocet_na_sklade']);
            
			$query="INSERT INTO knihy(nazov, autor, pocet_stran, pocet_na_sklade) VALUES('$nazov','$autor',$pocet_stran,$pocet_na_sklade)";
			$sql = $this->con->query($query);
			if ($sql==true) 
			{
			    header("Location:index.php?msg1=insert");
			}
			else
			{
			    header("Location:add.php?msg1=notsucces");
			}
		}

		// Výpočet potrebných premenných na stránkovanie
		public function vypStrankovanie($page_no)
		{
			$filterautor=$_SESSION['fautor'];
			if ($filterautor == "Všetko") {$fautor = "autor";}
			else {$fautor= "'".$filterautor."'" ;}
			$total_records_per_page = 3;
			$offset = ($page_no-1) * $total_records_per_page;
			
			$adjacents = "2";
			$query = "SELECT COUNT(*) as total_records FROM knihy WHERE autor = $fautor";
			$result_count = $this->con->query($query);
			$total_records = mysqli_fetch_array($result_count);
			$total_records = $total_records['total_records'];
			$total_no_of_pages = ceil($total_records / $total_records_per_page);
			$second_last = $total_no_of_pages - 1; // total pages minus 1
			$data = array();
			$data[1] = $offset;
			$data[2] = $total_no_of_pages;
			$data[3] = $total_records_per_page;
			return $data;
		}

		//Select záznamy podľa požadovanej stránky a filtru z databázy knihy na následné zobrazenie
		public function zobrazZaznamy($page_no)
		{
			$filterautor=$_SESSION['fautor'];
			if ($filterautor == "Všetko") {$fautor ="autor";}
			else {$fautor= "'".$filterautor."'" ;}
			$limit=$this->vypStrankovanie($page_no);
			$query = "SELECT * FROM knihy  WHERE autor = $fautor LIMIT $limit[1],$limit[3]";
		    $result = $this->con->query($query);
			if ($result->num_rows > 0) 
			{

			while ($row = $result->fetch_assoc()) 
			{
		           $data[] = $row;
		    }
			 return $data;
			}
			else
			{
			echo "Neboli nájdené žiadne knihy";
		    }
		}

		//Select všetky záznamy z databázy knihy na následné zobrazenie
		public function zobrazVsetkyZaznamy()
		{
			$query = "SELECT * FROM knihy";
			$result = $this->con->query($query);
			if ($result->num_rows > 0) 
			{

			while ($row = $result->fetch_assoc()) 
			{
				$data[] = $row;
			}
			return $data;
			}
			else
			{
			echo "Neboli nájdené žiadne knihy";
			}
		}


		// Select jeden záznam  z databázy knihy podľa id
		public function zobrazZaznamById($idknihy)
		{
		    $query = "SELECT * FROM knihy WHERE idknihy = $idknihy";
		    $result = $this->con->query($query);
			if ($result->num_rows > 0) 
			{
			$row = $result->fetch_assoc();
			return $row;
			}
			else
			{
			echo "Neboli nájdené žiadne knihy";
		    }
		}

		//Update počtu na kníh na sklade ak bola vrátená alebo požičaná
		public function updatePocetNaSklade($idknihy, $stav)	
		{
			if($stav == "Vrátená")
			{
				$query="UPDATE knihy SET pocet_na_sklade=(pocet_na_sklade + 1) WHERE idknihy = $idknihy[idknihy]";				
			}
			if($stav == "Nevrátená")
			{
				$query="UPDATE knihy SET pocet_na_sklade=pocet_na_sklade - 1 WHERE idknihy = $idknihy[idknihy]";				
			}
			$result = $this->con->query($query);
			if ($result) 
			{
			return;
			}
			else
			{
			echo "Nepodarilo sa zmeniť počet kníh na sklade";
			}
		}

		// Select  záznamy  z databázy knihy ak sa kniha nachádza na sklade
		public function zobrazZaznamIfNaSklade()
		{
			$query = "SELECT * FROM knihy WHERE pocet_na_sklade > 0";
		    $result = $this->con->query($query);
			if ($result->num_rows > 0) 
			{
		    $data = array();
			while ($row = $result->fetch_assoc()) 
			{
		           $data[] = $row;
		    }
			 return $data;
			}
			else
			{
			 echo "Neboli nájdené žiadne knihy";
		    }
		}

		//Select idknihy z databázy knihy podľa názvu knihy
		public function idKnihyByNazov($nazov)
		{
		    $query = "SELECT idknihy FROM knihy WHERE nazov = '$nazov' ";
		    $result = $this->con->query($query);
			if ($result->num_rows > 0) 
			{
			$row = $result->fetch_assoc();
			return $row;
			}
			else
			{
			echo "Neboli nájdené žiadne knihy";
		    }
		}

		//Update záznamu v databáze knihy
		public function updateZaznam($postData)
		{
		    $idknihy = $this->con->real_escape_string($_POST['idknihy']);
			$nazov = $this->con->real_escape_string($_POST['unazov']);
            $autor = $this->con->real_escape_string($_POST['uautor']);
			$pocet_stran = $this->con->real_escape_string($_POST['upocet_stran']);
			$pocet_na_sklade = $this->con->real_escape_string($_POST['upocet_na_sklade']);

		if (!empty($idknihy) && !empty($postData)) 
		{
			$query = "UPDATE knihy SET idknihy = $idknihy, nazov = '$nazov', autor = '$autor', pocet_stran = $pocet_stran, pocet_na_sklade = $pocet_na_sklade WHERE idknihy = $idknihy";
			$sql = $this->con->query($query);
			if ($sql==true) 
			{
			    header("Location:index.php?msg2=update");
			}
			else
			{
			    header("Location:edit.php?msg1=notsucces");;
			}
		    }
			
		}

		// Delete záznamu z databázy knihy podľa idknihy
		public function deleteZaznam($idknihy)
		{
		    $query = "DELETE FROM knihy WHERE  idknihy = $idknihy";
		    $sql = $this->con->query($query);
			if ($sql==true) 
			{
				header("Location:index.php?msg3=delete");
			}
			else
			{
			echo "Odstránenie záznamu bolo neúspešné";
		    }
		}

	}
?>