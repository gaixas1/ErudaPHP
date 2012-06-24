<div class="nav_container">
                    <h1>Actuales</h1>
                    <a class="cat_img_link" title="Categoria - Koudelka"             id="cat_koudelka" href="/koudelka/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Doll Star"             id="cat_doll" href="/doll-star/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_tokio" href="/tokio-red/">&nbsp;</a>
                </div>
                
                <div class="nav_container">
                    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_mini" href="http://moe.jlist.com/click/3919/118" target="_blank" title="You've got a friend in Japan at J-List!">
                        <img src="http://moe.jlist.com/media/3919/118" alt="You've got a friend in Japan at J-List!" >
                    </a>
<!-- End J-List Affiliate Code -->
                </div>
                
                <div class="nav_container">
                    <h1>Completos</h1>
                    <a class="cat_img_link" title="Categoria - Koudelka"             id="cat_oneshot" href="/oneshot/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Doll Star"             id="cat_mov" href="/cat-movie/">&nbsp;</a>
                    <br />
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_gacha" href="/gacha-gacha/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_shina" href="/shina-dark/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_okit" href="/okitsune-sama/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_crossing" href="/crossing-25/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_mitsu" href="/jigoku-shoujo/">&nbsp;</a>
                    <a class="cat_img_link" title="Categoria - Tokio Red Hood"         id="cat_negi" href="/negima-dorama/">&nbsp;</a>
                </div>
                
                <div class="nav_container">
                    <h1>Archivos</h1>
                    <select id="nav_archivos">
<?php
    $lastyear=null;
    foreach($model->get_archives() as $archive){
        if($lastyear != $archive['year']){
            if($lastyear!=null)
                echo '</optgroup>';
            $lastyear = $archive['year'];
            echo '<optgroup label="'.$lastyear.'">';
        }
        echo '<option value="/'.$archive['month'].'-'.$archive['year'].'/">'.Eruda_Helper_Parser::parseMonth($archive['month']).' '.$archive['year'].'</option>';
    }
    echo '</optgroup>';
?>
                    </select>
                </div>
                
                
                <div class="nav_container">
                    <h1>Publicidad</h1>
<!-- Start J-List Affiliate Code -->
                    <a class="jlist_img_max" href="http://pocky.jlist.com/click/3919/117" target="_blank" title="Click to visit J-List now">
                        <img src="http://pocky.jlist.com/media/3919/117" alt="Click to visit J-List now">
                    </a>
<!-- End J-List Affiliate Code -->
                </div>