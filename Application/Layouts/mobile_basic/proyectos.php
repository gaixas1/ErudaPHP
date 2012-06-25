<section id="navproyectos">
<?php
    $this->showframe('lateral',$model);
?>
</section>
<section id="proyectos">
    <?php
    foreach($model->get_items() as $p){
?>
    <article class="proyecto">
        <header class="titulo">
            <h1>
                <a title="<?php echo $p->get_serie();?>" 
                   href="/proyectos/<?php echo $p->get_id();?>/<?php echo Eruda_Helper_Parser::Text2Link($p->get_serie());?>/">
                       <?php echo $p->get_serie();?>
                </a>
            </h1>
        </header>
        <div class="texto_container">
            <div class="texto">
                <img class="imgProy" src="/capturas_projects/<?php echo $p->get_id();?>.jpg" />
                    <?php echo Eruda_Helper_Parser::parseText($p->get_texto());?>
                <div class="clearer_right" ></div>
            </div>
        </div>
        <footer class="pie">
            Tipo : <?php echo $p->get_tipo();?> | Estado : <?php echo $p->get_estado();?>
        </footer>
    </article>    
<?php
    }
    ?>
</section>
