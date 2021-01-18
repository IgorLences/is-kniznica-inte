<?php

class Pozicanie
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

         //Vložiť nový záznam o požičaní knihy do datábazy pozicovna(meno_zakaznika, id_knihy, datum_od, datum_do, stav) id je AI
		public function vlozitZaznam($post)
		{
			
            $meno_zakaznika = $this->con->real_escape_string($_POST['meno_zakaznika']);
            $nazov_knihy = $this->con->real_escape_string($_POST['nazov_knihy']);
            $datum_od = $this->con->real_escape_string($_POST['datum_od']);
            $datum_do = $this->con->real_escape_string($_POST['datum_do']);
			$stav = $this->con->real_escape_string($_POST['stav']);
			
			$knihyObj = new Knihy();
			$id_knihy = $knihyObj->idKnihyByNazov($nazov_knihy);

			$query="INSERT INTO pozicovna(meno_zakaznika, id_knihy, datum_od, datum_do, stav) VALUES('$meno_zakaznika',$id_knihy[idknihy],'$datum_od','$datum_do','$stav')";
			$sql = $this->con->query($query);

			if ($sql==true) 
			{
				$knihyObj->updatePocetNaSklade($id_knihy, $stav);
			    header("Location:ipozicovna.php?msg1=insert");
			}
			else
			{
			    header("Location:addpozicanie.php?msg1=notsucces");
			}
			
		}

		// Výpočet potrebných premenných na stránkovanie
		public function vypStrankovanie($page_no)
		{
			$filterstav=$_SESSION['fstav'];
			if ($filterstav == "Všetko") {$fstav = "pozicovna.stav";}
			if ($filterstav == "Vrátená") {$fstav = "'Vrátená'";}
			if ($filterstav == "Nevrátená") {$fstav = "'Nevrátená'";}
			$total_records_per_page = 3;
			$offset = ($page_no-1) * $total_records_per_page;
			
			$adjacents = "2";
			$query = "SELECT COUNT(*) as total_records FROM pozicovna WHERE stav = $fstav";
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

		//Select záznamy podľa požadovanej stránky a filtru z databázy pozicovna a knihy na následné zobrazenie
		public function zobrazZaznamy($page_no)
		{
			$filterstav=$_SESSION['fstav'];
			if ($filterstav == "Všetko") {$fstav = "pozicovna.stav";}
			if ($filterstav == "Vrátená") {$fstav = "'Vrátená'";}
			if ($filterstav == "Nevrátená") {$fstav = "'Nevrátená'";}
			$limit=$this->vypStrankovanie($page_no);
		    $query = "SELECT pozicovna.idpozicania, knihy.nazov, pozicovna.meno_zakaznika, pozicovna.datum_od, pozicovna.datum_do, pozicovna.stav FROM pozicovna INNER JOIN knihy ON pozicovna.id_knihy = knihy.idknihy WHERE pozicovna.stav = $fstav LIMIT $limit[1],$limit[3]";
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
			 echo "Neboli nájdené žiadne záznamy o požičaní knihy";
		    }
		}

		// Select jeden záznam  z databázy pozicovna podľa id
		public function zobrazZaznamById($idpozicania)	
		{
			$query = "SELECT pozicovna.idpozicania, knihy.nazov, pozicovna.meno_zakaznika, pozicovna.datum_od, pozicovna.datum_do, pozicovna.stav FROM pozicovna INNER JOIN knihy ON pozicovna.id_knihy = knihy.idknihy WHERE idpozicania = $idpozicania";
		    $result = $this->con->query($query);
			if ($result->num_rows > 0) 
			{
			$row = $result->fetch_assoc();
			return $row;
			}
			else
			{
			echo "Neboli nájdené žiadne záznamy o požičaní knihy";
		    }
		}


		//Update záznamu v databáze pozicovna
		public function updateZaznam($postData)
		{
			$idpozicania = $this->con->real_escape_string($_POST['idpozicania']);
			$nazov_knihy_old = $this->con->real_escape_string($_POST['nazov_knihy_old']);
			$nazov_knihy = $this->con->real_escape_string($_POST['unazov_knihy']);
            $meno_zakaznika = $this->con->real_escape_string($_POST['umeno_zakaznika']);
            $datum_od = $this->con->real_escape_string($_POST['udatum_od']);
            $datum_do = $this->con->real_escape_string($_POST['udatum_do']);
			$stav = $this->con->real_escape_string($_POST['ustav']);

			$knihyObj = new Knihy();
			$id_knihy = $knihyObj->idKnihyByNazov($nazov_knihy);
			$idknihy = $knihyObj->idKnihyByNazov($nazov_knihy_old);

		if (!empty($idpozicania) && !empty($postData)) 
		{
			$query = "UPDATE pozicovna SET idpozicania = $idpozicania, meno_zakaznika = '$meno_zakaznika', id_knihy = $id_knihy[idknihy], datum_od = '$datum_od', datum_do = '$datum_do', stav = '$stav' WHERE idpozicania = $idpozicania";
			$sql = $this->con->query($query);
			if ($sql==true) 
			{
				if($idknihy != $id_knihy)
				{
					$knihyObj->updatePocetNaSklade($idknihy, "Vrátená");
				}
				$knihyObj->updatePocetNaSklade($id_knihy, $stav);
			    header("Location:ipozicovna.php?msg2=update");
			}
			else
			{
			    header("Location:editpozicanie.php?msg1=notsucces");
			}
		    }
			
		}


		// Delete záznamu z databázy pozicanie podľa idpozicanie
		public function deleteZaznam( $idpozicania)
		{
		    $query = "DELETE FROM pozicovna WHERE  idpozicania = $idpozicania";
		    $sql = $this->con->query($query);
			if ($sql==true) 
			{
				header("Location:ipozicovna.php?msg3=delete");
			}
			else
			{
			echo "Odstránenie záznamu bolo neúspešné";
		    }
		}

	}
?>