<?php 
  require_once 'database.php';
  require_once 'head.php'; 

    if(!isset($_SESSION['user']) || $_SESSION['user']['Typ_Uzytkownika'] == 1)
    {
        header('Location:index.php?logowanie=true');
        die();  
    }

	$stmt = $db_conn->prepare("SELECT * FROM `uzytkownik` WHERE `UzytkownikID` = ?");
	$stmt->bind_param("i", $_GET['id']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	$stmt2 = "SELECT * FROM `raporty` WHERE `KlientID` = $row[UzytkownikID] AND `raporty`.`przeczytano` = 1 ORDER BY RaportyID ASC";
	$result3 = $db_conn -> query($stmt2);
	$first =  $result3->fetch_assoc();
	if($first != NULL)
	{
		while ($row3 = $result3->fetch_assoc()) 
		{
			$last = $row3;
		}
		if (!isset($last)) 
		{
			$last = $first;
		}
	}
    if($_SESSION['user']['Typ_Uzytkownika'] ==2 && $row['DietetykID'] !== $_SESSION['user']['UzytkownikID'])
    {
        header('Location:klienci.php');
        die();
    }
?>
<body id="dashboard">

<div class="modal fade" id="WyborDiety" tabindex="-1" role="dialog">
  <div class="modal-dialog" id="tablemodal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Wybierz diete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <?php
                $sql = "SELECT `dieta`.`DietaID`, `dieta`.`Tytul`, `dieta`.`Kalorycznosc`, `dieta`.`Opis`, `typ_diety`.`TypDietyID`, `typ_diety`.`Typ_Diety` FROM `dieta` INNER JOIN `typ_diety` ON `dieta`.`TypDietyID` = `typ_diety`.`TypDietyID` WHERE `dieta`.`DietetykID` = {$_SESSION['user']['UzytkownikID']}";
                $result = $db_conn -> query($sql);
                $i=0;
                while ($rowe = $result->fetch_assoc()) 
                  {
                    if($i % 4 == 0)
                    {
                      echo '<div class="row mb-3">';
                    }
                    echo '<div class="col-3">';
                      echo '<div class="card mb-3 tmp-card" style="">';
                        echo '<div class="card-body">';
                          echo '<h5 class="card-title">'.$rowe['Tytul'].'</h5>';
                          echo '<h6 class="card-subtitle mb-2 text-muted">'.$rowe['Typ_Diety'].' - '.$rowe['Kalorycznosc'].' kcal</h6>';
                          echo '<p class="card-text">'.nl2br($rowe["Opis"]).'</p>';
                          echo '<p hidden class="card-text font-weight-bold">'.$rowe['TypDietyID'].'</p>';
                          echo '<div class="text-right tmp-btn">';
                          echo '<form method="post" action="action.php">';
                          echo '<input type="hidden" id="dieta-id" name="dieta-id" value="'.$rowe['DietaID'].'">';
                          echo '<input type="hidden" id="klient-id" name="klient-id" value="'.$row['UzytkownikID'].'">';
                          echo '<input type="hidden" name="do" value="przypisz_diete">';
                           echo '<button type="submit" class="btn btn-success">Przypisz</button>';
                           echo '</form>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                    if($i % 4 == 3)
                    {
                      echo '</div>';
                    }
                    $i++;
                  }
                  if(($i) % 4 != 0)
                  {
                    echo '</div>';
                  }
              ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ZmienTyp" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Awans na dietetyka</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="action.php">
      <div class="modal-body">
      <?php echo 'Czy napewno chcesz awansować użytkownika '.$row['Imie'].' '.$row['Nazwisko'].' na dietetyka?' ?>
        <input type="hidden" id="advance-id" name="advance-id" value="<?php echo $row['UzytkownikID'];?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
        <input type="hidden" name="do" value="zmien_typ">
        <button type="submit" class="btn btn-success">Awansuj</button>   
      </div>
      </form>
    </div>
  </div>
</div>

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

<div class="container py-5 my-2">
    <div class="row">
        <div class="col-md-4" id="klient_side">
            <img class="w-80 rounded border" src="img/default.jpg" />
            <div class="pt-4 mt-2">
                <section class="mb-4 pb-1">
                	<?php
                    if($row['Typ_Uzytkownika'] == 1 && $first !== NULL && $last !== NULL)
                    {
                		$tmp = $first['MasaCiala'] - $last['MasaCiala'];
                		$progres = ($tmp/($first['MasaCiala'] - $last['Waga_Docelowa']))*100;
                		if($progres>=0 && $progres <25)
                		{
                			$color = "danger";
                		}
                		else if($progres >= 25 && $progres <= 75)
                		{
                			$color = "warning";
                		}
                		else
                		{
                			$color = "success";
                		}
                	?>                    
                    <h3 class="h6 font-weight-bold text-primary">Waga początkowa: <?php echo $first['MasaCiala']. 'kg'; ?></h3>
                    <h3 class="h6 font-weight-bold text-dark">Waga aktualna: <?php echo $last['MasaCiala']. 'kg'; ?></h3>
                    <h3 class="h6 font-weight-bold text-success text-uppercase">Waga docelowa: <?php echo $last['Waga_Docelowa']. 'kg'; ?></h3>  
                    <div class="progress">
  						<div class="progress-bar-striped progress-bar-animated bg-<?php echo $color; ?>" role="progressbar" style="width: <?php echo abs($progres); ?>%" aria-valuenow="<?php echo abs($progres); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    <?php }
                    else
                        {?>
<div class="progress">
                       <?php }?>
					</div> 
                </section>
            </div>
        </div>
        <div class="col-md-8 pl-5">
            <div class="d-flex align-items-center">
                <h2 class="font-weight-bold m-0">
                    <?php echo $row['Imie'].' '.$row['Nazwisko'] ?>
                </h2>
                <address class="m-0 pt-2 pl-0 pl-md-4 font-weight-light text-secondary">
                    <i class="fa fa-map-marker"></i>
                    <?php echo $row['Miasto']?>
                </address>
            </div>
            <p class="h5 text-info mt-2 d-block font-weight-bold">
                <?php if($row['Typ_Uzytkownika'] == 1)
                {
                	echo "Klient";
                }
                else
                {
                	echo "Dietetyk";
                }
                ?>
            </p>
                <section class="d-flex mt-5">
                <?php if(!is_null($row['DietaID']))
                {
                    echo '<a href="dieta.php?id='.$row['DietaID'].'" class="btn btn-md btn-dark mb-3 mr-3">';
                        echo ' <h6><i class="fas fa-file-invoice mr-2"></i>Wyświetl diete</h6>';
                    echo '</a>';
                }
                if($row['Typ_Uzytkownika'] == 1 && $_SESSION['user']['Typ_Uzytkownika'] == 2)
                   {
                    echo '<button class="btn btn-dark bg-dark mr-3 mb-3" data-toggle="modal" data-target="#WyborDiety">';
                                           echo '<i class="fas fa-balance-scale"></i>';
                                           if(is_null($row['DietaID']))
                                           {
                                               echo ' Przypisz dietę';
                                           }
                                           else
                                           {
                                               echo ' Zmień dietę';
                                           }

                    }
                    else if($_SESSION['user']['Typ_Uzytkownika'] == 3 && $row['Typ_Uzytkownika'] == 1)
                    {
                        echo '<button class="btn btn-dark bg-success mr-3 mb-3" data-toggle="modal" data-target="#ZmienTyp">';
                            echo '<i class="fas fa-exchange-alt"></i>';
                            echo 'Awansuj na dietetyka';
                    }
                ?>

            </section>
            <section class="mt-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#profil" role="tab" aria-controls="home" aria-selected="true">
                            Informacje
                        </a>
                    </li>
                    <?php if($row['Typ_Uzytkownika'] == 1) {?>
                    <li class="nav-item">
                        <a class="nav-link text-dark" id="profile-tab" data-toggle="tab" href="#dietetyk" role="tab" aria-controls="profile" aria-selected="false">
                            Dietetyk  
                        </a>
                    </li>
                <?php }?>
                </ul>
                <div class="tab-content py-4" id="myTabContent">
                    <div class="tab-pane py-3 fade show active" id="profil" role="tabpanel" aria-labelledby="home-tab">
                        <h6 class="text-uppercase font-weight-light text-secondary">
                            Informacje
                        </h6>
                        <dl class="row mt-4 mb-4 pb-3">
                            <dt class="col-sm-3">Imie</dt>
                            <dd class="col-sm-9">
                            	<?php echo $row['Imie']?>	
                            </dd>
                            
                            <dt class="col-sm-3">Nazwisko</dt>
                            <dd class="col-sm-9">
                        		<?php echo $row['Nazwisko']?>
                            </dd>
                            
                            <dt class="col-sm-3">Ulica</dt>
                            <dd class="col-sm-9">
                                <?php echo $row['Ulica']?>
                            </dd>

                            <dt class="col-sm-3">Miasto</dt>
                            <dd class="col-sm-9">
                                <?php echo $row['Miasto']?>
                            </dd>

                            <dt class="col-sm-3">Kod pocztowy</dt>
                            <dd class="col-sm-9">
                                <?php echo $row['Kod_Pocztowy']?>
                            </dd>
                        </dl>
                        
                        
                    </div>
                    <?php if($row['Typ_Uzytkownika'] == 1) { ?>
                    <div class="tab-pane fade" id="dietetyk" role="tabpanel" aria-labelledby="profile-tab">
                    	<h1 class="text-uppercase font-weight-bold text-secondary">
                            Dietetyk
                        </h6>
                        <?php 
                        if($row['DietetykID']==NULL)
                        {
                        	echo '<h6> BRAK PRZYPISANEGO DIETETYKA </h6>';
                        }
                        else
                        {
		                   	$sql2 = "SELECT * from `uzytkownik` where `UzytkownikID` = $row[DietetykID]";
		                  	$result2 = $db_conn -> query($sql2);
		                  	$row2 = $result2->fetch_assoc();
		                  	echo '<dl class="row mt-4 mb-4 pb-3">';
		                  	echo '<dt class="col-sm-4">';
		                  	echo '<img class="w-100 rounded border" src="img/default.jpg" />';
		                  	echo '</dt>';
		                  	echo '<dt class="col-sm-8">';
                        	echo '<a href="klient.php?id='.$row2['UzytkownikID'].'">';
                        	echo $row2['Imie'].' '.$row2['Nazwisko'];
                        	echo '</a>';
                        	echo '</dt>';
                        	echo '</dl>';
                        }
                        ?>
                    <?php }?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>





<script>
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