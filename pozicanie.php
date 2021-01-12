<?php
class Pozicanie
	{
		private $servername = "eu-cdbr-west-03.cleardb.net";
		private $username   = "b04b42a934c174";
		private $password   = "748e6c6c";
		private $database   = "heroku_db3c94d1d9b65dd";
		public  $con;


		// Database Connection 
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

        // Insert customer data into customer table idpozicania, meno_zakaznika, nazov_knihy, datum_od, datum_do, stav
        //
		public function insertData($post)
		{
            $meno_zakaznika = $this->con->real_escape_string($_POST['meno_zakaznika']);
            $nazov_knihy = $this->con->real_escape_string($_POST['nazov_knihy']);
            $datum_od = $this->con->real_escape_string($_POST['datum_od']);
            $datum_do = $this->con->real_escape_string($_POST['datum_do']);
            $stav = $this->con->real_escape_string($_POST['stav']);

            
			$query="INSERT INTO pozicovna(meno_zakaznika, nazov_knihy, datum_od, datum_do, stav) VALUES('$meno_zakaznika','$nazov_knihy','$datum_od','$datum_do','$stav')";
			$sql = $this->con->query($query);
			if ($sql==true) 
			{
			    header("Location:ipozicovna.php?msg1=insert");
			}
			else
			{
			    echo "Uloženie bolo neúspešné";
			}
		}

		// Fetch customer records for show listing
		public function displayData()
		{
		    $query = "SELECT * FROM pozicovna";
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

		// Fetch single data for edit from customer table
		public function displyaRecordById($idpozicania)	{
		    $query = "SELECT * FROM pozicovna WHERE idpozicania = $idpozicania";
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

		// Update customer data into customer table
		public function updateRecord($postData)
		{
		    $idpozicania = $this->con->real_escape_string($_POST['idpozicania']);
			$nazov_knihy = $this->con->real_escape_string($_POST['unazov_knihy']);
            $meno_zakaznika = $this->con->real_escape_string($_POST['umeno_zakaznika']);
            $datum_od = $this->con->real_escape_string($_POST['udatum_od']);
            $datum_do = $this->con->real_escape_string($_POST['udatum_do']);
			$stav = $this->con->real_escape_string($_POST['ustav']);

		if (!empty($idpozicania) && !empty($postData)) 
		{
			$query = "UPDATE pozicovna SET idpozicania = $idpozicania, meno_zakaznika = '$meno_zakaznika', nazov_knihy = '$nazov_knihy', datum_od = '$datum_od', datum_do = '$datum_do', stav = '$stav' WHERE idpozicania = $idpozicania";
			$sql = $this->con->query($query);
			if ($sql==true) 
			{
			    header("Location:ipozicovna.php?msg2=update");
			}
			else
			{
			    echo "Uloženie bolo neúspešné";
			}
		    }
			
		}


		// Delete customer data from customer table
		public function deleteRecord( $idpozicania)
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