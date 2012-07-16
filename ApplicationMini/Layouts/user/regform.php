<h1>Registro</h1>
    <form class="reg_form" title="Registrarse" action="" method="post">
        <div class="table">
            <label class="tablerow" for="user">
                <div class="input_text tablecell">Nombre de Usuario : </div>
                <input class="tablecell" type="text" name="user" value="<?php echo $model->get_username(); ?>">
            </label>
            <label class="tablerow" for="mail">
                <div class="input_text tablecell">Dirección e-mail : </div>
                <input class="tablecell" type="text" name="mail" value="<?php echo $model->get_mail(); ?>">
            </label>
            <br/>
            <label class="tablerow" for="pass">
                <div class="input_text tablecell">Contraseña : </div>
                <input class="tablecell" type="password" name="pass">
            </label>
            <label class="tablerow" for="pass">
                <div class="input_text tablecell">Repite la Contraseña : </div>
                <input class="tablecell" type="password" name="pass2">
            </label>
            <br/>
        </div>
        <label class="sub_log" for="send">
            <input type="submit" name="send" value="Registrar">
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
        ¿Ya eres usuario? <a class="login" title="Entrar" href="/user/log/">¡Entra!</a>
    </p>
    <p class="extra">
        ¿Ya eres usuario y quieres recuperar la contraseña? <a class="login" title="Recuperar Contraseña" href="/user/recupera/">¡Recuperar Contraseña!</a>
    </p>