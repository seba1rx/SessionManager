<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="wrapper p-5">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8 col-sm-10 bg-info text-center text-white">
                <h3>This is a SPA (Single Page Application) app</h3>
                <br>
                <h3>Check the functions in the left and the session content in the right</h3>

                <?php if($_SESSION['isUser'] ?? false){ ?>
                <img src="<?php echo $_SESSION['data']['avatar']; ?>" alt="avatar" style="max-width: 100px;" class="img-thumbnail mb-1 bg-info">
                <?php } ?>

            </div>
        </div>
        <div class="row justify-content-center no-gutters">
            <div class="col-lg-8 col-sm-10">
                <div class="row mt-5">
                    <div class="col-6">
                        <p>Click on each route to check this app working</p>
                        <dd>
                            <li>GET <a href="/"> Start</a></li>
                            <li>GET <a href="/hello"> Hello</a></li>
                            <li>GET <a href="/demoData"> Demo data</a></li>
                            <li>POST <a href="/login"> Login</a></li>
                            <li>POST <a href="/hello"> Hello</a></li>
                        </dd>

                        <br>

                        <?php if($_SESSION['isUser'] ?? false){ ?>
                            <a href="exit.php" class="btn btn-success mt-2">Log out</a>
                        <?php } ?>

                    </div>
                    <div class="col-6">
                        <h5>your session data:</h5>
                        <pre><?php echo json_encode($_SESSION ?? [], JSON_PRETTY_PRINT) ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>