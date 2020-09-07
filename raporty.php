<?php 
  require_once 'database.php';
  require_once 'head.php'; 

    if(!isset($_SESSION['user']) || $_SESSION['user']['Typ_Uzytkownika'] !== 2)
    {
        header('Location:index.php?logowanie=true');
        die();  
    }
?>
<body id="dashboard">

<div class="modal fade" id="ZaakceptujRaport" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Akceptacja raportu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="action.php">
      <div class="modal-body">    
      </div>
      <div class="modal-footer">
        <input type="hidden" id="accept-id" name="accept-id">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
        <input type="hidden" name="do" value="accept_raport">
        <button type="submit" class="btn btn-success">Akceptuj</button>   
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
          <div class="col-xl-10 col-lg-9 col-md-8 ml-auto bg-dark fixed-top pt-2 pb-1">
            <div class="row align-items-center">
              <div class="col-md-4">
                
              </div>
              <div class="col-md-5">
                <form>
                  <div class="input-group">
                    <input type="text" id="myInput" onkeyup="search()" class="form-control search-input text-white" placeholder="Wyszukaj...">
                  </div>
                </form>
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
          <div class="col-10 ml-auto" id="lista-raportow">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#nowe" role="tab" aria-controls="home" aria-selected="true">Nowe</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" id="profile-tab" data-toggle="tab" href="#przeczytane" role="tab" aria-controls="profile" aria-selected="false">Przeczytane</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="nowe" role="tabpanel" aria-labelledby="home-tab">
              <div class="container-fluid">
              <?php
                $sql = "SELECT * FROM `raporty` INNER JOIN uzytkownik ON `raporty`.`KlientID` = `uzytkownik`.`UzytkownikID` WHERE `uzytkownik`.`DietetykID` = {$_SESSION['user']['UzytkownikID']} ORDER BY `raporty`.`DataRaportu` ASC";
                $result = $db_conn -> query($sql);
                $raporty = array();
                while ($row = $result->fetch_assoc()) 
                  {
                    $raporty[$row['przeczytano']][$row['RaportyID']] = '<div class="col-3">';
                      $raporty[$row['przeczytano']][$row['RaportyID']] .= '<div class="card mb-3 tmp-card" style="">';
                        $raporty[$row['przeczytano']][$row['RaportyID']] .= '<div class="card-body mb-3">';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<h5 class="card-title">'.$row['Imie'].' '.$row['Nazwisko'].'</h5>';
                          if($row['przeczytano'] == 0)
                          {
                            $raporty[$row['przeczytano']][$row['RaportyID']] .= '<h6 class="card-subtitle mb-2 text-danger">'.$row['DataRaportu'].'</h6>';
                          }
                          else
                          {
                            $raporty[$row['przeczytano']][$row['RaportyID']] .= '<h6 class="card-subtitle mb-2 text-success">'.$row['DataRaportu'].'</h6>';
                          }
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text font-weight-bold">Waga ogólna - '.$row['MasaCiala'].' </p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text font-weight-bold">Waga docelowa - '.$row['Waga_Docelowa'].' </p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text font-weight-bold">Poszczególne wagi: </p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Tłuszcz: '.$row['Waga_Tluszczu'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Woda: '.$row['Waga_Wody'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Mięśnie: '.$row['Waga_Miesni'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<p class="card-text">Kości: '.$row['Waga_Kosci'].' kg</p>';
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<div class="text-right tmp-btn">';
                          if($row['przeczytano'] == 0)
                          {
                          $raporty[$row['przeczytano']][$row['RaportyID']] .= '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ZaakceptujRaport" data-id='.$row['RaportyID'].'>Zaakceptuj</button>';
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
            <div class="tab-pane fade" id="przeczytane" role="tabpanel" aria-labelledby="profile-tab">
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

<script type="text/javascript">
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    let content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}
</script>
<script type="text/javascript">
  $('li.nav-item a[href="raporty.php"]').removeClass('sidebar-link').addClass('current').parent().parent().removeClass('content').css('list-style', 'none').prev().removeClass('collapsible');
</script>

<script type="text/javascript">
  $('#ZaakceptujRaport').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')
  var nazwa = button.parent().parent().children().first().text()
  var data = button.parent().parent().children().first().next().text()
  var modal = $(this)
  modal.find('.modal-body').text('Czy napewno chcesz zaakceptować raport klienta ' + nazwa + ' z dnia: ' + data)
  modal.find('.modal-footer input#accept-id').val(id)
})
</script>

<script>

function search() {
    var input, filter, cards, cardContainer, h5, title, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("lista-raportow");
    cards = cardContainer.getElementsByClassName("card");
    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card-body h5.card-title");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
}
</script>

</body>
</html>