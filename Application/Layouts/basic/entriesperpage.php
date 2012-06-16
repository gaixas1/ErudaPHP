            <section id="articulos"> 
                <?php
                    if($model->get_title()!=null){
                        echo '<h1 class="grupo_entradas">'.$model->get_title().'</h1>';
                    }
                ?>
            
                <?php
                    foreach($model->get_entries() as $entry){
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
                    }
                ?>
                
                <?php
                        $page = $model->get_page();
                        if($page){
                            $base = $page->get_base();
                            $prev = $page->get_prev();
                            $next = $page->get_next();
                ?>
                <nav id="paginacion">
                    <?php
                        
                        if($prev)
                            if($prev>1)
                                echo '<a class="link_a" title="Página Anterior" href="'.$base.'p'.$prev.'/">«Página Anterior</a>';
                            else
                                echo '<a class="link_a" title="Página Anterior" href="'.$base.'">«Página Anterior</a>';
                        else
                            echo '<a class="link_a hidden" title="Página Anterior" href="'.$base.'p'.$prev.'/">«Página Anterior</a>';
                        echo '<a class="link_b" title="Arriba" href="#">Arriba</a>';
                        if($next)
                            echo '<a class="link_c" title="Siguiente Página" href="'.$base.'p'.$next.'/">Siguiente Página»</a>';
                        else
                            echo '<a class="link_c hidden" title="Siguiente Página" href="'.$base.'p'.$next.'/">Siguiente Página»</a>';
                    ?>
                </nav>
                <?php
                        }
                ?>
            </section>