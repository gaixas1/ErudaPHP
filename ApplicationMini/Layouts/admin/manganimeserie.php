<?php
$serie = $model->get_data('serie');
?>
<div class="bloques">
    <section class="bloque">
        <h1><?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?></h1>
        <div class="bigmsg">
            <?php
                /*Descargas*/
            switch($model->get_data('tipo'))
            {
                case 'manga':
            ?>
            <article><a class="alllink"  href="/manga/<?php echo Eruda_Helper_Parser::Text2Link($serie->get_serie()) ?>/"><?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?></a></article>
            <?php
                    foreach($serie->get_tomos() as $tomo) {
            ?>
            <article><a class="alllink"  href="/manga/<?php echo Eruda_Helper_Parser::Text2Link($serie->get_serie()) ?>/<?php echo Eruda_Helper_Parser::Text2Link($tomo) ?>/">- <?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?> :: <?php echo Eruda_Helper_Parser::Link2Text($tomo) ?></a></article>
            <?php
                    }
                    break;
                    case 'anime':
            ?>
            <article><a class="alllink"  href="/anime/<?php echo Eruda_Helper_Parser::Text2Link($serie->get_serie()) ?>/"><?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?></a></article>
            <?php
                    foreach($serie->get_cont() as $cont) {
            ?>
            <article><a class="alllink"  href="/anime/<?php echo Eruda_Helper_Parser::Text2Link($serie->get_serie()) ?>/<?php echo Eruda_Helper_Parser::Text2Link($cont) ?>/">- <?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?> :: <?php echo Eruda_Helper_Parser::Link2Text($cont) ?></a></article>
            <?php
                    }
                    break;
            }
            ?>
        </div>
    </section>
    <section class="bloque">
        <div class="bigmsg">
            <form action="" method="post" accept-charset="utf-8">
                <div class="value_semi">
                    <span class="subt">Serie:</span><br/>
                    <input type="text" name="title" value="<?php echo $serie->get_serie();?>" />
                </div>
                
            <?php
                /*Descargas*/
            switch($model->get_data('tipo'))
            {
                case 'manga':
            ?>
                <div class="value_semi">
                    <span class="subt">Tomos:</span><br/>
                    <input type="text" name="tomos" value="<?php echo implode(',',$serie->get_tomos());?>" />
                </div>
            <?php
                    break;
                    case 'anime':
                        
            ?>
                <div class="value_semi">
                    <span class="subt">Contenedores:</span><br/>
                    <input type="text" name="cont" value="<?php echo implode(',',$serie->get_cont());?>" />
                </div>
            <?php
                    break;
            }
            ?>
                <div class="value_semi">
                    <input type="submit" value="Modificar" />
                </div> 
            </form>
            <br/>
            <form action="<?php echo $model->get_data('tipo');?>/serie/<?php echo $serie->get_id();?>/delete/" method="post" accept-charset="utf-8">
                <div class="value_tota center">
                    <input type="submit" value="Eliminar Serie" />
                </div> 
            </form>
        </div>
    </section>
</div>