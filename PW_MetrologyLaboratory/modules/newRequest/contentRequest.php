<main>
    <div class="page-header row headerLogo">
        <div class="col divTitle">
            <h1> Solicitar una prueba </h1>
            <small>Favor de registrar los datos siguientes:</small>
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
    <section id="request-form-section" class="form-content-wrap page-content">
        <div class=" container">
            <div class=" row">
                <div class="tab-content">
                    <div class="col-sm-12">
                        <div class="item-wrap">
                            <div class="row">
                                <div class="col-md-12">
                                    <form name="formNewRequest" action="" method="POST" id="formRequestLab" data-toggle="validator" class="popup-form">
                                        <div class="row">
                                            <div id="msgContactSubmit" class="hidden"></div>

                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="numParte" placeholder="Número de parte" required data-error="Por favor ingresa el número de parte">
                                                <div class="input-group-icon"><i class="las la-cog"></i></div>
                                            </div><!-- end form-group -->

                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="OEM" placeholder="OEM" required data-error="Por favor ingresa OEM">
                                                <div class="input-group-icon"><i class="las la-screwdriver"></i></div>
                                            </div><!-- end form-group -->

                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <input type="text" class="form-control" id="plataforma" placeholder="Plataforma" required data-error="Por favor ingresa la plataforma">
                                                <div class="input-group-icon"><i class="las la-warehouse"></i></div>
                                            </div><!-- end form-group -->

                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <select class="form-control" id="tipoPrueba" name="tiposPrueba" title="TipoDePrueba" required data-error="Por favor seleccione tipo de prueba">
                                                    <option value="" disabled selected>Seleccione el tipo de prueba</option>
                                                    <option value="dimensional">Dimensional</option>
                                                    <option value="full">Full</option>
                                                    <option value="maquinaUniversal">Máquina Universal</option>
                                                </select>
                                                <div class="input-group-icon"><i class="las la-ruler-combined"></i></div>
                                            </div><!-- end form-group -->

                                            <!-- Formulario dependiendo tipo de prueba -->
                                            <div id="dimensionalFields" class="form-group col-sm-12" style="display: none;">
                                                <div class="help-block with-errors"></div>
                                                <textarea rows="3" name="campoDimensional" id="campoDimensional" placeholder="Observaciones Dimensional*" class="form-control" required data-error="Por favor ingresa tus observaciones"></textarea>
                                                <div class="textarea las la-clipboard-check"><i class="fa fa-pencil"></i></div>
                                            </div>

                                            <div id="fullFields" class="form-group" style="display: none;">
                                                <textarea rows="3" name="campoFull" id="campoFull" placeholder="Observaciones Full*" class="form-control" required data-error="Por favor ingresa tus observaciones"></textarea>
                                                <div class="textarea las la-clipboard-check"><i class="fa fa-pencil"></i></div>
                                            </div>

                                            <div id="maquinaUniversalFields" class="form-group" style="display: none;">
                                                <textarea rows="3" name="campoMaquinaUniversal" id="campoMaquinaUniversal" placeholder="Observaciones Máquina Universal*" class="form-control" required data-error="Por favor ingresa tus observaciones"></textarea>
                                                <div class="textarea las la-clipboard-check"><i class="fa fa-pencil"></i></div>
                                            </div>

                                            <div class="form-group last col-sm-12">
                                                <button type="button" id="submit" class="btn btn-custom"><i class='las la-paper-plane'></i> Enviar</button>
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