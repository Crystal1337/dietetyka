<?php require_once 'head.php'; ?>
<body id="index">
<?php 

  if(isset($_SESSION['user']))
  {
    require_once 'navs/logged_index.php';
  }
  else
  {
    require_once 'navs/guest.php';
  } 
?>

<main role="main" class="container-fluid">
  <div class="container" data-spy="scroll" data-target="#navbar" data-offset="0" id="main">
  <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="img/carousel1.jpg" class="d-block" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/carousel2.jpg" class="d-block" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/carousel3.jpg" class="d-block" alt="...">
    </div>
  </div>
</div>
<hr>
  <div class="row" data-spy="scroll" data-target="#navbar" data-offset="0" id="">
    <div class="col-3 offset-0-5">
      <div class="text-center mb-2">
        <span class="border rounded-circle"><i class="fas fa-seedling"></i></span>
      </div>
      <p class="text-justify">Aby odpowiedzieć sobie na pytanie, jak żywić się zdrowo, warto przede wszystkim zastanowić się nad tym, czym jest zdrowe żywienie. Najogólniej rzecz ujmując, jest to taki sposób odżywiania, który zapewnia zdrowe funkcjonowanie całemu ludzkiemu organizmowi, biorąc pod uwagę wszystkie jego funkcje i składniki odżywcze, których potrzebuje on do prawidłowego funkcjonowania.</p>
    </div>
    <div class="col-3 offset-1">
      <div class="text-center mb-2">
        <span class="border rounded-circle"><i class="fas fa-running"></i></span>
      </div>
      <p class="text-justify">Aktywność fizyczna jest nieodłącznym atrybutem życia człowieka. Wynika ona z wrodzonych potrzeb organizmu i nabytych umiejętności. Odpowiednio dobrana aktywność ruchowa sprzyja rozwojowi organizmu, pomnażaniu i zachowaniu zdrowia. Ruch rozwija mięśnie, wpływa na prawidłowy wzrost i kształt kości, rozwija układ krążeniowo-oddechowy, podnosi sprawność i wydolność fizyczną. </p>
    </div>
    <div class="col-3 offset-1">
      <div class="text-center mb-2">
        <span class="border rounded-circle"><i class="fas fa-drumstick-bite"></i></span>
      </div>
      <p class="text-justify">Na świecie znaleźć można ogromną liczbę osób odżywiających się czym popadnie, ale też tych, którzy stosują konkretną dietę, na przykład wegetariańską czy wegańską. Choć przez wiele lat dietetycy mieli wątpliwości, czy dieta wegańska jest odpowiednia dla człowieka, dziś już wiadomo, że nawet weganie mogą zrównoważyć swój sposób odżywiania w taki sposób, by dostarczyć swojemu organizmowi wszystkie konieczne składniki odżywcze.</p>
    </div>
  </div>
  <hr>
  <div class="row" data-spy="scroll" data-target="#navbar" data-offset="0" id="about">
    <div class="col-4">
      <img src="img/dietician.jpg" width="250">
    </div>
    <div class="col-8 mt-3">
      <h3 class="text-justify">Za najważniejszy element w pracy ze swoimi podopiecznymi uznajemy indywidualne podejście do potrzeb i problemów każdego klienta. Plany żywieniowe i suplementacyjne tworzymy zgodnie z trybem życia aby nie zaburzać harmonogramu dnia codziennego. Dieta nie może być nudna, a jej stosowanie trudne w realizacji. Wręcz przeciwnie - wspólnie z klientem staramy się znaleźć takie rozwiązanie, które pozwoli zapomnieć, że w ogóle jest się na diecie.</h3>
    </div>
</div>
<hr>
<h1 class="text-center">Nasza kadra</h1>
<div class="row mt-3" data-spy="scroll" data-target="#navbar" data-offset="0" id="team">
  <div class="col-4 text-center border">
    <img src="img/default.jpg" width="150" class="border rounded-circle mb-2 mt-3">
    <h3>Anna Zawrocka</h2>
    <p class="text-justify">Za najważniejszy element w pracy ze swoimi podopiecznymi uznajemy indywidualne podejście do potrzeb i problemów każdego klienta. Plany żywieniowe i suplementacyjne tworzymy zgodnie z trybem życia aby nie zaburzać harmonogramu dnia codziennego. Dieta nie może być nudna, a jej stosowanie trudne w realizacji. Wręcz przeciwnie - wspólnie z klientem staramy się znaleźć takie rozwiązanie, które pozwoli zapomnieć, że w ogóle jest się na diecie.</p>
  </div>
  <div class="col-4 text-center border">
    <img src="img/default.jpg" width="150" class="border rounded-circle mb-2 mt-3">
    <h3>Krzysztof Kowalski</h2>
    <p class="text-justify">Za najważniejszy element w pracy ze swoimi podopiecznymi uznajemy indywidualne podejście do potrzeb i problemów każdego klienta. Plany żywieniowe i suplementacyjne tworzymy zgodnie z trybem życia aby nie zaburzać harmonogramu dnia codziennego. Dieta nie może być nudna, a jej stosowanie trudne w realizacji. Wręcz przeciwnie - wspólnie z klientem staramy się znaleźć takie rozwiązanie, które pozwoli zapomnieć, że w ogóle jest się na diecie.</p>
  </div>
  <div class="col-4 text-center border">
    <img src="img/default.jpg" width="150" class="border rounded-circle mb-2 mt-3">
    <h3>Andrzej Nowak</h2>
    <p class="text-justify">Za najważniejszy element w pracy ze swoimi podopiecznymi uznajemy indywidualne podejście do potrzeb i problemów każdego klienta. Plany żywieniowe i suplementacyjne tworzymy zgodnie z trybem życia aby nie zaburzać harmonogramu dnia codziennego. Dieta nie może być nudna, a jej stosowanie trudne w realizacji. Wręcz przeciwnie - wspólnie z klientem staramy się znaleźć takie rozwiązanie, które pozwoli zapomnieć, że w ogóle jest się na diecie.</p>
  </div>
</div>
<hr>
</div>
</main>
</body>
</html>
