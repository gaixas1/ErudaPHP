<body> 
    <div id="contenedor">
        <header id="header">
            <?php
            foreach($model->get_dir() as $uri => $name) {
                echo '<a href="'.$uri.'">'.$name.'</a>';
            }
            ?>
        </header>
        <nav id="menu_lateral">
            <ul>
                <li><a href="/">Volver</a></li>
            <hr/>
                <li><a href="">Inicio</a></li>
                <li><a href="entradas/">Entradas</a></li>
                    <ul>
                    <li><a href="entradas/new/">Nueva</a></li>
                    </ul>
                <li><a href="comentarios/">Comentarios</a></li>
                <li><a href="avisos/">Avisos</a></li>
                <li><a href="manga/">Manga</a></li>
                <li><a href="anime/">Anime</a></li>
                <li><a href="proyectos/">Proyectos</a></li>
            </ul>
        </nav>
        <div id="cuerpo">
            <?php
            $this->showframe('section',$model);
            ?>
        </div>
        <div class="clearer" ></div>
        <footer id="pie">
            FallenSoul Fansub v.4 - Eruda | 2007 - 2012 | Diseñado por gaixas1
        </footer>
    </div> 
</body>