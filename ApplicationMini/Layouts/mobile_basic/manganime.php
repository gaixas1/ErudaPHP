<section id="navmanganime">
<?php
    $this->showframe('lateral',$model);
?>
</section>
<section id="manganime">
    <?php
    foreach($model->get_downloads() as $down){
        echo $down;
    }
    ?>
</section>
