<?php
/*
INSERT INTO `bd1`.`regions` (`region` ,`time`)VALUES ('Cанкт-Петербург', '2'),('Уфа', '3'),('Нижний Новгород','1'),('Владимир','1'),('Кострома','2'),('Екатеринбург','3'),('Ковров','1'),('Воронеж','3'),('Самара','1'),('Астрахань','2');
*/

function returnRegions(){
	include("bd.php");
$query = $db->query("SELECT * FROM regions WHERE 1");
echo "<select class='region'>";
echo "<option id='def'>-----</option>";
while($regions = $query->fetchArray()){
	$region = $regions['region'];
	$regionId = $regions['id'];
	$regionTime = $regions['time'];
	echo "<option id='id$regionId' value='$regionTime' >";
	echo	"$region";
echo "</option>";
}
echo "</select>";
}

function returnCouriers(){
	include("bd.php");
$query = $db->query("SELECT * FROM couriers WHERE 1");
echo "<select class='courier'>";
echo "<option id='def'>-----</option>";
while($couriers = $query->fetchArray()){
	$courier = $couriers['courier'];
	$courierId = $couriers['id'];
	$busy = $couriers['busy'];
	$busytime = str_replace('-','',$couriers['busytime']);
		if($busy == 1 && $busytime <= date('Ymd')){
            $db->query("UPDATE couriers SET busy=0, $busytime ='00000000' where id=$courierId");
			$busy = 0;
	}
		if($busy == 0)
	{
		echo "<option value='$courierId'>";
			echo	"$courier # $courierId";
		echo "</option>";
	}
}

echo "</select>";
}

function returnLefts($sort){
	include("bd.php");
$query = $db->query("SELECT * FROM leftList WHERE 1 ORDER BY ".$sort." DESC");
echo "<table class='table'>";
	echo "<tr>";
		echo "<td>id поездки</td><td>Регион</td><td>id курьера</td><td>Старт из МСК</td><td>Дата прибытия в регион</td><td>Дата возвращения в МСК</td>";
	echo "</tr>";
while($left = $query->fetchArray()){
	$id = $left['id'];
	$region = $left['region'];
	$courier = $left['courier'];
	$start = $left['start'];
	$toregion = $left['toregion'];
	$back = $left['back'];
	echo "<tr>";
		echo "<td>$id</td><td>$region</td><td>$courier</td><td>$start</td><td>$toregion</td><td>".date('Y-m-d',strtotime($back))."</td>";
	echo "</tr>";
}
$query1 = $db->query("update couriers set busy=true, busytime=$back where id=$courier");
echo "</table>";
}
