<?php

  // Include database file
  include 'pozicanie.php';

  $pozicanieObj = new Pozicanie();

  // Insert Record in customer table
  if(isset($_POST['submit'])) {
    $pozicanieObj->insertData($_POST);
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

<div class="card text-center" style="padding:15px;">
  <h4>Informačný systém pre knižnicu</h4>
</div><br> 

<div class="container">
  <form action="addpozicanie.php" method="POST">

    <div class="form-group">
      <label for="meno_zakaznika">Meno zákazníka:</label>
      <input type="text" class="form-control" name="meno_zakaznika" placeholder="Zadajte celé meno zákazníka" required="">
    </div>
    
    <div class="form-group">
      <label for="nazov_knihy">Názov knihy:</label>
      <input type="text" class="form-control" name="nazov_knihy" placeholder="Zadajte názov knihy" required="">
    </div>

    <div class="form-group">
      <label for="datum_od">Dátum požičania knihy:</label>
      <input type="text" class="form-control" name="datum_od" placeholder="Zadajte dátum požičania" required="">
    </div>

    <div class="form-group">
      <label for="datum_do">Dátum vrátenia knihy:</label>
      <input type="text" class="form-control" name="datum_do" placeholder="Zadajte dátum vrátenia" required="">
    </div>

    <div class="form-group">
      <label for="stav">Stav:</label>
      <select type="text" class="form-control" name="stav"  required="">
        <option>Vrátená</option>
        <option>nevrátená</option>
      </select>
    </div>

    <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Submit">
  </form>
</div><br><br>
<hr class="my-4">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>