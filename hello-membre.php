<?php
    session_start();
    include 'class/uploadclass.php';
    include 'database/configdatabase.php';
    $lienFichierBDD = "database/configdatabase.php";
?>

<?php
   

    if(isset($_SESSION['idMembre']) && isset($_SESSION['pseudoMembre']) && isset($_SESSION['emailMembre'])){ ?>



        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>hello - membre</title>

            <!-- lien pour integrer le framework boostrap -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <script src="https://kit.fontawesome.com/14273d579a.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="css/hello-membre-style.css">
            <link rel="stylesheet" href="css/header.css">


        </head>
        <body>
            <div class="container">
                <?php include "header.php" ; ?>
                <?php include 'popupdeconnexion.php'; //Confirmation de déconnexion de l'utilisateur ?>

                <div class="main-content" id="member-content" >
                   
                   




                    

                </div>

            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

            <script>
                function loadMessage(){
                    $.ajax({
                        url: 'load-members.php',
                        type: 'GET',
                        dataType: 'json',
                        success : function(response, statut){

                            if(response.status === "success"){
                                //$('#member-content').empty();

                                //$('#member-content').append(response.listeDesMembres);

                                

                                response.listeDesMembres.forEach(function(itemMembre) {
                                    if(itemMembre.statut == "en ligne"){
                                            $("#member-content").append(`
                                            <a href='hello-chat-inbox.php'>
                                                <div class='item-membre border'>
                                                    <div class='info-membre'>
                                                        <span>
                                                            <i class='bi bi-person-circle'></i>
                                                        </span>
                                                        <p>${itemMembre.pseudoMembre}</p>
                                                    </div>
                                                    <div class='status'>
                                                        <div class='online'></div>
                                                    </div>
                                                </div>
                                            </a>
                                        `);

                                    }else{

                                     $("#member-content").append(`
                                            <a href='hello-chat-inbox.php'>
                                                <div class='item-membre border'>
                                                    <div class='info-membre'>
                                                        <span>
                                                            <i class='bi bi-person-circle'></i>
                                                        </span>
                                                        <p>${itemMembre.pseudoMembre}</p>
                                                    </div>
                                                    <div class='status'>
                                                        <div class='online d-none'></div>
                                                    </div>
                                                </div>
                                            </a>
                                        `);

                                    }
                                    
                                });

                                

                            }



                            
                        },
                        error : function(resultat, statut, erreur){
                            alert("erreur lors du chargement des membres")
                        },
                        complete : function(resultat, statut){
                            //alert("requette terminée");

                        }
                    
                    });
                }

                loadMessage();
            </script>
        </body>
        </html>



<?php
    }
    else{
        header("Location:index.php");

    }

?>