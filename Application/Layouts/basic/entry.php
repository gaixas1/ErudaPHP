            <section id="articulos"> 
                <?php
                    $entry = $model->get_entry()
                ?>
                <article class="entrada" id="entrada_701">
                    <header class="entrada_titulo">
                        <h1>
                            <?php echo Eruda_Helper_Parser::parseDate($entry->get_created()); ?> | 
                            <a title="<?php echo utf8_encode($entry->get_title()); ?>" href="/<?php echo $entry->get_id(); ?>/<?php echo Eruda_Helper_Parser::Text2Link($entry->get_title()); ?>/"><?php echo utf8_encode($entry->get_title()); ?></a>
                        </h1>
                        <div class="entrada_categorias">
                            <?php if(count($entry->get_cats())>0) {?>
                            <div>Archivado en : 
                            <?php
                            foreach($entry->get_cats() as $cat){
                                echo ' <a title="Categoria '.$cat->get_name().'" href="/'.$cat->get_link().'/">'.$cat->get_name().'</a> ';
                            }?>
                            </div>
                            <?php }?>
                            <?php /*
                             * LISTAR TAGS, no se usa en fansub
                             * 
                            <?php if(count($entry->get_tags())>0) {?>
                            <div class="right">
                            <?php
                            foreach($entry->get_tags() as $tag){
                                echo '<a title="Tag '.$tag.'" href="/tag/'.Eruda_Helper_Parser::Text2Link($tag).'/">'.$tag.'</a>';
                            }?>
                            </div>
                            <?php }?>
                             * 
                            */ ?>
                        </div>
                    </header>
                    <div class="texto_container">
                        <div class="texto">
                            <?php
                                echo $entry->get_text();
                            ?>
                        </div>
                    </div>
                    <footer class="entrada_pie">
                        <div class="entrada_social">
                            <a name="fb_share" type="button_count" share_url="http://fallensoul.es/701/koudelka_08">Compartir en FB</a>
                            <a class="twiter" target="_blank" href="http://twitter.com/?status=FSFansub%20%3E%3E%20http://fallensoul.es/701/koudelka_08">Enviar a Twitter</a>
                        </div>
                        <div class="entrada_ncomentarios">
                            <?php 
                                $comNum = $entry->get_comments();
                                if($comNum<=0)
                                    echo '<a class="comLink" title="'.utf8_encode($entry->get_title()).'" href="/'.$entry->get_id().'/'.Eruda_Helper_Parser::Text2Link($entry->get_title()).'/#comentar">Sin Comentarios</a>';
                                else if($comNum==1)
                                    echo '<a class="comLink" title="'.utf8_encode($entry->get_title()).'" href="/'.$entry->get_id().'/'.Eruda_Helper_Parser::Text2Link($entry->get_title()).'/#comentarios">1 Comentario</a>';
                                else
                                    echo '<a class="comLink" title="'.utf8_encode($entry->get_title()).'" href="/'.$entry->get_id().'/'.Eruda_Helper_Parser::Text2Link($entry->get_title()).'/#comentarios">'.$comNum.' Comentarios</a>';
                            ?>
                        </div>
                    </footer>
                </article>
                
                <?php
                    $comments = $model->get_comments();
                    if($comments!=null && is_array($comments) && count($comments)>0) {
                ?>
                <section id="comentarios">
                    <h1>Comentarios</h1>
                <?php
                $t = true;
                        foreach($comments as $comment){
                            if($comment->can_see($model->get_user())) {
                                $us = $comment->get_author();
                ?>
                    <article id="comment_<?php echo $comment->get_id();?>" class="comentario coment_<?php echo ($t ? 'a' : 'b');?>">
			<img class="gravatar" src="<?php echo $us->get_gravatar(50);?>">
                        <header>Por <?php echo $us->get_name();?> el <?php echo Eruda_Helper_Parser::parseAllDate($comment->get_date());?></header>
                        <?php
                            if(!$comment->is_valid()){
                        ?>
                        <p class="toMod">(A la espera de moderación)</p>
                        <?php
                            }
                        ?>
			<section class="text"><?php echo $comment->get_text(); ?></section>
		</article>
                    
                    <article id="comment_<?php echo $comment->get_id();?>">
                    
                    </article>
                <?php
                                $t = !$t;
                            }
                        }
                ?>
                </section>
                <?php
                    }
                ?>
                
                
                <section id="comentar">
                    <h1>Comentar</h1>
                    <?php
                    $us = $model->get_user();
                    if($us->get_level()>0) {
                    ?>
                    <form action="" method="post" accept-charset="utf-8">
                        <p>
                            Identificado como <?php echo $us->get_name();?>. <a href="/user/logout/" title="Salir">Salir</a>
                        </p>
                        <section id="emoticDisplay">
                            <?php
                                //Emoticonos
                                $emotic = array('cabre', 'chulo', 'confu', 'dance', 'duda', 'lloron', 'love', 'nervi', 'plauso', 'sorry', 'morros', 'casi', 'powa', 'trellao');
                                foreach($emotic as $k=>$emo) {
                                    if($k==  round(count($emotic)/2)) echo '<br/>';
                                    echo '
                                        <a href=":'.$emo.':" class="emotico">
                                            <img src="/emotic/icon_'.$emo.'.gif" alt=":'.$emo.':">
                                        </a>';
                                }
                            ?>
                        </section>
                        <textarea id="comTxt" name="text"><?php echo $model->get_comtxt();?></textarea>
                        <section id="comBotones">	
                                <button id="comPrevia">Vista Previa</button><input type="submit" value="Enviar" />
                        </section>
                    </form>
                    <section id="vistaPrevia">
                        <?php
                        if($model->has_errors()){
                            echo '<p class="error">'.$model->get_errors().'</p>';
                        }
                        ?>
                    </section>
                    <?php
                    }else{
                    ?>
                    <p>
                        Necesitas estar logeado para poder comentar.
                    </p>
                    <p class="center">
                        <a title="Entrar" href="/user/log/"> Entrar </a> | <a  title="Registrarse" href="/user/register/"> Registrarse </a>
                    </p>
                    <?php
                    }
                    ?>
                </section>
            </section>