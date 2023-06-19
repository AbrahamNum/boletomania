<!-- BLOQUE PRINCIPAL CONTIENE LA IMAGEN-->
<header class="header">
    <!-- CENTRAR EL CONTENIDO-->
    <div class="header__contenedor">
        <nav class="header__navegacion">

        <?php if(is_auth()) { ?>
                <a href="<?php echo is_admin() ? '/admin/dashboard' : '/finalizar-registro'; ?>" class="header__enlace">Administrar</a>
                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php } else {  ?>

            <a href="/registro" class="header__enlace">Registro</a>
            <a href="/login" class="header__enlace">Iniciar Sesión</a>
            <?php } ?>
        </nav>
        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">BOLETOMANIA</h1>
            </a>
            <p class="header__texto">Venta de Boletos</p>
            <p class="header__texto header__texto--modalidad">En Linea</p>
            <a href="/registro" class="header__boton">Comprar Boletos</a>
         </div>
    </div>    
</header>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">BOLETOMANIA</h2>
        </a>
        <nav class="navegacion">
            <a class="navegacion__enlace <?php echo pagina_actual('/boletomania') ? 'navegacion__enlace--actual' : ''; ?>" href="/boletomania">Nosotros</a>
            <a class="navegacion__enlace <?php echo pagina_actual('/paquetes') ? 'navegacion__enlace--actual' : ''; ?>" href="/paquetes">Paquetes</a>
            <a class="navegacion__enlace <?php echo pagina_actual('/conciertos') ? 'navegacion__enlace--actual' : ''; ?>" href="/conciertos">Conciertos/Festivales</a>
            <a class="navegacion__enlace <?php echo pagina_actual('/registros') ? 'navegacion__enlace--actual' : ''; ?>" href="/registro">Comprar Boletos</a>
        </nav>
    </div>
</div> 