<body>
    
    <section id="formcontainer">
        <nav id="linkscontainer">
            <a class="link" href="<?php echo $model->get_ref();?>">Volver al Blog</a>
        </nav>
        <div class="allform">	
<?php
    $this->showframe('form',$model);
?>
        </div>
    </section>
</body>