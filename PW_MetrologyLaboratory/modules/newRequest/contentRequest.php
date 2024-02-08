<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle">
            <h1> Nueva Solicitud </h1>
            <small>Favor de registrar los datos para la nueva solicitud</small>
        </div>
        <div class="logoRight col-sm-3">
            <div>
                <img class="logoGrammer2-img logoR img-responsive" alt="LogoGrammer" src="\MetrologyLaboratory\PW_MetrologyLaboratory\imgs\logoGrammer.png"><br>
            </div>
            <div>
                <span><small>GRAMMER AUTOMOTIVE PUEBLA S. A. DE C. V.</small></span>
            </div>
        </div>
    </div>

    <div class="page-content table-responsive-sm newRequestTabla">
        <div class="container-fluid table-responsive">
            <form name="formNewRequest" action="" method="POST">
                <table class="table table-borderless tableOpe table-responsive">
                    <!--Fila uno-->
                    <thead>
                        <tr class="table-borderless">
                            <th>
                                <div class="form-group">
                                    <label for="folio">FOLIO:<br>
                                        <input type="number" class="form-control" id="idFolio" name="Folio" placeholder="6097" readonly>
                                    </label>
                                </div>
                            </th>
                            <th>
                                <div class="form-group">
                                    <label for="fecha">FECHA:
                                        <input type="date" class="form-control" id="idfecha" name="fecha" readonly>
                                    </label>
                                </div>
                            </th>
                            <th>
                                <div class="form-group">
                                    <label for="solicitante">SOLICITADO POR:
                                        <input type="text" class="form-control" id="idSolicitante" name="solicitante" placeholder="Aracely" readonly>
                                    </label>
                                </div>
                            </th>
                            <th>
                                <div class="form-group">
                                    <label for="turno">TURNO:
                                        <input type="text" class="form-control" id="idTurno" name="turno" placeholder="1°" readonly>
                                    </label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <!--Fila dos-->
                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="area">ÁREA/DEPTO:
                                    <input type="text" class="form-control" id="idArea" name="area" required>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="linea">LÍNEA:<br>
                                    <input type="text" class="form-control" id="idLinea" name="linea" required>
                                </label>

                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="estacion">ESTACIÓN:
                                    <input type="text" class="form-control" id="idEstacion" name="estacion" required>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="mantenimiento">MANTENIMIENTO:<br>
                                    <input type="radio" name="mantenimiento" value="correctivo" required>Correctivo
                                    <input type="radio" name="mantenimiento" value="preventivo" required>Preventivo
                                </label>
                            </div>
                        </td>
                    </tr>
                    <!--Fila tres-->
                    <tr>
                        <td colspan="3" >
                            <div class="form-group">
                                <label for="problema">DESCRIPCIÓN DEL PROBLEMA/TRABAJO:
                                    <input type="text" class="form-control" id="idProblema" name="problema" required>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="maquina">ESTATUS MÁQUINA:<br>
                                    <input type="radio" name="maquina" value="trabaja" required>Trabaja
                                    <input type="radio" name="maquina" value="noTrabaja" required>No trabaja
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="div-button">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="confirmarInfo">
                        <label class="form-check-label" for="confirmarInfo">Confirmo que la información es correcta</label>
                    </div>
                    <br><button type="submit" class="btn btn-primary">Generar Solicitud</button>
                </div>
            </form>
            <div class="col">
                <h6>La siguiente información es llenada por el técnico</h6>
            </div>
            <form name="formNewRequest" action="" method="POST">
                <table class="table table-borderless tableTec">
                    <!--Fila uno-->
                    <tr>
                        <td >
                            <div class="form-group">
                                <label for="ejecutadoPor">EJECUTADO POR EL TÉCNICO:
                                    <input type="text" class="form-control" id="idEjecutadoPor" name="ejecutadoPor" placeholder="Cristopher Mtz." readonly>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="horaRecibo">HORA RECIBO:
                                    <input type="time" class="form-control" id="idHoraRecibo" name="horaRecibo" readonly>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="afectados">OPERADORES AFECTADOS:
                                    <input type="number" class="form-control" id="idAfectados" name="afectados">
                                </label>
                            </div>
                        </td>
                    </tr>
                    <!--Fila dos-->
                    <tr>
                        <td colspan="2" >
                            <div class="form-group">
                                <label for="diagnostico">DIAGNÓSTICO/TRABAJO REALIZADO:
                                    <input type="text" class="form-control" id="idDiagnostico" name="diagnostico" required>
                                </label>
                            </div>
                        </td>
                        <td rowspan="2">
                            <div class="form-group">
                                <label for="obsTecnico">OBSERVACIONES:
                                    <input type="text" class="form-control" id="idObsTecnico" name="obsTecnico" required>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <!--Fila tres-->
                    <tr>
                        <td colspan="2">
                            <div class="form-group">
                                <label for="causa">CAUSA RAÍZ:
                                    <input type="text" class="form-control" id="idCausa" name="causa" required>
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="div-button">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="confirmarInfo">
                        <label class="form-check-label" for="confirmarInfo">Confirmo que la información es correcta</label>
                    </div>
                    <br><button type="submit" class="btn btn-primary">Registrar Solitud</button>
                </div>
            </form>

            <form name="formNewRequestCierre" action="" method="POST">
                <div class="col">
                    <h6>Favor de registrar el cierre de la solicitud.</h6>
                </div>
                <table class="table table-borderless tableTec">
                    <tr>
                        <td colspan="2">
                            <div class="form-group">
                                <label for="aprobadoPor">RECIBIDO Y APROBADO POR:
                                    <input type="text" class="form-control" id="idAprobadoPor" name="aprobadoPor" placeholder="Aracely" readonly>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="calificacion">CALIFICACIÓN DE TRABAJO RECIBIDO:<br>
                                    <input type="radio" name="calificacion" value="excelente" required>Excelente
                                    <input type="radio" name="calificacion" value="aceptable" required>Aceptable
                                    <input type="radio" name="calificacion" value="noConforme" required>No conforme
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="observadciones">OBSERVACIONES:<br>
                                    <input type="text" class="form-control" id="idObservaciones" name="observadciones" required>
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="div-button">
                    <br><button type="submit" class="btn btn-primary">Cerrar Solitud</button>
                </div>
            </form>
        </div>
    </div>
</main>