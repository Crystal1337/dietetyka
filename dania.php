<?php 
  require_once 'database.php';
  require_once 'head.php'; 

    if(!isset($_SESSION['user']) || $_SESSION['user']['Typ_Uzytkownika'] == 1)
    {
        header('Location:index.php?logowanie=true');
        die();  
    }
?>
<body id="dashboard">

<div class="modal fade" id="DodanieDania" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dodawanie dania</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
              <?php if (isset($_SESSION['adddanie_error'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['adddanie_error']; ?></p>
              </div>
            <?php } unset($_SESSION['adddanie_error']); ?>
          <div class="form-group">
            <label for="input-tytul" class="col-form-label">Tytuł:</label>
            <input type="text" class="form-control" id="input-tytul" name="tytul" placeholder="Tytuł" required value="<?php echo isset($_SESSION['LastData']['tytul']) ? $_SESSION['LastData']['tytul'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-tytul" class="col-form-label">Potrzebne produkty:</label>
            <button type="button" class="btn btn-success btn-sm mr-3" data-toggle="modal" data-target="#TabelaProduktow">Dodaj nowy</button>
            <div id="DodanieDaniaProdukty">
            </div>
          </div>
          <div class="form-group">
            <label for="input-opis" class="col-form-label">Sposób przygotowania:</label>
            <textarea class="form-control" id="input-opis" cols="30" rows="8" name="opis" required value=""><?php echo isset($_SESSION['LastData']['opis']) ? $_SESSION['LastData']['opis'] : '' ?></textarea>
          </div>
          <div class="form-group">
            <label for="OpcjeTypu" class="col-form-label">Typ dania:</label>
            <select class="form-control" id="OpcjeTypu" name="OpcjeTypu">
              <?php 
              $sql2 = "SELECT * FROM `typ_dania`";
              $result2 = $db_conn -> query($sql2);
              while ($row2 = $result2->fetch_assoc())
              {
                echo '<option value="'.$row2['TypID'].'"';
                if(isset($_SESSION['LastData']['OpcjeTypu']) && $_SESSION['LastData']['OpcjeTypu'] == $row2['TypID'])
                {
                  echo ' selected';
                }
                echo '>';
                echo $row2['TypDania'];
                echo '</option>';
              }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="add_danie">
            <button type="submit" class="btn btn-primary">Dodaj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EdycjaDania" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edycja dania</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
              <?php if (isset($_SESSION['editdanie_error'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['editdanie_error']; ?></p>
              </div>
            <?php } unset($_SESSION['editdanie_error']); ?>
          <div class="form-group">
            <label for="input-tytul" class="col-form-label">Tytuł:</label>
            <input type="text" class="form-control" id="input-tytul" name="tytul" placeholder="Tytuł" required value="<?php echo isset($_SESSION['LastData']['tytul']) ? $_SESSION['LastData']['tytul'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-tytul" class="col-form-label">Potrzebne produkty:</label>
            <button type="button" class="btn btn-success btn-sm mr-3" data-toggle="modal" data-target="#TabelaProduktow">Dodaj nowy</button>
            <div id="EdycjaDaniaProdukty">
            </div>
          </div>
          <div class="form-group">
            <label for="input-opis" class="col-form-label">Sposób przygotowania:</label>
            <textarea class="form-control" id="input-opis" cols="30" rows="8" name="opis" required value=""><?php echo isset($_SESSION['LastData']['opis']) ? $_SESSION['LastData']['opis'] : '' ?></textarea>
          </div>
          <div class="form-group">
            <label for="OpcjeTypu" class="col-form-label">Typ dania:</label>
            <select class="form-control" id="OpcjeTypu" name="OpcjeTypu">
              <?php 
              $sql2 = "SELECT * FROM `typ_dania`";
              $result2 = $db_conn -> query($sql2);
              while ($row2 = $result2->fetch_assoc())
              {
                echo '<option value="'.$row2['TypID'].'"';
                if(isset($_SESSION['LastData']['OpcjeTypu']) && $_SESSION['LastData']['OpcjeTypu'] == $row2['TypID'])
                {
                  echo ' selected';
                }
                echo '>';
                echo $row2['TypDania'];
                echo '</option>';
              }
              ?>
            </select>
          </div>
            <input type="hidden" id="edit-id" name="edit-id" value="<?php echo isset($_SESSION['LastData']['edit-id']) ? $_SESSION['LastData']['edit-id'] : '' ?>">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="edit_danie">
            <button type="submit" class="btn btn-primary">Edytuj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="TabelaProduktow" tabindex="-1" role="dialog">
  <div class="modal-dialog" id="tablemodal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Wybierz produkt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <table class="table table-curved bg-dark text-center text-light mx-auto">
            <thead>
              <tr class="text-muted">
                <th>Nazwa</th>
                <th>Białko/100g</th>
                <th>Węglowodany/100g</th>
                <th>Tłuszcze/100g</th>
                <th>Błonnik/100g</th>
                <th>Kalorie</th>
                <th>Dodaj</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT `ProduktID`, `Nazwa`, `Bialko_gr`, `Wegl_gr`, `Tluszcz_gr`, `Blonnik_gr`, `Kcal`, `DietetykID` from `produkt` ORDER BY `Nazwa` ASC";
                $result = $db_conn -> query($sql);
                while ($row = $result->fetch_assoc()) 
                  {
                    echo '<tr data-id="'.$row['ProduktID'].'">';
                    echo '<td>';
                      echo $row["Nazwa"];
                    echo '</td>';
                    echo '<td>';
                      echo $row["Bialko_gr"];
                    echo '</td>';
                    echo '<td>';
                      echo $row["Wegl_gr"];
                    echo '</td>';
                    echo '<td>';
                      echo $row["Tluszcz_gr"];
                    echo '</td>';
                    echo '<td>';
                      echo $row["Blonnik_gr"];
                    echo '</td>';
                    echo '<td>';
                      echo $row["Kcal"];
                    echo '</td>';
                    echo '<td>';
                      echo '<button type="button" class="btn btn-success btn-sm produkt-button" data-id="'.$row['ProduktID'].'">Dodaj</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="UsuwanieDania" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Usuwanie produktu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="action.php">
      <div class="modal-body">    
      </div>
      <div class="modal-footer">
        <input type="hidden" id="remove-id" name="remove-id">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
        <input type="hidden" name="do" value="remove_danie">
        <button type="submit" class="btn btn-danger">Usuń</button>   
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
          <div class="col-10 ml-auto" id="lista-dan">
            <h1 class="text-center text-muted py-3">Lista posiłków <button type="button" class="btn btn-success btn-lg mr-3 float-right" data-toggle="modal" data-target="#DodanieDania">Dodaj nowy posiłek</button></h1>
              <?php
              if($_SESSION['user']['Typ_Uzytkownika'] == 2)
                {
                  $sql = "SELECT `danie`.`DanieID`, `danie`.`Tytul`, `danie`.`Bialko_gr`, `danie`.`Wegl_gr`, `danie`.`Tluszcz_gr`, `danie`.`Blonnik_gr`, `danie`.`Kcal`, `danie`.`Opis`, `typ_dania`.`TypID`, `typ_dania`.`TypDania` FROM `danie` INNER JOIN `typ_dania` ON `danie`.`TypID` = `typ_dania`.`TypID` WHERE `danie`.`DietetykID` = {$_SESSION['user']['UzytkownikID']}";
                }
                else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
                {
                  $sql = "SELECT `danie`.`DanieID`, `danie`.`Tytul`, `danie`.`Bialko_gr`, `danie`.`Wegl_gr`, `danie`.`Tluszcz_gr`, `danie`.`Blonnik_gr`, `danie`.`Kcal`, `danie`.`Opis`, `typ_dania`.`TypID`, `typ_dania`.`TypDania` FROM `danie` INNER JOIN `typ_dania` ON `danie`.`TypID` = `typ_dania`.`TypID`";
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
                          echo '<p class="card-text font-weight-bold">Sposób przygotowania: </p>';
                          echo '<p class="card-text">'.nl2br($row['Opis']).'</p>';
                          echo '<p class="card-text font-weight-bold">Suma makroskładników: </p>';
                          echo '<p class="card-text font-weight-bold">'.round($row['Bialko_gr'], 1).' gram białka</p>';
                          echo '<p class="card-text font-weight-bold">'.round($row['Wegl_gr'], 1).' gram węglowodanów</p>';
                          echo '<p class="card-text font-weight-bold">'.round($row['Tluszcz_gr'], 1).' gram tłuszczy</p>';
                          echo '<p class="card-text font-weight-bold">'.round($row['Blonnik_gr'], 1).' gram błonnika</p>';
                          echo '<p hidden class="card-text font-weight-bold">'.$row['TypID'].'</p>';
                          echo '<div class="text-right tmp-btn">';
                          echo '<button type="button" class="btn btn-success btn-sm mr-3" data-toggle="modal" data-target="#EdycjaDania" data-id='.$row['DanieID'].'>Edytuj</button>';
                          echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#UsuwanieDania" data-id='.$row['DanieID'].'>Usuń</button>';
                          echo '</div>';
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
<?php unset($_SESSION['LastData']); ?>

<script type="text/javascript">
  <?php if(isset($_GET['dodanie_dania']))
  { ?>
    $('#DodanieDania').modal('show');
 <?php }
   else if(isset($_GET['edycja_dania']))
  { ?>
    $('#EdycjaDania').modal('show');
 <?php } ?>
</script> 

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
  $('li.nav-item a[href="dania.php"]').removeClass('sidebar-link').addClass('current').parent().parent().removeClass('content').css('list-style', 'none').prev().removeClass('collapsible');
</script>

<script type="text/javascript">
  $('.produkt-button').click(function(e) {
    e.preventDefault();
    $('#TabelaProduktow').modal('hide');
    let button = $(this) // Button that triggered the modal
    let id = button.data('id');
    let nazwa = button.parent().parent().children().first().text();
    let element = '<p class="font-weight-bold">'+nazwa+' - <input type="text" class="form-control d-inline-block" style="width:70px;"id="input-gramy" name="ProduktWaga['+id+']" required> gram<button type="button" class="btn btn-danger btn-sm ml-2 UsunProduktDanie" style="padding: 0rem .5rem;" tabIndex="-1" data-id="'+id+'">-</button><input type="hidden" name="ProduktID[]" value="'+id+'"></p>';
    $('#DodanieDaniaProdukty').append(element);
    $('#EdycjaDaniaProdukty').append(element);
    button.parent().parent().addClass('d-none');
    $('.UsunProduktDanie').off('click.usun').on('click.usun', function(){
      let id = $(this).data('id');
      $('#TabelaProduktow tr[data-id="'+id+'"]').removeClass('d-none');
      $(this).parent().remove();
    });
});
</script>

<script type="text/javascript">
  $('#DodanieDania').on('show.bs.modal', function (event) {
    $('#TabelaProduktow tr').removeClass('d-none');
    $('#DodanieDaniaProdukty').html('');
  });
</script>

<script type="text/javascript">
  $('#EdycjaDania').on('show.bs.modal', function (event) {
    $('#TabelaProduktow tr').removeClass('d-none');
    $('#EdycjaDaniaProdukty').html('');
    let button = $(event.relatedTarget); // Button that triggered the modal
    let id = button.data('id');
    let typ = button.parent().prev().text();
    let tytul = button.parent().parent().children().first().text();
    let opis = button.parent().prev().prev().prev().prev().prev().prev().prev().text();
    let modal = $(this);
    modal.find('.modal-body input#edit-id').val(id);
    modal.find('.modal-body input#input-tytul').val(tytul);
    modal.find('.modal-body textarea#input-opis').val(opis);
    $('#OpcjeTypu option:selected').prop('selected', false);
    $('#OpcjeTypu option[value="' + typ + '"]').prop('selected', true);
    button.parent().parent().children('.ProduktID').each(function(index, elem) {
      let id = $(elem).val();
      let nazwa = $('#TabelaProduktow tr[data-id="'+id+'"]').children().first().text();
      let waga = $(elem).next().val();
      let element = '<p class="font-weight-bold">'+nazwa+' - <input type="text" class="form-control d-inline-block" style="width:70px;"id="input-gramy" name="ProduktWaga['+id+']" value="'+waga+'" required> gram<button type="button" class="btn btn-danger btn-sm ml-2 UsunProduktDanie" style="padding: 0rem .5rem;" tabIndex="-1" data-id="'+id+'">-</button><input type="hidden" name="ProduktID[]" value="'+id+'"></p>';
      $('#EdycjaDaniaProdukty').append(element);
      $('#TabelaProduktow tr[data-id="'+id+'"]').addClass('d-none');
      $('.UsunProduktDanie').off('click.usun').on('click.usun', function(){
        let id = $(this).data('id');
        $('#TabelaProduktow tr[data-id="'+id+'"]').removeClass('d-none');
        $(this).parent().remove();
      });
    });
  });
</script>

<script type="text/javascript">
  $('#UsuwanieDania').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget) // Button that triggered the modal
  let id = button.data('id')
  let tytul = button.parent().parent().children().first().text();
  let modal = $(this)
  modal.find('.modal-body').text('Czy napewno chcesz usunąć danie: ' + tytul)
  modal.find('.modal-footer input#remove-id').val(id)
});
</script>
<script>

function search() {
    var input, filter, cards, cardContainer, h5, title, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("lista-dan");
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