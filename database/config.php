<?php
    /** Connect Database **/
    
    $DB_Host = '127.0.0.1';
    $DB_Username = 'root';
    $DB_Pass = '';
    $DB_Name = 'shop';

    $PDO = mysqli_connect($DB_Host, $DB_Username, $DB_Pass, $DB_Name) OR die('Cannot connect to Database');
?> 

