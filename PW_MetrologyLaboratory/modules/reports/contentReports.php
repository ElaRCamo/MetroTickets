<main>
    <div class="page-header">
        <h1>Reportes</h1>
        <small>Genera un nuevo reporte</small>
    </div>

    <div class="page-content">
        <div class="container" id="divFormReporte">
            <form id="reporteMensual" method="POST" class="popup-form">
                <div class="container">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>
                                    <label for="tipoReporte">Tipo de reporte</label>
                                </th>
                                <th>
                                    <label for="anio">Año</label>
                                </th>
                                <th>
                                    <label for="mes">Mes</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control" id="tipoReporte" name="tipoReporte" required data-error="Por favor seleccione un tipo de reporte válido.">
                                        <option value="">Seleccione el tipo de reporte*</option>
                                        <option value="1">Sólo estadísticas</option>
                                        <option value="2">Detallado</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="anio" name="anio" required data-error="Por favor seleccione un año válido.">
                                        <option value="">Seleccione el año*</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="mes" name="mes" required data-error="Por favor seleccione un mes válido.">
                                        <option value="">Seleccione el mes*</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="container">
                    <button type="submit" onclick="" class="btn btn-primary" id="btnReporte"><i class="las la-newspaper"></i>Generar reporte</button>
                </div>
            </form>
        </div>
    </div>
</main>