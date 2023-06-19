<?php
    include_once __DIR__ . '/conciertos.php';
?>
<section class="resumen">
    <div class="resumen__grid">
        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $cantantes_total; ?></p>
            <p class="resumen__texto">Cantantes</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $conciertos_total; ?></p>
            <p class="resumen__texto">Conciertos</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $festivales_total; ?></p>
            <p class="resumen__texto">Festivales</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero">+5000</p>
            <p class="resumen__texto">Asistentes</p>
        </div>
    </div>
</section>

<section class="cantantee">
    <h2 class="cantantee__heading">Cantantes</h2>
    <p class="cantantee__descripcion">Conoce a nuestros cantantes en Boletomania</p>

    <div class="cantantee__grid">
        <?php foreach($cantantes as $cantante) { ?>
            <div <?php aos_animacion(); ?> class="cantantee">
                <picture>
                    <source srcset="img/cantantes/<?php echo $cantante->imagen; ?>.webp" type="image/webp">
                    <source srcset="img/cantantes/<?php echo $cantante->imagen; ?>.png" type="image/png">
                    <img class="cantantee__imagen" loading="lazy" width="200" height="300" src="img/cantantes/<?php echo $cantante->imagen; ?>.png" alt="Imagen Cantante">
                </picture>

                <div class="cantantee__informacion">
                    <h4 class="cantantee__nombre">
                        <?php echo $cantante->nombre; ?>
                    </h4>

                    <p class="cantantee__ubicacion">
                        <?php echo $cantante->ciudad . ', ' . $cantante->pais; ?>
                    </p>

                    <nav class="cantantee-sociales">
                        <?php
                            $redes =  json_decode( $cantante->redes );
                        ?>
                        
                        <?php if(!empty($redes->twitter)) { ?>
                            <a class="cantantee-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->twitter; ?>">
                                <span class="cantantee-sociales__ocultar">Facebook</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->twitter)) { ?>
                            <a class="cantantee-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->twitter; ?>">
                                <span class="cantantee-sociales__ocultar">Twitter</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->youtube)) { ?>
                            <a class="cantantee-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->youtube; ?>">
                                <span class="cantantee-sociales__ocultar">YouTube</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->instagram)) { ?>
                            <a class="cantantee-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->instagram; ?>">
                                <span class="cantantee-sociales__ocultar">Instagram</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->tiktok)) { ?>
                            <a class="cantantee-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->tiktok; ?>">
                                <span class="cantantee-sociales__ocultar">Tiktok</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->github)) { ?>
                            <a class="cantantee-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->github; ?>">
                                <span class="cantantee-sociales__ocultar">Github</span>
                            </a>
                        <?php } ?> 
                    </nav>

                    <ul class="cantantee__listado-skills">
                        <?php 
                            $tags = explode(',', $cantante->tags);
                            foreach($tags as $tag) { 
                        ?>
                            <li class="cantantee__skill"><?php echo $tag; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div id="mapa" class="mapa"></div>

<section class="boletos">
    <h2 class="boletos__heading">Boletos & Precios</h2>
    <p class="boletos__descripcion">Precios para Boletomania</p>

    <div class="boletos__grid">
        <div <?php aos_animacion(); ?> class="boleto boleto--vip">
            <h4 class="boleto__logo">Boletomania</h4>
            <p class="boleto__plan">Vip</p>
            <p class="boleto__precio">$199</p>
        </div>

        <div <?php aos_animacion(); ?> class="boleto boleto--general">
            <h4 class="boleto__logo">Boletomania</h4>
            <p class="boleto__plan">General</p>
            <p class="boleto__precio">$49</p>
        </div>

        <div class="boleto boleto--gratis">
            <h4 class="boleto__logo">Boletomania</h4>
            <p class="boleto__plan">Gratis</p>
            <p class="boleto__precio">Gratis - $0</p>
        </div>
    </div>

    <div class="boleto__enlace-contenedor">
        <a href="/paquetes" class="boleto__enlace">Ver Paquetes</a>
    </div>
</section>