<?php
  session_start();
  // Include database file
  include 'pozicanie.php';

  $pozicanieObj = new Pozicanie();
  if (!isset($_SESSION['fstav'])) 
  {
    $_SESSION['fstav']="Všetko";
  }
  
  // select
  if(isset($_GET['fstav']) && !empty($_GET['fstav']))  
  {
    $_SESSION['fstav'] = $_GET['fstav'];
      echo $_SESSION['fstav'];
  }

 //Current page
 if (isset($_GET['page_no']) && !empty($_GET['page_no'])) 
 {
   $page_no = $_GET['page_no'];
   $pozicanie=$pozicanieObj->displayData($page_no); 
 } 
 else
 {
   $page_no = 1;
   $pozicanie=$pozicanieObj->displayData($page_no);
 }

  // Delete record from table
  if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) 
  {
      $deleteId = $_GET['deleteId'];
      $pozicanieObj->deleteRecord($deleteId);
  }
  



?> 
<!DOCTYPE html>
<html lang = "sk">
<head>
  <title>Informačný systém pre knižnicu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>

<div class="container-fluid  bg-primary text-white " style="padding:15px;">
<br>
<h1>Informačný systém pre knižnicu</h1>
<br>
</div>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="index.php">Zoznam kníh</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="ipozicovna.php">Záznamy o požičaní kníh</a>
  </li>
</ul>

<br><br> 

<div class="container">
  <?php
    if (isset($_GET['msg1']) == "insert") 
    {
      echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Uloženie bolo úspešné
            </div>";
      } 
    if (isset($_GET['msg2']) == "update")
    {
      echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Zmena bola uložená
            </div>";
    }
    if (isset($_GET['msg3']) == "delete") 
    {
      echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Odstránenie bolo úspešné
            </div>";
    }
  ?>


  <h2>Záznamy o požičaní kníh
    <a href="addpozicanie.php" class="btn btn-primary" style="float:right;">Pridať nový záznam o požičaní</a>
  </h2><br>
  


  
<div class="container-fluid">
  <div class="row">
    <div class="col-auto">

      <nav aria-label="...">
        <ul class="pagination">
        <?php 
              $data = $pozicanieObj->calcPages($page_no);
              $total_no_of_pages = $data[2];
              $previous_page = $page_no - 1;
              $next_page = $page_no + 1;
        ?>
          <li <?php if($page_no <= 1){echo 'class="page-item disabled"';} else {echo 'class="page-item"';} ?>>
            <a class="page-link" <?php echo "href='?page_no=$previous_page'"?> tabindex="-1" aria-disabled="true">Predchádzajúca</a>
          </li>

          <li <?php if($page_no <= 1){echo 'class="page-item disabled"';} else {echo 'class="page-item"';} ?>>
          <a class="page-link" <?php echo "href='?page_no=$previous_page'"?>><?php echo $previous_page;?></a>
          </li>

          <li class="page-item active" aria-current="page">
          <a class="page-link" <?php echo "href='?page_no=$page_no'"?>><?php echo $page_no;?></a>
          </li>

          <li <?php if($page_no >= $total_no_of_pages){echo 'class="page-item disabled"';} else {echo 'class="page-item"';} ?>>
          <a class="page-link" <?php echo "href='?page_no=$next_page'"?>><?php echo $next_page;?></a>
          </li>

          <li <?php if($page_no >= $total_no_of_pages){echo 'class="page-item disabled"';} else {echo 'class="page-item"';} ?>>
          <a class="page-link" <?php echo "href='?page_no=$next_page'"?>>Ďalšia</a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="col">     
    </div>
    
  <div class="col-auto">
    <form method="get" action="ipozicovna.php" class="form-inline">
      <div class="form-row align-items-center">
      <div class="col-auto">
      <label for="fstav" class="col-form-label-lg" >Stav</label>
      </div>
        <div class="col-auto">
          <select name="fstav"  class="form-control">
                      <option>Všetko</option>
                      <option>Vrátená</option>
                      <option>Nevrátená</option>
            </select>
        </div>
      <div class="col-auto">
          <button type="submit" class="btn btn-primary mb-2">Zobraz</button>
      </div>
     </div>
    </form>
  </div>
</div>




<div class="container-fluid">
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>Id požičania</th>
        <th>Meno zákazníka</th>
        <th>Názov knihy</th>
        <th>Dátum od</th>
        <th>Dátum do</th>
        <th>Stav</th>
        <th>Upraviť/Zmazať</th>
      </tr>
    </thead>
    <tbody>

        <?php 
          if ($pozicanie!=null)
          {
          foreach ($pozicanie as $pozicanie) 
          {
          ?>
            <tr>
              <td><?php echo $pozicanie['idpozicania'] ?></td>
              <td><?php echo $pozicanie['meno_zakaznika'] ?></td>
              <td><?php echo $pozicanie['nazov'] ?></td>
              <td><?php echo $pozicanie['datum_od'] ?></td>
              <td><?php echo $pozicanie['datum_do'] ?></td>
              <td><?php echo $pozicanie['stav'] ?></td>
              <td>
                <a href="editpozicanie.php?editId=<?php echo $pozicanie['idpozicania'] ?>" style="color:green">
                  <i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp
                  <a href="ipozicovna.php?deleteId=<?php echo $pozicanie['idpozicania'] ?>" style="color:red" onclick="confirm('Naozaj chcete odstrániť tento záznam?')">
                  <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
              </td>
            </tr>
          <?php 
          }
          } 
          ?>
    </tbody>
  </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>