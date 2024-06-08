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
    <link rel="stylesheet" href="/old/bootstrap/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/primevue/resources/themes/lara-light-green/theme.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/primevue@3.52.0/resources/primevue.min.css">
    <script src="https://cdn.jsdelivr.net/npm/primevue@3.52.0/core/core.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta charset="utf-8" />
    <title>
        Задание
    </title>
</head>

<body>
    <script src="https://unpkg.com/primevue/datatable/datatable.min.js"></script>
    <script src="https://unpkg.com/primevue/calendar/calendar.min.js"></script>
    <script src="https://unpkg.com/primevue/column/column.min.js"></script>
    <script src="https://unpkg.com/primevue/inputtext/inputtext.min.js"></script>
    <script src="https://unpkg.com/primevue/button/button.min.js"></script>
    <script src="https://unpkg.com/primevue/dropdown/dropdown.min.js"></script>
    <script src="https://unpkg.com/primevue/listbox/listbox.min.js"></script>
    <div id="app">
        <h1 class="main-title">Новая версия</h1>
        <section class="section-block">
            <form action="" class="add-courier">
                <h2 class="section-title">Добавить курьера</h2>
                <label for="username">Username</label>
                <p-inputtext v-model="newCourier" :class="'p-inputtext p-component'"></p-inputtext>
                <p-button label="Добавить" :class="'p-button p-component'" @click="addCourier"></p-button>
            </form>
        </section>

        <section class="section-block">
            <form class="add-drive-form">
                <h2 class="section-title">Добавить поездку</h2>
                <div class="">
                    <label for="region">Регион</label>
                    <p-listbox v-model="driveRegion" :options="regions" v-bind:option-label="'region'" v-bind:option-value="'region'"></p-listbox>
                </div>
                <div class="">
                    <label for="region">Дата из МСК</label>
                    <p-datepicker v-model="driveDate"></p-datepicker>
                </div>
                <div class="">
                    <label for="region">Фио курьера</label>
                    <p-listbox v-model="driveCourier" :options="couriers" v-bind:option-label="'courier'" v-bind:option-value="'id'"></p-listbox>
                </div>
                <p-button label="Добавить поездку" :class="'p-button p-component'" @click="addDrive"></p-button>
            </form>
        </section>

        <section class="section-block">
            <p-datatable :value="couriers" tableStyle="min-width: 50rem">
                <p-column field="id" header="Id" sortable></p-column>
                <p-column field="busy" header="Загруженность" sortable>
                    <template #body="slotProps">
                        {{ slotProps.data.busy === '1' ? 'Занят' : 'Свободен'}}
                    </template>
                </p-column>
                <p-column field="courier" header="Имя курьера" sortable></p-column>
                <p-column field="busytime" header="Дата загруженности" sortable></p-column>
                <p-column header="Действия" sortable>
                    <template #body="slotProps">
                        <p-button label="Удалить" :class="'p-button p-component'" @click="removerCourier(slotProps.data.id)"></p-button>
                    </template>
                </p-column>
            </p-datatable>
        </section>

        <section class="section-block">
            <p-datatable :value="leftList" tableStyle="min-width: 50rem">
                <p-column field="id" header="Id" sortable></p-column>
                <p-column field="region" header="Регион" sortable></p-column>
                <p-column field="courier" header="Id курьера" sortable></p-column>
                <p-column field="start" header="Старт из МСК" sortable></p-column>
                <p-column field="toregion" header="Дата прибытия в регион" sortable></p-column>
                <p-column field="back" header="Дата возвращения в МСК" sortable></p-column>
            </p-datatable>
        </section>
    </div>


    <script type="module">
        const { createApp, ref, onMounted, computed } = Vue
        import api from '/old/api/logistic.js';

        const app = createApp({
            setup() {
            const message = ref('Hello vue!')
            const couriers = ref([]);
            const regions = ref([]);
            const leftList = ref([]);
            const loading = ref(false);
            const error = ref(null);
            const newCourier = ref('');
            const driveRegion = ref('');
            const driveDate = ref('');
            const driveCourier = ref('');

            const driveDateServer =  computed(() => {
                return driveDate.value !== '' ? `${driveDate.value.getFullYear()}-${driveDate.value.getMonth() + 1}-${driveDate.value.getDate()}` : '';
            })

        const driveDateComeServer = computed(() => {
        if (!driveDate.value) return '';
        const region = regions.value.find(region => region.region === driveRegion.value)?.time;
        if (!region) return '';
        const dateToRegion = new Date(driveDate.value);
        dateToRegion.setDate(dateToRegion.getDate() + parseInt(region, 10)); 
        const year = dateToRegion.getFullYear();
        const month = String(dateToRegion.getMonth() + 1).padStart(2, '0');
        const day = String(dateToRegion.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
        });
        const driveDateBackServer = computed(() => {
        if (!driveDate.value) return '';
        const region = regions.value.find(region => region.region === driveRegion.value)?.time;
        if (!region) return '';
        const dateToRegion = new Date(driveDate.value);
        dateToRegion.setDate(dateToRegion.getDate() + parseInt(region, 10) * 2);
        const year = dateToRegion.getFullYear();
        const month = String(dateToRegion.getMonth() + 1).padStart(2, '0');
        const day = String(dateToRegion.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
        });



        const fetchData = async () => {
        loading.value = true;
        try {
            couriers.value = await api.getCouriers();
            regions.value = await api.getRegions();
            leftList.value = await api.getLeftList();
        } catch (err) {
            error.value = 'Failed to fetch data';
        } finally {
            loading.value = false;
        }
        };
        const addDrive = async () => {
            await api.addDrive({
                courier: driveCourier.value,
                region: driveRegion.value,
                startDate: driveDateServer.value,
                toRegionDate: driveDateComeServer.value,
                backDate: driveDateBackServer.value,
            });
            leftList.value = await api.getLeftList();
        }
        const addCourier = async () => {
            await api.addCourier(newCourier.value);
            couriers.value = await api.getCouriers();
        }
        const removeCourier = async (courierId) => {
            await api.removeCourier(courierId);
            couriers.value = await api.getCouriers();
        }

        onMounted(() => {
        fetchData();
        });
            return {
                message,
                regions,
                leftList,
                couriers,
                newCourier,
                addCourier,
                driveRegion,
                driveDate,
                driveDateServer,
                driveDateComeServer,
                driveDateBackServer,
                driveCourier,
                addDrive,
            }
            }
        })
        app.use(primevue.config.default, { unstyled: false });
        app.component('p-datepicker', primevue.calendar);
        app.component('p-datatable', primevue.datatable);
        app.component('p-column', primevue.column);
        app.component('p-inputtext', primevue.inputtext);
        app.component('p-button', primevue.button);
        app.component('p-dropdown', primevue.dropdown);
        app.component('p-listbox', primevue.listbox);
        app.mount('#app');
    </script>
    <style>
        .main-title{
        display: flex;
        justify-content: center;
        text-align: center;
        }
        .add-drive-form {
            display: flex; 
            flex-direction: column;
            margin-inline: auto;
        }
        .section-block {
            margin: 20px;
            display: flex;
            flex-direction: column;
        }
    </style>
    <!--  -->
    <!--  -->
    <!--  -->
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
