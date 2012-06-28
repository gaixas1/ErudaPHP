<?php
    $proy = $model->get_data('proy');
    $estado =$proy->get_estado();
    $tipo =$proy->get_tipo();
?>
<div class="bloques">
    <section class="bloque">
        <h1>Proyectos</h1>
        <div class="bigmsg">
            <?php
                /*Descargas*/
            foreach($model->get_data('proyectos') as $proyecto)
            {
            ?>
            <article><a class="alllink"  href="proyectos/<?php echo $proyecto->get_id(); ?>/"><?php echo $proyecto->get_serie(); ?></a></article>
            <?php
            }
            ?>
        </div>
    </section>
    <section class="bloque">
        <h1>Nuevo Proyecto</h1>
        <div class="bigmsg">
        <form method="post" action="" enctype="multipart/form-data" target="_self" accept-charset="utf-8">
                <div class="value_tota">
                    <span class="subt">Serie:</span><br/>
                    <input type="text" name="serie" value="<?php echo $proy->get_serie();?>"/>
                </div>
                <div class="value_semi">
                    <span class="subt">Tipo:</span><br/>
                    <select name="tipo">
                        <option value="manga" <?php if($tipo=='manga'){echo 'selected';}?>>Manga</option>
                        <option value="anime" <?php if($tipo=='anime'){echo 'selected';}?>>Anime</option>
                        <option value="dorama" <?php if($tipo=='dorama'){echo 'selected';}?>>Dorama</option>
                    </select>
                </div>
                <div class="value_semi">
                    <span class="subt">Estado:</span><br/>
                    <select name="estado">
                        <option value="activo" <?php if($estado=='activo'){echo 'selected';}?>>Activo</option>
                        <option value="finalizado" <?php if($estado=='finalizado'){echo 'selected';}?>>Finalizado</option>
                        <option value="pausado" <?php if($estado=='pausado'){echo 'selected';}?>>Pausado</option>
                        <option value="cancelado" <?php if($estado=='cancelado'){echo 'selected';}?>>Cancelado</option>
                    </select>
                </div>
                <div class="value_tota">
                    <p>
                        <span class="subt">Captura :</span><br />
                        <input type="FILE" name="imagen" />
                    </p>
                </div> 
                <div class="value_tota">
                        <span class="subt">Texto:</span><br>
                        <textarea name="texto"><?php echo $proy->get_texto();?></textarea>
                </div> 
                <div class="value_tota center">
                    <input type="submit" value="Guardar Proyecto" />
                </div> 
            </form>
        </div>
    </section>
</div>