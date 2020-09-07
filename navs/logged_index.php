<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" id="indexNavbar">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="container">
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#main">Strona główna</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#about">O nas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#team">Nasza kadra</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <?php
        if($_SESSION['user']['Typ_Uzytkownika'] == 1)
        {
          echo '<a class="nav-link" href="profil.php"><i class="fas fa-user mr-2"></i>Mój Profil</a>';
        }
        else
        {
          echo '<a class="nav-link" href="dashboard.php"><i class="fas fa-user mr-2"></i>Mój Profil</a>';
        }
        ?>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="action.php?do=logout"><i class="fas fa-sign-out-alt mr-2"></i>Wyloguj</a>
      </li>
    </ul>
  </div>
  </div>
</nav>