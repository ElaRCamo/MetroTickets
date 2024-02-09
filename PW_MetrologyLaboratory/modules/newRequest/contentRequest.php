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

    <!--
    <div class="page-content">
        <div class="row container ">
            <form name="formNewRequest" action="" method="POST">

                <div class="col-md-6 requestDiv">
                    <div class="form-group">
                        <label for="numParte">Número de parte </label>
                        <input type="text" class="form-control" id="numParte" placeholder="Número de parte">
                    </div>
                    <div class="form-group">
                        <label for="OEM">OEM</label>
                        <input type="text" class="form-control" id="OEM" placeholder="OEM">
                    </div>
                    <div class="form-group">
                        <label for="plataforma">Plataforma</label>
                        <input type="text" class="form-control" id="plataforma" placeholder="Plataforma">
                    </div>
                    <div class="form-group">
                        <label for="tipoPrueba">Tipo de prueba</label>
                        <select class="form-control" id="tipoPrueba" name="tiposPrueba">
                            <option value="" disabled selected>Seleccione el tipo de prueba</option>
                            <option value="dimensional">Dimensional</option>
                            <option value="full">Full</option>
                            <option value="maquinaUniversal">Máquina Universal</option>
                        </select>
                    </div>


                    <div id="dimensionalFields" class="form-group" style="display: none;">
                        <label for="campoDimensional">Campo Dimensional</label>
                        <input type="text" class="form-control" id="campoDimensional" name="campoDimensional">
                    </div>

                    <div id="fullFields" class="form-group" style="display: none;">
                        <label for="campoFull">Campo Full</label>
                        <input type="text" class="form-control" id="campoFull" name="campoFull">
                    </div>

                    <div id="maquinaUniversalFields" class="form-group" style="display: none;">
                        <label for="campoMaquinaUniversal">Campo Máquina Universal</label>
                        <input type="text" class="form-control" id="campoMaquinaUniversal" name="campoMaquinaUniversal">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                <div class="col-md-3">
                </div>
            </form>
        </div>
    </div>  -->
    <section id="contact-form-section" class="form-content-wrap">
        <div class="container">
            <div class="row">
                <div class="tab-content">
                    <div class="col-sm-12">
                        <div class="item-wrap">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="contactForm" name="contactform" data-toggle="validator" class="popup-form">
                                        <div class="row">
                                            <div id="msgContactSubmit" class="hidden"></div>

                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <input name="fname" id="fname" placeholder="Tu nombre*" class="form-control" type="text" required data-error="Por favor ingresa tu nombre">
                                                <div class="input-group-icon"><i class="fa fa-user"></i></div>
                                            </div><!-- end form-group -->
                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <input name="email" id="email" placeholder="Tu E-mail*" pattern=".*@\w{2,}\.\w{2,}" class="form-control" type="email" required data-error="Por favor ingresa un correo electrónico válido">
                                                <div class="input-group-icon"><i class="fa fa-envelope"></i></div>
                                            </div><!-- end form-group -->
                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <input name="phone" id="phone" placeholder="Teléfono*" class="form-control" type="text" required data-error="Por favor ingresa tu número de teléfono">
                                                <div class="input-group-icon"><i class="fa fa-phone"></i></div>
                                            </div><!-- end form-group -->
                                            <div class="form-group col-sm-6">
                                                <div class="help-block with-errors"></div>
                                                <input name="subject" id="subject" placeholder="Asunto*" class="form-control" type="text" required data-error="Por favor ingresa el asunto">
                                                <div class="input-group-icon"><i class="fa fa-book"></i></div>
                                            </div><!-- end form-group -->
                                            <div class="form-group col-sm-12">
                                                <div class="help-block with-errors"></div>
                                                <textarea rows="3" name="message" id="message" placeholder="Escribe tu comentario aquí*" class="form-control" required data-error="Por favor ingresa un mensaje"></textarea>
                                                <div class="textarea input-group-icon"><i class="fa fa-pencil"></i></div>
                                            </div><!-- end form-group -->
                                            <div class="form-group last col-sm-12">
                                                <button type="submit" id="submit" class="btn btn-custom"><i class='fa fa-envelope'></i> Enviar</button>
                                            </div><!-- end form-group -->

                                            <span class="sub-text">* Campos requeridos</span>
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