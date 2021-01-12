<?php
  
  // Include database file
  include 'knihy.php';

  $knihyObj = new Knihy();

  // Delete record from table
  if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) 
  {
      $deleteId = $_GET['deleteId'];
      $knihyObj->deleteRecord($deleteId);
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

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">Zoznam kníh <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="ipozicovna.php">Záznamy o požičaní kníh</a>
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


  <h2>Knihy
    <a href="add.php" class="btn btn-primary" style="float:right;">Pridať novú knihu</a>
  </h2>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id knihy</th>
        <th>Názov</th>
        <th>Autor</th>
        <th>Pocet strán</th>
        <th>Stav</th>
      </tr>
    </thead>
    <tbody>
        <?php 
          $knihy = $knihyObj->displayData();
          if ($knihy!=null)
          {
          foreach ($knihy as $knihy) 
          {
            ?>
            <tr>
              <td><?php echo $knihy['idknihy'] ?></td>
              <td><?php echo $knihy['nazov'] ?></td>
              <td><?php echo $knihy['autor'] ?></td>
              <td><?php echo $knihy['pocet_stran'] ?></td>
              <td><?php echo $knihy['stav'] ?></td>
              <td>
                <a href="edit.php?editId=<?php echo $knihy['idknihy'] ?>" style="color:green">
                  <i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp
                <a href="index.php?deleteId=<?php echo $knihy['idknihy'] ?>" style="color:red" onclick="confirm('Naozaj chcete odstrániť túto knihu?')">
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