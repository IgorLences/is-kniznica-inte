<?php

  // Include database file
  include 'knihy.php';

  $knihyObj = new Knihy();

  // Insert Record in customer table
  if(isset($_POST['submit'])) {
    $knihyObj->insertData($_POST);
  }

?>
<!DOCTYPE html>
<html lang="sk">
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
</div><br><br> 

<div class="container">
  <form action="add.php" method="POST">

    <div class="form-group">
      <label for="nazov">Názov:</label>
      <input type="text" class="form-control" name="nazov" placeholder="Zadajte názov knihy" required="">
    </div>

    <div class="form-group">
      <label for="autor">Autor:</label>
      <input type="text" class="form-control" name="autor" placeholder="Zadajte autora knihy" required="">
    </div>

    <div class="form-group">
      <label for="pocet_stran">Počet strán:</label>
      <input type="text" class="form-control" name="pocet_stran" placeholder="Zadajte počet strán" required="">
    </div>

    <div class="form-group">
      <label for="pocet_na_sklade">Počet na sklade:</label>
      <input type="text" class="form-control" name="pocet_na_sklade" placeholder="Zadajte počet na sklade" required="">
    </div>

    <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Submit">
  </form>
</div><br><br>
<hr class="my-4">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
