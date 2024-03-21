<?php
session_start();
$nombreUsuario = $_SESSION['nombreUsuario'];
?>
<main>
        <div class="page-header row headerLogo">
            <div class="col divTitle">
                <h1> Inicio </h1>
                <small>Bienvenido(a) <?php echo $nombreUsuario; ?> </small>
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
                        <h2>135</h2>
                        <span class="las la-ruler-combined"></span>
                    </div>
                    <div class="card-progress">
                        <small>Pruebas relaizadas este mes</small>
                        <div class="card-indicator">
                            <div class="indicator one" style="width: 60%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>12</h2>
                        <span class="las la-pencil-ruler"></span>
                    </div>
                    <div class="card-progress">
                        <small>Pruebas pendientes </small>
                        <div class="card-indicator">
                            <div class="indicator two" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>2 días/prueba</h2>
                        <span class="lar la-clock"></span>
                    </div>
                    <div class="card-progress">
                        <small>Tiempo de respuesta</small>
                        <div class="card-indicator">
                            <div class="indicator three" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>15 pruebas/día</h2>
                        <span class="las la-chart-line"></span>
                    </div>
                    <div class="card-progress">
                        <small>Eficiencia Operativa</small>
                        <div class="card-indicator">
                            <div class="indicator four" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
