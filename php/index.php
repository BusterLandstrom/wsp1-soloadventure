<?php
session_start();

include 'include/db.php';

$filteredId = 1;

if(isset($_GET['id'])) {
    $filteredId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $_SESSION['id'] = $filteredId;

} elseif (isset($_SESSION['id'])) {
    $filteredId = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);

}

$sth = $dbh->prepare('SELECT * 
                    FROM story
                    WHERE id = :filteredId');
$sth->bindParam(':filteredId', $filteredId);
$sth->execute();
$story = $sth->fetch(PDO::FETCH_ASSOC);
$sth = $dbh->prepare('SELECT * 
                    FROM links
                    WHERE story_id = :filteredId');
$sth->bindParam(':filteredId', $filteredId);
$sth->execute();
$links = $sth->fetchAll(PDO::FETCH_ASSOC);
$sth = $dbh->prepare('SELECT * FROM story, players, items WHERE item_id = items.id ');
    $sth->bindParam(':item_id', $item_id);
    $sth->execute([$item_id]);

$sth = $dbh->prepare('INSERT INTO players (primary_hand) VALUES (:item_id)');
    $sth->bindParam(':primary_hand', $primary_hand);
    $sth->execute([$primary_hand]);

$page_title = "Hansel & Gretel";

$endurance = filter_var($_SESSION['endurance'], FILTER_VALIDATE_INT);
$endurance = $endurance + $story['endurance'];



if($filteredId == 1) {
    $endurance = 20;
    $primary_hand = ;
    $_SESSION['primary_hand'] = array();
    array_push($_SESSION['primary_hand'],$primary_hand);
    $character = "Not selected yet";
    $_SESSION['character'] = array();
    array_push($_SESSION['character'], $character);
    $_SESSION['character'] = array_shift($_SESSION['character']);
}
if($filteredId == 3) {
    $character = "Hans";
    $_SESSION['character'] = array();
    array_push($_SESSION['character'], $character);
    $_SESSION['character'] = array_shift($_SESSION['character']);
}
if($filteredId == 2) {
    $character = "Greta";
    $_SESSION['character'] = array();
    array_push($_SESSION['character'], $character);
    $_SESSION['character'] = array_shift($_SESSION['character']);
}
if ($filteredId > 0){
$_SESSION['endurance'] = $endurance;
}

include 'views/index_layout.php';

?>