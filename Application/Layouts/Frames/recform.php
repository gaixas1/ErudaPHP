<h1>Recuperar contraseña</h1>
    <form class="reg_form" title="Registrarse" action="" method="post">
        <div class="table">
            <label class="tablerow" for="user">
                <div class="input_text tablecell">Nombre de Usuario : </div>
                <input class="tablecell" type="text" name="user" value="<?php echo $model->get_username(); ?>">
            </label>
            <br/>
        </div>
        <label class="sub_log" for="send">
            <input type="submit" name="senduser" value="Solicitar nueva contraseña para en nombre de usuario">
        </label>
            <br/>
            <br/>
            <div class="center">o</div>
            <br/>
        <div class="table">
            <label class="tablerow" for="mail">
                <div class="input_text tablecell">Dirección e-mail : </div>
                <input class="tablecell" type="text" name="mail" value="<?php echo $model->get_mail(); ?>">
            </label>
            <br/>
        </div>
        <label class="sub_log" for="send">
            <input type="submit" name="sendmail" value="Solicitar nueva contraseña para la dirección de correo">
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
    <p class="extra">
        ¿Todavia no eres usuario? <a class="login" title="Registrarse" href="/user/register/">¡Registrate!</a>
    </p>
    <p class="extra">
        ¿Ya te acuerdas de la contraseña? <a class="login" title="Entrar" href="/user/log/">¡Entra!</a>
    </p>