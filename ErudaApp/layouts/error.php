<body>
    <section id="errorcontainer">
        <div id="pagina">URL : <?php echo $model->get_url(); ?></div>
        <div id="msg"><?php echo $model->get_message(); ?></div>
        <?php if($model->get_extra()!=null){?>
        <div id="extra"><?php echo $model->get_extra(); ?></div>
        <?php } ?>
    </section>
</body>