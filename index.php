<?php
  session_start();

  include 'knihy.php';

  $knihyObj = new Knihy();
  // nastavenie filtru autor na všetko
  if (!isset($_SESSION['fautor'])) 
  {
    $_SESSION['fautor']="Všetko";
  }

  // nastavenie filtra podľa vybraného autora
  if(isset($_GET['fautor']) && !empty($_GET['fautor']))  
  {
    $_SESSION['fautor'] = $_GET['fautor'];
  }

  //Zmena stránky na požadovanú alebo nastavenie stránky na 1
  if (isset($_GET['page_no']) && !empty($_GET['page_no'])) 
  {
    $page_no = $_GET['page_no'];
    $knihy=$knihyObj->zobrazZaznamy($page_no); 
  } 
  else
  {
    $page_no = 1;
    $knihy=$knihyObj->zobrazZaznamy($page_no);
  }
  
   // Delete vybraného záznamu
   if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) 
   {
       $deleteId = $_GET['deleteId'];
       $knihyObj->deleteZaznam($deleteId);
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
<!--header na zobrazenie názvu app -->
<div class="container-fluid  bg-primary text-white " style="padding:15px;">
<br>
<h1>Informačný systém pre knižnicu</h1>
<br>
</div>
<!--menu na výber medzi Zoznam kníh / Záznamy o požičaní kníh -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="index.php">Zoznam kníh</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="ipozicovna.php">Záznamy o požičaní kníh</a>
  </li>
</ul>

<br><br> 
<!--alerty ktoré oznamujú úspešnú akciu -->
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
</div>
<!--Názov tabuľky a button pre pridanie novej knihy -->
<div class="container">
  <h2>Zoznam kníh
    <a href="add.php" class="btn btn-primary" style="float:right;">Pridať novú knihu</a>
  </h2><br>
</div>  


<div class="container">
    <div class="row">
      <div class="col-auto">
        <!-- Stránkovanie tabuľky -->
        <nav aria-label="...">
          <ul class="pagination">
          <?php 
                $data = $knihyObj->vypStrankovanie($page_no);
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
      <!-- Form na filter podľa autora knihy -->
      <form method="get" action="index.php" class="form-inline">
        <div class="form-row align-items-center">
          <div class="col-auto">
          <label for="fautor" class="col-form-label-lg" >Autor</label>
          </div>
            <div class="col-auto">
              <select name="fautor"  class="form-control">
                          <option>Všetko</option>
                          <?php
                          $autorknihy = $knihyObj->zobrazVsetkyZaznamy();
                          if ($autorknihy!=null)
                          {
                          foreach ($autorknihy as $autorknihy) 
                          {
                          echo  "<option>" .$autorknihy['autor']. "</option>";
                          }
                          }
                           ?>
              </select>
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary mb-2">Zobraz</button>
            </div>
        </div>
      </form>
    </div>
  </div>
  


<!-- zobrazenie tabuľky -->
<div class="container">
  <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>Id knihy</th>
          <th>Názov</th>
          <th>Autor</th>
          <th>Počet strán</th>
          <th>Počet na sklade</th>
          <th>Upraviť/Zmazať</th>
        </tr>
      </thead>
      <tbody>
      
            <?php 
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
                    <td><?php echo $knihy['pocet_na_sklade'] ?></td>
                    <td>
                    <!-- Link na zmenu danej knihy v podobe icon ceruzky -->
                      <a href="edit.php?editId=<?php echo $knihy['idknihy'] ?>" style="color:green">
                        <i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp
                    <!-- Link na odstránenie danej knihy v podobe icon koš -->
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