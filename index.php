<?php 
    require_once 'controller/index.controller.php'; ?>

<!DOCTYPE>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!-- CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="public/css/main.css" />
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-xs-2">
                <i class="fa fa-black-tie fa-5x green" id="logo" aria-hidden="true"></i>
                <h1>Find me a job !</h1>
                <ul class="nav nav-sidebar navbar">
                    <li class="active">plop</li>
                    <li>plup</li>
                </ul>
            </nav>
            <section class="col-xs-10">
                <!--include custom controller and view -->
                <?php 
                    // model may not exist, so we try to include it, we do not require it
                    include_once 'model/motivation.model.php';
                    // require controller
                    require_once 'controller/' .$page .'.controller.php';
                    // require page content
                    require_once 'view/' .$page .'.inc.php'; 
                ?>
            </section>
        </div>
    </div>
    
    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/584f23e963.js"></script>

</body>
