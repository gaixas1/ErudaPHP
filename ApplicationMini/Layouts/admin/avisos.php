<div class="bloques">
    <section class="bloque">
        <h1>Avisos en Portal</h1>
        <div class="bigmsg">
            <form action="avisos/edit/" method="post" accept-charset="utf-8">
            <?php
                /*Ultimos*/
            foreach($model->get_data('ultimos') as $aviso) {
            ?>
                <div class="value_tota">
                    <span class="subt">Aviso <?php echo $aviso->get_id();?>:</span><br/>
                    <input type="text" name="aviso[<?php echo $aviso->get_id();?>]" value="<?php echo $aviso->get_msg();?>" />
                </div>
            <?php 
            }
            ?>
            <div class="value_tota center">
                <input type="submit" value="Modificar" />
            </div> 
            </form>
        </div>
    </section>
    <section class="bloque">
            <h1>Nuevo Aviso</h1>
        <div class="bigmsg">
            <form action="avisos/new/" method="post" accept-charset="utf-8">
                <div class="value_tota">
                    <span class="subt">Texto:</span><br/>
                    <input type="text" name="aviso" value="" />
                </div>
            <div class="value_tota center">
                <input type="submit" value="Nuevo" />
            </div> 
            </form>
        </div>
    </section>
</div>