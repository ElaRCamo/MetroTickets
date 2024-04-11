<div class="main-content">
    <header>
        <div class="header-content">
            <label for="menu-toggle">
                <span class="las la-bars"></span>
            </label>
            <div class="header-menu">
                    <!--<span class="las la-search"></span>
                <div class="notify-icon">
                    <span class="las la-bell"></span>
                    <span class="notify">3</span>
                </div>-->
                <div class="userDiv">
                    <?php global $nombreUser; echo '<input type="text" id="nombreUser" value="' . $nombreUser . '">'; ?>
                </div>
                <div class="user">
                    <div><img class="user-img bg-img" alt="User" src="<?php global $fotoUsuario; echo $fotoUsuario; ?>"></div>
                </div>
                <div class="bg-img" id="cerrarS">
                    <span class="las la-power-off"></span>
                </div>
            </div>
        </div>
    </header>