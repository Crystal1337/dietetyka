<?php
    session_start();

    if ( basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME']) ) 
 	{
        die('<html><body></body></html>');
    } 

    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_database = 'dietetyka';

    $db_conn = new mysqli($db_host, $db_username, $db_password, $db_database);

    if ($db_conn->connect_error) {
        die('Problem z bazą danych');
    }

    $db_conn->set_charset('utf8');
?>