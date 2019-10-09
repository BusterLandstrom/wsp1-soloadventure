<?php
include 'dbinfo.php'; // rename dbinfo_example.php
try {
    $dbh = new PDO(
        'mysql:host=localhost;charset=utf8mb4;dbname=' . $database . '',
         $user,
          $password
    );
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>