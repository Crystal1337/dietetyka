<?php 
  require_once 'database.php';
  require_once 'head.php'; 

    if(!isset($_SESSION['user']) || $_SESSION['user']['Typ_Uzytkownika'] == 1 )
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

      <div class="container-fluid">
        <div class="row mt-5">
          <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
            <div class="row md-5 md-3 mb-5">
              <div class="col-xl-3 col-sm-6 p-2">
                <div class="card card-common">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <i class="fas fa-users fa-3x text-primary"></i>
                      <div class="text-right text-secondary">
                        <?php if($_SESSION['user']['Typ_Uzytkownika'] == 2){?>
                        <h5>Moi klienci</h5>
                        <h3>
                          <?php
                            $query = "SELECT COUNT(UzytkownikID) FROM uzytkownik WHERE `DietetykID` = {$_SESSION['user']['UzytkownikID']}";
                            $result = $db_conn->query($query);
                            if ($result) 
                            {
                                $row = $result->fetch_row();
                                echo $row[0];
                            }
                          ?>
                        </h3>
                      <?php }
                        else if($_SESSION['user']['Typ_Uzytkownika'] == 3){?>
                          <h5>Klienci</h5>
                        <h3>
                          <?php
                            $query = "SELECT COUNT(UzytkownikID) FROM uzytkownik WHERE `Typ_Uzytkownika` = 1";
                            $result = $db_conn->query($query);
                            if ($result) 
                            {
                                $row = $result->fetch_row();
                                echo $row[0];
                            }
                          ?>
                        </h3>
                      <?php }?>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-secondary">
                    <i class="fas fa-sync mr-3"></i>
                    <span>Zaktualizowano</span>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 p-2">
                <div class="card card-common">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <?php if($_SESSION['user']['Typ_Uzytkownika'] == 2){?>
                      <i class="fas fa-user fa-3x text-danger"></i>
                    <?php }
                    else if($_SESSION['user']['Typ_Uzytkownika'] == 3){?>
                      <i class="fas fa-user fa-3x text-success"></i>
                    <?php }?>
                      <div class="text-right text-secondary">
                        <?php if($_SESSION['user']['Typ_Uzytkownika'] == 2){?>
                        <h5>Klienci bez diety</h5>
                        <h3>
                          <?php
                            $query2 = "SELECT COUNT(`UzytkownikID`) FROM `uzytkownik` WHERE `DietetykID` = {$_SESSION['user']['UzytkownikID']} AND `DietaID` IS NULL";
                            $result2 = $db_conn->query($query2);
                            if ($result2) 
                            {
                                $row2 = $result2->fetch_row();
                                echo $row2[0];
                            }
                          ?>
                        </h3>
                      <?php }
                      else if($_SESSION['user']['Typ_Uzytkownika'] == 3){?>
                        <h5>Dietetycy</h5>
                        <h3>
                          <?php
                            $query2 = "SELECT COUNT(`UzytkownikID`) FROM `uzytkownik` WHERE `Typ_Uzytkownika` = 2";
                            $result2 = $db_conn->query($query2);
                            if ($result2) 
                            {
                                $row2 = $result2->fetch_row();
                                echo $row2[0];
                            }
                          ?>
                        </h3>
                      <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-secondary">
                    <i class="fas fa-sync mr-3"></i>
                    <span>Zaktualizowano</span>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 p-2">
                <div class="card card-common">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <i class="fas fa-scroll fa-3x text-warning"></i>
                      <div class="text-right text-secondary">
                        <?php if($_SESSION['user']['Typ_Uzytkownika'] == 2){?>
                        <h5>Moje diety</h5>
                        <h3>
                          <?php
                            $query3 = "SELECT COUNT(DietaID) FROM dieta WHERE DietetykID = {$_SESSION['user']['UzytkownikID']}";
                            $result3 = $db_conn->query($query3);
                            if ($result3) 
                            {
                                $row3 = $result3->fetch_row();
                                echo $row3[0];
                            }
                          ?>
                        </h3>
                      <?php }
                      else if($_SESSION['user']['Typ_Uzytkownika'] == 3){?>
                        <h5>Wszystkie diety</h5>
                        <h3>
                          <?php
                            $query3 = "SELECT COUNT(DietaID) FROM dieta";
                            $result3 = $db_conn->query($query3);
                            if ($result3) 
                            {
                                $row3 = $result3->fetch_row();
                                echo $row3[0];
                            }
                          ?>
                        </h3>
                      <?php }?>
                      </div>   
                    </div>
                  </div>
                  <div class="card-footer text-secondary">
                    <i class="fas fa-sync mr-3"></i>
                    <span>Zaktualizowano</span>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 p-2">
                <div class="card card-common">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <?php if($_SESSION['user']['Typ_Uzytkownika'] == 2){?>
                      <i class="fas fa-file-invoice fa-3x text-success"></i>
                    <?php } else if($_SESSION['user']['Typ_Uzytkownika'] == 3){?>
                      <i class="fas fa-list-alt fa-3x text-danger"></i>
                    <?php }?>
                      <div class="text-right text-secondary">
                        <?php if($_SESSION['user']['Typ_Uzytkownika'] == 2){?>
                        <h5>Nowe raporty</h5>
                        <h3>
                          <?php
                            $query4 = "SELECT COUNT(`RaportyID`) FROM `raporty` INNER JOIN  `Uzytkownik` ON `raporty`.`KlientID` = `Uzytkownik`.`UzytkownikID` WHERE przeczytano = 0 AND `DietetykID` = {$_SESSION['user']['UzytkownikID']}";
                            $result4 = $db_conn->query($query4);
                            if ($result4) 
                            {
                                $row4 = $result4->fetch_row();
                                echo $row4[0];
                            }
                          ?>
                        </h3>
                      <?php }
                      else if($_SESSION['user']['Typ_Uzytkownika'] == 3){?>
                        <h5>Użytkownicy bez diet</h5>
                        <h3>
                          <?php
                            $query4 = "SELECT COUNT(`UzytkownikID`) FROM `uzytkownik` WHERE `DietaID` IS NULL AND `Typ_Uzytkownika` = 1";
                            $result4 = $db_conn->query($query4);
                            if ($result4) 
                            {
                                $row4 = $result4->fetch_row();
                                echo $row4[0];
                            }
                          ?>
                        </h3>
                      <?php }?>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer text-secondary">
                    <i class="fas fa-sync mr-3"></i>
                    <span>Zaktualizowano</span>
                  </div>
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
  $('li.nav-item a[href="dashboard.php"]').removeClass('sidebar-link').addClass('current');
</script>
</body>
</html>
