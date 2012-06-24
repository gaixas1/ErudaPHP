<div class="nav_container">
    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_mini" href="http://moe.jlist.com/click/3919/118" target="_blank" title="You've got a friend in Japan at J-List!">
                        <img src="http://moe.jlist.com/media/3919/118" alt="You've got a friend in Japan at J-List!" >
                    </a>
<!-- End J-List Affiliate Code -->
</div>

<?php
    $proyectos = $model->get_proyectos();
?>
<?php
if(isset($proyectos['activo'])){
?>
                <div class="nav_container">
                    <h1>En Proceso</h1>
                    <?php
                    foreach ($proyectos['activo'] as $tipo => $proys) {
                        echo '<br/>';
                        echo '<h2>'.  ucfirst($tipo).'</h2>';
                        foreach ($proys as $p) {
                            echo '<h2><a href="/proyectos/'.$p->get_id().'/'.Eruda_Helper_Parser::Text2Link($p->get_serie()).'/">- '.$p->get_serie().'</a></h2>';
                        }
                    }
                    ?>
                    <br/>
                </div>

<?php
}
if(isset($proyectos['finalizado'])){
?>
                <div class="nav_container">
                    <h1>Finalizado</h1>
                    <?php
                    foreach ($proyectos['finalizado'] as $tipo => $proys) {
                        echo '<br/>';
                        echo '<h2>'.  ucfirst($tipo).'</h2>';
                        foreach ($proys as $p) {
                            echo '<h2><a href="/proyectos/'.$p->get_id().'/'.Eruda_Helper_Parser::Text2Link($p->get_serie()).'/">- '.$p->get_serie().'</a></h2>';
                        }
                    }
                    ?>
                    <br/>
                </div>

<?php
}
if(isset($proyectos['pausado'])){
?>
                <div class="nav_container">
                    <h1>Pausado</h1>
                    <?php
                    foreach ($proyectos['pausado'] as $tipo => $proys) {
                        echo '<br/>';
                        echo '<h2>'.  ucfirst($tipo).'</h2>';
                        foreach ($proys as $p) {
                            echo '<h2><a href="/proyectos/'.$p->get_id().'/'.Eruda_Helper_Parser::Text2Link($p->get_serie()).'/">- '.$p->get_serie().'</a></h2>';
                        }
                    }
                    ?>
                    <br/>
                </div>

<?php
}
if(isset($proyectos['cancelado'])){
?>
                <div class="nav_container">
                    <h1>Cancelado</h1>
                    <?php
                    foreach ($proyectos['cancelado'] as $tipo => $proys) {
                        echo '<h2>'.  ucfirst($tipo).'</h2>';
                        foreach ($proys as $p) {
                            echo '<h2><a href="/proyectos/'.$p->get_id().'/'.Eruda_Helper_Parser::Text2Link($p->get_serie()).'/">- '.$p->get_serie().'</a></h2>';
                        }
                        echo '<br/>';
                    }
                    ?>
                    <br/>
                </div>

<?php
}
?>

                <div class="nav_container">
                    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_max" href="http://pocky.jlist.com/click/3919/117" target="_blank" title="Click to visit J-List now">
                        <img src="http://pocky.jlist.com/media/3919/117" alt="Click to visit J-List now">
                    </a>
<!-- End J-List Affiliate Code -->
                </div>