<?php
    $proy = $model->get_data('proy');
    $estado =$proy->get_estado();
    $tipo =$proy->get_tipo();
?>
<h1>Entrada</h1>
<div class="bloques">
    <section class="bloque">
        <h1>Añadir Descarga Manga</h1>
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
    </section>
<?php
    if($proy->get_id()>0) {
?>

    <section class="bloque">
        <article class="proyecto">
        <header class="titulo">
            <h1>
                <a title="<?php echo $proy->get_serie();?>" 
                   href="/proyectos/<?php echo $proy->get_id();?>/<?php echo Eruda_Helper_Parser::Text2Link($proy->get_serie());?>/">
                       <?php echo $proy->get_serie();?>
                </a>
            </h1>
        </header>
        <div class="texto_container">
            <div class="texto">
                <img class="imgProy" src="/capturas_projects/<?php echo $proy->get_id();?>.jpg" />
                    <?php echo Eruda_Helper_Parser::parseText($proy->get_texto());?>
                <div class="clearer_right" ></div>
            </div>
        </div>
        <footer class="pie">
            Tipo : <?php echo $proy->get_tipo();?> | Estado : <?php echo $proy->get_estado();?>
        </footer>
    </article>    
    </section>
<?php
    }
?>
</div>  