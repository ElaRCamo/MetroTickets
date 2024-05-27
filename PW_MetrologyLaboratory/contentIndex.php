<main>
        <div class="page-header row headerLogo">
            <div class="col divTitle contenedorFecha">
                <small id="saludoH">¡Hola <?php global $nombreUser; echo $nombreUser; ?>!</small>
                <h3 class="fechaH">Indicadores <?php
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
                    <!--php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime('%B'); ?> --></h3>
                <h6 class="fechaH"><?php echo date("d/m/Y"); ?></h6>
            </div>
            <div class="logoRight col-sm-3">
                <div>
                    <img class="logoGrammer2-img logoR img-responsive" alt="LogoGrammer" src="https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory\imgs\logoGrammer.png"><br>
                </div>
                <div>
                    <span><small>GRAMMER AUTOMOTIVE PUEBLA S. A. DE C. V.</small></span>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="analytics">
                <div class="card">
                    <div class="card-head">
                        <h2><span id="numeroPruebas"></span></h2>
                        <span class="las la-ruler-combined"></span>
                    </div>
                    <div class="card-progress">
                        <small>Pruebas realizadas este mes</small>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head">
                        <h2><span id="pruebasPendientes"></span></h2>
                        <span class="las la-pencil-ruler"></span>
                    </div>
                    <div class="card-progress">
                        <small>Pruebas pendientes </small>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2><span id="tiempoRespuesaSpan"></span> días/prueba</h2>
                        <span class="lar la-clock"></span>
                    </div>
                    <div class="card-progress">
                            <small>Tiempo de respuesta</small>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2><span id="pruebasPorDiaSpan"></span> pruebas/día</h2>
                        <span class="las la-chart-line"></span>
                    </div>
                    <div class="card-progress">
                        <small>Eficiencia Operativa</small>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col" id="graficoPruebasPorMes">
                    </div>
                    <div class="col" id="graficoPorMesPorMetro">
                        2 of 2
                    </div>
                </div>
                <div class="row" id="graficosCirculares">
                    <div class="col">
                        1 of 3
                    </div>
                    <div class="col">
                        2 of 3
                    </div>
                    <div class="col">
                        3 of 3
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    pruebasMes();
    function pruebasMes() {
        $.getJSON('https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/dao/daoConsultaPruebasMes.php', function (data) {

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
                name: 'Pruebas realizadas por mes',
                data: [Ene, Feb, Mar, Abril, May, Jun, Jul, Ago, Sep, Oct, Nov, Dic]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '65%',
                    endingShape: 'rounded'
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
                    text: 'Pruebas'
                }
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
            }
        };
        var chart = new ApexCharts(document.querySelector("#graficoPruebasPorMes"), options);
        chart.render();
    }


</script>