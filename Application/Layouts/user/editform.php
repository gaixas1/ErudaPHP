<h1>Modificar contraseña</h1>

<?php 
    $user = $model->get_user();
?>
    
    <section id="user">
        <img class="user_avatar" alt="<?php echo $user->get_name();?>" src="<?php echo $user->get_avatar();?>"> 
        <h3><?php echo $user->get_name();?></h3>
        <h4>«<?php echo $user->get_mail();?>»</h4>
    </section>
        
        
    <form class="log_form" title="Entrar" action="" method="post">
        <div class="table">
            <label class="tablerow" for="pass">
                <div class="input_text tablecell">Contraseña actual : </div>
                <input class="tablecell" type="password" name="actpass">
            </label>
            <br/>
            <label class="tablerow" for="pass">
                <div class="input_text tablecell">Nueva Contraseña : </div>
                <input class="tablecell" type="password" name="newpass">
            </label>
            <label class="tablerow" for="pass">
                <div class="input_text tablecell">Repite la Contraseña : </div>
                <input class="tablecell" type="password" name="newpass2">
            </label>
            <br/>
        </div>
        <label class="sub_log" for="send">
            <input type="submit" name="send" value="Modificar Contraseña">
        </label>
    </form>
    <?php
            if($model->has_errors()){
            ?>
    <div class="error">
        <?php echo $model->get_errors(); ?>
    </div>
        <?php
        }
        ?>
    <?php
            if($model->changed()){
            ?>
    <div class="ok">
        Contraseña modificada con exito
    </div>
        <?php
        }
        ?>