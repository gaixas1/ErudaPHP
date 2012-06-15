<div class="nav_container">
    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_mini" href="http://moe.jlist.com/click/3919/118" target="_blank" title="You've got a friend in Japan at J-List!">
                        <img src="http://moe.jlist.com/media/3919/118" alt="You've got a friend in Japan at J-List!" >
                    </a>
<!-- End J-List Affiliate Code -->
</div>
                
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

                <div class="nav_container">
                    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_max" href="http://pocky.jlist.com/click/3919/117" target="_blank" title="Click to visit J-List now">
                        <img src="http://pocky.jlist.com/media/3919/117" alt="Click to visit J-List now">
                    </a>
<!-- End J-List Affiliate Code -->
                </div>