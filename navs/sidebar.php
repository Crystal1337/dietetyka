<?php
if($_SESSION['user']['Typ_Uzytkownika'] == 2)
{
echo '<div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">';
echo '<a href="#" class="navbar-brand text-white d-block mx-auto text-center py-3 mb-3 bottom-border">Panel dietetyka</a>';
echo '<div class="bottom-border pb-3">';
echo '<img src="img/default.jpg" width="50" class="rounded-circle mr-2">';
echo '<a href="#" class="text-white pl-3">'.$_SESSION['user']['Imie'].' '.$_SESSION['user']['Nazwisko'].'</a>';
echo '</div>';
echo	'<ul class="navbar-nav flex-column mt-4">';
echo		'<li class="nav-item"><a href="dashboard.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-home text-light fa-lg mr-3"></i>Główny panel</a></li>';
echo 		'<li class="nav-item"><a href="klienci.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-users text-light fa-lg mr-3"></i>Klienci</a></li>';					
echo 		'<li class="nav-item collapsible"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-plus text-light fa-lg mr-3"></i>Przeglądaj<i class="fas fa-angle-down ml-2"></i></a></li>';
echo 		'<ul class="content">';
echo 			'<li class="nav-item"><a href="diety.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-utensils text-light fa-lg mr-3"></i>Diety</a></li>';
echo 			'<li class="nav-item"><a href="dania.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-hamburger text-light fa-lg mr-3"></i>Posiłki</a></li>';
echo 			'<li class="nav-item"><a href="produkty.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-apple-alt text-light fa-lg mr-3"></i>Składniki</a></li>';
echo 		'</ul>';
echo 		'<li class="nav-item"><a href="raporty.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-file-invoice text-light fa-lg mr-3"></i>Raporty</a></li>';
echo 	'</ul>';
echo '</div>';
}
else if($_SESSION['user']['Typ_Uzytkownika'] == 1)
{
echo '<div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">';
echo '<a href="#" class="navbar-brand text-white d-block mx-auto text-center py-3 mb-3 bottom-border">Panel klienta</a>';
echo '<div class="bottom-border pb-3">';
echo '<img src="img/default.jpg" width="50" class="rounded-circle mr-2">';
echo '<a href="#" class="text-white pl-3">'.$_SESSION['user']['Imie'].' '.$_SESSION['user']['Nazwisko'].'</a>';
echo '</div>';
echo	'<ul class="navbar-nav flex-column mt-4">';
echo		'<li class="nav-item"><a href="profil.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-home text-light fa-lg mr-3"></i>Mój profil</a></li>';
echo 		'<li class="nav-item"><a href="mojadieta.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-users text-light fa-lg mr-3"></i>Moja dieta</a></li>';				
echo 		'<li class="nav-item"><a href="mojeraporty.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-file-invoice text-light fa-lg mr-3"></i>Raporty</a></li>';
echo 	'</ul>';
echo '</div>';
}
else if($_SESSION['user']['Typ_Uzytkownika'] == 3)
{
echo '<div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">';
echo '<a href="#" class="navbar-brand text-white d-block mx-auto text-center py-3 mb-3 bottom-border">Panel administratora</a>';
echo '<div class="bottom-border pb-3">';
echo '<img src="img/default.jpg" width="50" class="rounded-circle mr-2">';
echo '<a href="#" class="text-white pl-3">'.$_SESSION['user']['Imie'].' '.$_SESSION['user']['Nazwisko'].'</a>';
echo '</div>';
echo	'<ul class="navbar-nav flex-column mt-4">';
echo		'<li class="nav-item"><a href="dashboard.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-home text-light fa-lg mr-3"></i>Główny panel</a></li>';
echo 		'<li class="nav-item"><a href="klienci.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-users text-light fa-lg mr-3"></i>Klienci</a></li>';		
echo 		'<li class="nav-item"><a href="dietetycy.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-users text-light fa-lg mr-3"></i>Dietetycy</a></li>';					
echo 		'<li class="nav-item collapsible"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-plus text-light fa-lg mr-3"></i>Przeglądaj<i class="fas fa-angle-down ml-2"></i></a></li>';
echo 		'<ul class="content">';
echo 			'<li class="nav-item"><a href="diety.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-utensils text-light fa-lg mr-3"></i>Diety</a></li>';
echo 			'<li class="nav-item"><a href="dania.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-hamburger text-light fa-lg mr-3"></i>Posiłki</a></li>';
echo 			'<li class="nav-item"><a href="produkty.php" class="nav-link text-white p-3 mb-2 sidebar-link"><i class="fas fa-apple-alt text-light fa-lg mr-3"></i>Składniki</a></li>';
echo 		'</ul>';
echo 	'</ul>';
echo '</div>';
}
?>

