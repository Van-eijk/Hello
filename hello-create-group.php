<?php
    session_start();
?>

<?php
   

    if(isset($_SESSION['idMembre']) && isset($_SESSION['pseudoMembre']) && isset($_SESSION['emailMembre'])){ ?>




        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>hello create group</title>

            <!-- lien pour integrer le framework boostrap -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <script src="https://kit.fontawesome.com/14273d579a.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="css/hello-create-group-style.css">
            <link rel="stylesheet" href="css/header.css">
        </head>
        <body>
            <div class="container">
                <?php include "header.php" ; ?>
                <?php include 'popupdeconnexion.php'; //Confirmation de déconnexion de l'utilisateur ?>

                <div class="main-content">
                    <div class="add-group">
                        <form action="" method="post">
                            <div class="name-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nom du groupe </label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    <div id="info" class="form-text d-none">We'll never share your email with anyone else.</div>
                                </div>

                            </div>

                            <div class="add-members">
                                <div class="admin-group">
                                    <p>Admin</p>
                                    <strong><p>Van</p></strong>
                                </div>
                                <p>Ajouter des membres</p>
                                <div class="list-members">


                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Bobo" id="checkDefault">
                                        <label class="form-check-label" for="checkDefault">
                                            Bobo
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Charles" id="checkChecked" >
                                        <label class="form-check-label" for="checkChecked">
                                            Charles
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="zozo" id="zozo" >
                                        <label class="form-check-label" for="zozo">
                                            zozo
                                        </label>
                                    </div>

                                </div>

                            </div>

                            <button type="submit">Create group</button>
                        </form>
                    </div>
                </div>

            </div>



            


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        </body>
        </html>


<?php
    }
        else{
            header("Location:index.php");

        }

?>