<?php
    if (empty($_REQUEST['do'])) 
    {
        die('<html><body></body></html>');
    }

    function redirect($file = '') 
    {
        if (!empty($file)) 
        {
            header('Location: '.pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME).'/'.$file);
        } 
        else 
        {
            header('Location: '.pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME));
        }
        die();
    }

    session_start();
    require_once 'database.php';
    require_once 'lib/password.php';

    switch (strtoupper($_REQUEST['do'])) 
    {
        case 'REGISTER':
        $_SESSION['LastData'] = $_POST; 
        $response_key = $_POST['g-recaptcha-response'];
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify'.'?secret='.'6Lf-MsEUAAAAAKv6qvjlT74gkrKgcOdYwzM4_bKY'.'&response='.$response_key.'&remoteip='.$_SERVER['REMOTE_ADDR']);
        $response = json_decode($response);
        if($response->success == 1)
        {
			if (!empty($_POST['email']) && !empty($_POST['haslo_normal']) && !empty($_POST['haslo_valid']) && !empty($_POST['imie'])
			&& !empty($_POST['nazwisko']) && !empty($_POST['ulica']) && !empty($_POST['miasto']) && !empty($_POST['kod_pocztowy'])) 
			{
				if($_POST['haslo_normal'] == $_POST['haslo_valid'])
				{
					$stmt = $db_conn->prepare("SELECT * FROM `uzytkownik` WHERE `email` = ?");
		        	$stmt->bind_param("s", $_POST['email']);
		        	$stmt->execute();
		        	$result = $stmt->get_result();
                	if ($result->num_rows === 0) 
                	{
			        	$password_hash = password_hash($_POST['haslo_normal'], PASSWORD_DEFAULT);
			        	$stmt = $db_conn->prepare("INSERT INTO `uzytkownik` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, 1, NULL, NULL)");
			        	$stmt->bind_param("sssssss", $_POST['email'], $password_hash, $_POST['imie'], $_POST['nazwisko'], $_POST['ulica'],
			        	$_POST['miasto'], $_POST['kod_pocztowy']);
			        	if ($stmt->execute()) 
			        	{
			            	$_SESSION['success'] = 'Użytkownik dodany';
			            	unset($_SESSION['LastData']);
			            	$_SESSION['LastData']['email'] = $_POST['email'];
			            	redirect('?logowanie=true');
			        	} 
			        	else 
			        	{
			            	$_SESSION['registererror'] = 'Problem z dodaniem użytkownika';
			        	}
		        	}
		        	else
		        	{
		        		$_SESSION['registererror'] = 'Użytkownik z takim adresem e-mail już istnieje';
		        	}
		        }
		        else
		        {
		        	$_SESSION['registererror'] = 'Hasła się nie zgadzają';
		        }
	    	}
            else 
            {
                $_SESSION['registererror'] = 'Wprowadź wszystkie dane';
            }
        } 
        else
        {
            $_SESSION['registererror'] = 'CAPTCHA zweryfikowana negatywnie. Spróbuj ponownie.';
        }
	    	


	    	redirect('?rejestracja=true');
        break;

        case 'LOGIN':
        $_SESSION['LastData'] = $_POST;
        if(!empty($_POST['email']) && !empty($_POST['haslo']))
        {
        	$stmt = $db_conn->prepare("SELECT * FROM `uzytkownik` WHERE `email` = ?");
		    $stmt->bind_param("s", $_POST['email']);
		    $stmt->execute();
		    $result = $stmt->get_result();
            if ($result->num_rows === 1)
            {
            	$row = $result->fetch_assoc();
            	if (password_verify($_POST['haslo'], $row['Haslo'])) 
            	{
			        unset($_SESSION['LastData']);
            		$_SESSION['user'] = $row;
            		redirect();
            	}
            	else
            	{
            		$_SESSION['loginerror'] = 'Podane hasło jest nieprawidłowe';
            	}
            }
            else
            {
            	$_SESSION['loginerror'] = 'Nie znaleziono użytkownika o takim adresie e-mail';
            }
        }
        else
        {
        	$_SESSION['loginerror'] = 'Wprowadź wszystkie dane';
        }

		redirect('?logowanie=true');
        break;

        case 'LOGOUT': unset($_SESSION['user']);
        break;

        case 'ADD_PRODUCT':

        $_SESSION['LastData'] = $_POST;
            if(!empty($_POST['nazwa']) && isset($_POST['bialko']) && isset($_POST['weglowodany']) && isset($_POST['tluszcze']) && isset($_POST['blonnik']))
            {              
                $stmt = $db_conn->prepare("INSERT INTO `produkt` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
                if($_POST['bialko'] >= 0 && $_POST['weglowodany'] >= 0 && $_POST['tluszcze'] >= 0 && $_POST['blonnik'] >= 0)
                {
                    $_POST['bialko'] = str_replace(',', '.', $_POST['bialko']);
                    $_POST['weglowodany'] = str_replace(',', '.', $_POST['weglowodany']);
                    $_POST['tluszcze'] = str_replace(',', '.', $_POST['tluszcze']);
                    $_POST['blonnik'] = str_replace(',', '.', $_POST['blonnik']);
                    if(is_numeric($_POST['bialko']) && is_numeric($_POST['weglowodany']) && is_numeric($_POST['tluszcze']) && is_numeric($_POST['blonnik']))
                    {
                        $kalorie = ($_POST['bialko']*4)+($_POST['weglowodany']*4)+($_POST['tluszcze']*9)+($_POST['blonnik']*4);
                        $stmt->bind_param("sdddddi", $_POST['nazwa'], $_POST['bialko'], $_POST['weglowodany'], $_POST['tluszcze'], $_POST['blonnik'], $kalorie, $_SESSION['user']['UzytkownikID']);
                        if ($stmt->execute()) 
                        {
                            unset($_SESSION['LastData']);
                           $_SESSION['productadd_success'] = 'Produkt dodany';
                           redirect('produkty.php');
                        }
                    }
                    else
                    {
                        $_SESSION['productadd_error'] = 'Błędnie wprowadzone dane makroskładników';
                    }
                }
                else
                {
                    $_SESSION['productadd_error'] = 'Błędnie wprowadzone dane makroskładników';
                }
            }
            else
            {
                $_SESSION['productadd_error'] = 'Wprowadź wszystkie dane'; 
            }
            redirect('produkty.php?dodanie_produktu=true');
            break;


        case 'EDIT_PRODUCT':

        $_SESSION['LastData'] = $_POST;
        if(!empty($_POST['nazwa']) && isset($_POST['bialko']) && isset($_POST['weglowodany']) && isset($_POST['tluszcze']) && isset($_POST['blonnik']) && !empty($_POST['edit-id']))
        {
            if($_POST['bialko'] >= 0 && $_POST['weglowodany'] >= 0 && $_POST['tluszcze'] >= 0 && $_POST['blonnik'] >= 0)
            {          
                $stmt = $db_conn->prepare("UPDATE `produkt` SET `Nazwa` = ?, `Bialko_gr` = ?, `Wegl_gr` = ?, `Tluszcz_gr` = ?, `Blonnik_gr` = ?, `Kcal` = ? WHERE `ProduktID` = ?");
                $_POST['bialko'] = str_replace(',', '.', $_POST['bialko']);
                $_POST['weglowodany'] = str_replace(',', '.', $_POST['weglowodany']);
                $_POST['tluszcze'] = str_replace(',', '.', $_POST['tluszcze']);
                $_POST['blonnik'] = str_replace(',', '.', $_POST['blonnik']);
                if(is_numeric($_POST['bialko']) && is_numeric($_POST['weglowodany']) && is_numeric($_POST['tluszcze']) && is_numeric($_POST['blonnik']))
                {
                    $kalorie = ($_POST['bialko']*4)+($_POST['weglowodany']*4)+($_POST['tluszcze']*9)+($_POST['blonnik']*4);
                    $stmt->bind_param("sdddddi", $_POST['nazwa'], $_POST['bialko'], $_POST['weglowodany'], $_POST['tluszcze'], $_POST['blonnik'], $kalorie, $_POST['edit-id']);
                    if ($stmt->execute()) 
                    {
                        unset($_SESSION['LastData']);
                       $_SESSION['editsuccess'] = 'Produkt edytowany';
                       redirect('produkty.php');
                    }
                }
                else
                {
                    $_SESSION['productedit_error'] = 'Błędnie wprowadzone dane makroskładników';
                }
            }
            else 
            {
                $_SESSION['productedit_error'] = 'Błędnie wprowadzone dane makroskładników';
            }
        }
        else
        {
            $_SESSION['productedit_error'] = 'Wprowadź wszystkie dane';
        }
        redirect('produkty.php?edycja_produktu=true');
        break;

        case 'REMOVE_PRODUCT':
        $stmt = $db_conn->prepare("DELETE FROM `produktdanie` WHERE `ProduktID` = ?");
        $stmt->bind_param('i',  $_POST['remove-id']);
        if($stmt->execute())
        {
            $stmt = $db_conn->prepare("DELETE FROM `produkt` WHERE `ProduktID` = ?");
            $stmt->bind_param("i", $_POST['remove-id']);
            if ($stmt->execute()) 
            {
                $_SESSION['removeerror'] = 'Produkt usunięty';

            }
            else 
            {
                $_SESSION['removeerror'] = 'Problem z usunięciem produktu';
            }
        }
        redirect('produkty.php');
        break;

        case 'ADD_DANIE':

        $_SESSION['LastData'] = $_POST;
        if(!empty($_POST['tytul']) && !empty($_POST['opis']) && !empty($_POST['OpcjeTypu']))
        {
            $_SESSION['adddanie'] = 'poczatek edytowane';
            $suma = array(0, 0, 0, 0, 0);
            if(!empty($_POST['ProduktID']))
            {
                $_SESSION['adddanie'] = 'w ifie';
                $in = '';
                foreach ($_POST['ProduktID'] as $id) {
                    if (is_numeric($id)) {
                        $in .= $id.',';
                    }
                }
                $in = substr($in, 0, -1);
                $sql = ("SELECT * FROM `produkt` WHERE `ProduktID` IN ({$in})");
                $result = $db_conn -> query($sql);
                while ($row = $result->fetch_assoc())
                {
                    $suma[0] += $row['Bialko_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[1] += $row['Wegl_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[2] += $row['Tluszcz_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[3] += $row['Blonnik_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[4] += $row['Kcal'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                }
                $_SESSION['adddanie'] = 'przed statement';
                $stmt = $db_conn->prepare("INSERT INTO `danie` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sdddddsii", $_POST['tytul'], $suma[0], $suma[1], $suma[2], $suma[3], $suma[4], $_POST['opis'], $_POST['OpcjeTypu'], $_SESSION['user']['UzytkownikID']);
                if ($stmt->execute()) 
                {
                    if(!empty($_POST['ProduktID']))
                    {
                        $inserciki = '';
                        foreach ($_POST['ProduktID'] as $id) {
                            if (is_numeric($id)) {
                                $inserciki .= "({$id}, {$stmt->insert_id}, {$_POST['ProduktWaga'][$id]}),";
                            }
                        }
                        $inserciki = substr($inserciki, 0, -1);
                        $stmt = $db_conn->prepare("INSERT INTO `produktdanie` VALUES {$inserciki}");
                        if($stmt->execute())
                        {
                            unset($_SESSION['LastData']);
                            $_SESSION['adddanie'] = 'Danie edytowane';
                            redirect('dania.php');
                        }
                    }
                    else
                    {
                       $_SESSION['adddanie_error'] = 'Danie dodane';
                    }
                }
                else 
                {
                    $_SESSION['adddanie_error'] = 'Problem z dodaniem produktow';
                }
            }
            else
            {
                $_SESSION['adddanie_error'] = 'Nie można dodać dania bez żadnego produktu';
            }

        }
        else
        {
            $_SESSION['adddanie_error'] = 'Wprowadź wszystkie dane';
        }
        redirect('dania.php?dodanie_dania=true');
        break;

        case 'EDIT_DANIE':

        $_SESSION['LastData'] = $_POST;
        if(!empty($_POST['tytul']) && !empty($_POST['opis']) && !empty($_POST['OpcjeTypu']) && !empty($_POST['edit-id']))
        {          
            $suma = array(0, 0, 0, 0, 0);
            if(!empty($_POST['ProduktID']))
            {
                $in = '';
                foreach ($_POST['ProduktID'] as $id) {
                    if (is_numeric($id)) {
                        $in .= $id.',';
                    }
                }
                $in = substr($in, 0, -1);
                $sql = ("SELECT * FROM `produkt` WHERE `ProduktID` IN ({$in})");
                $result = $db_conn -> query($sql);
                while ($row = $result->fetch_assoc())
                {
                    $suma[0] += $row['Bialko_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[1] += $row['Wegl_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[2] += $row['Tluszcz_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[3] += $row['Blonnik_gr'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                    $suma[4] += $row['Kcal'] * ($_POST['ProduktWaga'][$row['ProduktID']]/100);
                }
            }
            else
            {
                $_SESSION['editdanie_error'] = 'Nie można edytować dania bez żadnego produktu';
                redirect('dania.php?edycja_dania=true');
            }
            $stmt = $db_conn->prepare("UPDATE `danie` SET `Tytul` = ?, `Bialko_gr` = ?, `Wegl_gr` = ?, `Tluszcz_gr` = ?, `Blonnik_gr` = ?, `Kcal` = ?, `Opis` = ?, `TypID` = ? WHERE `DanieID` = ?");
            $stmt->bind_param("sdddddsii", $_POST['tytul'], $suma[0], $suma[1], $suma[2], $suma[3], $suma[4], $_POST['opis'], $_POST['OpcjeTypu'], $_POST['edit-id']);
            if ($stmt->execute() && $stmt->affected_rows == 1) 
            {
                $stmt = $db_conn->prepare("DELETE FROM `produktdanie` WHERE `DanieID` = ?");
                $stmt->bind_param('i',  $_POST['edit-id']);
                if($stmt->execute())
                {
                    if(!empty($_POST['ProduktID']))
                    {
                        $inserciki = '';
                        foreach ($_POST['ProduktID'] as $id) {
                            if (is_numeric($id)) {
                                $inserciki .= "({$id}, {$_POST['edit-id']}, {$_POST['ProduktWaga'][$id]}),";
                            }
                        }
                        $inserciki = substr($inserciki, 0, -1);
                        $stmt = $db_conn->prepare("INSERT INTO `produktdanie` VALUES {$inserciki}");
                        if($stmt->execute())
                        {
                            unset($_SESSION['LastData']);
                            $_SESSION['editerror'] = 'Danie edytowane';
                            redirect('dania.php');
                        }
                        else
                        {
                            $_SESSION['editerror'] = 'Problem z edytowaniem dania';
                        }
                    } else {
                        $_SESSION['editerror'] = 'Danie edytowane';
                    }
                }
                else
                {
                    $_SESSION['editerror'] = 'Problem z edytowaniem dania';
                }
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z edytowaniem dania';
            }
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';
        }
        redirect('dania.php?edycja_dania=true');
        break;

        case 'REMOVE_DANIE':
        $stmt = $db_conn->prepare("DELETE FROM `danie` WHERE `DanieID` = ?");
        $stmt->bind_param("i", $_POST['remove-id']);
        $stmt2 = $db_conn->prepare("DELETE FROM `produktdanie` WHERE `DanieID` = ?");
        $stmt2->bind_param("i", $_POST['remove-id']);
        $stmt3 = $db_conn->prepare("DELETE FROM `daniedieta` WHERE `DanieID` = ?");
        $stmt3->bind_param("i", $_POST['remove-id']);
        if ($stmt2->execute() && $stmt3->execute())
        {
            if($stmt->execute())
            {
                $_SESSION['removesuccess'] = 'Danie usunięty';
            }
            else
            {
                $_SESSION['removeerror'] = 'Problem z usunięciem dania';
            }
        }
        else 
        {
            $_SESSION['removeerror'] = 'Problem z usunięciem dania';
        }
        redirect('dania.php');
        break;

        case 'ADD_DIETA':
            if(!empty($_POST['nazwa']) && !empty($_POST['opis']) && !empty($_POST['OpcjeTypu']))
            {              
                $stmt = $db_conn->prepare("INSERT INTO `dieta` VALUES (NULL, ?, NULL, ?, ?, ?)");
                $stmt->bind_param("ssii", $_POST['nazwa'], $_POST['opis'], $_POST['OpcjeTypu'], $_SESSION['user']['UzytkownikID']);
                if ($stmt->execute()) 
            {
               $_SESSION['dietaerror'] = 'Dieta dodana';
            }
            else 
            {
                $_SESSION['dietaerror'] = 'Problem z dodaniem produktu';
            }
            redirect('diety.php');
            }
            else
            {
                $_SESSION['dietaerror'] = 'Wprowadź wszystkie dane';
                redirect('diety.php');
            }
            break;

        case 'EDIT_DIETA':

        if(!empty($_POST['nazwa']) && !empty($_POST['opis']) && !empty($_POST['OpcjeTypu']) && !empty($_POST['edit-id']))
        {          
            $stmt = $db_conn->prepare("UPDATE `dieta` SET `Tytul` = ?, `Opis` = ?, `TypDietyID` = ? WHERE `DietaID` = ?");
            $stmt->bind_param("ssii", $_POST['nazwa'], $_POST['opis'], $_POST['OpcjeTypu'], $_POST['edit-id']);
            if ($stmt->execute()) 
            {
               $_SESSION['editsuccess'] = 'Produkt edytowany';
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z dodaniem produktu';
            }
            redirect('diety.php');
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';
            redirect('diety.php');
        }
        break;

        case 'REMOVE_DIETA':
        $stmt = $db_conn->prepare("DELETE FROM `daniedieta` WHERE `DietaID` = ?");
        $stmt->bind_param('i',  $_POST['remove-id']);
        if($stmt->execute())
        {
            $stmt = $db_conn->prepare("DELETE FROM `dieta` WHERE `DietaID` = ?");
            $stmt->bind_param("i", $_POST['remove-id']);
            if ($stmt->execute()) 
            {
                $_SESSION['removeerror'] = 'Produkt usunięty';
            }
            else 
            {
                $_SESSION['removeerror'] = 'Problem z usunięciem produktu';
            }
            $_SESSION['removeerror'] = 'Produkt usunięty';
        }
        else
        {
            $_SESSION['removeerror'] = 'Produkt usunięty';
        }
        redirect('diety.php');
        break;


        case 'ADD_DANIE_DIETA':

        if(!empty($_POST['dieta-id']) && !empty($_POST['danie-id']) && !empty($_POST['OpcjeDni']) && !empty($_POST['OpcjePory']))
        {          
            $stmt = $db_conn->prepare("INSERT INTO `daniedieta` VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $_POST['danie-id'], $_POST['dieta-id'], $_POST['OpcjeDni'], $_POST['OpcjePory']);
            if ($stmt->execute()) 
            {
                $sql = "SELECT * FROM `daniedieta` INNER JOIN `danie` ON `daniedieta`.`DanieID` = `danie`.`DanieID` WHERE `dietaID` = {$_POST['dieta-id']}";
                $result = $db_conn -> query($sql);
                while ($row = $result->fetch_assoc())
                {
                    $kalorycznosc += $row['Kcal'];
                }
                $kcal = ($kalorycznosc/7);
                $stmt = $db_conn->prepare("UPDATE `dieta` SET `Kalorycznosc` = ? WHERE `DietaID` = {$_POST['dieta-id']}");
                $stmt->bind_param("i", $kcal);
                if($stmt->execute())
                {
                    $_SESSION['editsuccess'] = 'Produkt edytowany';
                }
               $_SESSION['editsuccess'] = 'Produkt edytowany';
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z dodaniem produktu';
            }
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';
        }
        redirect('dieta.php?id='.$_POST['dieta-id'].'');
        break;

        case 'USUN_DANIE_DIETA':

        if(!empty($_POST['dieta-id']) && !empty($_POST['danie-id']))
        {          
            $stmt = $db_conn->prepare("DELETE FROM `daniedieta` WHERE `DietaID` = ? AND `DanieID` = ? AND `PoraID` = ? AND DniID = ?");
            $stmt->bind_param("iiii", $_POST['dieta-id'], $_POST['danie-id'], $_POST['pora-id'], $_POST['dzien-id']);
            if ($stmt->execute()) 
            {
               $sql = "SELECT * FROM `daniedieta` INNER JOIN `danie` ON `daniedieta`.`DanieID` = `danie`.`DanieID` WHERE `dietaID` = {$_POST['dieta-id']}";
                $result = $db_conn -> query($sql);
                while ($row = $result->fetch_assoc())
                {
                    $kalorycznosc += $row['Kcal'];
                }
                $kcal = ($kalorycznosc/7);
                $stmt = $db_conn->prepare("UPDATE `dieta` SET `Kalorycznosc` = ? WHERE `DietaID` = {$_POST['dieta-id']}");
                $stmt->bind_param("i", $kcal);
                if($stmt->execute())
                {
                    $_SESSION['editsuccess'] = 'Produkt edytowany';
                }
               $_SESSION['editsuccess'] = 'Produkt edytowany';
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z dodaniem produktu';
            }
            redirect('dieta.php?id='.$_POST['dieta-id'].'');
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';
            redirect('diety.php');
        }
        break;

        case 'ACCEPT_RAPORT':
        if(!empty($_POST['accept-id']))
        {
            $stmt = $db_conn->prepare("UPDATE `raporty` SET `przeczytano` = ? WHERE `RaportyID` = ?");
            $accept = 1;
            $stmt->bind_param("ii", $accept, $_POST['accept-id']);
            if($stmt->execute())
            {
                $_SESSION['raportsuccess'] = 'Raport zaakceptowany';
            }
            else
            {
                $_SESSION['raporterror'] = 'Problem z zaakceptowaniem raportu';
            }
            redirect('raporty.php');
            break;
        }

        case 'ADD_RAPORT':
        /*$req_dump = print_r($_POST, TRUE);
        $fp = fopen('request.log', 'a');
        fwrite($fp, $req_dump);
        fclose($fp);*/
        $_SESSION['LastData'] = $_POST;
        if(isset($_POST['masa-ciala']) && isset($_POST['waga-docelowa']) && isset($_POST['masa-tluszczu']) && isset($_POST['masa-wody']) && isset($_POST['masa-miesni']) && isset($_POST['masa-kosci']))
        {
            $stmt = $db_conn->prepare("INSERT INTO `raporty` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
            if($_POST['masa-ciala']>=0 && $_POST['waga-docelowa']>=0 && $_POST['masa-tluszczu']>=0 && $_POST['masa-wody']>=0 && $_POST['masa-miesni']>=0 && $_POST['masa-kosci']>=0)
            {
                $data = date("Y-m-d");
                $_POST['masa-ciala'] = str_replace(',', '.', $_POST['masa-ciala']);
                $_POST['waga-docelowa'] = str_replace(',', '.', $_POST['waga-docelowa']);
                $_POST['masa-tluszczu'] = str_replace(',', '.', $_POST['masa-tluszczu']);
                $_POST['masa-wody'] = str_replace(',', '.', $_POST['masa-wody']);
                $_POST['masa-miesni'] = str_replace(',', '.', $_POST['masa-miesni']);
                $_POST['masa-kosci'] = str_replace(',', '.', $_POST['masa-kosci']);
                if(is_numeric($_POST['masa-ciala']) && is_numeric($_POST['waga-docelowa']) && is_numeric($_POST['masa-tluszczu']) && is_numeric($_POST['masa-wody']) && is_numeric($_POST['masa-miesni']) && is_numeric($_POST['masa-kosci']))
                {
                    $stmt->bind_param("sddddddi", $data, $_POST['masa-ciala'], $_POST['waga-docelowa'], $_POST['masa-tluszczu'], $_POST['masa-wody'], $_POST['masa-miesni'], $_POST['masa-kosci'], $_SESSION['user']['UzytkownikID']);
                    if ($stmt->execute()) 
                    {
                        unset($_SESSION['LastData']);
                       $_SESSION['mojraportsuccess'] = 'Raport dodany';
                       redirect('mojeraporty.php');
                    }
                    else 
                    {
                        $_SESSION['mojraporterror'] = 'Problem z dodaniem produktu';
                    }
                }
                else 
                {
                     $_SESSION['mojraporterror'] = 'Błędnie podane wartości wagi';
                }
            }
            else 
            {
                $_SESSION['mojraporterror'] = 'Błędnie podane wartości wagi';
            }
        }
         else
        {
            $_SESSION['mojraporterror'] = 'Wprowadź wszystkie dane';
        }
        redirect('mojeraporty.php?dodanie_raportu=true');
        break;

        case 'EDIT_RAPORT':
        $_SESSION['LastData'] = $_POST;
        if(isset($_POST['masa-ciala']) && isset($_POST['waga-docelowa']) && isset($_POST['masa-tluszczu']) && isset($_POST['masa-wody']) && isset($_POST['masa-miesni']) && isset($_POST['masa-kosci']) && !empty($_POST['edit-id']))
        {          
            $stmt = $db_conn->prepare("UPDATE `raporty` SET `MasaCiala` = ?, `Waga_Docelowa` = ?, `Waga_Tluszczu` = ?, `Waga_Wody` = ?, `Waga_Miesni` = ?, `Waga_Kosci` = ? WHERE `RaportyID` = ?");
            if($_POST['masa-ciala']>=0 && $_POST['waga-docelowa']>=0 && $_POST['masa-tluszczu']>=0 && $_POST['masa-wody']>=0 && $_POST['masa-miesni']>=0 && $_POST['masa-kosci']>=0)
            {
                $_POST['masa-ciala'] = str_replace(',', '.', $_POST['masa-ciala']);
                $_POST['waga-docelowa'] = str_replace(',', '.', $_POST['waga-docelowa']);
                $_POST['masa-tluszczu'] = str_replace(',', '.', $_POST['masa-tluszczu']);
                $_POST['masa-wody'] = str_replace(',', '.', $_POST['masa-wody']);
                $_POST['masa-miesni'] = str_replace(',', '.', $_POST['masa-miesni']);
                $_POST['masa-kosci'] = str_replace(',', '.', $_POST['masa-kosci']);
                if(is_numeric($_POST['masa-ciala']) && is_numeric($_POST['waga-docelowa']) && is_numeric($_POST['masa-tluszczu']) && is_numeric($_POST['masa-wody']) && is_numeric($_POST['masa-miesni']) && is_numeric($_POST['masa-kosci']))
                {
                    $stmt->bind_param("ddddddi", $_POST['masa-ciala'], $_POST['waga-docelowa'], $_POST['masa-tluszczu'], $_POST['masa-wody'], $_POST['masa-miesni'], $_POST['masa-kosci'], $_POST['edit-id']);
                    if ($stmt->execute()) 
                    {
                        unset($_SESSION['LastData']);
                       $_SESSION['editraportsuccess'] = 'Raport edytowany';
                       redirect('mojeraporty.php');
                    }
                    else 
                    {
                        $_SESSION['editraporterror'] = 'Problem z edycją raportu';
                    }
                }
                else 
                {
                    $_SESSION['editraporterror'] = 'Błędnie podane wartości wag';
                }
            }
            else 
            {
                $_SESSION['editraporterror'] = 'Błędnie podane wartości wag';
            }
        }
        else
        {
            $_SESSION['editraporterror'] = 'Wprowadź wszystkie dane';

        }
        redirect('mojeraporty.php?edycja_raportu=true');
        break;

        case 'EDIT_PROFIL':
        if(!empty($_POST['imie']) && !empty($_POST['nazwisko']) && !empty($_POST['ulica']) && !empty($_POST['miasto']) && !empty($_POST['kod-pocztowy']))
        {
            $stmt = $db_conn->prepare("UPDATE `uzytkownik` SET `Imie` = ?, `Nazwisko` = ?, `Ulica` = ?, `Miasto` = ?, `Kod_Pocztowy` = ? WHERE `UzytkownikID` = {$_SESSION['user']['UzytkownikID']}");
            $stmt->bind_param("sssss", $_POST['imie'], $_POST['nazwisko'], $_POST['ulica'], $_POST['miasto'], $_POST['kod-pocztowy']);
            if($stmt->execute())
            {
                $_SESSION['user']['Imie'] = $_POST['imie'];
                $_SESSION['user']['Nazwisko'] = $_POST['nazwisko'];
                $_SESSION['user']['Ulica'] = $_POST['ulica'];
                $_SESSION['user']['Miasto'] = $_POST['miasto'];
                $_SESSION['user']['Kod_Pocztowy'] = $_POST['kod-pocztowy'];
                $_SESSION['editsuccess'] = 'Produkt edytowany';
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z dodaniem produktu';
            }
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';

        }
        redirect('profil.php');
        break;

        case 'WYBIERZ_DIETETYKA':
        if(!empty($_POST['OpcjeDietetyka']) && is_null($_SESSION['user']['DietetykID']))
        {
            $stmt = $db_conn->prepare("UPDATE `uzytkownik` SET `DietetykID` = ? WHERE `UzytkownikID` = {$_SESSION['user']['UzytkownikID']}");
            $stmt->bind_param("i", $_POST['OpcjeDietetyka']);
            if($stmt->execute())
            {
                $_SESSION['user']['DietetykID'] = $_POST['OpcjeDietetyka'];
                $_SESSION['editsuccess'] = 'Produkt edytowany';
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z dodaniem produktu';
            }
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';

        }
        redirect('profil.php');
        break;

        case 'PRZYPISZ_DIETE':
        if(!empty($_POST['dieta-id']) && !empty($_POST['klient-id']))
        {
            $stmt = $db_conn->prepare("UPDATE `uzytkownik` SET `DietaID` = ? WHERE `UzytkownikID` = ?");
            $stmt->bind_param("ii", $_POST['dieta-id'], $_POST['klient-id']);
            if($stmt->execute())
            {
                $_SESSION['editsuccess'] = 'Produkt edytowany';
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z dodaniem produktu';
            }
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';

        }
        redirect('klient.php?id='.$_POST['klient-id'].'');

        case 'ZMIEN_TYP':
        if(!empty($_POST['advance-id']))
        {
            $stmt = $db_conn->prepare("UPDATE `uzytkownik` SET `Typ_Uzytkownika` = 2 WHERE `UzytkownikID` = ?");
            $stmt->bind_param("i", $_POST['advance-id']);
            if($stmt->execute())
            {
                $_SESSION['editsuccess'] = 'Produkt edytowany';
            }
            else 
            {
                $_SESSION['editerror'] = 'Problem z dodaniem produktu';
            }
        }
        else
        {
            $_SESSION['editerror'] = 'Wprowadź wszystkie dane';

        }
        redirect('klient.php?id='.$_POST['advance-id'].'');
    }
    redirect();
?>