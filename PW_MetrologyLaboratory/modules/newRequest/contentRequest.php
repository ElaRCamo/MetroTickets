<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle">
            <h1> Solicitar una prueba </h1>
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
                                            <div class="form-group col-sm-6" id="selectTipoPrueba">
                                                <div class="help-block with-errors"></div>
                                                <select class="form-control" id="tipoPrueba" name="tiposPrueba" title="TipoDePrueba" required data-error="Por favor seleccione tipo de prueba" onchange="banderaTipoPrueba()">
                                                    <option value="" disabled selected>Seleccione el tipo de prueba</option>
                                                    <option value="universal">Pruebas con máquina universal</option>
                                                    <option value="FOAM">Pruebas-FOAM</option>
                                                    <option value="INSITU">Pruebas-INSITU</option>
                                                    <option value="durezaFOAM">Pruebas de dureza a FOAM</option>
                                                    <option value="durezaINSITU">Pruebas de dureza INSITU</option>
                                                    <option value="especiales">Pruebas especiales/otra</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-combined"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="div-OEM">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="OEM" placeholder="OEM" required data-error="Por favor ingresa OEM">
                                                <div class="input-group-icon"><i class="las la-screwdriver"></i></div>
                                            </div>


                                            <!-- Formulario dependiendo tipo de prueba -->

                                            <div class="form-group col-sm-6" id="normaNombre">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="norma" placeholder="Norma*" required data-error="Por favor ingresa la norma para realizar la prueba">
                                                <div class="input-group-icon"><i class="las la-certificate"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="normaArchivo">
                                                <div class="help-block with-errors"></div>
                                                <input type="file" class="form-control" id="normaFile" placeholder="Documento de la Norma " required data-error="Por favor ingresa la norma para realizar la prueba">
                                                <div class="input-group-icon"><i class="las la-file"></i></div>
                                            </div>

                                            <div class="form-group col-sm-12" id="pruebaEspecial">
                                                <div class="help-block with-errors pruebasEspeciales">
                                                    <h6>Seleccione el tipo de prueba especial*:</h6>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="extraccion" value="extraccion">
                                                        <label class="form-check-label" for="extraccion">Extraccion</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="compresion" value="compresion">
                                                        <label class="form-check-label" for="compresion">Compresion</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="desprendimiento" value="desprendimiento">
                                                        <label class="form-check-label" for="desprendimiento">Desprendimiento</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" id="otro" value="otro">
                                                        <label class="form-check-label" for="otro">Otro (especificar)</label>
                                                    </div>
                                                </div>
                                                <div class="input-group-icon"><i class="las la-ruler"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="otroTipoPrueba">
                                                <div class="help-block with-errors"></div>
                                                <input type="number" class="form-control" id="otroPrueba" placeholder="Especificar tipo de prueba*" required data-error="Por favor ingresa tipo de prueba">
                                                <div class="input-group-icon"><i class="las la-ruler-horizontal"></i></div>
                                            </div>

                                            <div class="form-group col-sm-6" id="numeroPiezas">
                                                <div class="help-block with-errors"></div>
                                                <input type="number" class="form-control" id="numPiezas" placeholder="Cantidad de piezas" required data-error="Por favor ingresa la cantidad de piezas">
                                                <div class="input-group-icon"><i class="las la-puzzle-piece"></i></div>
                                            </div>
                                            <div class="form-group col-sm-12" id="detallesPrueba">
                                                <div class="help-block with-errors"></div>
                                                <textarea type="text" class="form-control" id="especificaciones" placeholder="Especificaciones y detalles de la prueba*" required data-error="Por favor ingresa las especifícaciones de la prueba"></textarea>
                                                <div class="input-group-icon"><i class="las la-file-alt"></i></div>
                                            </div>

                                            <!-- Para agregar material por número de parte
                                            <div class=" col-sm-12 numerosPartes"> </div> -->
                                            <div class="col-sm-12" id="agregarNumParte">
                                                <h6>MATERIALES | Para agregar otro número de parte, presione
                                                    <button type="button" id="addNumParte" onclick="agregarNumParte()">
                                                        <i class="las la-plus-square"></i>
                                                    </button>
                                                </h6>
                                            </div>
                                            <div class="form-group col-sm-6" id="numeroParte">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="numParte" placeholder="Número de parte" required data-error="Por favor ingresa el número de parte">
                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="descripcionMaterial">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="descMaterial" placeholder="Descripcion del material" required data-error="Por favor ingresa la descripción del material">
                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" ID="plataformaDiv">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="plataforma" placeholder="Plataforma" required data-error="Por favor ingresa la plataforma">
                                                <div class="input-group-icon"><i class="las la-warehouse"></i></div>
                                            </div>
                                            <div class="form-group col-sm-6" id="cantidadMaterial">
                                                <div class="help-block with-errors"></div>
                                                <input type="number" class="form-control" id="cdadMaterial" placeholder="Cantidad"  required data-error="Por favor ingresa la cantidad">
                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                            </div>


                                            <div class="form-group last col-sm-12 buttons">
                                                <button type="button" id="submit" class="btn btn-custom"><i class='las la-paper-plane'></i> Enviar</button>
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




<!-- Intento de cargar archivos con label personalizada
    <div class="form-group col-sm-6">
        <div class="help-block with-errors"></div>
        <label for="normaFile" class="file-label">
            Seleccionar Archivo
            <input type="file" class="form-control" id="normaFile" required data-error="Por favor ingresa la norma para realizar la prueba">
        </label>
        <div class="input-group-icon"><i class="las la-file"></i></div>
    </div>
-->

<!--</div>-->

<!--<option value="full">Pruebas especiales / otra </option>-->
<!--<div id="especiales" class="row">-->
