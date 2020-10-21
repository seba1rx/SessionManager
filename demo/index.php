<?php require('required.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="wrapper p-5">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8 col-sm-10 <?php echo ($_SESSION['urlIsAllowedToLoad']? 'bg-info': 'bg-danger'); ?> text-center">
                <h3>Public content</h3>
                <p>Anyone can see this content, you are in index.php</p>

                <?php if($_SESSION['isUser']){ ?>  
                <img src="<?php echo $_SESSION['data']['avatar']; ?>" alt="avatar" style="max-width: 100px;" class="img-thumbnail mb-1 bg-info">
                <?php } ?>

            </div>
        </div>
        <div class="row justify-content-center no-gutters">
            <div class="col-lg-8 col-sm-10">
                <div class="row mt-5">
                    <div class="col-6">
                        <p>Contents of this demo are:</p>
                        <dd>
                            <li><a href="index.php">index.php</a> -> public</li>
                            <li><a href="page2.php">page2.php</a> -> public</li>
                            <li><a href="private.php">private.php</a> -> private</li>
                        </dd>

                        <?php if($_SESSION['isUser']){ ?>  
                        <a href="exit.php" class="btn btn-success mt-2">Log out</a>
                        <?php } ?>

                    </div>
                    <div class="col-6">
                        <h5>your session data:</h5>
                        <pre><?php echo json_encode($_SESSION, JSON_PRETTY_PRINT) ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>