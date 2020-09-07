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

<div class="modal fade" id="EdycjaProduktu" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edycja produktu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
            <?php if (isset($_SESSION['productedit_error'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['productedit_error']; ?></p>
              </div>
            <?php } unset($_SESSION['productedit_error']); ?>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Nazwa produktu:</label>
            <input type="text" class="form-control" id="input-nazwa" name="nazwa" placeholder="Nazwa" required value="<?php echo isset($_SESSION['LastData']['nazwa']) ? $_SESSION['LastData']['nazwa'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-bialko" class="col-form-label">Białko / 100gram:</label>
            <input type="text" class="form-control" id="input-bialko" name="bialko" placeholder="Białko/100g" required value="<?php echo isset($_SESSION['LastData']['bialko']) ? $_SESSION['LastData']['bialko'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-weglowodany" class="col-form-label">Węglowodany / 100gram:</label>
            <input type="text" class="form-control" id="input-weglowodany" name="weglowodany" placeholder="Węglowodany/100g" required value="<?php echo isset($_SESSION['LastData']['weglowodany']) ? $_SESSION['LastData']['weglowodany'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-tluszcze" class="col-form-label">Tłuszcze / 100gram:</label>
            <input type="text" class="form-control" id="input-tluszcze" name="tluszcze" placeholder="Tłuszcze/100g" required value="<?php echo isset($_SESSION['LastData']['tluszcze']) ? $_SESSION['LastData']['tluszcze'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-blonnik" class="col-form-label">Błonnik / 100gram:</label>
            <input type="text" class="form-control" id="input-blonnik" name="blonnik" placeholder="Błonnik/100g" required value="<?php echo isset($_SESSION['LastData']['blonnik']) ? $_SESSION['LastData']['blonnik'] : '' ?>">
          </div>
            <input type="hidden" id="edit-id" name="edit-id" value="<?php echo isset($_SESSION['LastData']['edit-id']) ? $_SESSION['LastData']['edit-id'] : '' ?>">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="edit_product">
            <button type="submit" class="btn btn-primary">Edytuj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="DodanieProduktu" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dodaj nowy produktu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
              <?php if (isset($_SESSION['productadd_error'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['productadd_error']; ?></p>
              </div>
            <?php } unset($_SESSION['productadd_error']); ?>
          <div class="form-group">
            <label for="input-nazwa" class="col-form-label">Nazwa produktu:</label>
            <input type="text" class="form-control" id="input-nazwa" name="nazwa" placeholder="Nazwa" required value="<?php echo isset($_SESSION['LastData']['nazwa']) ? $_SESSION['LastData']['nazwa'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-bialko" class="col-form-label">Białko / 100gram:</label>
            <input type="text" class="form-control" id="input-bialko" name="bialko" placeholder="Białko/100g" required value="<?php echo isset($_SESSION['LastData']['bialko']) ? $_SESSION['LastData']['bialko'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-weglowodany" class="col-form-label">Węglowodany / 100gram:</label>
            <input type="text" class="form-control" id="input-weglowodany" name="weglowodany" placeholder="Węglowodany/100g" required value="<?php echo isset($_SESSION['LastData']['weglowodany']) ? $_SESSION['LastData']['weglowodany'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-tluszcze" class="col-form-label">Tłuszcze / 100gram:</label>
            <input type="text" class="form-control" id="input-tluszcze" name="tluszcze" placeholder="Tłuszcze/100g" required value="<?php echo isset($_SESSION['LastData']['tluszcze']) ? $_SESSION['LastData']['tluszcze'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="input-blonnik" class="col-form-label">Błonnik / 100gram:</label>
            <input type="text" class="form-control" id="input-blonnik" name="blonnik" placeholder="Błonnik/100g" required value="<?php echo isset($_SESSION['LastData']['blonnik']) ? $_SESSION['LastData']['blonnik'] : '' ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="add_product">
            <button type="submit" class="btn btn-success">Dodaj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="UsuwanieProduktu" tabindex="-1" role="dialog">
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
        <input type="hidden" name="do" value="remove_product">
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
          <div class="col-10 ml-auto">

            <div class="row">
              <div class="col-10 offset-1">
                <h1 class="text-center text-muted py-3">Lista składników <button type="button" class="btn btn-success btn-lg float-right" data-toggle="modal" data-target="#DodanieProduktu">Dodaj produkt</button></h1>
                <table class="table table-curved bg-dark text-center text-light mx-auto" id="tabela-produkty">
                  <thead>
                    <tr class="text-muted">
                      <th>Nazwa</th>
                      <th>Białko/100g</th>
                      <th>Węglowodany/100g</th>
                      <th>Tłuszcze/100g</th>
                      <th>Błonnik/100g</th>
                      <th>Kalorie/100g</th>
                      <th>Edytuj</th>
                      <th>Usuń</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      if($_SESSION['user']['Typ_Uzytkownika'] == 2)
                      {
                        $sql = "SELECT `ProduktID`, `Nazwa`, `Bialko_gr`, `Wegl_gr`, `Tluszcz_gr`, `Blonnik_gr`, `Kcal`, `DietetykID` from `produkt` WHERE `DietetykID` = {$_SESSION['user']['UzytkownikID']} ORDER BY `Nazwa` ASC";
                      }
                      else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
                      {
                        $sql = "SELECT `ProduktID`, `Nazwa`, `Bialko_gr`, `Wegl_gr`, `Tluszcz_gr`, `Blonnik_gr`, `Kcal`, `DietetykID` from `produkt` ORDER BY `Nazwa` ASC";
                      }
                      $result = $db_conn -> query($sql);
                      while ($row = $result->fetch_assoc()) 
                        {
                            echo '<tr>';
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
                              echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EdycjaProduktu" data-id='.$row['ProduktID'].'>Edytuj</button>';
                            echo '</td>';
                            echo '<td>';
                              echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#UsuwanieProduktu" data-id='.$row['ProduktID'].'>Usuń</button>';
                            echo '</td>';
                            echo '</tr>';
                      }
                      ?>
                      <?php
                      if($_SESSION['user']['Typ_Uzytkownika'] == 2)
                      {
                      $sql = "SELECT `ProduktID`, `Nazwa`, `Bialko_gr`, `Wegl_gr`, `Tluszcz_gr`, `Blonnik_gr`, `Kcal`, `DietetykID` from `produkt` WHERE `DietetykID` != {$_SESSION['user']['UzytkownikID']} ORDER BY `Nazwa` ASC";
                      $result = $db_conn -> query($sql);
                      while ($row = $result->fetch_assoc()) 
                        {

                            echo '<tr>';
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
                              echo '';
                            echo '</td>';
                            echo '<td>';
                              echo '';
                            echo '</td>';
                            echo '</tr>';
                      }
                    }
                      ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </section>

<?php unset($_SESSION['LastData']); ?>
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
  $('li.nav-item a[href="produkty.php"]').removeClass('sidebar-link').addClass('current').parent().parent().removeClass('content').css('list-style', 'none').prev().removeClass('collapsible');
</script>

<script type="text/javascript">
  <?php if(isset($_GET['dodanie_produktu']))
  { ?>
    $('#DodanieProduktu').modal('show');
 <?php }
  else if(isset($_GET['edycja_produktu']))
  { ?>
    $('#EdycjaProduktu').modal('show');
 <?php } ?>
</script> 

<script type="text/javascript">
  $('#EdycjaProduktu').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')
  var blonnik = button.parent().prev().prev().text()
  var tluszcz = button.parent().prev().prev().prev().text()
  var weglowodany = button.parent().prev().prev().prev().prev().text()
  var bialko = button.parent().prev().prev().prev().prev().prev().text()
  var nazwa = button.parent().prev().prev().prev().prev().prev().prev().text()
  var modal = $(this)
  modal.find('.modal-body input#edit-id').val(id)
  modal.find('.modal-body input#input-tluszcze').val(tluszcz)
  modal.find('.modal-body input#input-weglowodany').val(weglowodany)
  modal.find('.modal-body input#input-bialko').val(bialko)
  modal.find('.modal-body input#input-blonnik').val(blonnik)
  modal.find('.modal-body input#input-nazwa').val(nazwa)
})
</script>

<script type="text/javascript">
  $('#UsuwanieProduktu').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id')
  var nazwa = button.parent().prev().prev().prev().prev().prev().prev().prev().text()
  var modal = $(this)
  modal.find('.modal-body').text('Czy napewno chcesz usunąć produkt: ' + nazwa)
  modal.find('.modal-footer input#remove-id').val(id)
})
</script>

<script>
function search() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabela-produkty");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>


</body>
</html>
