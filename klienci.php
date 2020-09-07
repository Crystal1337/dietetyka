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
                <?php 
                if($_SESSION['user']['Typ_Uzytkownika'] == 2)
                {
                  echo '<h1 class="text-center text-muted py-3"> Moi klienci </h1>';
                }
                else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
                {
                  echo '<h1 class="text-center text-muted py-3">Wszyscy klienci </h1>';
                }
                ?>
                <table class="table table-curved bg-dark text-center text-light mx-auto" id="tabela-klienci">
                  <thead>
                    <tr class="header text-muted">
                      <th>Imię</th>
                      <th>Nazwisko</th>
                      <th>Ulica</th>
                      <th>Miasto</th>
                      <th>Kod pocztowy</th>
                      <?php if($_SESSION['user']['Typ_Uzytkownika'] == 2){?>
                      <th>Dieta</th>
                    <?php }else if($_SESSION['user']['Typ_Uzytkownika'] == 3){
                      echo '<th>Dietetyk</th>';}?>
                      <th>Profil</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      $sql = "SELECT `UzytkownikID`, `Imie`, `Nazwisko`, `Ulica`, `Miasto`, `Kod_Pocztowy`, `Typ_Uzytkownika`, `DietetykID`, `DietaID` from uzytkownik where Typ_Uzytkownika=1";
                      $result = $db_conn -> query($sql);
                      while ($row = $result->fetch_assoc()) 
                        {
                          if($_SESSION['user']['Typ_Uzytkownika'] == 2)
                          {
                            if($_SESSION['user']['UzytkownikID'] == $row['DietetykID'])
                            {
                              echo '<tr>';
                              echo '<td>';
                              echo $row["Imie"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Nazwisko"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Ulica"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Miasto"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Kod_Pocztowy"];
                              echo '</td>';
                              echo '<td>';
                                if($row["DietaID"]==NULL)
                                {
                                  echo 'Brak';
                                }
                                else
                                {
                                  $query2 = "SELECT * FROM dieta WHERE DietaID = $row[DietaID]";
                                  $result2 = $db_conn->query($query2);
                                  if ($result2) 
                                    {
                                      $row2 = $result2->fetch_row();
                                      echo $row2[1];
                                    }
                                }
                              echo '</td>';
                              echo '<td>';
                              echo '<a href="klient.php?id='.$row['UzytkownikID'].'" class="btn btn-sm btn-primary">Profil</a>';
                              echo '</td>';
                              echo '</tr>';
                            }
                          }
                          else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
                          {
                            echo '<tr>';
                              echo '<td>';
                              echo $row["Imie"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Nazwisko"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Ulica"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Miasto"];
                              echo '</td>';
                              echo '<td>';
                              echo $row["Kod_Pocztowy"];
                              echo '</td>';
                              echo '<td>';
                                if($row["DietetykID"]==NULL)
                                {
                                  echo 'Brak';
                                }
                                else
                                {
                                  $query2 = "SELECT Imie, Nazwisko FROM uzytkownik WHERE UzytkownikID = $row[DietetykID]";
                                  $result2 = $db_conn->query($query2);
                                  if ($result2) 
                                    {
                                      $row2 = $result2->fetch_row();
                                      echo $row2[0]. ' ' .$row2[1];
                                    }
                                }
                              echo '</td>';
                              echo '<td>';
                              echo '<a href="klient.php?id='.$row['UzytkownikID'].'" class="btn btn-sm btn-primary">Profil</a>';
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

<script>
function search() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabela-klienci");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>

<script type="text/javascript">
  $('li.nav-item a[href="klienci.php"]').removeClass('sidebar-link').addClass('current');
</script>
</body>
</html>
