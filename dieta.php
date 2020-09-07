<?php 
  require_once 'database.php';
  require_once 'head.php'; 

    if(!isset($_SESSION['user']) || $_SESSION['user']['Typ_Uzytkownika'] == 1)
    {
        header('Location:index.php?logowanie=true');
        die();  
    }

  $stmt10 = $db_conn->prepare("SELECT * FROM `dieta` WHERE `DietaID` = ?");
  $stmt10->bind_param("i", $_GET['id']);
  $stmt10->execute();
  $result10 = $stmt10->get_result();
  $row10 = $result10->fetch_assoc();
?>


<body id="dashboard">

<div class="modal fade" id="ListaDan" tabindex="-1" role="dialog">
  <div class="modal-dialog" id="tablemodal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Wybierz produkt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
      <section class="">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <?php
              if($_SESSION['user']['Typ_Uzytkownika'] == 2)
                {
                  $sql = "SELECT `danie`.`DanieID`, `danie`.`Tytul`, `danie`.`Bialko_gr`, `danie`.`Wegl_gr`, `danie`.`Tluszcz_gr`, `danie`.`Kcal`, `danie`.`Opis`, `typ_dania`.`TypID`, `typ_dania`.`TypDania` FROM `danie` INNER JOIN `typ_dania` ON `danie`.`TypID` = `typ_dania`.`TypID` WHERE `danie`.`DietetykID` = {$_SESSION['user']['UzytkownikID']}";
                }
                else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
                {
                  $sql = "SELECT `danie`.`DanieID`, `danie`.`Tytul`, `danie`.`Bialko_gr`, `danie`.`Wegl_gr`, `danie`.`Tluszcz_gr`, `danie`.`Kcal`, `danie`.`Opis`, `typ_dania`.`TypID`, `typ_dania`.`TypDania` FROM `danie` INNER JOIN `typ_dania` ON `danie`.`TypID` = `typ_dania`.`TypID`";
                }
                $result = $db_conn -> query($sql);
                $i=0;
                while ($row = $result->fetch_assoc()) 
                  {
                    if($i % 3 == 0)
                    {
                      echo '<div class="row mb-4">';
                    }
                    echo '<div class="col-4">';
                      echo '<div class="card mb-3 tmp-card" style="">';
                        echo '<div class="card-body">';
                          echo '<h5 class="card-title">'.$row['Tytul'].'</h5>';
                          echo '<h6 class="card-subtitle mb-2 text-muted">'.$row['TypDania'].' - '.$row['Kcal'].' kcal</h6>';
                          echo '<p class="card-text font-weight-bold">Potrzebne produkty: </p>';
                          $sql2 = "SELECT `danie`.`DanieID`, `produktdanie`.`ProduktID`, `produktdanie`.`DanieID`, `produktdanie`.`ilosc`, `produkt`.`ProduktID`, `produkt`.`Nazwa` FROM `danie` INNER JOIN `produktdanie` ON `danie`.`DanieID` = `produktdanie`.`DanieID` INNER JOIN `produkt` ON `produktdanie`.`ProduktID` = `produkt`.`ProduktID` WHERE `danie`.`DanieID` = $row[DanieID]";
                          $result2 = $db_conn -> query($sql2);
                          while($row2 = $result2->fetch_assoc())
                          {
                            echo '<p class="card-text">'.$row2['Nazwa'].' - '.$row2['ilosc'].' gram</p>';
                            echo '<input type="hidden" class="ProduktID" value="'.$row2['ProduktID'].'">';
                            echo '<input type="hidden" class="ProduktWaga" value="'.$row2['ilosc'].'">';
                          }
                          echo '<p class="card-text font-weight-bold">Suma makroskładników: </p>';
                          echo '<p class="card-text font-weight-bold">'.$row['Bialko_gr'].' gram białka</p>';
                          echo '<p class="card-text font-weight-bold">'.$row['Wegl_gr'].' gram węglowodanów</p>';
                          echo '<p class="card-text font-weight-bold">'.$row['Tluszcz_gr'].' gram tłuszczy</p>';
                          echo '<p hidden class="card-text font-weight-bold">'.$row['TypID'].'</p>';
                          echo '<form method="post" action="action.php">';
                          echo '<label for="OpcjeDni" class="col-form-label">Dzień tygodnia:</label>';
                          echo '<select class="form-control mb-3 OpcjeDni" id="" name="OpcjeDni">';
                            $sql2 = "SELECT * FROM `dni_tygodnia`";
                            $result2 = $db_conn -> query($sql2);
                            while ($row2 = $result2->fetch_assoc())
                            {
                              echo '<option value="'.$row2['DniID'].'">';
                              echo $row2['Dzien'];
                              echo '</option>';
                            }
                          echo '</select>';
                          echo '<label for="OpcjePory" class="col-form-label">Pora dnia:</label>';
                          echo '<select class="form-control mb-5 OpcjePory" id="" name="OpcjePory">';
                            $sql2 = "SELECT * FROM `pora_dnia`";
                            $result2 = $db_conn -> query($sql2);
                            while ($row2 = $result2->fetch_assoc())
                            {
                              echo '<option value="'.$row2['PoraID'].'">';
                              echo $row2['Pora_Dnia'];
                              echo '</option>';
                            }
                          echo '</select>';
                          echo '<input type="hidden" id="dieta-id" name="dieta-id" value="'.$row10['DietaID'].'">';
                          echo '<input type="hidden" id="danie-id" name="danie-id" value="'.$row['DanieID'].'">';
                          echo '<input type="hidden" name="do" value="add_danie_dieta">';
                          echo '<div class="text-right tmp-btn">';
                          echo '<button type="submit" class="btn btn-success">Dodaj</button>'; 
                          echo '</div>';
                          echo '</form>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                    if($i % 3 == 2)
                    {
                      echo '</div>';
                    }
                    $i++;
                  }
                  if(($i) % 3 != 0)
                  {
                    echo '</div>';
                  }
              ?>
          </div>
        </div>
      </div>
    </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button> 
      </div>
    </div>
  </div>
</div>




  <nav class="navbar navbar-expand-md navbar-light">
    <div class="navbar" id="myNavbar">
      <div class="container-fluid">
        <div class="row">
          <!-- SIDEBAR -->
          <?php
          require_once 'navs/sidebar.php';
          ?>
          <!-- SIDEBAR -->
          <!-- TOP NAV -->
          <div class="col-xl-10 col-lg-9 col-md-8 ml-auto bg-dark fixed-top pt-2 pb-2">
            <div class="row align-items-center">
              <div class="col-md-4">
                
              </div>
              <div class="col-md-5">
              </div>
              <div class="col-md-3">
                <ul class="navbar-nav">
                  <li class="nav-item ml-lg-auto" id="wyloguj"><a href="action.php?do=logout" class="nav-link text-danger"><i class="fas fa-sign-out-alt text-danger fa-lg"></i>   Wyloguj</a></li>
                </ul>
              </div>
            </div>
          </div>
          <!-- TOP NAV -->
        </div>
      </div>
    </div> 
  </nav>


  <section class="mt-5">
    <div class="container-fluid">
      <div class="row">
        <div class="col-10 ml-auto">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#poniedzialek" role="tab" aria-controls="home" aria-selected="true">Poniedziałek</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="profile-tab" data-toggle="tab" href="#wtorek" role="tab" aria-controls="profile" aria-selected="false">Wtorek</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="contact-tab" data-toggle="tab" href="#sroda" role="tab" aria-controls="contact" aria-selected="false">Środa</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="contact-tab" data-toggle="tab" href="#czwartek" role="tab" aria-controls="contact" aria-selected="false">Czwartek</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="contact-tab" data-toggle="tab" href="#piatek" role="tab" aria-controls="contact" aria-selected="false">Piątek</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="contact-tab" data-toggle="tab" href="#sobota" role="tab" aria-controls="contact" aria-selected="false">Sobota</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="contact-tab" data-toggle="tab" href="#niedziela" role="tab" aria-controls="contact" aria-selected="false">Niedziela</a>
            </li>
          </ul>

            <div class="tab-content" id="myTabContent">
              <h1 class="text-center text-muted py-3">Dania w diecie: <?php echo $row10['Tytul']?> <button type="button" class="btn btn-success btn-lg float-right" data-toggle="modal" data-target="#ListaDan">Dodaj danie</button></h1>
              <div class="tab-pane fade show active" id="poniedzialek" role="tabpanel" data-id="1" aria-labelledby="home-tab">
          <?php
          if($_SESSION['user']['Typ_Uzytkownika'] == 2)
            {
              $sql = "SELECT `danie`.`DanieID`, `danie`.`Opis`, `danie`.`TypID`, `danie`.`Tytul`, `danie`.`Bialko_gr`, `danie`.`Wegl_gr`, `danie`.`Tluszcz_gr`, `danie`.`Blonnik_gr`, `danie`.`Kcal`, `typ_dania`.`TypDania`, `pora_dnia`.`Pora_Dnia`, `daniedieta`.`PoraID`, `daniedieta`.`DniID` FROM `danie` INNER JOIN `typ_dania` ON `danie`.`TypID` = `typ_dania`.`TypID` INNER JOIN `daniedieta` ON `danie`.`DanieID` = `daniedieta`.`DanieID` INNER JOIN `dieta` ON `daniedieta`.`DietaID` = `dieta`.`DietaID` INNER JOIN `dni_tygodnia` ON `daniedieta`.`DniID` = `dni_tygodnia`.`DniID` INNER JOIN `pora_dnia` ON `daniedieta`.`PoraID` = `pora_dnia`.`PoraID` WHERE `dieta`.`DietaID` = $row10[DietaID] AND `danie`.`DietetykID` = {$_SESSION['user']['UzytkownikID']} ORDER BY `daniedieta`.`PoraID` ASC";
            }
            else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
            {
              $sql = "SELECT `danie`.`DanieID`, `danie`.`Opis`, `danie`.`TypID`, `danie`.`Tytul`, `danie`.`Bialko_gr`, `danie`.`Wegl_gr`, `danie`.`Tluszcz_gr`, `danie`.`Blonnik_gr`, `danie`.`Kcal`, `typ_dania`.`TypDania`, `pora_dnia`.`Pora_Dnia`, `daniedieta`.`PoraID`, `daniedieta`.`DniID` FROM `danie` INNER JOIN `typ_dania` ON `danie`.`TypID` = `typ_dania`.`TypID` INNER JOIN `daniedieta` ON `danie`.`DanieID` = `daniedieta`.`DanieID` INNER JOIN `dieta` ON `daniedieta`.`DietaID` = `dieta`.`DietaID` INNER JOIN `dni_tygodnia` ON `daniedieta`.`DniID` = `dni_tygodnia`.`DniID` INNER JOIN `pora_dnia` ON `daniedieta`.`PoraID` = `pora_dnia`.`PoraID` WHERE `dieta`.`DietaID` = $row10[DietaID] ORDER BY `daniedieta`.`PoraID` ASC";
            }
            $result = $db_conn -> query($sql);
            $dania = array();
            while ($row = $result->fetch_assoc()) 
              {
                $dania[$row['DniID']][] = '<div class="col-4 mt-3 mb-4">';
                $last = count($dania[$row['DniID']]) - 1;
                $dania[$row['DniID']][$last] .= '<h1 class="text-center">'.$row['Pora_Dnia'].'</h1>';
                  $dania[$row['DniID']][$last] .= '<div class="card mb-3 tmp-card" style="">';
                    $dania[$row['DniID']][$last] .= '<div class="card-body">';
                      $dania[$row['DniID']][$last] .= '<h5 class="card-title">'.$row['Tytul'].'</h5>';
                      $dania[$row['DniID']][$last] .= '<h6 class="card-subtitle mb-2 text-muted">'.$row['TypDania'].' - '.$row['Kcal'].' kcal</h6>';
                      $dania[$row['DniID']][$last] .= '<p class="card-text font-weight-bold">Potrzebne produkty: </p>';
                      $sql2 = "SELECT `danie`.`DanieID`, `produktdanie`.`ProduktID`, `produktdanie`.`DanieID`, `produktdanie`.`ilosc`, `produkt`.`ProduktID`, `produkt`.`Nazwa` FROM `danie` INNER JOIN `produktdanie` ON `danie`.`DanieID` = `produktdanie`.`DanieID` INNER JOIN `produkt` ON `produktdanie`.`ProduktID` = `produkt`.`ProduktID` WHERE `danie`.`DanieID` = $row[DanieID]";
                      $result2 = $db_conn -> query($sql2);
                      while($row2 = $result2->fetch_assoc())
                      {
                        $dania[$row['DniID']][$last] .= '<p class="card-text">'.$row2['Nazwa'].' - '.$row2['ilosc'].' gram</p>';
                        $dania[$row['DniID']][$last] .= '<input type="hidden" class="ProduktID" value="'.$row2['ProduktID'].'">';
                        $dania[$row['DniID']][$last] .= '<input type="hidden" class="ProduktWaga" value="'.$row2['ilosc'].'">';
                      }
                      $dania[$row['DniID']][$last] .= '<p class="card-text font-weight-bold">Suma makroskładników: </p>';
                      $dania[$row['DniID']][$last] .= '<p class="card-text font-weight-bold">'.$row['Bialko_gr'].' gram białka</p>';
                      $dania[$row['DniID']][$last] .= '<p class="card-text font-weight-bold">'.$row['Wegl_gr'].' gram węglowodanów</p>';
                      $dania[$row['DniID']][$last] .= '<p class="card-text font-weight-bold">'.$row['Tluszcz_gr'].' gram tłuszczy</p>';
                      $dania[$row['DniID']][$last] .= '<p hidden class="card-text font-weight-bold">'.$row['TypID'].'</p>';
                      $dania[$row['DniID']][$last] .= '<div class="text-right tmp-btn">';
                      $dania[$row['DniID']][$last] .= '<form method="post" action="action.php">';
                      $dania[$row['DniID']][$last] .= '<input type="hidden" id="dieta-id" name="dieta-id" value="'.$row10['DietaID'].'">';
                      $dania[$row['DniID']][$last] .= '<input type="hidden" id="dzien-id" name="dzien-id" value="'.$row['DniID'].'">';
                      $dania[$row['DniID']][$last] .= '<input type="hidden" id="pora-id" name="pora-id" value="'.$row['PoraID'].'">';
                      $dania[$row['DniID']][$last] .= '<input type="hidden" id="danie-id" name="danie-id" value="'.$row['DanieID'].'">';
                      $dania[$row['DniID']][$last] .= '<input type="hidden" name="do" value="usun_danie_dieta">';
                      $dania[$row['DniID']][$last] .= '<button type="submit" class="btn btn-danger">Usuń z diety</button>'; 
                      $dania[$row['DniID']][$last] .= '</form>';
                      $dania[$row['DniID']][$last] .= '</div>';
                    $dania[$row['DniID']][$last] .= '</div>';
                  $dania[$row['DniID']][$last] .= '</div>';
                $dania[$row['DniID']][$last] .= '</div>';
              }
              $i = 0;
              if(isset($dania[1]))
              {
                foreach ($dania[1] as $danie)
                {
                if($i % 3 == 0)
                {
                  echo '<div class="row mb-4">';
                }

                echo $danie;
               
                if($i % 3 == 2)
                {
                  echo '</div>';
                }
                $i++;
              }
              if(($i) % 3 != 0)
              {
                echo '</div>';
              }
            }
          ?>
              </div>
                <div class="tab-pane fade" id="wtorek" role="tabpanel" data-id="2" aria-labelledby="profile-tab">
                  <?php $i = 0;
                  if(isset($dania[2]))
                  {
                foreach ($dania[2] as $danie)
                {
                if($i % 3 == 0)
                {
                  echo '<div class="row mb-4">';
                }

                echo $danie;
               
                if($i % 3 == 2)
                {
                  echo '</div>';
                }
                $i++;
              }
              if(($i) % 3 != 0)
              {
                echo '</div>';
              }
            }
                  ?>
                </div>

                <div class="tab-pane fade" id="sroda" role="tabpanel" data-id="3" aria-labelledby="profile-tab">
                 <?php $i = 0;
                if(isset($dania[3]))
                {
                  foreach ($dania[3] as $danie)
                  {
                    if($i % 3 == 0)
                    {
                      echo '<div class="row mb-4">';
                    }

                    echo $danie;
               
                    if($i % 3 == 2)
                    {
                      echo '</div>';
                    }
                    $i++;
                  }
                if(($i) % 3 != 0)
                {
                 echo '</div>';
                }
              } 
              ?>
                </div>

                <div class="tab-pane fade" id="czwartek" role="tabpanel" data-id="4" aria-labelledby="profile-tab">
                 <?php $i = 0;
                if(isset($dania[4]))
                {
                  foreach ($dania[4] as $danie)
                  {
                    if($i % 3 == 0)
                    {
                      echo '<div class="row mb-4">';
                    }

                    echo $danie;
               
                    if($i % 3 == 2)
                    {
                      echo '</div>';
                    }
                    $i++;
                  }
                if(($i) % 3 != 0)
                {
                 echo '</div>';
                }
              } 
              ?>
                </div>

                <div class="tab-pane fade" id="piatek" role="tabpanel" data-id="5" aria-labelledby="profile-tab">
                 <?php $i = 0;
                if(isset($dania[5]))
                {
                  foreach ($dania[5] as $danie)
                  {
                    if($i % 3 == 0)
                    {
                      echo '<div class="row mb-4">';
                    }

                    echo $danie;
               
                    if($i % 3 == 2)
                    {
                      echo '</div>';
                    }
                    $i++;
                  }
                if(($i) % 3 != 0)
                {
                 echo '</div>';
                }
              } 
              ?>
                </div>

                <div class="tab-pane fade" id="sobota" role="tabpanel" data-id="6" aria-labelledby="profile-tab">
                 <?php $i = 0;
                if(isset($dania[6]))
                {
                  foreach ($dania[6] as $danie)
                  {
                    if($i % 3 == 0)
                    {
                      echo '<div class="row mb-4">';
                    }

                    echo $danie;
               
                    if($i % 3 == 2)
                    {
                      echo '</div>';
                    }
                    $i++;
                  }
                if(($i) % 3 != 0)
                {
                 echo '</div>';
                }
              } 
              ?>
                </div>
                <div class="tab-pane fade" id="niedziela" data-id="7" role="tabpanel" aria-labelledby="profile-tab">
                <?php $i = 0;
                if(isset($dania[7]))
                {
                  foreach ($dania[7] as $danie)
                  {
                    if($i % 3 == 0)
                    {
                      echo '<div class="row mb-4">';
                    }

                    echo $danie;
               
                    if($i % 3 == 2)
                    {
                      echo '</div>';
                    }
                    $i++;
                  }
                if(($i) % 3 != 0)
                {
                 echo '</div>';
                }
              } 
              ?>
                </div>

                </div>
              </div>
        </div>
      </div>
  </section>

<script type="text/javascript">
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}
</script>
  
<script type="text/javascript">
  $('#ListaDan').on('show.bs.modal', function (event) {
    let dzien = $('#myTabContent .active').data('id');
    $('select.OpcjeDni option:selected').prop('selected', false);
    $('select.OpcjeDni option[value="'+dzien+'"]').prop('selected', true);
  });
</script>

</body>
</html>