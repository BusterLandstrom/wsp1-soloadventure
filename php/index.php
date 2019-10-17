<?php
session_start();

include 'include/db.php';


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
    $item_id = $sth->fetchAll(PDO::FETCH_ASSOC);

$sth = $dbh->prepare('INSERT INTO players (primary_hand) VALUES (:item_id)');
    $sth->bindParam(':primary_hand', $primary_hand);
    $sth->execute([$primary_hand]);
    $primary_hand = $sth->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Hansel & Gretel";

$endurance = filter_var($_SESSION['endurance'], FILTER_VALIDATE_INT);
$endurance = $endurance + $story['endurance'];

if($filteredId == 6){
    $item_place = array_rand($_SESSION['bath_item_room']);
    $item_found = $_SESSION['bath_item_room'][$item_place];
    $filteredId = $item_found;
    sleep(2);
    if($filteredId == 8 or $filteredId == 7){
    $sth = $dbh->prepare('SELECT * 
                    FROM story
                    WHERE id =' . $filteredId);
    $sth->execute();
    $story = $sth->fetch(PDO::FETCH_ASSOC);


    $sth = $dbh->prepare('SELECT * 
                    FROM links
                    WHERE story_id =' . $filteredId);
    $sth->execute();
    $links = $sth->fetchAll(PDO::FETCH_ASSOC);

    } else{
    $filteredId = 11;
    $sth = $dbh->prepare('SELECT * 
                    FROM story
                    WHERE id =' . $filteredId);
    $sth->execute();
    $story = $sth->fetch(PDO::FETCH_ASSOC);


    $sth = $dbh->prepare('SELECT * 
                    FROM links
                    WHERE story_id =' . $filteredId);
    $sth->execute();
    $links = $sth->fetchAll(PDO::FETCH_ASSOC);

    }
    unset($_SESSION['bath_item_room'][0]);
    unset($_SESSION['bath_item_room'][1]);
}

if($filteredId == 9 or $filteredId == 10){
    $filteredId = 4;
    
    $sth = $dbh->prepare('SELECT * 
                    FROM story
                    WHERE id =' . $filteredId);
    $sth->execute();
    $story = $sth->fetch(PDO::FETCH_ASSOC);
    $sth = $dbh->prepare('SELECT * 
                    FROM links
                    WHERE story_id =' . $filteredId);
    $sth->execute();
    $links = $sth->fetchAll(PDO::FETCH_ASSOC);

    unset($_SESSION['bath_item_room'][$item_place]);

    $sth = $dbh->prepare('SELECT item_id 
                    FROM story
                    WHERE id =' . $filteredId);
    $sth->execute();
    $item_id = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth = $dbh->prepare('SELECT items.name 
                    FROM items
                    WHERE items.id =' . $item_id);
    $sth->execute();
    $item_name = $sth->fetchAll(PDO::FETCH_ASSOC);

    if(!isset($_SESSION['backpack'])){
        $_SESSION['backpack'] = [];
    }

    array_push($_SESSION['backpack'], $item_name);
}


if($filteredId == 1) {
    $_SESSION['bath_item_room'] = [7,8];
    unset($_SESSION['backpack']);
    $endurance = 20;
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