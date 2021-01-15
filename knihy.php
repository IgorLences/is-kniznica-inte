<?php
class Knihy
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

        // Insert customer data into customer table idknihy, nazov, autor, pocet_stran, pocet_na_sklade
		public function insertData($post)
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
			    echo "Uloženie bolo neúspešné";
			}
		}

		// Fetch customer records for show listing
		public function displayData()
		{
		    $query = "SELECT * FROM knihy";
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

		// Fetch single data for edit from customer table
		public function displyaRecordById($idknihy)
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


		public function IdKnihyByNazov($nazov)
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

		// Update customer data into customer table
		public function updateRecord($postData)
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
			    echo "Uloženie bolo neúspešné";
			}
		    }
			
		}

		// Delete customer data from customer table
		public function deleteRecord($idknihy)
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