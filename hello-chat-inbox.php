<?php
    session_start();
?>

<?php
   

    if(isset($_SESSION['idMembre']) && isset($_SESSION['pseudoMembre']) && isset($_SESSION['emailMembre'])){ 
        if(isset($_GET['id'])){

       
        
        ?>



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
            <link rel="stylesheet" href="css/hello-chat-inbox-style.css">
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
                            <a href="hello-home.php">
                                    <span>
                                        <i class="bi bi-arrow-left-circle-fill"></i>
                                    </span>
                            </a>

                            </div>
                            <div class="icon-receiver">
                                <span>
                                    <i class="bi bi-person-circle"></i>
                                </span>
                            </div>
                            <div class="name-reciever-status">
                                <div class="receiver-name">
                                    <p id="receiver-name">Bobo</p>

                                </div>
                                <div class="receiver-status">
                                    <p id="receiver-status">On line</p>

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




                    <div class="main-chat w-100 h-100" id="main-chat">
                        <p class="text-center" id="info-message">
                            
                        </p>
                        

                        

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

        <script>
            jQuery(function($){
                // Variable pour sauvegarder l'id du premier message qui nous permettra de charger les anciens messages
                let firstId = 0;
                // On recupère l'id qui veint de l'url
                const params = new URLSearchParams(window.location.search);

                // Récupérer un paramètre
                var idReceiver = params.get('id');
                
                /** Fonction pour charger les messages inbox */


                function loadMessage(idSender,idReceiver){
                    $.ajax({
                        url: 'load-message-inbox.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            idSenderAjax: idSender,
                            idReceiverAjax: idReceiver

                        },
                        success : function(response){

                            if(response.status === "success"){
                                $("#main-chat").empty();
                                //console.log("ID dernier message " + response.firstMessage);
                                firstId = response.firstMessage ;

                                //firstId = data.firstId; // On stocke l'identifiant du premier message affiché pour pouvoir l'utiliser pour afficher les anciens messages lorsque l'utilisateur scroll vers le haut de la liste des messages.

                                response.listeMessage.forEach(function(itemMsg){
                                    //console.log("Expediteur " + itemMsg.idMembreExpediteur);
                                    
                                    

                                    if(itemMsg.idMembreDestinataire == idReceiver){
                                        //console.log(idReceiver);
                                        $("#main-chat").append(`
                                            <div class="box-message-right">
                                                <div class="main-message-right">
                                                    <p>${itemMsg.messagetext}</p>
                                                    <p>${itemMsg.datemessage}</p>
                                                    <p>${itemMsg.idMessageInbox}</p>
                                                </div>
                                            </div>

                                        `);
                                        
                                       

                                    }else{
                                        $("#main-chat").append(`
                                            <div class="box-message-left">
                                                <div class="main-message-left">
                                                    <p>${itemMsg.messagetext}</p>
                                                    <p>${itemMsg.datemessage}</p>
                                                    <p>${itemMsg.idMessageInbox}</p>

                                                </div>
                                            </div>
                                        `);
                                        

                                       

                                    }


                                   

                                   

                                }); 

                                

                                // 🔥 scroll vers le bas après rendu complet
                                setTimeout(function () {
                                    $("#main-chat").scrollTop($("#main-chat")[0].scrollHeight);
                                }, 50);

                            }
                            if(response.status === "erreur"){
                                //alert(response.message);
                                $('#info-message').css('display','block')
                                $('#info-message').text(response.message);
                            }
                           

                          


                            
                        },
                        error : function(resultat, statut, erreur){
                            alert("erreur lors du chargement des messages");
                            //alert(idSenderAjax) ;
                            //alert(idReceiverAjax);
                        },
                        complete : function(resultat, statut){
                            //alert("requette terminée");

                        }
                    
                    });
                }


                /** Fonction pour récupérer le pseudo et le statut de l'utilisateur en BD */

                function getInfoReceiver(idReceiver){

                    $.ajax({
                        url: 'load-info-receiver.php',
                        type: 'GET',
                        dataType: 'json',
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        data: {
                            idAjax: idReceiver
                        },
                        success : function(response){
                            if(response.status === "success"){
                                $('#receiver-name').text(response.infoMembres.pseudoMembre);
                                if(response.infoMembres.statut === "en ligne"){
                                    $('#receiver-status').text(response.infoMembres.statut);

                                }else{
                                    // Séparer date et heure
                                    let dateComplete = response.infoMembres.derniereConnexion;
                                    let parts = dateComplete.split(' ');
                                    let dateSeule = parts[0]; 
                                    let heureSeule = parts[1]; 
                                    $('#receiver-status').text("en ligne le " + dateSeule + " à " +heureSeule);

                                }
                                

                            }
                           



                            
                        },
                        error : function(resultat, statut, erreur){
                            alert("erreur lors de la récupération des info du destinataire");
                        },
                        complete : function(resultat, statut){
                            //alert("requette terminée");

                        }
                
                    });


                }

               
                // Vérifier si le paramètre existe
                if(idReceiver){

                    let userLogin = {
                        idMembre: <?php echo json_encode($_SESSION['idMembre']); ?>
                        
                    };

                    idSender = userLogin.idMembre ;

                    getInfoReceiver(idReceiver);
                    loadMessage(idSender,idReceiver);




                    // Maintenant, on va afficher les anciens messages lorsque l'utilisateur scroll vers le bas de la liste des messages. Pour cela, on va faire une requette ajax pour récupérer les anciens messages à partir de l'identifiant du premier message affiché (firstId) et on va les ajouter au début de la liste des messages.

                    let anciennePosition = 0 ;
                    $("#main-chat").scroll(function(){
                    
                        // Position actuelle du scroll
                        let nouvellePosition = $(this).scrollTop();


                        if(nouvellePosition > anciennePosition){
                            //console.log("Scroll vers le bas");

                            

                        }else{
                            //console.log("Scroll vers le haut");

                            

                            if($("#main-chat").scrollTop() === 0 && firstId > 0){

                                firstId = firstId - 1;
                                

                                // On est en haut de la liste des messages et il y a des anciens messages à afficher
                                $.ajax({
                                    url: 'afficherancienmessages.php',
                                    type: 'GET',
                                    dataType: 'json',
                                    data: {
                                        firstIdAjax: firstId
                                    },
                                    success : function(response){
                                        if(response.status === "success"){
                                            // Ajoute le message au début de la liste des messages
                                            response.oldMessage.forEach(function(itemMsg){

                                                if(itemMsg.idMembreDestinataire == idReceiver){
                                                    //console.log(idReceiver);
                                                    $("#main-chat").prepend(`
                                                        <div class="box-message-right">
                                                            <div class="main-message-right">
                                                                <p>${itemMsg.messagetext}</p>
                                                                <p>${itemMsg.datemessage}</p>
                                                                <p>${itemMsg.idMessageInbox}</p>
                                                            </div>
                                                        </div>

                                                    `);
                                                    
                                                

                                                }else{
                                                    $("#main-chat").prepend(`
                                                        <div class="box-message-left">
                                                            <div class="main-message-left">
                                                                <p>${itemMsg.messagetext}</p>
                                                                <p>${itemMsg.datemessage}</p>
                                                                <p>${itemMsg.idMessageInbox}</p>

                                                            </div>
                                                        </div>
                                                    `);
                                                    

                                                

                                                }

                                            });

                                            firstId = response.newFirstId; // On met à jour l'identifiant du premier message affiché pour pouvoir afficher les autres anciens messages lorsque l'utilisateur scroll vers le haut de la liste des messages.

                                            console.log(firstId);

                                            $("#main-chat").scrollTop(50); // On remet le scroll à 50px pour éviter de déclencher à nouveau l'événement scroll vers le haut

                                            
                                        }else{
                                            //alert(data.message);
                                        }
                                    },
                                    error : function(resultat, statut, erreur){
                                        alert("erreur lors du chargement des messages")
                                    },
                                    complete : function(resultat, statut){
                                        //alert("requette terminée");
                                    }
                                });
                            }
                        }
                        // Met à jour l'ancienne position pour la prochaine comparaison
                        anciennePosition = nouvellePosition; 
                    });


                   




                    
                }

            });
        </script>
        </body>
        </html>


 <?php

        }else{
            echo "Identifiant de l'url manquant" ;
        }    

    }
    else{
        header("Location:index.php");

    }

?>