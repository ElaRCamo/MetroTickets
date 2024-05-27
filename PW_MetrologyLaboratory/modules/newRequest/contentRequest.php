
<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle" id="divh1">
            <h1> Solicitar una prueba </h1>
            <input type="hidden" id="idUsuario" value="<?php global $idUsuario; echo $idUsuario; ?>">
            <?php global $tipoUser; if($tipoUser == 3){ ?><small> ¡Hola <?php global $nombreUser; echo $nombreUser; ?>! <span>Favor de registrar los datos siguientes para tu solicitud:<span/></small><?php }?>
            <?php if($tipoUser == 1 || $tipoUser == 2){ ?><h5> ¡Hola <?php global $nombreUser;echo $nombreUser; ?>! Te recordamos que tu perfil no permite registrar solicitudes. </h5><?php }?>
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
    <section id="request-form-section" class="form-content-wrap page-content">
        <div class=" container">
            <div class=" row">
                <div class="tab-content">
                    <div class="col-sm-12">
                        <div class="item-wrap">
                            <div class="row">
                                <div class="col-md-12">
                                    <form name="formNewRequest" action="" method="POST" enctype="multipart/form-data" id="formRequestLab" data-toggle="validator" class="popup-form">
                                        <div class="row" id="contenedorFormulario">
                                            <div class="form-group col-sm-12" id="divGenerales">
                                                <table class="table table-borderless" id="solicitudTitulo">
                                                    <tr>
                                                        <td class="tdH6">
                                                            <h6>DATOS GENERALES</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="form-group col-sm-6" id="selectEvaluacion">
                                                <select class="form-control" id="tipoEvaluacion" onchange="banderaTipoEvaluacion(); llenarTipoPrueba();" name="tiposEvaluaciones" title="TipoDeEvaluacion" required data-error="Por favor seleccione un tipo de evaluación válido.">
                                                    <option value="">Seleccione el tipo de evaluación*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-sitemap" onclick="obtenerNuevoId()"></i></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="selectTipoPrueba">
                                                <select class="form-control" id="tipoPrueba" onchange="banderaTipoPrueba(); llenarCliente(1);"  name="tiposPrueba" title="TipoDePrueba" required data-error="Por favor seleccione un tipo de prueba válido.">
                                                    <option value="">Seleccione el tipo de prueba*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-combined"></i></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="pruebaEspecial">
                                                <select class="form-control" id="tipoPruebaEspecial" name="tipoPruebaEspecial" onchange="otroTipoPrueba()" title="TipoDePruebaEspecial" data-error="Por favor seleccione un tipo de prueba válido.">
                                                    <option value="" >Seleccione el tipo de prueba especial*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-horizontal"></i></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="otroTipoPrueba">
                                                <input type="text" class="form-control" id="otroPrueba" placeholder="Especifique*" data-error="Por favor indique tipo de prueba.">
                                                <div class="input-group-icon"><i class="las la-search"></i></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <!-- Formulario dependiendo tipo de prueba -->
                                            <div class="form-group col-sm-6" id="normaNombre">
                                                <input type="text" class="form-control" id="norma" placeholder="Norma*" data-error="Por favor indique la norma.">
                                                <div class="input-group-icon"><i class="las la-certificate"></i></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="normaArchivo">
                                                    <input type="file" placeholder="Seleccione el documento de la norma" class="form-control" id="normaFile" name="normaFile" data-error="Por favor seleccione el archivo de la norma">
                                                <div class="input-group-icon"><i class="las la-file-pdf"></i></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-sm-12" id="detallesPrueba">
                                                <textarea type="text" class="form-control" id="especificaciones" placeholder="Especificaciones y detalles de la prueba*" required data-error="Por favor ingresa las especifícaciones de la prueba"></textarea>
                                                <div class="input-group-icon"><i class="las la-file-alt"></i></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <!-- Para agregar material por número de parte-->
                                            <div class="form-group col-sm-12" id="agregarNumParte">
                                                <table class="table table-borderless" id="materialesTitulo">
                                                    <tr>
                                                        <td class="tdH6">
                                                            <h6>REGISTRO DE MATERIALES</h6>
                                                        </td>
                                                        <td class="tdButton">
                                                            <button type="button" id="addNumParte1"><i class="las la-plus-square"></i>Agregar material</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row row-cols-xl-2 clearfix" id="newRow1">
                                                <div class="col-xl-8">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="div-OEM1">
                                                                <select id="cliente1" name="clientes[]" class="form-control"  onchange="llenarPlataforma(1)" required data-error="Por favor ingresa el area solicitante">
                                                                    <option value="">Seleccione el cliente (OEM)*</option>
                                                                </select>
                                                                <div class="input-group-icon"><i class="las la-car"></i></div>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="plataformaDiv1">
                                                                <select id="plataforma1" name="plataformas[]" class="form-control"  onchange="llenarDescMaterial(1)" required data-error="Por favor ingresa la plataforma">
                                                                    <option value="">Seleccione la plataforma*</option>
                                                                </select>
                                                                <div class="input-group-icon"><i class="las la-warehouse"></i></div>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="descripcionMaterial1">
                                                                <select id="descMaterial1" name="descripciones[]" class="form-control"  onchange="descripcionMaterial(1); numeroDeParte(1);" required data-error="Por favor ingresa la descripción del material">
                                                                    <option value="">Seleccione la descripción*</option>
                                                                </select>
                                                                <div class="input-group-icon"><i class="las la-eye"></i></div>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="cantidadMaterial1">
                                                                <input id="cdadMaterial1" name="cdadesMaterial[]" type="number" class="form-control"  placeholder="Cantidad*" required data-error="Por favor ingresa la cantidad">
                                                                <div class="input-group-icon"><i class="las la-cubes"></i></div>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 text-center row" id="imgMaterial1">
                                                    <div class="col">
                                                        <img src="" class="rounded img-fluid img-thumbnail" id="imagenMaterial1" alt="Imagen Material">
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group" id="numeroParte1">
                                                            <input id="numParte1" name="numPartes[]" type="text" class="numParteInput" placeholder="Número de parte*" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group last col-sm-12 buttons" >
                                            <button type="button" id="submitRequest"  class="btn btn-custom" onclick="validarFormNewRequest()"><i class='las la-paper-plane'></i>Enviar</button>
                                            <button type="button" id="updateRequest"  class="btn btn-custom" onclick="validarFormNewRequest()"><i class="las la-save" ></i>Guardar cambios</button>
                                            <button type="reset" id="reset" class="btn btn-custom"><i class="las la-undo-alt"></i> Restaurar </button>
                                        </div><!-- end form-group -->
                                        <div class="sub-text">*Campos requeridos</div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- end item-wrap -->
                    </div><!--End col -->
                </div><!--End tab-content -->
            </div><!--End row -->
        </div><!--End container -->
    </section>


    <!-- Modal RequestReview-->
    <div class="modal fade container-fluid" id="RequestReview" aria-hidden="true" aria-labelledby="titleResumenMain" tabindex="-1">
        <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleResumenMain">Resumen de Solicitud de Prueba Metrológica</h5><br>
                    <button type="button" class="btn-close" id="btnClose" data-bs-dismiss="modal" onclick="redirectToRequestsIndex()" aria-label="Close"></button>
                </div>

                <div class="modal-body row">
                    <!-- Mensaje de confirmación -->
                    <small>   Se ha enviado un mensaje de confirmación al correo electrónico asociado a tu cuenta con la siguiente información:</small><br>
                    <div class="col p-3 ">
                        <p><strong>No. de solicitud:       </strong><span id="solicitudNumero"></span></p>
                        <p><strong>Estatus de la solicitud:</strong><span id="estatusSolicitud"></p>
                        <p><strong>Tipo de Prueba:         </strong><span id="tipoPruebaSolicitud"></span></p>
                        <p class="resumenHidden"><strong>Norma:                  </strong><span id="normaNombreSol"></span></p>
                    </div>
                    <div class="col p-3 ">
                        <p><strong>Fecha de Solicitud:     </strong><span id="fechaSolicitud"></span></p>
                        <p><strong>Solicitante:            </strong><span id="solicitante"></span></p>
                        <p><strong>Observaciones:          </strong><span class="obs" id="observacionesSolicitud"></span></p>
                        <p class="resumenHidden"><strong>Documento de la norma:  </strong><span ><a id="archivoNormaSol" href="">Archivo pdf</a></span></p><br>
                    </div>
                    <div class="">

                    </div>
                    <div class="row">
                        <div id="divTableSol">
                            <h5 id="titleResumen">MATERIAL PARA MEDICIÓN</h5>
                            <div id="divTableSol2">
                                <table class="table table-striped table-responsive" id="materialesSolicitud">
                                    <thead>
                                    <tr>
                                        <th>No. de Parte</th>
                                        <th>Material</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje de espera -->
                    <br><small>Por favor, espera a que tu solicitud sea revisada y aprobada por nuestro equipo de laboratorio. Te notificaremos cualquier cambio en el estado de tu solicitud. ¡Gracias por tu paciencia y confianza en nuestros servicios!</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="redirectToRequestsIndex()">Close</button>
                    <button type="button" class="btn btn-secondary" onclick="reviewPDF(id_review)">Descargar solicitud en pdf</button>
                </div>
            </div>
        </div>
    </div>
</main>






