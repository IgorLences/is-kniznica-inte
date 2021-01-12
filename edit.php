<?php
  
  // Include database file
  include 'knihy.php';

  $knihyObj = new Knihy();

  // Edit knihy record
  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $editId = $_GET['editId'];
    $knihy = $knihyObj->displyaRecordById($editId);
  }

  // Update Record in knihy table
  if(isset($_POST['update'])) {
    $knihyObj->updateRecord($_POST);
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
  <form action="edit.php" method="POST">
    <div class="form-group">
      <label for="nazov">Názov:</label>
      <input type="text" class="form-control" name="unazov" value="<?php echo $knihy['nazov']; ?>" required="">
    </div>
    <div class="form-group">
      <label for="autor">Autor:</label>
      <input type="text" class="form-control" name="uautor" value="<?php echo $knihy['autor']; ?>" required="">
    </div>
    <div class="form-group">
      <label for="pocet_stran">Pocet strán:</label>
      <input type="text" class="form-control" name="upocet_stran" value="<?php echo $knihy['pocet_stran']; ?>" required="">
    </div>
    <div class="form-group">
      <label for="stav">Stav:</label>
      <input type="text" class="form-control" name="ustav" value="<?php echo $knihy['stav']; ?>" required="">
    </div>

    <div class="form-group">
      <input type="hidden" name="idknihy" value="<?php echo $knihy['idknihy']; ?>">
      <input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Update">
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>