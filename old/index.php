<?php include_once('bd.php'); ?>
<?php include_once('func.php'); ?>
<?php

if (isset($_GET["func"])) {
    $func = $_GET["func"];


    if ($func == "retCour") {
        echo returnCouriers();
        die();
    } else {
        if ($func == "result") {
            echo returnLefts("id");
            die();
        } else {
            if ($func == "sort") {
                echo returnLefts("start");
                die();
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="/old/bootstrap/css/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!--    <script src="http://wisdomweb.ru/editor/localization.js"></script>-->
    <meta charset="utf-8"/>
    <title>
        Задание
    </title>
</head>
<body>
<div>
    <h2 style="text-align:center">Задание</h2>
</div>
<style>
    td {
        padding-top: 10px;
    }

    td input[type=text], select {
        width: 150px;
        margin-right: 10px;
    }
</style>
<table>
    <tr>
        <td>Добавить курьера</td>
        <td><input type="text" id="courier"/></td>
        <td colspan="2"><input id="addCourier" class="btn btn-success" type="submit" value="OK"></td>
    </tr>
</table>
<h2>Добавить поездку</h2>
<table>
    <tr>
        <td>Регион</td>
        <td><?php returnRegions(); ?></td>
    </tr>
    <tr>
        <td>Дата из МСК</td>
        <td><input type="text" name="date" id="date" placeholder="Выберите дату"/></td>
    </tr>
    <tr>
        <td>ФИО курьера</td>
        <td id="retCour"><?php returnCouriers(); ?></td>
    </tr>
    <tr>
        <td>Дата прибытия в регион</td>
        <td><p id="time"></p></td>
    </tr>
    <tr>
        <td>Дата возврата в МСК</td>
        <td><p id="timeBack"></p></td>
    </tr>
    <tr>
        <td colspan="2"><input id="addLeft" class="btn btn-success" type="submit" value="OK"></td>
    </tr>
</table>
<input type="button" id="sortCour" class="btn btn-success" value="По дате отправления"/>
<div id="Res_table">
    <?php returnLefts("id"); ?></div>
<script>
    $('#addCourier').click(function () {
        var courier = $('#courier').val();
        $.post("/old/query.php", {"courier": courier}, function (data) {
            alert(data);
            $.get("/old/index.php?func=retCour", function (res) {
                $("#retCour").html(res);
            });
        });
    });
</script>
<script>
    var btClick = 0;
    var courier = '';
    var region = '';
    var date = '';
    var dateToRegion = '';
    var dateToBack = '';
    var date = '';
    var regionDate = '';
    $('#date').datepicker({
        dateFormat: 'y-m-d',
        onSelect: function () {
            courier = $('.courier option:selected').attr('value');
            region = parseInt($('.region option:selected').attr('value'));
            date = $('#date').datepicker('getDate', 'y-m-d');
            regionDate = new Date(date);
            dateToRegion = new Date(regionDate.setDate(regionDate.getDate() + region));
            dateToBack = new Date(regionDate.setDate(regionDate.getDate() + region));
            $('#time').text(dateToRegion.getFullYear() + '-' + (dateToRegion.getMonth() + 1) + '-' + dateToRegion.getDate());
            $('#timeBack').text(dateToBack.getFullYear() + '-' + (dateToBack.getMonth() + 1) + '-' + dateToBack.getDate());

        }
    });
</script>
<script>
    $("#sortCour").click(function () {
        $.get("/old/index.php?func=sort", function (res) {
            $("#Res_table").html(res);
        });
    });
    $('#addLeft').click(function () {
        if ($("select.region").prop("selectedIndex") != 0 && $("select.courier").prop("selectedIndex") != 0 && date) {
            var date1 = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
            var tyda = dateToRegion.getFullYear() + '-' + (dateToRegion.getMonth() + 1) + '-' + dateToRegion.getDate();
            var cyda = dateToBack.getFullYear() + '-' + (dateToBack.getMonth() + 1) + '-' + dateToBack.getDate();
            var region = $('.region option:selected').text();
            var courier = $('.courier option:selected').val();
            $.post("/old/query.php",
                {inRegion: region, who: courier, start: date1, toRegion: tyda, back: cyda}, function (data) {
                    alert(data);
                    $.get("/old/index.php?func=result", function (res) {
                        $("#Res_table").html(res);
                    });
                    $("select").prop("selectedIndex", 0);
                });
        } else {
            alert('Заполните все поля');
        }
    });
</script>
</body>
</html>
