<?php
  
  // Include database file
  include 'pozicanie.php';

  $pozicanieObj = new Pozicanie();

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

<div class="card text-left" style="padding:15px;">
  <h4>Informačný systém pre knižnicu</h4>
</div>

<nav class="navbar navbar-expand-lg  navbar-light bg-light">
  <a class="navbar-brand">Menu</a>
    <div class="navbar-nav">
     <li> <a class="nav-item nav-link" href="index.php">Zoznam kníh <span class="sr-only">(current)</span></a></li>
     <li> <a class="nav-item nav-link active" href="ipozicovna.php">Záznamy o požičaní kníh</a></li>
    </div>
  </div>
</nav>

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


  <h2>Záznamy o požičaní knihy
    <a href="addpozicanie.php" class="btn btn-primary" style="float:right;">Pridať nový záznam o požičaní</a>
  </h2>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id požičania</th>
        <th>Meno zákazníka</th>
        <th>Názov knihy</th>
        <th>Dátum od</th>
        <th>Dátum do</th>
        <th>Stav</th>
      </tr>
    </thead>
    <tbody>
        <?php 
          $pozicanie = $pozicanieObj->displayData();
          if ($pozicanie!=null)
          {
          foreach ($pozicanie as $pozicanie) 
          {
            ?>
            <tr>
              <td><?php echo $pozicanie['idpozicania'] ?></td>
              <td><?php echo $pozicanie['meno_zakaznika'] ?></td>
              <td><?php echo $pozicanie['nazov_knihy'] ?></td>
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