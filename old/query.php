<?php
include "bd.php";
if (isset($_POST["courier"])) {
    $courier = $_POST['courier'];
    $query = "INSERT INTO couriers ('courier', 'busytime') VALUES ('$courier', date())";
    $db->query($query);
    if ($query) {
        echo "Курьер добавлен";
    } else {
        echo $db->lastErrorMsg();
    }
}
if (isset($_POST['start']) && isset($_POST['back']) && !empty($_POST['back']) && !empty($_POST['start'])) {
    $region = $_POST['inRegion'];
    $courier = $_POST['who'];
    $date = $_POST['start'];
    $toRegion = $_POST['toRegion'];
    $back = date('Ymd', strtotime($_POST['back']));
    $query = "INSERT INTO leftlist ('start','region','courier','toregion','back') VALUES ('$date','$region','$courier','$toRegion','$back')";
    $db->query($query) or die($db->lastErrorMsg());
    $query = "UPDATE couriers SET busy=1, busytime=$back where id='$courier'";
    $db->query($query) or die($db->lastErrorMsg());
    echo "Успех!";
}