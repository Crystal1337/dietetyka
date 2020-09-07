-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Lut 2020, 16:12
-- Wersja serwera: 10.4.6-MariaDB
-- Wersja PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `dietetyka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `danie`
--

CREATE TABLE `danie` (
  `DanieID` int(11) NOT NULL,
  `Tytul` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `Bialko_gr` float NOT NULL,
  `Wegl_gr` float NOT NULL,
  `Tluszcz_gr` float NOT NULL,
  `Blonnik_gr` float DEFAULT NULL,
  `Kcal` int(11) NOT NULL,
  `Opis` longtext COLLATE utf8_polish_ci DEFAULT NULL,
  `TypID` int(11) NOT NULL,
  `DietetykID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `danie`
--

INSERT INTO `danie` (`DanieID`, `Tytul`, `Bialko_gr`, `Wegl_gr`, `Tluszcz_gr`, `Blonnik_gr`, `Kcal`, `Opis`, `TypID`, `DietetykID`) VALUES
(16, 'Dorsz smażony w cieście', 107.52, 65.14, 8.38, 1.84, 773, 'Filety dorsza rozmrozić jeśli były mrożone. Dokładnie osuszyć papierowymi ręcznikami. Pokroić na porcje, doprawić solą, pieprzem i ziołami.\r\nDo miski wsypać mąkę, dodać jajko, sól i pieprz. Ciągle energicznie mieszając rózgą wlewać mleko, aż ciasto będzie gładkie (ma być raczej gęste).\r\nRozgrzać tłuszcz na patelni, obtaczać rybę w cieście i kłaść na patelnię. Smażyć partiami, na umiarkowanym ogniu, przez ok. 5 minut z każdej strony, na złoty kolor.', 5, 2),
(17, 'Kurczak w kremowym sosie koperkowym', 37.125, 16.73, 31.33, 3.855, 513, 'Kurczaka oczyścić z błonek i kostek, pokroić na mniejsze filety (odkroić polędwiczkę - ruchomą część filetu), następnie rozbić tłuczkiem w najgrubszej części na ok. 1 cm filety.\r\nDoprawić solą, pieprzem i delikatnie obtoczyć w mące. Rozgrzać patelnię z oliwą, a gdy będzie gorąca włożyć kurczaka, podsmażać po ok. 2 minuty z każdej strony. Odłożyć na talerz.\r\nNa tę samą patelnię włożyć obraną i startą na tarce marchewkę oraz dokładnie umytego i pokrojonego w kosteczkę lub paseczki pora. Smażyć mieszając przez ok. 2 minuty, dodać masło i jeszcze chwilę podsmażać.\r\nDodać bulion i zagotować. Dodać liść laurowy, ziele angielskie i kurkumę, wymieszać. Przykryć i gotować przez ok. 3 minuty. Włożyć podsmażone filety z kurczaka i gotować bez przykrycia przez ok. 2 minuty, w międzyczasie raz przewrócić mięso.\r\nWlać śmietankę i dodać koperek, wymieszać i zagotować. Pogotować chwilę jeśli sos nie jest jeszcze gęsty.', 2, 2),
(18, 'Placki twarogowe z jabłkiem', 41.565, 45.925, 18.235, 2.49, 524, 'Do miski włożyć twaróg, dodać żółtka (białka zachować) oraz cukier wanilinowy, następnie rozgnieść praską. \r\nJabłko obrać i zetrzeć na tarce o większych oczkach, dodać do twarogu i wymieszać. Następnie dodać mąkę i ponownie dokładnie wymieszać.\r\nBiałka ubić na sztywną pianę z dodatkiem cukru pudru. Dodać do masy twarogowej i połączyć składniki delikatnie mieszając łyżką.\r\nNakładać porcje ciasta (po ok. 2 łyżki) na rozgrzaną patelnię (np. teflonową, naleśnikową) i rozprowadzić je po powierzchni formując kształtnego placka. Można smażyć na suchej patelni lub z dodatkiem oleju.\r\nZmniejszyć ogień i smażyć przez ok. 2 - 3 minuty lub aż od spodu będą delikatnie zrumienione na złoto. Przewrócić na drugą stronę i powtórzyć smażenie przez ok. 2 minuty. Posypać cukrem pudrem i cynamonem, opcjonalnie skropić syropem klonowym.', 1, 2),
(19, 'Koktajl bananowy', 14.32, 75.17, 14.22, 4.85, 505, 'Składniki (banana, płatki owsiane błyskawiczne, masło orzechowe, cukier i mleko) zmiksować na gładki koktajl w blenderze. Podawać najlepiej od razu po przygotowaniu.', 1, 2),
(20, 'Roladki z tortilli ze szpinakiem', 32.65, 32.52, 37.42, 3.45, 611, 'Przygotować zielone pesto bazyliowe\r\nTortillę posmarować łyżką pesto, następnie ułożyć plasterki szynki, sera żółtego oraz rozłożyć liście szpinaku.\r\nDoprawić solą i świeżo zmielonym pieprzem, zwinąć tortille w rulonik.\r\nPokroić na porcje, ułożyć na półmisku łączeniem do dołu. Udekorować pozostałym pesto.', 6, 2),
(21, 'Pieczone krewetki z masłem i czosnkiem', 34.175, 0.175, 22.625, 0, 341, 'Krewetki rozmrozić jeśli były mrożone. Opłukać i dokładnie osuszyć. Doprawić solą oraz pieprzem i ułożyć w większym naczyniu żaroodpornym.\r\nPiekarnik nagrzać do 180 stopni C.\r\nDo rondelka włożyć masło, dodać starty lub przeciśnięty przez praskę czosnek i zagotować, następnie gotować jeszcze przez około minutę. Odstawić z ognia, dodać sok z cytryny oraz posiekaną natkę pietruszki. Wymieszać i polać po krewetkach.\r\nDokładnie wymieszać zawartość naczynia i posypać płatkami chili. Tak przygotowane danie można od razu zapiekać lub odstawić do zamarynowania.\r\nWstawić do piekarnika i piec bez przykrycia przez ok. 10 minut (surowe większe krewetki) lub 8 minut (podgotowane, mniejsze). Podawać z pieczywem (np. bagietka, ciabatta).', 5, 2),
(22, 'Placki serowe z truskawkami', 41.725, 81.865, 14.075, 1.84, 628, 'Do miski włożyć twaróg i rozgnieść go praską do ziemniaków. Dodać jajka, cukier i wymieszać rózgą, następnie wlać olej oraz mleko i ponownie wymieszać.\r\nW drugiej misce wymieszać mąkę z proszkiem do pieczenia. Krótko połączyć składniki z dwóch misek za pomocą łyżki na dość gęstą masę.\r\nRozgrzać patelnię (np. naleśnikową lub inną z nieprzywierającą powłoką), nakładać po 2 łyżki ciasta na jednego placka, wyrównać powierzchnię i smażyć na średnim ogniu do czasu aż urosną i będą ładnie zrumienione przez około 2,5 minuty.\r\nGdy placki trochę podrosną wcisnąć w ciasto po ok. 4 plasterki truskawek. Przewrócić na drugą stronę i smażyć do zrumienienia w podobnym czasie jak poprzednio. Posypać cukrem pudrem.', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `daniedieta`
--

CREATE TABLE `daniedieta` (
  `DanieID` int(11) NOT NULL,
  `DietaID` int(11) NOT NULL,
  `DniID` int(11) NOT NULL,
  `PoraID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `daniedieta`
--

INSERT INTO `daniedieta` (`DanieID`, `DietaID`, `DniID`, `PoraID`) VALUES
(19, 22, 1, 1),
(18, 22, 1, 2),
(16, 22, 1, 3),
(22, 22, 1, 5),
(16, 22, 2, 1),
(17, 22, 2, 2),
(18, 22, 2, 4),
(17, 22, 2, 3),
(20, 22, 2, 5),
(19, 22, 1, 4),
(16, 22, 3, 1),
(17, 22, 3, 2),
(18, 22, 3, 3),
(18, 22, 3, 4),
(20, 22, 3, 5),
(16, 22, 4, 1),
(17, 22, 4, 2),
(18, 22, 4, 3),
(21, 22, 4, 4),
(19, 22, 4, 5),
(16, 22, 5, 1),
(17, 22, 5, 2),
(18, 22, 5, 4),
(19, 22, 5, 3),
(21, 22, 5, 5),
(16, 22, 6, 1),
(17, 22, 6, 2),
(18, 22, 6, 3),
(21, 22, 6, 4),
(22, 22, 6, 5),
(16, 22, 7, 1),
(17, 22, 7, 2),
(18, 22, 7, 4),
(20, 22, 7, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dieta`
--

CREATE TABLE `dieta` (
  `DietaID` int(11) NOT NULL,
  `Tytul` varchar(60) COLLATE utf8_polish_ci DEFAULT NULL,
  `Kalorycznosc` int(11) DEFAULT NULL,
  `Opis` longtext COLLATE utf8_polish_ci NOT NULL,
  `TypDietyID` int(11) NOT NULL,
  `DietetykID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dieta`
--

INSERT INTO `dieta` (`DietaID`, `Tytul`, `Kalorycznosc`, `Opis`, `TypDietyID`, `DietetykID`) VALUES
(22, 'Dieta na masę 80kg-', 2760, 'Dieta na przyśpieszy przyrost masy mięśniowej dla ludzi o wadze ciała poniżej 80 kilogramów składająca się głównie z wysokobiałkowych produktów.', 1, 2),
(23, 'Dieta redukcyjna sportowa', 2200, 'Dieta na redukcję masy ciała ukierunkowana do sportowego trybu życia.', 3, 2),
(26, 'Dieta redukcyjna osobista - Anna Borucka', 1600, 'Dieta na redukcję masy ciała wyspecjalizowana osobiście pod klientkę - Annę Borucką ze względu na nietypowość organizmu', 4, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dni_tygodnia`
--

CREATE TABLE `dni_tygodnia` (
  `DniID` int(11) NOT NULL,
  `Dzien` varchar(20) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dni_tygodnia`
--

INSERT INTO `dni_tygodnia` (`DniID`, `Dzien`) VALUES
(1, 'Poniedziałek'),
(2, 'Wtorek'),
(3, 'Środa'),
(4, 'Czwartek'),
(5, 'Piątek'),
(6, 'Sobota'),
(7, 'Niedziela');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pora_dnia`
--

CREATE TABLE `pora_dnia` (
  `PoraID` int(11) NOT NULL,
  `Pora_Dnia` varchar(60) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pora_dnia`
--

INSERT INTO `pora_dnia` (`PoraID`, `Pora_Dnia`) VALUES
(1, 'Śniadanie'),
(2, 'Drugie śniadanie'),
(3, 'Obiad'),
(4, 'Podwieczorek'),
(5, 'Kolacja');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt`
--

CREATE TABLE `produkt` (
  `ProduktID` int(11) NOT NULL,
  `Nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `Bialko_gr` float NOT NULL,
  `Wegl_gr` float NOT NULL,
  `Tluszcz_gr` float NOT NULL,
  `Blonnik_gr` float DEFAULT NULL,
  `Kcal` float NOT NULL,
  `DietetykID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `produkt`
--

INSERT INTO `produkt` (`ProduktID`, `Nazwa`, `Bialko_gr`, `Wegl_gr`, `Tluszcz_gr`, `Blonnik_gr`, `Kcal`, `DietetykID`) VALUES
(30, 'Kurczak', 21.5, 0, 1.3, 0, 97.7, 2),
(31, 'Ziemniak', 1.9, 16.8, 0.1, 1.5, 81.7, 2),
(32, 'Makaron spaghetti', 15.2, 68, 1.3, 6.2, 369.3, 2),
(33, 'Dorsz', 17.7, 0.7, 0, 0, 73.6, 2),
(34, 'Mąka', 11.1, 71.7, 1.2, 2.3, 351.2, 2),
(35, 'Jajko kurze', 12.5, 0.6, 9.7, 0, 139.7, 2),
(36, 'Mleko 2%', 3.3, 4.9, 2, 0, 50.8, 2),
(37, 'Masło', 0.7, 0.7, 82.5, 0, 748.1, 2),
(38, 'Marchew', 1, 5.1, 0.2, 3.6, 40.6, 2),
(39, 'Por', 2.2, 3, 0.3, 2.7, 34.3, 2),
(40, 'Bulion drobiowy w płynie', 0.5, 0.5, 1, 0, 13, 2),
(41, 'Śmietana 30%', 2.2, 3.1, 30, 0, 291.2, 2),
(42, 'Twaróg półtłusty', 18.3, 3.7, 4.7, 0, 130.3, 2),
(43, 'Jabłko', 0.4, 10.1, 0.4, 2, 53.6, 2),
(44, 'Cukier puder', 0, 99.8, 0, 0, 399.2, 2),
(45, 'Płatki owsiane', 11.9, 69.3, 7.2, 6.9, 417.2, 2),
(46, 'Banan', 1, 21.8, 0.3, 1.7, 100.7, 2),
(47, 'Masło orzechowe', 13, 10, 67, 7.4, 724.6, 2),
(48, 'Cukier', 0, 99.8, 0, 0, 399.2, 2),
(49, 'Tortilla pszenna', 8.5, 47.2, 6.7, 4, 299.1, 2),
(50, 'Pesto', 3.7, 6.3, 34.6, 0, 351.4, 2),
(51, 'Szynka gotowana', 20, 1.1, 2.1, 0, 103.3, 2),
(52, 'Ser zółty', 28.8, 0.1, 29.7, 0, 382.9, 2),
(53, 'Szpinak', 2.6, 0.9, 0.4, 2.1, 26, 2),
(54, 'Krewetki', 17, 0, 1, 0, 77, 2),
(55, 'Proszek do pieczenia', 1.4, 11, 0.2, 0, 51.4, 2),
(56, 'Truskawki', 0.7, 11, 0.4, 0, 50.4, 2),
(57, 'Jajko przepiórcze', 13, 0.4, 11, 0, 152.6, 10),
(58, 'Ser Mozarella', 24, 3, 16, 0, 252, 10),
(59, 'Chleb tostowy biały', 8.9, 56.7, 4.7, 2.1, 313.1, 10),
(60, 'Chleb tostowy pełnoziarnisty', 7.2, 54, 3.1, 3.5, 286.7, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produktdanie`
--

CREATE TABLE `produktdanie` (
  `ProduktID` int(11) NOT NULL,
  `DanieID` int(11) NOT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `produktdanie`
--

INSERT INTO `produktdanie` (`ProduktID`, `DanieID`, `ilosc`) VALUES
(30, 17, 150),
(33, 16, 500),
(34, 16, 80),
(34, 17, 15),
(34, 18, 30),
(34, 22, 80),
(35, 16, 60),
(35, 18, 120),
(35, 22, 60),
(36, 16, 80),
(36, 19, 250),
(36, 22, 60),
(37, 17, 20),
(37, 21, 25),
(38, 17, 45),
(39, 17, 70),
(40, 17, 40),
(41, 17, 40),
(42, 18, 125),
(42, 22, 125),
(43, 18, 90),
(44, 18, 10),
(45, 19, 30),
(46, 19, 120),
(47, 19, 10),
(48, 19, 15),
(48, 22, 10),
(49, 20, 60),
(50, 20, 50),
(51, 20, 50),
(52, 20, 50),
(53, 20, 50),
(54, 21, 200),
(55, 22, 10),
(56, 22, 50);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `raporty`
--

CREATE TABLE `raporty` (
  `RaportyID` int(11) NOT NULL,
  `DataRaportu` date NOT NULL,
  `MasaCiala` float NOT NULL,
  `Waga_Docelowa` float DEFAULT NULL,
  `Waga_Tluszczu` float NOT NULL,
  `Waga_Wody` float NOT NULL,
  `Waga_Miesni` float NOT NULL,
  `Waga_Kosci` float NOT NULL,
  `KlientID` int(11) NOT NULL,
  `przeczytano` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `raporty`
--

INSERT INTO `raporty` (`RaportyID`, `DataRaportu`, `MasaCiala`, `Waga_Docelowa`, `Waga_Tluszczu`, `Waga_Wody`, `Waga_Miesni`, `Waga_Kosci`, `KlientID`, `przeczytano`) VALUES
(16, '2020-01-16', 70, 80, 16, 10, 35, 5, 1, 1),
(17, '2020-02-16', 75, 80, 16, 10, 40, 5, 1, 1),
(18, '2020-01-22', 90, 80, 30, 10, 30, 5, 10, 0),
(19, '2020-01-06', 70, 60, 20, 10, 30, 4, 11, 0),
(20, '2020-01-01', 60, 55, 15, 10, 30, 4, 12, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typ_dania`
--

CREATE TABLE `typ_dania` (
  `TypID` int(11) NOT NULL,
  `TypDania` varchar(40) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `typ_dania`
--

INSERT INTO `typ_dania` (`TypID`, `TypDania`) VALUES
(1, 'Wegetariańskie'),
(2, 'Mięsne'),
(3, 'Niskotłuszczowe'),
(4, 'Niskobiałkowe'),
(5, 'Wysokobiałkowe'),
(6, 'Wysokotłuszczowe');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typ_diety`
--

CREATE TABLE `typ_diety` (
  `TypDietyID` int(11) NOT NULL,
  `Typ_Diety` varchar(60) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `typ_diety`
--

INSERT INTO `typ_diety` (`TypDietyID`, `Typ_Diety`) VALUES
(1, 'Białkowa'),
(3, 'Węglowodanowa'),
(4, 'Ketogeniczna');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `UzytkownikID` int(11) NOT NULL,
  `email` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `Haslo` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `Imie` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `Ulica` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `Miasto` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `Kod_Pocztowy` varchar(6) COLLATE utf8_polish_ci NOT NULL,
  `Typ_Uzytkownika` tinyint(4) NOT NULL,
  `DietetykID` int(11) DEFAULT NULL,
  `DietaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownik`
--

INSERT INTO `uzytkownik` (`UzytkownikID`, `email`, `Haslo`, `Imie`, `Nazwisko`, `Ulica`, `Miasto`, `Kod_Pocztowy`, `Typ_Uzytkownika`, `DietetykID`, `DietaID`) VALUES
(1, 'michal.nwk@gmail.com', '$2y$10$uvO3CkXoHSZPs8js3kb2L.bU5lEVyHlUkVljMFSw2gMSIfcCSDC.u', 'Michał', 'Nowak', 'Marii Konopnickiej 17', 'Kalisz', '62-800', 1, 2, 22),
(2, 'krzysztof@wp.pl', '$2y$10$TBDn/lvEzT2QnwxomYBSCe9ssgAGabjug1CR.Xm8MwQP4KDDgZEh6', 'Krzysztof', 'Kowalski', 'Marii', 'Kalisz', '62-800', 2, NULL, NULL),
(8, 'admin@admin', '$2y$10$DCQ8pyDmyLhlKxzv2oKur.yiKhUFS7ln9lXi7infzCkQzUeo58kgS', 'admin', 'admin', 'admin', 'admin', 'admin', 3, NULL, NULL),
(10, 'andrzej@wp.pl', '934527', 'Andrzej', 'Kowalski', 'Warszawska 20', 'Warszawa', '03-258', 1, 2, NULL),
(11, 'ania@onet.eu', '21904732', 'Anna', 'Borucka', 'Niepodległości 14', 'Warszawa', '00-001', 1, 2, 26),
(12, 'edyta@onet.pl', '23490432798', 'Edyta', 'Stangret', 'Legionów 8', 'Kalisz', '62-800', 1, 2, NULL),
(13, 'grzegorz@wp.pl', '489032695782890760897', 'Grzegorz', 'Marcinkiewicz', 'Górnośląska 68', 'Poznań', '60-001', 1, NULL, NULL),
(14, 'mateo123@gmail.com', '0423028937654', 'Mateusz', 'Markowiak', 'Żołnierzy wyklętych 10A', 'Poznań', '60-123', 1, NULL, NULL),
(15, 'marcin@wp.pl', '20439872398', 'Marcin', 'Kowalski', 'Armii krajowej 17', 'Wrocław', '50-001', 2, NULL, NULL),
(16, 'piotr@wp.pl', '$2y$10$z6DXe0XmKPEmCgArweQiu.g5gYBwgSveDjQyidSPyEU54c5WLOEp.', 'Piotr', 'Maciejewski', 'Struga 24B', 'Łódź', '90-004', 1, NULL, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `danie`
--
ALTER TABLE `danie`
  ADD PRIMARY KEY (`DanieID`),
  ADD KEY `TypID` (`TypID`),
  ADD KEY `DietetykID` (`DietetykID`);

--
-- Indeksy dla tabeli `daniedieta`
--
ALTER TABLE `daniedieta`
  ADD KEY `DanieID` (`DanieID`),
  ADD KEY `DietaID` (`DietaID`),
  ADD KEY `DniID` (`DniID`),
  ADD KEY `PoraID` (`PoraID`);

--
-- Indeksy dla tabeli `dieta`
--
ALTER TABLE `dieta`
  ADD PRIMARY KEY (`DietaID`),
  ADD KEY `TypDietyID` (`TypDietyID`),
  ADD KEY `DietetykID` (`DietetykID`);

--
-- Indeksy dla tabeli `dni_tygodnia`
--
ALTER TABLE `dni_tygodnia`
  ADD PRIMARY KEY (`DniID`);

--
-- Indeksy dla tabeli `pora_dnia`
--
ALTER TABLE `pora_dnia`
  ADD PRIMARY KEY (`PoraID`);

--
-- Indeksy dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`ProduktID`),
  ADD KEY `produkt` (`DietetykID`);

--
-- Indeksy dla tabeli `produktdanie`
--
ALTER TABLE `produktdanie`
  ADD PRIMARY KEY (`ProduktID`,`DanieID`),
  ADD KEY `DanieID` (`DanieID`);

--
-- Indeksy dla tabeli `raporty`
--
ALTER TABLE `raporty`
  ADD PRIMARY KEY (`RaportyID`),
  ADD KEY `KlientID` (`KlientID`);

--
-- Indeksy dla tabeli `typ_dania`
--
ALTER TABLE `typ_dania`
  ADD PRIMARY KEY (`TypID`);

--
-- Indeksy dla tabeli `typ_diety`
--
ALTER TABLE `typ_diety`
  ADD PRIMARY KEY (`TypDietyID`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`UzytkownikID`),
  ADD KEY `DietetykID` (`DietetykID`),
  ADD KEY `DietaID` (`DietaID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `danie`
--
ALTER TABLE `danie`
  MODIFY `DanieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `dieta`
--
ALTER TABLE `dieta`
  MODIFY `DietaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `dni_tygodnia`
--
ALTER TABLE `dni_tygodnia`
  MODIFY `DniID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `pora_dnia`
--
ALTER TABLE `pora_dnia`
  MODIFY `PoraID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `produkt`
--
ALTER TABLE `produkt`
  MODIFY `ProduktID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT dla tabeli `raporty`
--
ALTER TABLE `raporty`
  MODIFY `RaportyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `typ_dania`
--
ALTER TABLE `typ_dania`
  MODIFY `TypID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `typ_diety`
--
ALTER TABLE `typ_diety`
  MODIFY `TypDietyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `UzytkownikID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `danie`
--
ALTER TABLE `danie`
  ADD CONSTRAINT `danie_ibfk_1` FOREIGN KEY (`TypID`) REFERENCES `typ_dania` (`TypID`),
  ADD CONSTRAINT `danie_ibfk_2` FOREIGN KEY (`DietetykID`) REFERENCES `uzytkownik` (`UzytkownikID`);

--
-- Ograniczenia dla tabeli `daniedieta`
--
ALTER TABLE `daniedieta`
  ADD CONSTRAINT `daniedieta_ibfk_1` FOREIGN KEY (`DanieID`) REFERENCES `danie` (`DanieID`),
  ADD CONSTRAINT `daniedieta_ibfk_2` FOREIGN KEY (`DietaID`) REFERENCES `dieta` (`DietaID`),
  ADD CONSTRAINT `daniedieta_ibfk_3` FOREIGN KEY (`DniID`) REFERENCES `dni_tygodnia` (`DniID`),
  ADD CONSTRAINT `daniedieta_ibfk_4` FOREIGN KEY (`PoraID`) REFERENCES `pora_dnia` (`PoraID`);

--
-- Ograniczenia dla tabeli `dieta`
--
ALTER TABLE `dieta`
  ADD CONSTRAINT `dieta_ibfk_1` FOREIGN KEY (`TypDietyID`) REFERENCES `typ_diety` (`TypDietyID`),
  ADD CONSTRAINT `dieta_ibfk_2` FOREIGN KEY (`DietetykID`) REFERENCES `uzytkownik` (`UzytkownikID`);

--
-- Ograniczenia dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt` FOREIGN KEY (`DietetykID`) REFERENCES `uzytkownik` (`UzytkownikID`);

--
-- Ograniczenia dla tabeli `produktdanie`
--
ALTER TABLE `produktdanie`
  ADD CONSTRAINT `produktdanie_ibfk_1` FOREIGN KEY (`ProduktID`) REFERENCES `produkt` (`ProduktID`),
  ADD CONSTRAINT `produktdanie_ibfk_2` FOREIGN KEY (`DanieID`) REFERENCES `danie` (`DanieID`);

--
-- Ograniczenia dla tabeli `raporty`
--
ALTER TABLE `raporty`
  ADD CONSTRAINT `raporty_ibfk_1` FOREIGN KEY (`KlientID`) REFERENCES `uzytkownik` (`UzytkownikID`);

--
-- Ograniczenia dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD CONSTRAINT `uzytkownik_ibfk_1` FOREIGN KEY (`DietetykID`) REFERENCES `uzytkownik` (`UzytkownikID`),
  ADD CONSTRAINT `uzytkownik_ibfk_2` FOREIGN KEY (`DietaID`) REFERENCES `dieta` (`DietaID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
