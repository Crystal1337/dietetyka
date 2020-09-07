<?php 
  require_once 'database.php';
  require_once 'head.php'; 

    if(!isset($_SESSION['user']) || $_SESSION['user']['Typ_Uzytkownika'] !== 1)
    {
        header('Location:index.php?logowanie=true');
        die();  
    }
?>
<body id="dashboard">

	<!-- NAVBAR -->
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
	<!-- END OF NAVBAR -->

    <section class="mt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-10 ml-auto">
            <h1 class="text-center text-muted py-3">Moja dieta</h1>
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
            <div class="tab-pane fade show active" id="poniedzialek" role="tabpanel" data-id="1" aria-labelledby="home-tab">
              <?php
              $sql = "SELECT * FROM `uzytkownik` INNER JOIN `dieta` ON `uzytkownik`.`DietaID` = `dieta`.`DietaID` INNER JOIN `daniedieta` ON `dieta`.`DietaID` = `daniedieta`.`DietaID` INNER JOIN `danie` ON `daniedieta`.`DanieID` = `danie`.`DanieID` INNER JOIN `pora_dnia` ON `daniedieta`.`PoraID` = `pora_dnia`.`PoraID` INNER JOIN `dni_tygodnia` ON `daniedieta`.`DniID` = `dni_tygodnia`.`DniID` WHERE `uzytkownik`.`UzytkownikID` = {$_SESSION['user']['UzytkownikID']} ORDER BY `daniedieta`.`PoraID` ASC";
              $result = $db_conn -> query($sql);
              $dania = array();
              while($row = $result->fetch_assoc())
              {
                $dania[$row['DniID']][] = '<div class="col-4 mt-3 mb-4">';
                $last = count($dania[$row['DniID']]) - 1;
                $dania[$row['DniID']][$last] .= '<h1 class="text-center">'.$row['Pora_Dnia'].'</h1>';
                  $dania[$row['DniID']][$last] .= '<div class="card mb-3 tmp-card" style="">';
                    $dania[$row['DniID']][$last] .= '<div class="card-body">';
                      $dania[$row['DniID']][$last] .= '<h5 class="card-title">'.$row['Tytul'].'</h5>';
                      $dania[$row['DniID']][$last] .= '<h6 class="card-subtitle mb-2 text-muted">'.$row['Kcal'].' kcal</h6>';
                      $dania[$row['DniID']][$last] .= '<p class="card-text font-weight-bold">Potrzebne produkty: </p>';
                $sql2 = "SELECT `danie`.`DanieID`, `produktdanie`.`ProduktID`, `produktdanie`.`DanieID`, `produktdanie`.`ilosc`, `produkt`.`ProduktID`, `produkt`.`Nazwa` FROM `danie` INNER JOIN `produktdanie` ON `danie`.`DanieID` = `produktdanie`.`DanieID` INNER JOIN `produkt` ON `produktdanie`.`ProduktID` = `produkt`.`ProduktID` WHERE `danie`.`DanieID` = $row[DanieID]";
                $result2 = $db_conn -> query($sql2);
                while($row2 = $result2->fetch_assoc())
                {
                  $dania[$row['DniID']][$last] .= '<p class="card-text">'.$row2['Nazwa'].' - '.$row2['ilosc'].' gram</p>';
                  $dania[$row['DniID']][$last] .= '<input type="hidden" class="ProduktID" value="'.$row2['ProduktID'].'">';
                  $dania[$row['DniID']][$last] .= '<input type="hidden" class="ProduktWaga" value="'.$row2['ilosc'].'">';
                }
                $dania[$row['DniID']][$last] .= '<p class="card-text font-weight-bold">Sposób przygotowania: </p>';
                      $dania[$row['DniID']][$last] .= '<p class="card-text">'.nl2br($row['Opis']).'</p>';
                      $dania[$row['DniID']][$last] .= '<div class="text-right tmp-btn">';
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
            <div class="tab-pane fade" id="wtorek" role="tabpanel" data-id="1" aria-labelledby="home-tab">
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
            <div class="tab-pane fade" id="sroda" role="tabpanel" data-id="1" aria-labelledby="home-tab">
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
            <div class="tab-pane fade" id="czwartek" role="tabpanel" data-id="1" aria-labelledby="home-tab">
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
            <div class="tab-pane fade" id="piatek" role="tabpanel" data-id="1" aria-labelledby="home-tab">
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
            <div class="tab-pane fade" id="sobota" role="tabpanel" data-id="1" aria-labelledby="home-tab">
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
            <div class="tab-pane fade" id="niedziela" role="tabpanel" data-id="1" aria-labelledby="home-tab">
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
  $('li.nav-item a[href="mojadieta.php"]').removeClass('sidebar-link').addClass('current').parent().parent().removeClass('content').css('list-style', 'none').prev().removeClass('collapsible');
</script>

</body>
</html>