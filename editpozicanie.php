<?php
  
  // Include database file
  include 'pozicanie.php';
  include 'knihy.php';

  $pozicanieObj = new Pozicanie();
  $knihyObj = new Knihy();

  // Edit pozicanie record
  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $editId = $_GET['editId'];
    $pozicanie = $pozicanieObj->displyaRecordById($editId);
  }

  // Update Record in pozicanie table
  if(isset($_POST['update'])) {
    $pozicanieObj->updateRecord($_POST);
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
  <form action="editpozicanie.php" method="POST">

    <div class="form-group">
      <label for="meno_zakaznika">Meno zákazníka:</label>
      <input type="text" class="form-control" name="umeno_zakaznika" value="<?php echo $pozicanie['meno_zakaznika']; ?>" required="">
    </div>

    <div class="form-group">
      <label for="nazov_knihy">Názov knihy:</label>
      <select type="text" class="form-control" name="unazov_knihy" ?>" required="">
      <option selected><?php echo $pozicanie['nazov']; ?></option>
      <?php
         $knihy = $knihyObj->displyaRecordByPocetNaSklade();
         if ($knihy!=null)
         {
         foreach ($knihy as $knihy) 
         {
        echo  "<option>" .$knihy['nazov']. "</option>";
         }
         }
        ?>
        </select>
    </div>

    <div class="form-group">
      <label for="datum_od">Dátum požičania:</label>
      <input type="date" class="form-control" name="udatum_od" value="<?php echo $pozicanie['datum_od']; ?>" required="">
    </div>

    <div class="form-group">
      <label for="datum_do">Dátum vrátenia:</label>
      <input type="date" class="form-control" name="udatum_do" value="<?php echo $pozicanie['datum_do']; ?>" required="">
    </div>

    <div class="form-group">
      <label for="stav">Stav:</label>
      <select type="text" class="form-control" name="ustav" value="<?php echo $pozicanie['stav']; ?>"required="">
        <option>Vrátená</option>
        <option>Nevrátená</option>
      </select>
    </div>

    <div class="form-group">
      <input type="hidden" name="nazov_knihy_old" value="<?php echo $pozicanie['nazov']; ?>">
      <input type="hidden" name="idpozicania" value="<?php echo $pozicanie['idpozicania']; ?>">
    </div>

    <div class="form-group">
      <input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Uložiť">
    </div>

  </form>
</div><br><br>
<hr class="my-4">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>