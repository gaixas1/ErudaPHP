<?php
    $download = $model->get_data('descarga');
    $actserie = $download->get_serie();
?>
<h1>Entrada</h1>
<div class="bloques">
    <section class="bloque">
        <h1>Descarga Manga</h1>
        <form method="post" action="" enctype="multipart/form-data" target="_self" accept-charset="utf-8">
            <div class="value_semi">
                <span class="subt">Serie:</span><br/>
                <select name="serie">
            <?php
                /*SeriesManga*/
            foreach($model->get_data('series') as $serie)
            {
            ?>
                    <option value="<?php echo $serie->get_serie(); ?>" <?php if($actserie==$serie->get_serie()) {echo ' selected ';} ?>><?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?></option>
            <?php
            }
            ?>
                </select>
            </div>
            <div class="value_semi">
                <span class="subt">Tomo:</span><br/>
                <input name="tomo" type="text" value="<?php echo $download->get_tomo(); ?>"/>
            </div>
            <div class="value_semi">
                <span class="subt">Descarga:</span><br/>
                <input name="descarga" type="text" value="<?php echo $download->get_titulo(); ?>"/>
            </div>
            <div class="value_semi">
                <span class="subt">Ver online:</span>
                <input name="verO" type="checkbox" value="1" <?php if($download->has_verO()) {echo ' checked ';} ?> />
            </div>
            <div class="value_tota">
                    <span class="subt">Enlaces:</span><br>
                    <textarea name="links"><?php echo $download->get_downloads(); ?></textarea>
            </div> 
            <div class="value_tota">
                <p>
                    <span class="subt">Captura 1:</span><br />
                    <input type="FILE" name="imagen1" />
                </p>
                <p>
                    <span class="subt">Captura 2:</span><br />
                    <input type="FILE" name="imagen2" />
                </p>
            </div> 
            <div class="value_tota center">
                <input type="submit" value="Enviar" />
            </div> 
        </form>
    </section>
<?php
    if($download->get_id()>0) {
?>

    <section class="bloque">
        <?php
        echo $download;
        ?>
    </section>
<?php
    }
?>
</div>  