<?php 
  require_once 'database.php';
  require_once 'head.php'; 

    if(!isset($_SESSION['user']) || $_SESSION['user']['Typ_Uzytkownika'] !== 1)
    {
        header('Location:index.php?logowanie=true');
        die();  
    }

	$stmt = "SELECT * FROM `uzytkownik` WHERE `UzytkownikID` = {$_SESSION['user']['UzytkownikID']}";
	$result = $db_conn -> query($stmt);
	$row = $result->fetch_assoc();

	$stmt2 = "SELECT * FROM `raporty` WHERE `KlientID` = {$_SESSION['user']['UzytkownikID']} AND `raporty`.`przeczytano` = 1 ORDER BY RaportyID ASC";
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

?>
<body id="dashboard">

    <div class="modal fade" id="EdycjaProfilu" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edytuj profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
          <div class="form-group">
            <label for="input-imie" class="col-form-label">Imię:</label>
            <input type="text" class="form-control" id="input-imie" name="imie" required value="">
          </div>
          <div class="form-group">
            <label for="input-nazwisko" class="col-form-label">Nazwisko:</label>
            <input type="text" class="form-control" id="input-nazwisko" name="nazwisko" required value="">
          </div>
          <div class="form-group">
            <label for="input-ulica" class="col-form-label">Ulica:</label> 
            <input type="text" class="form-control" id="input-ulica" name="ulica" required value="">
          </div>
          <div class="form-group">
            <label for="input-miasto" class="col-form-label">Miasto:</label> 
            <input type="text" class="form-control" id="input-miasto" name="miasto" required value="">
          </div>
          <div class="form-group">
            <label for="input-kod-pocztowy" class="col-form-label">Kod pocztowy:</label> 
            <input type="text" class="form-control d-inline-block" id="input-kod-pocztowy" style="width: 100px" name="kod-pocztowy" required value="">
          </div>
          <input type="hidden" id="edit-id" name="edit-id">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="edit_profil">
            <button type="submit" class="btn btn-primary">Edytuj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="WyborDietetyka" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Wybierz dietetyka</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
            <div class="form-group">
            <label for="OpcjeDietetyka" class="col-form-label">Dietetycy:</label>
                <select class="form-control" id="OpcjeDietetyka" name="OpcjeDietetyka">
                    <?php $sql="SELECT `UzytkownikID`, `Imie`, `Nazwisko` FROM `uzytkownik` WHERE `Typ_Uzytkownika` = 2";
                        $result = $db_conn -> query($sql);
                        while ($row2 = $result->fetch_assoc())
                        {
                            echo '<option value="'.$row2['UzytkownikID'].'">';
                            echo $row2['Imie']. " " .$row2["Nazwisko"];
                            echo '</option>';
                        }
                        ?>
                </select>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="wybierz_dietetyka">
            <button type="submit" class="btn btn-primary">Potwierdź</button>
          </div>
        </form>
      </div>
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
                        if($first !== NULL && $last !== NULL)
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
                    <?php echo $row['Miasto'];
                    ?>
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
                <?php echo '<button type="button"  class="btn btn-dark bg-dark mr-3 mb-3" data-toggle="modal" data-target="#EdycjaProfilu" data-id="'.$row['UzytkownikID'].'">';?>
                    <i class="fas fa-file-invoice"></i>
                    Edytuj moje dane
                </button>
                <?php if($_SESSION['user']['DietetykID'] == NULL)
                    {?>
                        <button type="button" class="btn bg-success mr-3 mb-3" data-toggle="modal" data-target="#WyborDietetyka">
                            <i class="fas fa-asterisk"></i>
                            Wybierz dietetyka
                        </button>
                    <?php }?>
            </section>
            <section class="mt-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#profil" role="tab" aria-controls="home" aria-selected="true">
                            Informacje
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" id="profile-tab" data-toggle="tab" href="#dietetyk" role="tab" aria-controls="profile" aria-selected="false">
                            Dietetyk  
                        </a>
                    </li>
                </ul>
                <div class="tab-content py-4" id="myTabContent">
                    <div class="tab-pane py-3 fade show active" id="profil" role="tabpanel" aria-labelledby="home-tab">
                        <h6 class="text-uppercase font-weight-light text-secondary">
                            Informacje
                        </h6>
                        <dl class="row mt-4 mb-4 pb-3">
                            <dt class="col-sm-3">Imie</dt>
                            <dd class="col-sm-9" id="imie">
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
                        	echo '<a href="">';
                        	echo $row2['Imie'].' '.$row2['Nazwisko'];
                        	echo '</a>';
                        	echo '</dt>';
                        	echo '</dl>';
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
  $('li.nav-item a[href="profil.php"]').removeClass('sidebar-link').addClass('current');
</script>

<script>
  $('#EdycjaProfilu').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')
  var imie = $.trim($( "dd" ).first().text())
  var nazwisko = $.trim($( "dd" ).first().next().next().text())
  var ulica = $.trim($( "dd" ).first().next().next().next().next().text())
  var miasto = $.trim($( "dd" ).first().next().next().next().next().next().next().text())
  var kod_pocztowy = $.trim($( "dd" ).first().next().next().next().next().next().next().next().next().text())
  var modal = $(this)
  modal.find('.modal-body input#edit-id').val(id)
  modal.find('.modal-body input#input-imie').val(imie)
  modal.find('.modal-body input#input-nazwisko').val(nazwisko)
  modal.find('.modal-body input#input-ulica').val(ulica)
  modal.find('.modal-body input#input-miasto').val(miasto)
  modal.find('.modal-body input#input-kod-pocztowy').val(kod_pocztowy)
})
</script>

</body>
</html>