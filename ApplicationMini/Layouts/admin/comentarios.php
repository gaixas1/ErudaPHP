<div class="bloques">
    <section class="bloque">
        <h1>Ultimos Comentarios</h1>
        <div class="bigmsg">
            <?php
                /*Ultimos*/
            foreach($model->get_data('ultimos') as $comment)
            {
                $us = $comment->get_author();
            ?>
            <article id="comment_<?php echo $comment->get_id();?>" class="comentario">
                <img class="gravatar" src="<?php echo $us->get_avatar(50);?>" />
                <header>Por <?php echo $us->get_name();?> el <?php echo Eruda_Helper_Parser::parseAllDate($comment->get_date());?></header>
		<section class="text"><?php echo $comment->get_text(); ?></section>
            </article>
            <?php
            }
            ?>
        </div>
    </section>
    <section class="bloque">
            <h1>Validar</h1>
            <?php if(count($model->get_data('pendientes'))>0) {?>
        <div class="bigmsg">
            <h2>A validar</h2>
            <?php
                /*Ultimos*/
            foreach($model->get_data('pendientes') as $comment)
            {
                $us = $comment->get_author();
            ?>
            <div class="tovalid">
                <article id="comment_<?php echo $comment->get_id();?>" class="comentario">
                    <img class="gravatar" src="<?php echo $us->get_avatar(50);?>" />
                    <header>Por <?php echo $us->get_name();?> el <?php echo Eruda_Helper_Parser::parseAllDate($comment->get_date());?></header>
                    <section class="text"><?php echo $comment->get_text(); ?></section>
                </article>
                <div class="center">
                    <form method="post" action="comentarios/<?php echo $comment->get_id();?>/valid/">
                        <input type="submit" name ="validar" value="Validar"/>
                    </form>
                    <br/>
                    <form method="post" action="comentarios/<?php echo $comment->get_id();?>/delete/">
                        <input class="deletecomment" type="submit" name ="eliminar" value="Eliminar"/>
                    </form>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
            <?php }?>
            <?php if(count($model->get_data('spam'))>0) {?>
        <div class="bigmsg">
            <h2>Posible SPAM</h2>
            <?php
                /*Ultimos*/
            foreach($model->get_data('spam') as $comment)
            {
                $us = $comment->get_author();
            ?>
            <div class="tovalid">
                <article id="comment_<?php echo $comment->get_id();?>" class="comentario">
                    <img class="gravatar" src="<?php echo $us->get_avatar(50);?>" />
                    <header>Por <?php echo $us->get_name();?> el <?php echo Eruda_Helper_Parser::parseAllDate($comment->get_date());?></header>
                    <section class="text"><?php echo $comment->get_text(); ?></section>
                </article>
                <div class="center">
                    <form method="post" action="comentarios/<?php echo $comment->get_id();?>/valid/">
                        <input type="submit" name ="validar" value="Validar"/>
                    </form>
                    <br/>
                    <form method="post" action="comentarios/<?php echo $comment->get_id();?>/delete/">
                        <input class="deletecomment" type="submit" name ="eliminar" value="Eliminar"/>
                    </form>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
            <?php }?>
    </section>
</div>