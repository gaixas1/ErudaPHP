                    <?php
                    foreach($model->get_series() as $serie){
                        ?>

                <div class="nav_container">
                    <?php
                        echo '<h1>'.Eruda_Helper_Parser::Link2Text($serie->get_serie()).'</h1>';
                            foreach($serie->get_links() as $link){
                                echo '<h2><a href="'.$link[0].'">'.$link[1].'</a></h2>';
                            }
                    ?>
                </div>
                   <?php
                   }
                    ?>