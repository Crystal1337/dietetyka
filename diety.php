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

<div class="modal fade" id="DodanieDiety" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dodawanie diety</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Nazwa:</label>
            <input type="text" class="form-control" id="input-nazwa" name="nazwa" placeholder="Nazwa" required value="">
          </div>
          <div class="form-group">
            <label for="input-tytul" class="col-form-label">Opis:</label>
            <textarea class="form-control" id="input-opis" cols="30" rows="8" name="opis" required value=""></textarea>
          </div>
          <div class="form-group">
            <label for="OpcjeTypu" class="col-form-label">Typ diety:</label>
            <select class="form-control" id="OpcjeTypu" name="OpcjeTypu">
              <?php 
              $sql2 = "SELECT * FROM `typ_diety`";
              $result2 = $db_conn -> query($sql2);
              while ($row2 = $result2->fetch_assoc())
              {
                echo '<option value="'.$row2['TypDietyID'].'">';
                echo $row2['Typ_Diety'];
                echo '</option>';
              }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="add_dieta">
            <button type="submit" class="btn btn-primary">Dodaj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EdycjaDiety" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edycja diety</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Nazwa:</label>
            <input type="text" class="form-control" id="input-nazwa" name="nazwa" placeholder="Nazwa" required value="">
          </div>
          <div class="form-group">
            <label for="input-tytul" class="col-form-label">Opis:</label>
            <textarea class="form-control" id="input-opis" cols="30" rows="8" name="opis" required value=""></textarea>
          </div>
          <div class="form-group">
            <label for="OpcjeTypu" class="col-form-label">Typ diety:</label>
            <select class="form-control" id="OpcjeTypu" name="OpcjeTypu">
              <?php 
              $sql2 = "SELECT * FROM `typ_diety`";
              $result2 = $db_conn -> query($sql2);
              while ($row2 = $result2->fetch_assoc())
              {
                echo '<option value="'.$row2['TypDietyID'].'">';
                echo $row2['Typ_Diety'];
                echo '</option>';
              }
              ?>
            </select>
          </div>
            <input type="hidden" id="edit-id" name="edit-id">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="edit_dieta">
            <button type="submit" class="btn btn-primary">Edytuj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="UsuwanieDiety" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Usuwanie diety</h5>
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
        <input type="hidden" name="do" value="remove_dieta">
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
          <div class="col-10 ml-auto" id="lista-diet">
            <h1 class="text-center text-muted py-3">Lista diet <button type="button" class="btn btn-success btn-lg mr-3 float-right" data-toggle="modal" data-target="#DodanieDiety">Dodaj nową diete</button></h1>
              <?php
              if($_SESSION['user']['Typ_Uzytkownika'] == 2)
                {
                  $sql = "SELECT `dieta`.`DietaID`, `dieta`.`Tytul`, `dieta`.`Kalorycznosc`, `dieta`.`Opis`, `typ_diety`.`TypDietyID`, `typ_diety`.`Typ_Diety` FROM `dieta` INNER JOIN `typ_diety` ON `dieta`.`TypDietyID` = `typ_diety`.`TypDietyID` WHERE `dieta`.`DietetykID` = {$_SESSION['user']['UzytkownikID']}";
                }
                else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
                {
                  $sql = "SELECT `dieta`.`DietaID`, `dieta`.`Tytul`, `dieta`.`Kalorycznosc`, `dieta`.`Opis`, `typ_diety`.`TypDietyID`, `typ_diety`.`Typ_Diety` FROM `dieta` INNER JOIN `typ_diety` ON `dieta`.`TypDietyID` = `typ_diety`.`TypDietyID`";
                }
                $result = $db_conn -> query($sql);
                $i=0;
                while ($row = $result->fetch_assoc()) 
                  {
                    if($i % 4 == 0)
                    {
                      echo '<div class="row mb-3">';
                    }
                    echo '<div class="col-3">';
                      echo '<div class="card mb-3 tmp-card" style="">';
                        echo '<div class="card-body">';
                          echo '<h5 class="card-title">'.$row['Tytul'].'</h5>';
                          echo '<h6 class="card-subtitle mb-2 text-muted">'.$row['Typ_Diety'].' - '.$row['Kalorycznosc'].' kcal</h6>';
                          echo '<p class="card-text">'.nl2br($row["Opis"]).'</p>';
                          echo '<p hidden class="card-text font-weight-bold">'.$row['TypDietyID'].'</p>';
                          echo '<div class="text-right tmp-btn">';
                            echo '<a href="dieta.php?id='.$row['DietaID'].'" class="btn btn-sm btn-primary mr-3">Szczegóły</a>';
                            echo '<button type="button" class="btn btn-success btn-sm mr-3" data-toggle="modal" data-target="#EdycjaDiety" data-id='.$row['DietaID'].'>Edytuj</button>';
                            echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#UsuwanieDiety" data-id='.$row['DietaID'].'>Usuń</button>';
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
  $('li.nav-item a[href="diety.php"]').removeClass('sidebar-link').addClass('current').parent().parent().removeClass('content').css('list-style', 'none').prev().removeClass('collapsible');
</script>

<script type="text/javascript">
  $('#UsuwanieDiety').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget) // Button that triggered the modal
  let id = button.data('id')
  let tytul = button.parent().parent().children().first().text();
  let modal = $(this)
  modal.find('.modal-body').text('Czy napewno chcesz usunąć diete: ' + tytul)
  modal.find('.modal-footer input#remove-id').val(id)
});
</script>

<script type="text/javascript">
  $('#EdycjaDiety').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let id = button.data('id');
    let tytul = button.parent().parent().children().first().text();
    let opis = button.parent().parent().children().first().next().next().text();
    let typ = button.parent().prev().text();
    let modal = $(this);
    modal.find('.modal-body input#edit-id').val(id);
    modal.find('.modal-body input#input-nazwa').val(tytul);
    modal.find('.modal-body textarea#input-opis').val(opis);
    $('#OpcjeTypu option:selected').prop('selected', false);
    $('#OpcjeTypu option[value="' + typ + '"]').prop('selected', true);
  });
</script>

<script>

function search() {
    var input, filter, cards, cardContainer, h5, title, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("lista-diet");
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