<div class="bloques">
    <section class="bloque">
        <h1>Resumen</h1>
        <div class="bigmsg">
            <h2 class="noticias">Noticias</h2>
            <?php
                /*Avisos*/
            foreach($model->get_data('aviso') as $aviso)
            {
            ?>
            <article class="aviso"><?php echo $aviso->get_msg(); ?></article>
            <?php
            }
            ?>
        </div>
        <div class="bigmsg">
            <h2 class="bigmsg">Entradas - <?php echo $model->get_data('nent'); ?></h2>
        </div>
        <div class="bigmsg">
            <h2>Comentarios - <?php echo $model->get_data('ncomval'); ?></h2>
            <h2 class="bigmsg">- Espera - <?php echo $model->get_data('ncomesp'); ?></h2>
            <h2 class="bigmsg">- SPAM - <?php echo $model->get_data('ncomspm'); ?></h2>
        </div>
    </section>

    <section class="bloque">
        <h1>Manganime</h1>
        <div class="bigmsg">
            <h2>Ultimas Descargas Manga</h2>
            <?php
                /*LastManga*/
            foreach($model->get_data('lastmanga') as $manga)
            {
            ?>
            <article><a class="alllink"  href="manga/<?php echo $manga->get_id(); ?>/"><?php echo $manga->get_description(); ?></a></article>
            <?php
            }
            ?>
        </div>
        <div class="bigmsg">
            <h2>Ultimas Descargas Anime</h2>
            <?php
                /*LastAnime*/
            foreach($model->get_data('lastanime') as $anime)
            {
            ?>
            <article><a class="alllink" href="anime/<?php echo $anime->get_id(); ?>/"><?php echo $anime->get_description(); ?></a></article>
            <?php
            }
            ?>
        </div>
    </section>
</div>
<div class="bloques">
    <section class="bloque">
        <h1>Añadir Descarga Manga</h1>
        <form method="post" action="manga/new/" enctype="multipart/form-data" target="_blank" accept-charset="utf-8">
            <div class="value_semi">
                <span class="subt">Serie:</span><br/>
                <select name="serie">
            <?php
                /*SeriesManga*/
            foreach($model->get_data('seriesmanga') as $serie)
            {
            ?>
                    <option value="<?php echo $serie->get_serie(); ?>"><?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?></option>
            <?php
            }
            ?>
                </select>
            </div>
            <div class="value_semi">
                <span class="subt">Tomo:</span><br/>
                <input name="tomo" type="text" />
            </div>
            <div class="value_semi">
                <span class="subt">Descarga:</span><br/>
                <input name="descarga" type="text" />
            </div>
            <div class="value_semi">
                <span class="subt">Ver online:</span>
                <input name="verO" type="checkbox" value="1" checked="" />
            </div>
            <div class="value_tota">
                    <span class="subt">Enlaces:</span><br>
                    <textarea name="links"></textarea>
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
                <input type="submit" value="Añadir enlaces" />
            </div> 
    </form>
    </section>

    <section class="bloque">
            <h1>Añadir Descarga Anime</h1>
    <form method="post" action="anime/new/" enctype="multipart/form-data" target="_blank" accept-charset="utf-8">
            <div class="value_tota">
                <span class="subt">Serie:</span><br/>
                <select name="serie">
            <?php
                /*SeriesAnime*/
            foreach($model->get_data('seriesanime') as $serie)
            {
            ?>
                    <option value="<?php echo $serie->get_serie(); ?>"><?php echo Eruda_Helper_Parser::Link2Text($serie->get_serie()); ?></option>
            <?php
            }
            ?>
                </select>
            </div>
            <div class="value_semi">
                <span class="subt">Capitulo:</span><br/>
                <input name="capi" type="text" />
            </div>
            <div class="value_semi">
                <span class="subt">Contenedor:</span><br/>
                <input name="cont" type="text" />
            </div>
            <div class="value_tota">
                <span class="subt">Enlaces:</span><br>
                <textarea name="links"></textarea>
            </div> 
            <div class="value_tota">
                <p>
                    <span class="subt">Captura :</span><br />
                    <input type="FILE" name="imagen" />
                </p>
            </div> 
            <div class="value_tota center">
                <input type="submit" value="Añadir enlaces" />
            </div> 
    </form>
    </section>
</div>