<main>
        <div class="page-header row headerLogo">
            <div class="col divTitle">
                <h1> Inicio </h1>
                <h5 id="saludoH5">¡Hola <?php global $nombreUser; echo $nombreUser; ?>!</h5>
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
                        <div class="card-indicator">
                            <div class="indicator one" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head">
                        <h2><span id="pruebasPendientes"></span></h2>
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
                        <h2><span id="tiempoRespuesaSpan"></span></h2>
                        <span class="lar la-clock"></span>
                    </div>
                    <div class="card-progress">
                            <small>días/prueba</small>
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
