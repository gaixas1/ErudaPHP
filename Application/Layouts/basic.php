<body>
    <section id="user">
        
    </section>
    <section id="social">
        <a id="social_rss"      title="RSS"         href="/rss">&nbsp;</a>
        <a id="social_twitter"  title="Twitter"     href="https://twitter.com/#!/gaixas1">&nbsp;</a>
        <a id="social_facebook" title="Facebook"    href="https://www.facebook.com/pages/FallenSoul-Fansub/149614985063701">&nbsp;</a>
        <a id="social_google"   title="Google+"     href="https://plus.google.com/u/0/b/109986527431362054063/">&nbsp;</a>
        <a id="social_deviant"  title="DeviantArt"  href="http://gaixas1.deviantart.com/">&nbsp;</a>
        </section>
        
        <header id="cabecera">
            <div id="baner"><img alt="FallenSoul" src="img/b0.jpg" /></div>
            <nav id="menu_superior">
                <a id="link_inicio" href="http://fallensoul.es/">Inicio</a><a id="link_veronline" href="http://veronline.fallensoul.es">Ver Online</a><a id="link_manga" href="http://fallensoul.es/manga/">Manga</a><a id="link_anime" href="http://fallensoul.es/anime/">Anime</a><a id="link_proyectos" href="http://fallensoul.es/proyectos/">Proyectos</a><a id="link_respaldo" href="http://respaldo.fallensoul.es/">Respaldo</a>
            </nav>
        </header>
        
        <div id="cuerpo">
            <section id="novedades">
                Novedades
            </section>
        
            <nav id="menu_lateral">
                <div class="nav_container">
                    <h1>Actuales</h1>
                    <a class="cat_img_link" title="Categoria - Koudelka"             id="cat_koudelka" href="/koudelka/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Doll Star"             id="cat_doll" href="/doll-star/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_tokio" href="/tokio-red/">&nbsp;</a>
                </div>
                
                <div class="nav_container">
                    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_mini" href="http://moe.jlist.com/click/3919/118" target="_blank" title="You've got a friend in Japan at J-List!">
                        <img src="http://moe.jlist.com/media/3919/118" alt="You've got a friend in Japan at J-List!" >
                    </a>
<!-- End J-List Affiliate Code -->
                </div>
                
                <div class="nav_container">
                    <h1>Completos</h1>
                    <a class="cat_img_link" title="Categoria - Koudelka"             id="cat_oneshot" href="/koudelka/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Doll Star"             id="cat_mov" href="/doll-star/">&nbsp;</a>
                    <br />
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_gacha" href="/tokio-red/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_shina" href="/tokio-red/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_okit" href="/tokio-red/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_crossing" href="/tokio-red/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_mitsu" href="/tokio-red/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_negi" href="/tokio-red/">&nbsp;</a>
                </div>
                
                <div class="nav_container">
                    <h1>Archivos</h1>
                    <select id="nav_archivos">
<?php
    $lastyear=null;
    foreach($model->get_archives() as $archive){
        if($lastyear != $archive['year']){
            if($lastyear!=null)
                echo '</optgroup>';
            $lastyear = $archive['year'];
            echo '<optgroup label="'.$lastyear.'">';
        }
        echo '<option value="/'.$archive['month'].'-'.$archive['year'].'/">'.Eruda_Helper_Parser::parseMonth($archive['month']).' '.$archive['year'].'</option>';
    }
    echo '</optgroup>';
?>
                    </select>
                </div>
                
                
                <div class="nav_container">
                    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_max" href="http://pocky.jlist.com/click/3919/117" target="_blank" title="Click to visit J-List now">
                        <img src="http://pocky.jlist.com/media/3919/117" alt="Click to visit J-List now">
                    </a>
<!-- End J-List Affiliate Code -->
                </div>
            </nav>
            
                <?php
                $this->showframe('section',$model);
                ?>
            <div class="clearer" ></div>
        </div>
        <footer id="pie">
            FallenSoul Fansub v.4 - Eruda | 2007 - 2012 | Diseñado por gaixas1 | <a href="mailto:admin@fallensoul.es">Contacto</a>
        </footer>
    </body>