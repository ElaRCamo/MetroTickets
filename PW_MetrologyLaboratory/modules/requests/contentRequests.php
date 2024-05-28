<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle">
            <h1>Solicitudes</h1>
            <small>Buscar</small>
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
        <div class="records table-responsive">
            <div class="record-header">
                <div class="search">
                </div>
                <div class="browse search">
                    <input type="search" placeholder="Buscar" class="record-search">
                    <select name="" id="">
                        <option value="numFolio">Folio</option>
                        <option value="estadoSolitud">Estado</option>
                        <option value="prioridadSolitud">Prioridad</option>
                    </select>
                    <button class="btn button-cristal">Buscar</button>
                </div>
            </div>
            <div class="table-Conteiner">
                <table class="table tableSearch" id="listadoPruebas" >
                    <thead>
                        <tr>
                            <th id="folio">FOLIO</th>
                            <th >FECHA DE SOLICITUD</th>
                            <th >FECHA DE RESPUESTA</th>
                            <th >ESTATUS </th>
                            <th >TIPO DE PRUEBA</th>
                            <th >PRIORIDAD</th>
                            <th >SOLICITANTE </th>
                            <th >METRÓLOGO </th>
                            <th >ESPECIFÍCACIONES </th>
                        </tr>
                    </thead>
                    <tbody id="listadoPruebasBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</main>