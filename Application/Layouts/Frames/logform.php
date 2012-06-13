<div class="allform">	
    <form class="log_form" title="Entrar" action="" method="post">
        <div class="table">
            <label class="tablerow" for="user">
                <div class="input_text tablecell">Nombre de Usuario : </div>
                <input class="tablecell" type="text" name="user" value="<?php echo $model->get_username(); ?>">
            </label>
            <label class="tablerow" for="pass">
                <div class="input_text tablecell">Contraseña : </div>
                <input class="tablecell" type="password" name="pass">
            </label>
            <br/>
            <div class="tablerow">
            <label class="tablecell" for="mantain">
                <div class="input_text">Recordar Sesion <input type="checkbox" name="mantain" value="1"> </div>
            </label>
            <label class="tablecell" class="sub_log" for="send">
                <input type="submit" name="send" value="Entrar">
            </label>
            </div>
        </div>
    </form>
    <?php
            $error = $model->get_error();
            if($error!=null){
            ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
        <?php
        }
        ?>
    <p class="extra">
        ¿Todavia no eres usuario? <a class="login" title="Registrarse" href="http://fallensoul.es/ajax/reg_form/">¡Registrate!</a>
    </p>
    <p class="extra">
        ¿Ya eres usuario y quieres recuperar la contraseña? <a class="login" title="Recuperar Contraseña" href="http://fallensoul.es/ajax/recu_form/">¡Recuperar Contraseña!</a>
    </p>
</div>