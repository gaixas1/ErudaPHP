
<div class="bloques">
    <section class="bloque">
    <h1>Descargas <?php echo $model->get_data('tipo'); ?></h1>
        <a class="alllink"  href="<?php echo $model->get_data('tipo'); ?>/new/">Nueva descarga</a>
        <br/>    
        <h2>Novedades</h2>
        <div class="bigmsg">
            <?php
                /*Descargas*/
            foreach($model->get_data('descargas') as $descarga)
            {
            ?>
            <article><a class="alllink"  href="<?php echo $model->get_data('tipo'); ?>/<?php echo $descarga->get_id(); ?>/"><?php echo $descarga->get_description(); ?></a></article>
            <?php
            }
            ?>
        </div>
    </section>
    <section class="bloque">
        <h1>Series <?php echo $model->get_data('tipo'); ?></h1>
        <div class="bigmsg">
            <?php
                /*Series*/
            foreach($model->get_data('series') as $serie)
            {
            ?>
            <article><a class="alllink"  href="<?php echo $model->get_data('tipo'); ?>/serie/<?php echo $serie->get_id(); ?>/"><?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?></a></article>
            <?php
            }
            ?>
            <form action="" method="post" accept-charset="utf-8">
                <div class="value_semi">
                    <span class="subt">Nueva:</span><br/>
                    <input type="text" name="title" value="" />
                </div>
                <div class="value_semi">
                    <input type="submit" value="Nueva serie" />
                </div> 
            </form>
        </div>
    </section>
</div>