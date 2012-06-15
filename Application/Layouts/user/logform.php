<h1>Entrar</h1>
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
        ¿Ya eres usuario y quieres recuperar la contraseña? <a class="login" title="Recuperar Contraseña" href="/user/recupera/">¡Recuperar Contraseña!</a>
    </p>