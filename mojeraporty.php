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

<div class="modal fade" id="DodanieRaportu" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Przesyłanie raportu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
          <?php if (isset($_SESSION['mojraporterror'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['mojraporterror']; ?></p>
              </div>
            <?php } unset($_SESSION['mojraporterror']); ?>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Masa ciała:</label>
            <input type="text" class="form-control d-inline-block" id="input-masa-ciala" style="width: 60px" name="masa-ciala" required value="<?php echo isset($_SESSION['LastData']['masa-ciala']) ? $_SESSION['LastData']['masa-ciala'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Waga docelowa:</label>
            <input type="text" class="form-control d-inline-block" id="input-waga-docelowa" style="width: 60px" name="waga-docelowa" required value="<?php echo isset($_SESSION['LastData']['waga-docelowa']) ? $_SESSION['LastData']['waga-docelowa'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Masa tłuszczowa:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-tluszczu" style="width: 60px" name="masa-tluszczu" required value="<?php echo isset($_SESSION['LastData']['masa-tluszczu']) ? $_SESSION['LastData']['masa-tluszczu'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Masa wody:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-wody" style="width: 60px" name="masa-wody" required value="<?php echo isset($_SESSION['LastData']['masa-wody']) ? $_SESSION['LastData']['masa-wody'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Masa mięsniowa:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-miesni" style="width: 60px" name="masa-miesni" required value="<?php echo isset($_SESSION['LastData']['masa-miesni']) ? $_SESSION['LastData']['masa-miesni'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Masa kości:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-kosci" style="width: 60px" name="masa-kosci" required value="<?php echo isset($_SESSION['LastData']['masa-kosci']) ? $_SESSION['LastData']['masa-kosci'] : '' ?>"> kg
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="add_raport">
            <button type="submit" class="btn btn-success">Wyślij</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EdycjaRaportu" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edytuj raport</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
          <?php if (isset($_SESSION['editraporterror'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['editraporterror']; ?></p>
              </div>
            <?php } unset($_SESSION['editraporterror']); ?>
          <div class="form-group">
            <label for="input-masa-ciala" class="col-form-label">Masa ciała:</label>
            <input type="text" class="form-control d-inline-block" id="input-masa-ciala" style="width: 60px" name="masa-ciala" required value="<?php echo isset($_SESSION['LastData']['masa-ciala']) ? $_SESSION['LastData']['masa-ciala'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-waga-docelowa" class="col-form-label">Waga docelowa:</label>
            <input type="text" class="form-control d-inline-block" id="input-waga-docelowa" style="width: 60px" name="waga-docelowa" required value="<?php echo isset($_SESSION['LastData']['waga-docelowa']) ? $_SESSION['LastData']['waga-docelowa'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-masa-tluszczu" class="col-form-label">Masa tłuszczowa:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-tluszczu" style="width: 60px" name="masa-tluszczu" required value="<?php echo isset($_SESSION['LastData']['masa-tluszczu']) ? $_SESSION['LastData']['masa-tluszczu'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-masa-wody" class="col-form-label">Masa wody:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-wody" style="width: 60px" name="masa-wody" required value="<?php echo isset($_SESSION['LastData']['masa-wody']) ? $_SESSION['LastData']['masa-wody'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-masa-miesni" class="col-form-label">Masa mięsniowa:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-miesni" style="width: 60px" name="masa-miesni" required value="<?php echo isset($_SESSION['LastData']['masa-miesni']) ? $_SESSION['LastData']['masa-miesni'] : '' ?>"> kg
          </div>
          <div class="form-group">
            <label for="input-masa-kosci" class="col-form-label">Masa kości:</label> 
            <input type="text" class="form-control d-inline-block" id="input-masa-kosci" style="width: 60px" name="masa-kosci" required value="<?php echo isset($_SESSION['LastData']['masa-kosci']) ? $_SESSION['LastData']['masa-kosci'] : '' ?>"> kg
          </div>
          <input type="hidden" id="edit-id" name="edit-id">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="edit_raport">
            <button type="submit" class="btn btn-primary">Edytuj</button>
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

    <section class="mt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-10 ml-auto">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#niezaakceptowane" role="tab" aria-controls="home" aria-selected="true">Oczekujące</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="profile-tab" data-toggle="tab" href="#zaakceptowane" role="tab" aria-controls="profile" aria-selected="false">Zaakceptowane</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="niezaakceptowane" role="tabpanel" aria-labelledby="home-tab">
              <div class="container-fluid">
                <h1 class="text-center text-muted py-3"><button type="button" class="btn btn-success btn-lg mr-3 float-right" data-toggle="modal" data-target="#DodanieRaportu">Prześlij nowy raport</button></h1>

              <?php
                $sql = "SELECT * FROM `raporty` INNER JOIN uzytkownik ON `raporty`.`KlientID` = `uzytkownik`.`UzytkownikID` WHERE `uzytkownik`.`UzytkownikID` = {$_SESSION['user']['UzytkownikID']} ORDER BY `raporty`.`DataRaportu` ASC";
                $result = $db_conn -> query($sql);
                $raporty = array();
                while ($row = $result->fetch_assoc()) 
                  {
                    $raporty[$row['przeczytano']][$row['RaportyID']] = '<div class="col-3">';
                      $raporty[$row['przeczytano']][$row['RaportyID']] .= '<div class="card mb-3 tmp-card" style="">';
                        $raporty[$row['przeczytano']][$row['RaportyID']] .= '<div class="card-body mb-3">';
                          if($row['przeczytano'] == 0)
                          {
                            $raporty[$row['przeczytano']][$row['RaportyID']] .= '<h6 class="card-subtitle mb-2 text-danger">'.$row['DataRaportu'].'</h6>';
                          }
                          else
                          {
                            $raporty[$row['przeczytano']][$row['RaportyID']] .= '<h6 class="card-subtitle mb-2 text-success">'.$row['DataRaportu'].'</h6>';
                          }
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text font-weight-bold">Waga ogólna - '.$row['MasaCiala'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text font-weight-bold">Waga docelowa - '.$row['Waga_Docelowa']. ' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text font-weight-bold">Poszczególne wagi: </p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Tłuszcz: '.$row['Waga_Tluszczu'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Woda: '.$row['Waga_Wody'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Mięśnie: '.$row['Waga_Miesni'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Kości: '.$row['Waga_Kosci'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<div class="text-right tmp-btn">';
                          if($row['przeczytano'] == 0)
                          {
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<button type="button" class="btn btn-primary btn-sm mr-3" data-toggle="modal" data-target="#EdycjaRaportu" data-id="'.$row['RaportyID'].'">Edytuj</button>';
                          }
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '</div>';
                        $raporty[$row['przeczytano']][$row['RaportyID']] .= '</div>';
                      $raporty[$row['przeczytano']][$row['RaportyID']] .= '</div>';
                    $raporty[$row['przeczytano']][$row['RaportyID']] .= '</div>';
                  }
                  $i=0;
                  if(isset($raporty[0]))
                  {
                    foreach($raporty[0] as $raport)
                    {
                      if($i % 4 == 0)
                      {
                        echo '<div class="row mb-3 mt-3">';
                      }
                      echo $raport;
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
                }
              ?>
            </div>
          </div>
            <div class="tab-pane fade" id="zaakceptowane" role="tabpanel" aria-labelledby="profile-tab">
              <div class="container-fluid">
              <?php
                  $i = 0;
                  if(isset($raporty[1]))
                  {
                    foreach($raporty[1] as $raport)
                    {
                      if($i % 4 == 0)
                      {
                        echo '<div class="row mb-3 mt-3">';
                      }
                      echo $raport;
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
                }
                ?>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </section>
<?php unset($_SESSION['LastData']); ?>
<script type="text/javascript">
  <?php if(isset($_GET['dodanie_raportu']))
  { ?>
    $('#DodanieRaportu').modal('show');
 <?php }
   else if(isset($_GET['edycja_raportu']))
  { ?>
    $('#EdycjaRaportu').modal('show');
 <?php } ?>
</script> 

<script type="text/javascript">
  $('li.nav-item a[href="mojeraporty.php"]').removeClass('sidebar-link').addClass('current').parent().parent().removeClass('content').css('list-style', 'none').prev().removeClass('collapsible');
</script>

<script>
  $('#EdycjaRaportu').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')
  var masa = button.parent().prev().prev().prev().prev().prev().prev().prev().text()
  var docelowa = button.parent().prev().prev().prev().prev().prev().prev().text()
  var tluszcz = button.parent().prev().prev().prev().prev().text()
  var woda = button.parent().prev().prev().prev().text()
  var miesnie = button.parent().prev().prev().text()
  var kosci = button.parent().prev().text()
  var modal = $(this)
  var regex = /[+-]?\d+(\.\d+)?/g;
  var masa = masa.match(regex);
  var docelowa = docelowa.match(regex);
  var tluszcz = tluszcz.match(regex);
  var woda = woda.match(regex);
  var miesnie = miesnie.match(regex);
  var kosci = kosci.match(regex);
  modal.find('.modal-body input#edit-id').val(id)
  modal.find('.modal-body input#input-masa-ciala').val(masa)
  modal.find('.modal-body input#input-waga-docelowa').val(docelowa)
  modal.find('.modal-body input#input-masa-tluszczu').val(tluszcz)
  modal.find('.modal-body input#input-masa-wody').val(woda)
  modal.find('.modal-body input#input-masa-miesni').val(miesnie)
  modal.find('.modal-body input#input-masa-kosci').val(kosci)
})
</script>

</body>
</html>