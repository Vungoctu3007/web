<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/style.css">
</head>
<body>
    <?php
        $this->render('blocks/header', $sub_content);
        $this->render($content, $sub_content);
        $this->render('blocks/footer', $sub_content);
    ?>
    <script></script>
</body>
</html>