<h1>Ultimas Entradas</h1>
<div class="bloques">
    <section class="bloque">
        <div class="bigmsg">
            <?php
                /*Entradas*/
            foreach($model->get_data('entradas1') as $entrada)
            {
            ?>
            <article><a class="alllink" href="entradas/<?php echo $entrada->get_id(); ?>/">[<?php echo $entrada->get_id(); ?>] <?php echo $entrada->get_title(); ?></a></article>
            <?php
            }
            ?>
        </div>
    </section>
    <section class="bloque">
        <div class="bigmsg">
            <?php
                /*Entradas*/
            foreach($model->get_data('entradas2') as $entrada)
            {
            ?>
            <article><a class="alllink" href="entradas/<?php echo $entrada->get_id(); ?>/">[<?php echo $entrada->get_id(); ?>] <?php echo $entrada->get_title(); ?></a></article>
            <?php
            }
            ?>
        </div>
    </section>
</div>