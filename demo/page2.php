<?php require('required.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper p-5">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8 col-sm-10 <?php echo ($_SESSION['urlIsAllowedToLoad'] ? 'bg-info' : 'bg-danger'); ?> text-center">
                <h3>Public content, you are in page2.php</h3>
                <p>Anyone can see this content, you are in page2.php</p>

                <?php if($_SESSION['isUser']){ ?>
                <img src="<?php echo $_SESSION['data']['avatar']; ?>" alt="avatar" style="max-width: 100px;" class="img-thumbnail mb-1 bg-info">
                <?php } ?>

            </div>
        </div>
        <div class="row justify-content-center no-gutters">
            <div class="col-lg-8 col-sm-6">
                <?php if(!$_SESSION['isUser']){ ?>
                <div class="col-12">
                    <form id="loginForm" name="loginForm" onsubmit="return tryToAuthenticate(event)" class="form-inline mt-2">
                        <input type="email" title="Enter email" class="form-control mr-1" name="useremail" placeholder="email@example.com" value="demo@mail.com">
                        <input type="password" title="Enter password" class="form-control mr-1" name="userpassword" value="your_password_here">
                        <button type="submit" class="btn btn-info">Authenticate</button>
                    </form>
                </div>
                <?php } ?>
                <div class="row mt-3">
                    <div class="col-6">
                        <p>Contents of this demo are:</p>
                        <dd>
                            <li><a href="index.php">index.php</a> -> public</li>
                            <li><a href="page2.php">page2.php</a> -> public</li>
                            <li><a href="private.php">private.php</a> -> private</li>
                        </dd>

                        <span>
                            if you are a guest and click on private.php in the menu, you won't be able to load it and will be sent to index
                        </span>

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
    <script>
        function tryToAuthenticate(event){
            event.preventDefault();

            $.ajax({
                method: "POST",
                url: "authentication.php",
                dataType: 'json',
                data: $('#loginForm').serializeArray()
            }).done(function( validationResponse ) {
                if(validationResponse.ok){
                    alert(validationResponse.msg);
                    /**
                     * in a propper system, content would be updated here,
                     * but for the sake of this demo, we will just reload
                     */
                    location.reload();
                }else{
                    alert(validationResponse.msg);
                }
            });
        };
    </script>
</body>
</html>
