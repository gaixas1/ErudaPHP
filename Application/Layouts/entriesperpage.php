<body>
    <ul>
    <?php
        foreach ($model->get_cats() as $cat)
            echo '<li>'.$cat->get_id().' - '.$cat->get_name().' ('.$cat->get_count().')</li>';
    ?>
    </ul>
</body>
    