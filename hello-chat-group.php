
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
            <title>Hello chat inbox</title>

            <!-- lien pour integrer le framework boostrap -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <script src="https://kit.fontawesome.com/14273d579a.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="css/hello-chat-group-style.css">
            <link rel="stylesheet" href="css/header.css">
        </head>
        <body>

            <div class="container">
                <?php include "header.php" ; ?>
                <?php include 'popupdeconnexion.php'; //Confirmation de déconnexion de l'utilisateur ?>


                <div class="main-content">
                    <div class="header-chat">
                        <div class="left-side">
                            <div class="button-back">
                            <a href="hello-groupe.php">
                                    <span>
                                        <i class="bi bi-arrow-left-circle-fill"></i>
                                    </span>
                            </a>

                            </div>
                            <div class="icon-receiver">
                                <span>
                                    <i class="bi bi-people-fill"></i>
                                </span>
                            </div>
                            <div class="name-reciever-status">
                                <div class="receiver-name">
                                    <p>Promo 2018</p>

                                </div>
                                <div class="receiver-status">
                                    <p>Membres</p>

                                </div>

                            </div>
                        </div>
                        <div class="block-button">
                        <button title="Bloquer cette personne">
                                <span class="lock-receiver">
                                    <i class="bi bi-lock-fill"></i>

                                </span>
                                <span class="unlock-receiver">
                                    <i class="bi bi-unlock-fill"></i>

                                </span>
                        </button>
                        </div>
                    </div>




                    <div class="main-chat w-100 h-100">
                        <div class="box-message-left">
                            <div class="main-message-left">
                                <h3>Van</h3>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus, deserunt. Cumque nesciunt, sit ratione, vero eum numquam dignissimos non, maxime aspernatur vitae eos. At quam enim earum placeat nam quasi!</p>
                                <p>12h00</p>
                            </div>
                        </div>

                        <div class="box-message-right">
                            <div class="main-message-right">
                                <h3>Bobo</h3>
                                <p>Lorem ipsum dolor sit amet consectetur, .</p>
                                <p>13h00</p>
                            </div>
                        </div>

                    </div>
                    <div class="send-message">
                        <form action="">
                            <div class="form-floating w-100">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Send message</label>
                            </div>
                            <div class="send">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                        <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
                                        </svg>
                                </button>
                            </div>
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