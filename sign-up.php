<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello-login</title>

     <!-- lien pour integrer le framework boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/14273d579a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/sign-up-style.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center">
        <div class="box-login">
            <div class="box-title">
                <h2>SIGN UP</h2>
            </div>
            <div class="info">
                <p>Mot de passe incorrect</p>
            </div>
            <div class="box-form">
               <form action="" method="post">
                    <div class="pseudo">
                        <div class="icon-pseudo">
                            <span><i class="bi bi-person-fill"></i></span>

                        </div>
                        <input type="text" class="" placeholder="Pseudo" >               
                    </div>

                    <div class="pseudo">
                        <div class="icon-pseudo">
                            <span><i class="bi bi-envelope-fill"></i></span>

                        </div>
                        <input type="email" class="" id="emial" placeholder="Email" >               
                    </div>

                    <div class="password">
                        <div class="icon-password">
                            <span><i class="bi bi-lock-fill"></i></span>

                        </div>
                        <input type="password" class="" placeholder="Password" >
                    </div>

                    <div class="password">
                        <div class="icon-password">
                            <span><i class="bi bi-lock-fill"></i></span>

                        </div>
                        <input type="password" class="" id="confirmpassword" placeholder=" Confirm password" >
                    </div>
                    <input type="submit" class="send" value="SIGN UP">
               </form>

            </div>
            <div class="box-footer">
                <p>Vous avez déjà un compte, <a href="index.php">connectez-vous ici</a></p>
            </div>
        </div>

    </div>
    





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</body>
</html>