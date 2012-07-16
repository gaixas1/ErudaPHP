<div class="bloques">
    <section class="bloque">
        <h1>Categorias</h1>
        <div class="bigmsg">
            <?php
                /*Ultimos*/
            foreach($model->get_data('categorias') as $cat) {
            ?>
            <article><a class="alllink" href="categorias/<?php echo $cat->get_id();?>/"><?php echo $cat->get_name();?></a></article>
            <?php 
            }
            ?>
        </div>
    </section>
    <section class="bloque">
            <h1>Nueva Categoria</h1>
        <div class="bigmsg">
            <form action="categorias/new/" method="post" accept-charset="utf-8">
                <div class="value_tota">
                    <span class="subt">Nombre:</span><br/>
                    <input type="text" name="name" value="" />
                </div>
                <div class="value_tota center">
                    <input type="submit" value="Nueva" />
                </div> 
            </form>
        </div>
    </section>
</div>