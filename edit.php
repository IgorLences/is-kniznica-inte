<?php
  
  include 'knihy.php';

  $knihyObj = new Knihy();

  // načítanie knihy ,ktorú chceme editovať
  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $editId = $_GET['editId'];
    $knihy = $knihyObj->zobrazZaznamById($editId);
  }

  // Update záznamu knihy podľa idknihy
  if(isset($_POST['update'])) {
    $knihyObj->updateZaznam($_POST);
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
<!--header na zobrazenie názvu app -->
<div class="container-fluid  bg-primary text-white " style="padding:15px;">
<br>
<h1>Informačný systém pre knižnicu</h1>
<br>
</div> <br><br> 
<!--alert ktorý oznamujú neúspešnú akciu -->
<?php
    if (isset($_GET['msg1']) == "notsucces") 
    {
      echo "<div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Uloženie nebolo úspešné
            </div>";
    } 
  ?>
<!--form na zadanie zmien pre update knihy -->
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
      <input type="number" class="form-control" name="upocet_stran" value="<?php echo $knihy['pocet_stran']; ?>" required="">
    </div>

    <div class="form-group">
      <label for="pocet_na_sklade">Počet na sklade:</label>
      <input type="number" class="form-control" name="upocet_na_sklade" value="<?php echo $knihy['pocet_na_sklade']; ?>"required="">
    </div>

    <div class="form-group">
      <input type="hidden" name="idknihy" value="<?php echo $knihy['idknihy']; ?>">
      <input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Uložiť">
    </div>

  </form>
</div><br><br>
<hr class="my-4">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>