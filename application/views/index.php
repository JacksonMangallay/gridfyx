<?php defined('BASEPATH') OR exit('Direct access is forbidden'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gridfyx v1.4</title>
    
    <style type="text/css">
        html,body{
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
            font-size: .9rem;
            font-weight: normal;
            color: #4F5155;
        }

        body{
            padding: 10px;
        }

        .wrapper{
            padding: 20px;
        }

        h1{
            margin: 0 0 20px;
            font-weight: 100;
            font-size: 1.7rem;
        }

        a{
            color: #00B16A;
        }

        .highlight{
            display: block;
            margin-top: 10px;
            padding: 15px;
            background-color: #f5f5f5;
        }
    </style>

</head>
<body>
    <div class="wrapper">
        <h1>Gridfyx v1.4 is now running. Happy coding!</h1>
        <p>If this is your first time using Gridfyx, check out the <a href="<?= System\Core\base_url(); ?>/documentation">manual guide here.</a></p>
        <p>The controller of this page is located at: <span class="highlight">/application/controllers/IndexController.php</span></p>
        <p>This view file is located at: <span class="highlight">/application/views/index.php</span></p>
        <p>Thank you for using Gridfyx. Show your support by <a href="https://github.com/JacksonMangallay/gridfyx" target="_blank">giving it a star!</a></p>
    </div>
</body>
</html>