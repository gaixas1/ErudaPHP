<?php
    $entry = $model->get_data('entrada');
    $entryparsed = $model->get_data('entradaparsed');
?>
<h1>Entrada</h1>
<div class="bloques">
    <form action="" method="post" accept-charset="utf-8">
        <section class="bloque">
            <div class="value_tota">
                <span class="subt">Titulo:</span><br/>
                <input type="text" name="title" value="<?php echo $entry->get_title();?>" />
            </div>
            <div class="value_tota">
                <span class="subt">Texto:</span><br/>
                <textarea id="text" name="text" ><?php echo $entry->get_text();?></textarea>
            </div>
            
            <div class="value_tota center">
                <input type="submit" value="Guardar" />
            </div> 
        </section>
        <section class="bloque">
            <div class="bigmsg">
                <h2>Categorias</h2>
                <?php
                $catsId = $model->get_data('categoriesId');
                    /*Avisos*/
                foreach($model->get_data('categories') as $cat)
                {
                ?>
                <label class="check" for="cat_<?php echo $cat->get_id();?>">
                    <input id="cat_<?php echo $cat->get_id();?>" value="<?php echo $cat->get_id();?>" type="checkbox" name="cats[]" <?php
                    if(in_array($cat->get_id(), $catsId)) echo 'checked';
                    ?>/>
                    <?php echo $cat->get_name();?>
                </label>
                <?php
                }
                ?>
                <h2>Emoticonos</h2>
                <section id="emoticDisplay">
                    <?php
                    ////Emoticonos
                    $emotic = array('cabre', 'chulo', 'confu', 'dance', 'duda', 'lloron', 'love', 'nervi', 'plauso', 'sorry', 'morros', 'casi', 'powa', 'trellao');
                    foreach($emotic as $k=>$emo) {
                        if($k==  round(count($emotic)/2)) echo '<br/>';
                        echo '
                            <a href=":'.$emo.':" class="emotico">
                                <img src="/emotic/icon_'.$emo.'.gif" alt=":'.$emo.':">
                            </a>';
                        
                    }
                    ?>
                </section>
                <h2>Novedades</h2>
                <a class="alllink center" id="lastmanga" href="#lastmanga">Añadir ultima descarga manga</a>
                <a class="alllink center" id="lastanime" href="#lastanime">Añadir ultima descarga anime</a>
            </div>
        </section>
    </form>
<?php
    if($entryparsed) {
?>

    <section class="bloque">
        <article class="entrada" id="entrada_<?php echo $entryparsed->get_id(); ?>">
            <header class="entrada_titulo">
                <h1>
                    <?php echo Eruda_Helper_Parser::parseDate($entryparsed->get_created()); ?> | 
                    <a title="<?php echo ($entryparsed->get_title()); ?>" href="/<?php echo $entryparsed->get_id(); ?>/<?php echo Eruda_Helper_Parser::Text2Link($entryparsed->get_title()); ?>/"><?php echo ($entryparsed->get_title()); ?></a>
                </h1>
                <div class="entrada_categorias">
                    <?php if(count($entryparsed->get_cats())>0) {?>
                    <div>Archivado en : 
<?php
foreach($entryparsed->get_cats() as $cat){
    echo ' <a title="Categoria '.$cat->get_name().'" href="/'.$cat->get_link().'/">'.$cat->get_name().'</a> ';
}
?>
                    </div>
<?php }?>
                </div>
            </header>
            <div class="texto_container">
                <div class="texto">
                    <?php
                    echo $entryparsed->get_text();
                    ?>
                </div>
            </div>
        </article>
    </section>
<?php
    }
?>
</div>  