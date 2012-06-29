<?php 
    $categoria = $model->get_data('categoria');
?>
<div class="bloques">
    <section class="bloque">
        <h1>Categoria : <?php echo $categoria->get_name();?></h1>
        <div class="bigmsg">
            <article><a class="alllink" href="/<?php echo $categoria->get_link();?>/"><?php echo $categoria->get_name();?></a></article>
            <br/>
            <?php echo $categoria->get_count();?> entradas en esta categoria.
        </div>
    </section>
    <section class="bloque">
        <div class="bigmsg">
            <form action="" method="post" accept-charset="utf-8">
                <div class="value_tota">
                    <span class="subt">Nombre:</span><br/>
                    <input type="text" name="name" value="<?php echo $categoria->get_name();?>" />
                </div>
                <div class="value_tota">
                    <span class="subt">Link:</span><br/>
                    <input type="text" name="link" value="<?php echo $categoria->get_link();?>" />
                </div>
                
                <div class="value_semi">
                    <input type="submit" value="Modificar" />
                </div> 
            </form>
            <br/>
            <form action="categorias/<?php echo $categoria->get_id();?>/delete/" method="post" accept-charset="utf-8">
                <div class="value_tota center">
                    <input type="submit" value="Eliminar Categoria" class="deletecat" />
                </div> 
            </form>
        </div>
    </section>
</div>