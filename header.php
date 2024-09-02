
<input type="checkbox" id="menu-toggle" title="visibilidadMenu">
<div class="sidebar">
    <div class="side-header">
        <div><img class="logoGrammer-img bg-img" alt="LogoGrammer" src="https://grammermx.com/Metrologia/MetroTickets/imgs\Grammer_Logo.ico"></div>
    </div>

    <div class="side-content">
        <div class="profile">
            <span><img class="logoGrammer2-img img-responsive" alt="LogoGrammer" src="https://grammermx.com/Metrologia/MetroTickets/imgs\logoGrammer.png"></span>
        </div>
        <div class="side-menu" id="menuLateral">
            <ul >
                <li>
                    <a href="https://grammermx.com/Metrologia/MetroTickets/index.php" class="optionMenu">
                        <span class="las la-home"></span>
                        <small>Inicio</small>
                    </a>
                </li>

                <li>
                    <a href="https://grammermx.com/Metrologia/MetroTickets/modules\newRequest\newRequestIndex.php" class="optionMenu">
                        <span class="lar la-edit"></span>
                        <small>Nueva solicitud</small>
                    </a>
                </li>
                <li>
                    <a href="https://grammermx.com/Metrologia/MetroTickets/modules\requests\requestsIndex.php" class="optionMenu">
                        <span class="las la-list-ol"></span>
                        <small>Solicitudes</small>
                    </a>
                </li>
                <?php if($tipoUser == 1 ){ ?>
                <li>
                    <a href="https://grammermx.com/Metrologia/MetroTickets/modules/reports/reportsIndex.php" class="optionMenu">
                        <span class="las la-book"></span>
                        <small>Generar reporte</small>
                    </a>
                </li>
                <?php }?>
                <?php if($tipoUser == 1 || $tipoUser == 2){ ?>
                <li>
                    <a href="https://grammermx.com/Metrologia/MetroTickets/modules\administrator\administratorIndex.php" class="optionMenu">
                        <span class="las la-cog"></span>
                        <small>Administrar</small>
                    </a>
                </li>
                <?php }?>
                <li>
                    <a class="optionMenu" id="cerrarSesion">
                        <span class="las la-power-off"></span>
                        <small>Cerrar sesión</small>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    document.getElementById("cerrarSesion").addEventListener("click", function (event) {
        event.preventDefault();
        cerrarSesion();
    });
</script>