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
			    header("Location:add.php?msg1=notsucces");
			}
		}
		// Počet stránok
		public function calcPages($page_no)
		{
			$total_records_per_page = 3;
			$offset = ($page_no-1) * $total_records_per_page;
			
			$adjacents = "2";
			$query = "SELECT COUNT(*) as total_records FROM knihy";
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

		// Fetch customer records for show listing
		public function displayData($page_no)
		{
			$limit=$this->calcPages($page_no);
		    $query = "SELECT * FROM knihy LIMIT $limit[1],$limit[3]";
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

		// Fetch single data for edit from customer table
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

// Fetch single data for edit from customer table
		public function displyaRecordByPocetNaSklade()
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
			    header("Location:edit.php?msg1=notsucces");;
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