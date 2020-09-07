# dietetyka
Wymagania:

1. XAMPP - https://www.apachefriends.org/pl/index.html

Jak skonfigurować projekt:

1. Po zainstalowaniu oprogramowania XAMPP folder projektu tj. "dietetyka-master" (można zmienić) należy przenieść do folderu xampp/htdocs,
2. Należy włączyć pakiet XAMPP oraz uruchomić serwisy Apache i MySQL,
3. W przeglądarce wpisać adres "localhost",
4. W prawym górnym rogu wybrać w "phpMyAdmin",
5. W panelu po lewej stronie kliknąć "Nowa" w celu stworzenia bazy danych. Wprowadzić "dietetyka" jako nazwę oraz wybrać "utf8_polish_ci" w oknie obok,
6. Na górnym pasku wybrać opcję "Import" następnie wybrać plik "dietetyka.sql" z folderu "baza danych" w projekcie i nacisnąć przycisk "Wykonaj".

Korzystanie z aplikacji:

1. Jeśli wszystko zostało skonfigurowane poprawnie aplikacja jest dostępna w przeglądarce pod adresem "localhost/dietetyka-master" (localhost/nazwa_folderu_projektu jeśli była zmieniona),
2. Strona główna służy celom informacyjnym dla gości oraz pozwala na rejestrację nowego konta, czy logowanie na instniejące już konto,
3. Kontami testowymi aplikacji dla zwykłego użytkownika jest email: "michal.nwk@gmail.com" i hasło "123", a dla dietetyka email: "krzysztof@wp.pl" i hasło "123",
4. Po zalogowaniu na panel dietetyka w panelu po lewej stronie widnieją następujące przyciski
  a) Główny panel - wyświetla podstawowe informacje dla dietetyka,
  b) Klienci - wyświetla listę klientów, którzy wybrali tego dietetyka do prowadzenia ich diety. Możemy przejść dalej do profilu każdego z nich w celu przypisania wcześniej stworzonej diety, lub w przypadku kiedy dieta jest już przypisana możemy ją wyświetlić, lub zmienić na inną,
  c) Przeglądaj - przycisk rozwijany na kolejne elementy:
    1. Składniki - lista wszystkich składników w aplikacji. Dietetyk może tylko edytować i usuwać elementy dodane z jego konta. Na stronie widnieje również przycisk służący dodaniu nowego sładnika,
    2. Posiłki - karty posiłków dodanych przez konto na które jesteśmy zalogowani. Możliwość edycji oraz usuwania każdego z dań oraz przycisk służący dodaniu nowego dania,
    3. Diety - karty diet dodanych przez konto, na które jesteśmy zalogowani. Możliwość edycji oraz usuwania każdej z diet oraz przycisk służący dodaniu nowej diety. Dodatkowo na każdej z kart widnieje przycisk "Szczegóły", który przenosi nas do szczegółowego widoku diety, w której widnieją dni tygodnia oraz dania do nich przypisane. Na stronie widnieje przycisk dodania dania do diety,
  d) Raporty - Wyświetla raporty odnośnie wag przesłane przez klientów. Podzielone są one na nowe oraz zaakceptowane.
5. Po zalogowaniu na panel zwykłego użytkownika w panelu po lewej stronie widnieją następujące przyciski:
  a) Mój profil - wyświetla dane klienta razem z jego postępami w diecie. Na stronie widnieje przycisk do edycji profilu,
  b) Moja dieta - wyświetla szczegółowy widok diety (dania ustawione na dany dzień tygodnia) przypisanej do klienta przez jego dietetyka,
  c) Raporty - Wyświetla raporty klienta. Podzielone są na oczekujące i zaakceptowane przez dietetyka.
