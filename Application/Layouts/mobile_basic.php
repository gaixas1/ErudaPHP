<body>
    <section id="social">
        <a id="social_rss"      title="RSS"         href="/rss/">&nbsp;</a>
        <a id="social_twitter"  title="Twitter"     href="https://twitter.com/#!/gaixas1">&nbsp;</a>
        <a id="social_facebook" title="Facebook"    href="https://www.facebook.com/pages/FallenSoul-Fansub/149614985063701">&nbsp;</a>
        <a id="social_google"   title="Google+"     href="https://plus.google.com/u/0/b/109986527431362054063/">&nbsp;</a>
        <a id="social_deviant"  title="DeviantArt"  href="http://gaixas1.deviantart.com/">&nbsp;</a>
    </section>
        
    <header id="cabecera">
        <div id="baner"><img alt="FallenSoul" src="img/b0.jpg" /></div>
        <nav id="menu_superior">
            <a id="link_inicio" href="/">Inicio</a><a id="link_veronline" href="http://veronline.fallensoul.es">Ver Online</a><a id="link_manga" href="/manga/">Manga</a><a id="link_anime" href="/anime/">Anime</a><a id="link_proyectos" href="/proyectos/">Proyectos</a><a id="link_respaldo" href="http://respaldo.fallensoul.es/">Respaldo</a>
        </nav>
    </header>
    <section id="user">
        <?php
        $user = $model->get_user();
        if($user->get_id()>0){
        ?>
        <h3><?php echo $user->get_name();?></h3>
        <img class="user_avatar" alt="<?php echo $user->get_name();?>" src="<?php echo $user->get_avatar();?>"> 
        <a class="ulink" title="Editar" href="/user/edit/"> Editar </a>
        <a class="ulink uexit" title="Salir" href="/user/logout/"> Salir </a>
        <?php if(Eruda_Helper_Auth::canAdmin($user)) {?>
        <a class="ulink" title="Administración" href="/admin/"> Admin </a>
        <?php }?>
        <?php
        }else{
        ?>
        <h3>Invitado</h3>
        <img class="user_avatar" alt="Invitado" src="http://www.gravatar.com/avatar.php?gravatar_id=f2768ecb9d6958f3fecce263e592f75a&amp;default=http%3A%2F%2Fwww.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D50&amp;size=70"> 
        <a class="ulink" title="Entrar" href="/user/log/"> Entrar </a>
        <a class="ulink"  title="Registrarse" href="/user/register/"> Registrarse </a>
        <fb:login-button perms="email">Login with Facebook</fb:login-button>
        
        <div id="fb-root"></div>
        <?php
        }
        ?>
    </section>
<!-- Start J-List Affiliate Code -->
    <a class="jlist_img_baner" href="http://moe.jlist.com/click/3919/118" target="_blank" title="You've got a friend in Japan at J-List!">
        <img src="http://anime.jlist.com/media/3920/102" alt="You've got a friend in Japan at J-List!" >
    </a>
<!-- End J-List Affiliate Code -->
</div>
        
        <div id="cuerpo">
            <?php 
            $avisos = $model->get_avisos();
            if($avisos && count($avisos)){
            ?>
            <?php
            }
            ?>
            <?php
                $this->showframe('section',$model);
            ?>
            <div class="clearer" ></div>
        </div>
<!-- Start J-List Affiliate Code -->
    <a class="jlist_img_baner" href="http://moe.jlist.com/click/3919/118" target="_blank" title="You've got a friend in Japan at J-List!">
        <img src="http://anime.jlist.com/media/3920/102" alt="You've got a friend in Japan at J-List!" >
    </a>
<!-- End J-List Affiliate Code -->
        <footer id="pie">
            FallenSoul Fansub v.4 - Eruda | 2007 - 2012 | Diseñado por gaixas1 | <a href="mailto:admin@fallensoul.es">Contacto</a> | <a href="/device/pc/">Versión para PC</a>
        </footer>
    </body>