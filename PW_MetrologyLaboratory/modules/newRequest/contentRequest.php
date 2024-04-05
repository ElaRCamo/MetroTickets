
<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle">
            <h1> Solicitar una prueba </h1>
            <h5>Bienvenido(a) <?php echo $nombreUser; ?></h5><input type="hidden" id="idUsuario" value="<?php echo $idUsuario; ?>">
            <small>Favor de registrar los datos siguientes:</small>
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
                                            <div class="form-group col-sm-6" id="selectEvaluacion">
                                                <div class="help-block with-errors"></div>
                                                <select class="form-control" id="tipoEvaluacion" onchange="banderaTipoEvaluacion();  llenarTipoPrueba();" name="tiposEvaluaciones" title="TipoDeEvaluacion" required data-error="Por favor seleccione tipo de evaluacion" >
                                                    <option value="">Seleccione el tipo de evaluación*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-combined" onclick="obtenerNuevoId()"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="selectTipoPrueba">
                                                <div class="help-block with-errors"></div>
                                                <select class="form-control" id="tipoPrueba" onchange="banderaTipoPrueba(); llenarCliente(1);"  name="tiposPrueba" title="TipoDePrueba" required data-error="Por favor seleccione tipo de prueba" >
                                                    <option value="">Seleccione el tipo de prueba*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-combined"></i></div>
                                            </div>

                                            <!-- Formulario dependiendo tipo de prueba -->
                                            <div class="form-group col-sm-6" id="normaNombre">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="norma" onchange="llenarPruebaEspecial();" placeholder="Norma*" required data-error="Por favor ingresa la norma para realizar la prueba">
                                                <div class="input-group-icon"><i class="las la-certificate"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="normaArchivo">
                                                <div class="help-block with-errors"></div>
                                                    <input type="file" placeholder="Seleccione el documento de la norma" class="form-control" id="normaFile" name="normaFile">
                                                <div class="input-group-icon"><i class="las la-file"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6 " id="pruebaEspecial">
                                                    <select class="form-control" id="tipoPruebaEspecial" name="tipoPruebaEspecial" onchange="otroTipoPrueba()" title="TipoDePruebaEspecial" required data-error="Por favor seleccione tipo de prueba" >
                                                        <option value="" >Seleccione el tipo de prueba especial*</option>
                                                    </select>
                                                <div class="input-group-icon"><i class="las la-ruler"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="otroTipoPrueba">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="otroPrueba" placeholder="Especifique*" required data-error="Por favor especifique el tipo de prueba">
                                                <div class="input-group-icon"><i class="las la-ruler-horizontal"></i></div>
                                            </div>
                                            <!-- Para agregar material por número de parte-->
                                            <div class=" form-group col-sm-12" id="agregarNumParte">
                                                <h6>REGISTRO DE MATERIALES | Para agregar otro número de parte, presione
                                                    <button type="button" id="addNumParte1" >
                                                        <i class="las la-plus-square"></i>
                                                    </button>
                                                </h6>
                                            </div>
                                            <div class="row row-cols-xl-2 clearfix" id="newRow1">
                                                <div class="col-xl-8">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="div-OEM1">
                                                                <div class="help-block with-errors" id="divError1"></div>
                                                                <select id="cliente1" name="clientes[]" class="form-control"  onchange="llenarPlataforma(1)" required data-error="Por favor ingresa el area solicitante">
                                                                    <option value="">Seleccione el cliente (OEM)*</option>
                                                                </select>
                                                                <div class="input-group-icon"><i class="las la-screwdriver"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="plataformaDiv1">
                                                                <div class="help-block with-errors"></div>
                                                                <select id="plataforma1" name="plataformas[]" class="form-control"  onchange="llenarDescMaterial(1)" required data-error="Por favor ingresa la plataforma">
                                                                    <option value="">Seleccione la plataforma*</option>
                                                                </select>
                                                                <div class="input-group-icon"><i class="las la-warehouse"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="descripcionMaterial1">
                                                                <div class="help-block with-errors"></div>
                                                                <select id="descMaterial1" name="descripciones[]" class="form-control"  onchange="descripcionMaterial(1); numeroDeParte(1);" required data-error="Por favor ingresa la descripción del material">
                                                                    <option value="">Seleccione la descripción*</option>
                                                                </select>
                                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="numeroParte1">
                                                                <div class="help-block with-errors"></div>
                                                                <input id="numParte1" name="numPartes[]" type="text" class="form-control" placeholder="Número de parte*" required data-error="Por favor ingresa el número de parte" readonly>
                                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group" id="cantidadMaterial1">
                                                                <div class="help-block with-errors"></div>
                                                                <input id="cdadMaterial1" name="cdadesMaterial[]" type="number" class="form-control"  placeholder="Cantidad*" required data-error="Por favor ingresa la cantidad">
                                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 text-center" id="imgMaterial1">
                                                    <img src="" class="col-md-6 mb-3 ms-md-3 rounded img-fluid img-thumbnail" id="imagenMaterial1" alt="Imagen Material">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12" id="detallesPrueba">
                                            <div class="help-block with-errors"></div>
                                            <textarea type="text" class="form-control" id="especificaciones" placeholder="Especificaciones y detalles de la prueba*" required data-error="Por favor ingresa las especifícaciones de la prueba"></textarea>
                                            <div class="input-group-icon"><i class="las la-file-alt"></i></div>
                                        </div>
                                        <div class="form-group last col-sm-12 buttons" >
                                            <button type="submit" id="submitRequest"  onclick="registrarSolicitud()" class="btn btn-custom"><i class='las la-paper-plane'></i> Enviar</button>
                                            <button type="reset" id="reset" class="btn btn-custom"><i class="las la-undo-alt"></i> Restaurar </button>
                                            <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Open first modal</a>
                                        </div><!-- end form-group -->
                                        <div class="sub-text">* Campos requeridos</div>
                                        <div class="clearfix"></div>
                                        </div><!-- end row -->
                                    </form><!-- end form -->
                                </div>
                            </div><!--End row -->
                            <!-- Popup end -->
                        </div><!-- end item-wrap -->
                    </div><!--End col -->
                </div><!--End tab-content -->
            </div><!--End row -->
        </div><!--End container -->
    </section>
</main>

<!-- Modal 1 -->
<div class="modal fade modal-dialog modal-dialog-scrollable" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Resumen de Solicitud de Prueba Metrologica</h5>
                <!-- Mensaje de confirmación -->
                <small>Se ha enviado un mensaje de confirmación al correo electrónico asociado a su cuenta con la siguiente información:</small>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <p><strong>No. de solicitud:</strong> ?php echo $id_prueba; ?></p>
                <p><strong>Fecha de Solicitud:</strong> ?php echo $fechaSolicitud; ?></p>
                <p><strong>Solicitante:</strong> <?php echo $idUsuario; ?></p>
                <p><strong>Tipo de Prueba:</strong> ?php echo $tipoPrueba; ?></p>
                <p><strong>Observaciones:</strong> ?php echo $especificaciones; ?></p>
                <p><strong>Materiales a medir:</strong></p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    ?php for ($i = 0; $i < count($descMateriales); $i++) { ?>
                        <tr>
                            <td>?php echo $descMateriales[$i]; ?></td>
                            <td>?php echo $cdadMateriales[$i]; ?></td>
                        </tr>
                    ?php } ?>
                    </tbody>
                </table><br>

                <!-- Mensaje de espera -->
                <p>Por favor, espere a que su solicitud sea revisada y aprobada por nuestro equipo de laboratorio. Le notificaremos cualquier cambio en el estado de su solicitud. ¡Gracias por su paciencia y confianza en nuestros servicios!</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
    </div>
</div>
</div>





