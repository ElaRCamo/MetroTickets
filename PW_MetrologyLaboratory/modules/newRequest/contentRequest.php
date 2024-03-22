
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
                                        <div class="row">
                                            <div class="form-group col-sm-6" id="selectEvaluacion">
                                                <div class="help-block with-errors"></div>
                                                <select class="form-control" id="tipoEvaluacion" onchange="banderaTipoEvaluacion();  llenarTipoPrueba();" name="tiposEvaluaciones" title="TipoDeEvaluacion" required data-error="Por favor seleccione tipo de evaluacion" >
                                                    <option value="">Seleccione el tipo de evaluación*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-combined" onclick="obtenerNuevoId()"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="selectTipoPrueba">
                                                <div class="help-block with-errors"></div>
                                                <select class="form-control" id="tipoPrueba" onchange="banderaTipoPrueba()"  name="tiposPrueba" title="TipoDePrueba" required data-error="Por favor seleccione tipo de prueba" >
                                                    <option value="">Seleccione el tipo de prueba*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-combined"></i></div>
                                            </div>

                                            <!-- Formulario dependiendo tipo de prueba -->
                                            <div class="form-group col-sm-6" id="normaNombre">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="norma" onchange="llenarPruebaEspecial()" placeholder="Norma*" required data-error="Por favor ingresa la norma para realizar la prueba">
                                                <div class="input-group-icon"><i class="las la-certificate"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="normaArchivo">
                                                <div class="help-block with-errors"></div>
                                                <label for="normaFile" class="file-label">
                                                    Seleccione el documento de la norma
                                                    <input type="file" class="form-control" id="normaFile" name="normaFile" onchange="">
                                                </label>
                                                <div class="input-group-icon"><i class="las la-file"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6 " id="pruebaEspecial">
                                                    <select class="form-control" id="tipoPruebaEspecial" onchange="otroTipoPrueba()" name="tiposPruebaEspecial" title="TipoDePruebaEspecial" required data-error="Por favor seleccione tipo de prueba" >
                                                        <option value="" >Seleccione el tipo de prueba especial*</option>
                                                    </select>
                                                <div class="input-group-icon"><i class="las la-ruler"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="otroTipoPrueba">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="otroPrueba" placeholder="Especifique*" required data-error="Por favor especifique el tipo de prueba">
                                                <div class="input-group-icon"><i class="las la-ruler-horizontal"></i></div>
                                            </div>

                                            <div class="form-group col-sm-6" id="numeroPiezas">
                                                <div class="help-block with-errors"></div>
                                                <input type="number" class="form-control" id="numPiezas" placeholder="Cantidad de piezas*" required data-error="Por favor ingresa la cantidad de piezas">
                                                <div class="input-group-icon"><i class="las la-puzzle-piece"></i></div>
                                            </div>
                                            <div class="form-group col-sm-12" id="detallesPrueba">
                                                <div class="help-block with-errors"></div>
                                                <textarea type="text" class="form-control" id="especificaciones" placeholder="Especificaciones y detalles de la prueba*" required data-error="Por favor ingresa las especifícaciones de la prueba"></textarea>
                                                <div class="input-group-icon"><i class="las la-file-alt"></i></div>
                                            </div>

                                            <!-- Para agregar material por número de parte-->
                                            <div class=" form-group col-sm-12" id="agregarNumParte">
                                                <h6>REGISTRO DE MATERIALES | Para agregar otro número de parte, presione
                                                    <button type="button" id="addNumParte" onclick="agregarNumParte()">
                                                        <i class="las la-plus-square"></i>
                                                    </button>
                                                </h6>
                                            </div>
                                            <div class="form-group col-sm-4" id="numeroParte">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="numParte" name="numPartes[]"  onchange="llenarCliente()" placeholder="Número de parte*" required data-error="Por favor ingresa el número de parte">
                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                            </div>

                                            <div class="form-group col-sm-4" id="div-OEM">
                                                <div class="help-block with-errors" id="divError"></div>
                                                <select class="form-control" id="cliente" name="clientes[]" onchange="llenarPlataforma()" required data-error="Por favor ingresa el area solicitante">
                                                    <option value="">Seleccione el cliente (OEM)*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-screwdriver"></i></div>
                                            </div>
                                            <div class="form-group col-sm-4" id="plataformaDiv">
                                                <div class="help-block with-errors"></div>
                                                <select name="plataformas[]" class="form-control" id="plataforma" onchange="llenarDescMaterial()" required data-error="Por favor ingresa la plataforma">
                                                    <option value="">Seleccione la plataforma*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-warehouse"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="descripcionMaterial">
                                                <div class="help-block with-errors"></div>
                                                <select name="descripciones[]" class="form-control" id="descMaterial" onchange="descripcionMaterial()" required data-error="Por favor ingresa la descripción del material">
                                                    <option value="">Seleccione la descripción*</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="cantidadMaterial">
                                                <div class="help-block with-errors"></div>
                                                <input type="number" class="form-control" id="cdadMaterial" name="cdadesMaterial[]"  placeholder="Cantidad*"  required data-error="Por favor ingresa la cantidad">
                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                            </div>
                                            <div class="form-group col-sm-12 contenedorImg" id="imgMaterial">
                                                <img src="" class="imgsMaterial" id="imagenMaterial" alt="Imagen Material">
                                            </div>
                                            <div class="form-group last col-sm-12 buttons" >
                                                <button type="submit" id="submitRequest"  onclick="registrarSolicitud()" class="btn btn-custom"><i class='las la-paper-plane'></i> Enviar</button>
                                                <button type="reset" id="reset" class="btn btn-custom"><i class="las la-undo-alt"></i> Restaurar </button>
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
