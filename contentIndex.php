<main>
        <div class="page-header row headerLogo">
            <div class="col divTitle contenedorFecha">
                <!--<small id="saludoH">¡Hola ?php global $nombreUser; echo $nombreUser; ?>!</small>-->
                <h1 class="fechaH">LABORATORIO DE METROLOGÍA</h1>
                    <h6 class="fechaH">Indicadores <?php
                    $meses = array(
                        1 => "Enero",
                        2 => "Febrero",
                        3 => "Marzo",
                        4 => "Abril",
                        5 => "Mayo",
                        6 => "Junio",
                        7 => "Julio",
                        8 => "Agosto",
                        9 => "Septiembre",
                        10 => "Octubre",
                        11 => "Noviembre",
                        12 => "Diciembre"
                    );
                    echo $meses[date("n")];
                    ?>
                    <!--php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime('%B'); ?> -->
                <?php echo date("d/m/Y"); ?></h6>
            </div>
            <div class="logoRight col-sm-3">
                <div>
                    <img class="logoGrammer2-img logoR img-responsive" alt="LogoGrammer" src="https://grammermx.com/Metrologia/MetroTickets/imgs\logoGrammer.png"><br>
                </div>
                <div>
                    <span><small>LABORATORIO DE METROLOGÍA</small></span>
                </div>
            </div>
        </div>


        <div class="page-content">
            <div class="analytics">

                <?php global $tipoUser; if($tipoUser == 1 || $tipoUser == 2 ){ ?>
                <div class="card " id="cardActRealizadas">
                    <div class="card-progress">
                        <small>ACTIVIDADES REALIZADAS ESTE MES</small>
                    </div>
                    <div class="card-head">
                        <h2><span id="numeroPruebas"></span></h2>
                        <span class="las la-check-square"></span>
                    </div>
                </div>
                <div class="card" id="cardActPendientes">
                    <div class="card-progress">
                        <small>ACTIVIDADES PENDIENTES</small>
                    </div>
                    <div class="card-head">
                        <h2><span id="pruebasPendientes"></span></h2>
                        <span class="las la-tools"></span>
                    </div>
                </div>

                <div class="card" id="cardTiempoResp">
                    <div class="card-progress" >
                        <small>TIEMPO DE RESPUESTA</small>
                    </div>
                    <div class="card-head">
                        <h2><span id="tiempoRespuesaSpan"></span> DÍAS/PRUEBA</h2>
                        <span class="lar la-clock"></span>
                    </div>
                </div>
                <div class="card" id="cardEficiencia">
                    <div class="card-progress">
                        <small>CUMPLIMIENTO</small>
                    </div>
                    <div class="card-head">
                        <h2><span id="cumplimiento"></span></h2>
                        <span class="las la-award"></span>
                    </div>

                </div>
            </div>
            <?php }?>

            <div class="container">
                <?php global $tipoUser; if($tipoUser == 1){ ?>
                <div class="row" id="divGraficoTipo">
                    <div class="col-xl-12" id="graficoPorTipoPrueba"></div>
                </div>
                <div class="row" id="graficosMetrologos">
                    <div class="col-xl-6" id="graficoPruebasPorMes"></div>
                    <div class="col-xl-6" id="graficoPorMesPorMetro"></div>
                </div>
                <?php }?>

                <?php global $tipoUser; if($tipoUser !== 1){ ?>
                    <div class="row" id="divGraficoGeneral">
                        <div class="col-xl-12" id="graficoPruebasGnal"></div>
                    </div>
                <?php }?>
            </div>
        </div>
    </main>
</div>


<script>
    let fechaActual = new Date();
    let anioActual = fechaActual.getFullYear();

    pruebasMesGeneral();
    function pruebasMesGeneral() {
        $.getJSON('https://grammermx.com/Metrologia/MetroTickets/dao/daoConsultaPruebasGnal.php', function (data) {

            var Ene1 = 0, Feb1 = 0, Mar1 = 0, Abril1 = 0, May1 = 0, Jun1 = 0, Jul1 = 0, Ago1 = 0,
                Sep1 = 0, Oct1 = 0, Nov1 = 0, Dic1 = 0;

            for (var i = 0; i < data.data.length; i++) {

                if (data.data[i].Mes === '1') {
                    Ene1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '2') {
                    Feb1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '3') {
                    Mar1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '4') {
                    Abril1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '5') {
                    May1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '6') {
                    Jun1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '7') {
                    Jul1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '8') {
                    Ago1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '9') {
                    Sep1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '10') {
                    Oct1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '11') {
                    Nov1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '12') {
                    Dic1 = data.data[i].Pruebas;
                }

            }
            graficaPruebasGnal(Ene1, Feb1, Mar1, Abril1, May1, Jun1, Jul1, Ago1, Sep1, Oct1, Nov1, Dic1);
        });
    }

    function graficaPruebasGnal(Ene,Feb, Mar, Abril, May,Jun, Jul, Ago, Sep,Oct, Nov, Dic) {
        var options = {
            series: [{
                name: 'Pruebas realizadas',
                data: [Ene, Feb, Mar, Abril, May, Jun, Jul, Ago, Sep, Oct, Nov, Dic]
            }],
            chart: {
                type: 'bar',
                height: 350,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '65%',
                    endingShape: 'rounded',
                    colors: {
                        ranges: [{
                            from: 0,
                            to: 100,
                            color: '#005195'
                        }]
                    }

                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 5,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Ene', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'],
            },
            yaxis: {
                title: {
                    text: 'Pruebas realizadas',
                    style: {
                        color: '#005195'
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return " " + val + " pruebas"
                    }
                }
            },
            title: {
                text: 'Pruebas realizadas por mes, '+anioActual,
                floating: true,
                offsetY: 0,
                align: 'center',
                style: {
                    color: '#005195'
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#graficoPruebasGnal"), options);
        chart.render();
    }


    <?php global $tipoUser; if($tipoUser == 1){ ?>

    pruebasMes();
    function pruebasMes() {
        $.getJSON('https://grammermx.com/Metrologia/MetroTickets/dao/daoConsultaPruebasMes.php', function (data) {

            var Ene1 = 0, Feb1 = 0, Mar1 = 0, Abril1 = 0, May1 = 0, Jun1 = 0, Jul1 = 0, Ago1 = 0,
                Sep1 = 0, Oct1 = 0, Nov1 = 0, Dic1 = 0;

            for (var i = 0; i < data.data.length; i++) {

                if (data.data[i].Mes === '1') {
                    Ene1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '2') {
                    Feb1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '3') {
                    Mar1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '4') {
                    Abril1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '5') {
                    May1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '6') {
                    Jun1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '7') {
                    Jul1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '8') {
                    Ago1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '9') {
                    Sep1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '10') {
                    Oct1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '11') {
                    Nov1 = data.data[i].Pruebas;
                }
                if (data.data[i].Mes === '12') {
                    Dic1 = data.data[i].Pruebas;
                }

            }
            graficaPruebasMes(Ene1, Feb1, Mar1, Abril1, May1, Jun1, Jul1, Ago1, Sep1, Oct1, Nov1, Dic1);
        });
    }

    function graficaPruebasMes(Ene,Feb, Mar, Abril, May,Jun, Jul, Ago, Sep,Oct, Nov, Dic) {
        var options = {
            series: [{
                name: 'Pruebas realizadas',
                data: [Ene, Feb, Mar, Abril, May, Jun, Jul, Ago, Sep, Oct, Nov, Dic]
            }],
            chart: {
                type: 'bar',
                height: 350,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '65%',
                    endingShape: 'rounded',
                    colors: {
                        ranges: [{
                            from: 0,
                            to: 100,
                            color: '#005195'
                        }]
                    }

                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 5,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Ene', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'],
            },
            yaxis: {
                title: {
                    text: 'Pruebas realizadas',
                    style: {
                        color: '#005195'
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return " " + val + " pruebas"
                    }
                }
            },
            title: {
                text: 'Pruebas realizadas por mes, '+anioActual,
                floating: true,
                offsetY: 0,
                align: 'center',
                style: {
                    color: '#005195'
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#graficoPruebasPorMes"), options);
        chart.render();
    }

    pruebasMesTipoPrueba();
    function pruebasMesTipoPrueba() {
        $.getJSON('https://grammermx.com/Metrologia/MetroTickets/dao/daoConsultaTipoPrueba.php', function(data) {
            const transformedData = {};

            data.data.forEach(entry => {
                const month = parseInt(entry.Mes);
                const tipoPrueba = entry.descripcionPrueba;
                const pruebas = parseInt(entry.Pruebas);

                if (!transformedData[tipoPrueba]) {
                    transformedData[tipoPrueba] = Array(12).fill(0); // Asumiendo 12 meses
                }
                transformedData[tipoPrueba][month - 1] = pruebas; // Meses en ApexCharts son 0-indexed
            });

            graficaPruebasMesTipo(transformedData);
        });
    }

    function graficaPruebasMesTipo(transformedData) {
        const seriesData = Object.keys(transformedData).map(tipoPrueba => ({
            name: tipoPrueba,
            data: transformedData[tipoPrueba]
        }));

        var options = {
            series: seriesData,
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                title: {
                    text: 'Pruebas'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " pruebas";
                    }
                }
            },
            title: {
                text: 'Pruebas solicitadas por tipo de prueba, '+ anioActual,
                floating: true,
                offsetY: 0,
                align: 'center',
                style: {
                    color: '#005195'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#graficoPorTipoPrueba"), options);
        chart.render();
    }


    function pruebasMesMetrologo() {
        $.getJSON('https://grammermx.com/Metrologia/MetroTickets/dao/daoConsultaPruebasMesMetro.php', function(data) {
            const transformedData = {};

            data.data.forEach(entry => {
                const month = parseInt(entry.Mes);
                const metrologo = entry.NombreMetrologo;
                const pruebas = parseInt(entry.Pruebas);

                if (!transformedData[metrologo]) {
                    transformedData[metrologo] = Array(12).fill(0); // Asumiendo 12 meses
                }
                transformedData[metrologo][month - 1] = pruebas; // Meses en ApexCharts son 0-indexed
            });

            graficaPruebasMesMetro(transformedData);
        });
    }


    function graficaPruebasMesMetro(transformedData) {
        const seriesData = Object.keys(transformedData).map(metrologo => ({
            name: metrologo,
            data: transformedData[metrologo]
        }));

        var options = {
            series: seriesData,
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                title: {
                    text: 'Pruebas'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " pruebas";
                    }
                }
            },
            title: {
                text: 'Pruebas realizadas por metrólogo, '+ anioActual,
                floating: true,
                offsetY: 0,
                align: 'center',
                style: {
                    color: '#005195'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#graficoPorMesPorMetro"), options);
        chart.render();
    }

    pruebasMesMetrologo();
    <?php }?>
</script>
