<div class="modal fade" id="rejestracja" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Zarejestruj się!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
            <?php if (isset($_SESSION['registererror'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['registererror']; ?></p>
              </div>
            <?php } unset($_SESSION['registererror']); ?>
          <div class="form-group">
            <input type="email" class="form-control" id="input-email" name="email" placeholder="E-mail" required autocomplete="off" value="<?php echo isset($_SESSION['LastData']['email']) ? $_SESSION['LastData']['email'] : '' ?>">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="input-haslo" name="haslo_normal" placeholder="Hasło" required autocomplete="off">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="input-haslo" name="haslo_valid" placeholder="Potwierdź hasło" required autocomplete="off">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="input-imie" name="imie" placeholder="Imię" required value="<?php echo isset($_SESSION['LastData']['imie']) ? $_SESSION['LastData']['imie'] : '' ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="input-nazwisko" name="nazwisko" placeholder="Nazwisko" required value="<?php echo isset($_SESSION['LastData']['nazwisko']) ? $_SESSION['LastData']['nazwisko'] : '' ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="input-ulica" name="ulica" placeholder="Adres zamieszkania" required value="<?php echo isset($_SESSION['LastData']['ulica']) ? $_SESSION['LastData']['ulica'] : '' ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="input-miasto" name="miasto" placeholder="Miasto" required value="<?php echo isset($_SESSION['LastData']['miasto']) ? $_SESSION['LastData']['miasto'] : '' ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="input-kod_pocztowy" name="kod_pocztowy" placeholder="Kod pocztowy" required value="<?php echo isset($_SESSION['LastData']['kod_pocztowy']) ? $_SESSION['LastData']['kod_pocztowy'] : '' ?>">
          </div>
          <div class="g-recaptcha mb-2" data-sitekey="6Lf-MsEUAAAAAJvdR4a5UTImEtnYVVN7pBzkTmri"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="register">
            <button type="submit" class="btn btn-primary">Rejestracja</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="logowanie" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Zaloguj się!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="action.php">
            <?php if (isset($_SESSION['loginerror'])) { ?>
              <div class="form-group text-danger" id="error-message">
                <p><?php echo $_SESSION['loginerror']; ?></p>
              </div>
            <?php } unset($_SESSION['loginerror']); ?>
            <?php if (isset($_SESSION['success'])) { ?>
              <div class="form-group text-success" id="success-message">
                <p><?php echo $_SESSION['success']; ?></p>
              </div>
            <?php } unset($_SESSION['success']); ?>
          <div class="form-group">
            <input type="email" class="form-control" id="input-email" name="email" placeholder="E-mail" required value="<?php echo isset($_SESSION['LastData']['email']) ? $_SESSION['LastData']['email'] : '' ?>">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="input-haslo" name="haslo" placeholder="Hasło" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij okno</button>
            <input type="hidden" name="do" value="login">
            <button type="submit" class="btn btn-primary">Zaloguj</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

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

        <a class="nav-link" data-toggle="modal" data-target="#rejestracja" href="#"><i class="fas fa-user-plus mr-2"></i>Rejestracja</a>
      </li>
      <li class="nav-item">

        <a class="nav-link" data-toggle="modal" data-target="#logowanie" href="#"><i class="fas fa-sign-in-alt mr-2"></i>Logowanie</a>
      </li>
    </ul>
  </div>
  </div>
</nav>

<?php unset($_SESSION['LastData']); ?>
<script type="text/javascript">
  <?php if(isset($_GET['rejestracja']))
  { ?>
    $('#rejestracja').modal('show');
 <?php }
  else if(isset($_GET['logowanie']))
  { ?>
    $('#logowanie').modal('show');
 <?php } ?>
</script>