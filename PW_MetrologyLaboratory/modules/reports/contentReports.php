<main>
    <div class="page-header">
        <h1>Reportes</h1>
        <small>Genera un nuevo reporte</small>
    </div>

    <div class="page-content">
        <div class="container" id="divFormReporte">
            <form id="reporteMensual" method="POST" class="popup-form wrapper">
                <div class="container row">
                    <div class="col-sm-4" id="divTipoReporte">
                        <label for="tipoReporte">Tipo de reporte</label>
                        <div class="form-group" id="divTipoReporte">
                            <select class="form-control" id="tipoReporte" name="tipoReporte" required data-error="Por favor seleccione un tipo de reporte válido.">
                                <option value="">Seleccione el tipo de reporte*</option>
                                <option value="1">Sólo estadísticas</option>
                                <option value="2">Detallado</option>
                            </select>
                            <div class="input-group-icon"><i class="las la-clipboard-check"></i></div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-sm-4" id="divAnioReporte">
                        <label for="anio">Año</label>
                        <div class="form-group" id="divAnioReporte">
                            <select class="form-control" id="anio" name="anio" required data-error="Por favor seleccione un año válido.">
                                <option value="">Seleccione el año*</option>
                            </select>
                            <div class="input-group-icon"><i class="las la-calendar-check"></i></div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-sm-4" id="divMesReporte">
                        <label for="mes">Mes</label>
                        <div class="form-group" id="divMesReporte">
                            <select class="form-control" id="mes" name="mes" required data-error="Por favor seleccione un mes válido.">
                                <option value="">Seleccione el mes*</option>
                            </select>
                            <div class="input-group-icon"><i class="las la-calendar-week"></i></div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                <div class="container" id="divBtnReporte">
                    <button type="submit" onclick="" class="btn btn-primary" id="btnReporte"><i class="las la-newspaper"></i>Generar reporte</button>
                </div>
            </form>
        </div>
    </div>
</main>