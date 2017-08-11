<?php
    require_once 'router.php';
?>

<!-- display page -->
<!DOCTYPE>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!-- CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="public/css/main.css" />
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> 
    <!-- custom page css file -->
    <?php
        $filename = 'public/css/' .$page .'.css';
        if (file_exists($filename)) { echo '<link rel="stylesheet" type="text/css" href="' .$filename .'"'; }
    ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-xs-2">
                <a href="index.php" class="no-decoration">
                    <i class="fa fa-black-tie fa-5x green" id="logo" aria-hidden="true"></i>
                    <h1>Find me a job !</h1>
                </a>
                <ul class="nav nav-sidebar navbar">
                    <li><a href="index.php?page=application">Envoyer ma candidature</a></li>
                    <li><a href="index.php?page=history">Historique des candidatures</a></li>
                    <li class="active"><a href="index.php?page=motivation">Lettre de motivation</a></li>
                    <li class="active"><a href="index.php?page=htmllivedisplay">Editions HTML en direct</a></li>
                </ul>
            </nav>
            <section class="col-xs-10">
                <h1 class="center bordered-h1"><?php echo $pageTitle; ?></h1>
                <!--include custom view -->
                <!-- jumbotron (only if there's a message to display) -->
                <?php if (isset($msg) && $msg !== "") {
                ?>    
                    <section class="jumbotron small-margin-top"><?php echo $msg; ?></section>
                <?php
                    }
                
                    $filename = 'view/' .$page .'.view.php';
                    require_once $filename;
                ?>
            </section>
        </div>
    </div>
    <!-- CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/584f23e963.js"></script>
    <script src="public/vendor/knob/js/jquery.knob.js"></script>
    <script src="public/js/main.js"></script>
    <!-- custom page js file -->
    <?php
        $filename = 'public/js/' .$page .'.js';
        echo '<script src="' .$filename .'"></script>';
    ?>
</body>
