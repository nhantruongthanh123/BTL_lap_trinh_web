<html>
    <head>
        <title>Website</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href=" <?php echo WEBROOT . '/public/assets/Clients/css/style.css'; ?>">
    </head>
    <body>
        <?php 
            $this->render('Block/header');
        ?>
        
        <?php
            $this->render($info, $content);
        ?>

        <?php 
            $this->render('Block/footer');
        ?>

        <script src="<?php echo WEBROOT . '/public/assets/Clients/js/script.js'; ?>"></script>
        
    </body>
</html>