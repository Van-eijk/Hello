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
            <title>Hello-home</title>

            <!-- lien pour integrer le framework boostrap -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <script src="https://kit.fontawesome.com/14273d579a.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="css/hello-home-style.css">
            <link rel="stylesheet" href="css/header.css">
        </head>
        <body>
            <div class="container">
                <?php include "header.php" ; ?>
                <?php include 'popupdeconnexion.php'; //Confirmation de déconnexion de l'utilisateur ?>

                <div class="main-content" id="main-content">
                    <p id="info-discussion"></p>

                   



                    
                </div>
            </div>



            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
            <script>
               jQuery(function($){

                    // On récupère l'identifiant du membre connecté depuis la session
                    let idMembre = <?php if(isset($_SESSION['idMembre'])) { echo $_SESSION['idMembre']; }?>;
                    let pseudoMembre = "<?php if(isset($_SESSION['pseudoMembre'])) { echo $_SESSION['pseudoMembre']; }?>";

                    let idFirstDiscussion = 0 ; // On initialise l'identifiant de la première discussion à null pour pouvoir le récupérer plus tard


                  


                    function loadDiscussionInbox(idMembre, callback){
                        let discussionId = [] ; // On initialise un tableau pour stocker les identifiants des discussions
                        $.ajax({
                            url: 'afficherDiscussionInbox.php',
                            type: 'GET',
                            dataType: 'json',
                            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                            data: {
                                idMembreAjax : idMembre

                            },
                            success : function(response){
                                
                                if(response.status === "success"){
                                    

                                    
                                    //alert("Discussions récentes récupérées avec succès !");
                                    $('#main-content').empty(); // On vide le contenu de la div avant d'ajouter les nouvelles discussions
                                    response.discussionsInbox.forEach(function(discussion){

                                        discussionId.push(discussion.idMessageInbox) ; // On ajoute l'identifiant de la discussion au tableau
                                      
                                        if(discussion.sender === pseudoMembre){
                                            discussion.sender = discussion.receiver; // On remplace le pseudo de l'expéditeur par celui du destinataire si l'expéditeur est le membre connecté
                                        }

                                        if(discussion.idMembreDestinataire === idMembre){
                                            discussion.idMembreDestinataire = discussion.idMembreExpediteur; // On remplace l'identifiant du destinataire par celui de l'expéditeur si le destinataire est le membre connecté
                                        }

                                        

                            
                                       
                                        let discussionHTML = `
                                           <a href="hello-chat-inbox.php?id=${discussion.idMembreDestinataire}" class="discussion-item" id="${discussion.idMembreDestinataire}">
                                                <div class="item-message">
                                                    <div class="icon-message">
                                                        <span>
                                                            <i class="bi bi-person-circle"></i>
                                                        </span>

                                                    </div>
                                                    <div class="main-message border-bottom">
                                                        <div class="sender-message">
                                                            <h5>${discussion.sender}</h5>
                                                        </div>
                                                        <div class="message-text">
                                                            <p>${discussion.messagetext}</p>
                                                        </div>

                                                    </div>
                                                    <div class="hour-message">
                                                        <p>${discussion.datemessage}</p>
                                                        <div class="new-message">
                                                            <span>1</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        `;

                                        // Maintenant on vérifie si l'expéditeur est déjà présent dans la liste des discussions pour éviter les doublons. Si l'expéditeur est déjà présent, on ne l'ajoute pas à la liste.

                                        let discussionitem = $(".discussion-item"); //On récupère tous les éléments de discussion déjà présents dans la liste
                                        let text = discussionitem.map(function(){
                                            return $(this).find(".sender-message h5").text() ;
                                        }).get() ; // On récupère le texte de tous les éléments de discussion déjà présents dans la liste et on le stocke dans un tableau

                                        if(text.includes(discussion.sender)){
                                            console.log("présent") ;
                                        }
                                        else{
                                            $('#main-content').append(discussionHTML); // On ajoute l'élément de discussion à la liste si l'expéditeur n'est pas déjà présent
                                        }





                                       
                                        

                                        
                                    });


                                    if(callback && typeof callback === 'function') {
                                        callback(discussionId[0]); // On appelle la fonction de rappel avec l'identifiant de la première discussion
                                    }


                                }else{
                                    //alert("Aucune discussion récente");
                                    $('#info-discussion').text(response.message);
                                }
                                
                            
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText); // 🔥 debug réel
                                alert("Erreur avec la communication avec la BD");
                            }
                        
                        });
                    }




                    // Fonction pour verifier l'arrivage de nouveaux messages dans la discussion

                    let newD = false ;

                    function getNewDiscussions(idMembre, pseudoMembre, lastIdMessage, callback){
                        let discussionId = [] ; // On initialise un tableau pour stocker les identifiants des discussions
                        let identifiantDiscussion = 0 ;

                        $.ajax({
                            url: 'getNewDiscussions.php',
                            type: 'GET',
                            dataType: 'json',
                            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                            data: {
                                idMembreAjax: idMembre,
                                
                                lastIdMessageAjax: lastIdMessage
                            },
                            success : function(response){
                                if(response.status === "success"){

                                    response.newDiscussions.forEach(function(discussion){

                                        discussionId.push(discussion.idMessageInbox) ; // On ajoute l'identifiant de la discussion au tableau


                                        if(discussion.sender === pseudoMembre){
                                            discussion.sender = discussion.receiver; // On remplace le pseudo de l'expéditeur par celui du destinataire si l'expéditeur est le membre connecté
                                        }

                                        if(discussion.idMembreDestinataire === idMembre){
                                            discussion.idMembreDestinataire = discussion.idMembreExpediteur; // On remplace l'identifiant du destinataire par celui de l'expéditeur si le destinataire est le membre connecté
                                        }


                                        let discussionHTML = `
                                            <a href="hello-chat-inbox.php?id=${discussion.idMembreDestinataire}" class="discussion-item" id="${discussion.idMembreDestinataire}">
                                                <div class="item-message">
                                                    <div class="icon-message">
                                                        <span>
                                                            <i class="bi bi-person-circle"></i>
                                                        </span>

                                                    </div>
                                                    <div class="main-message border-bottom">
                                                        <div class="sender-message">
                                                            <h5>${discussion.sender}</h5>
                                                        </div>
                                                        <div class="message-text">
                                                            <p>${discussion.messagetext}</p>
                                                        </div>

                                                    </div>
                                                    <div class="hour-message">
                                                        <p>${discussion.datemessage}</p>
                                                        <div class="new-message">
                                                            <span>1</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        `;

                                        identifiantDiscussion = discussion.idMembreDestinataire ; // On récupère l'identifiant de la discussion pour vérifier si elle est déjà présente dans la liste

                                        if( $('#'+identifiantDiscussion).length > 0) {
                                            //console.log("L'élément existe !");

                                            $('#'+identifiantDiscussion).remove(); // On supprime l'élément de discussion existant pour éviter les doublons
                                            $('#main-content').prepend(discussionHTML); // On ajoute le nouvel élément de discussion en haut de la liste

                                        }else {
                                            //console.log("L'élément n'existe pas.");
                                            $('#main-content').prepend(discussionHTML); // On ajoute le nouvel élément de discussion en haut de la liste

                                        }


                                            

                                        idLastMessage = discussionId[0] ; // On met à jour l'identifiant du dernier message pour la prochaine vérification
                                    });
                                

                                    if(callback && typeof callback === 'function'){
                                        callback(idLastMessage);
                                    }
                                   //alert("ok");

                                
                                }
                                if(response.status === "error"){
                                    //alert(response.message);
                                }
                                
                            },
                            error : function(resultat, statut, erreur){
                                alert("erreur lors de la vérification des nouveaux messages");
                            },
                            complete : function(resultat, statut){
                                //alert("requette terminée");

                            }
                    
                        });
                    }



                    loadDiscussionInbox(idMembre, function(firstId){
                        lastIdMessage = firstId ; // On récupère l'identifiant de la première discussion
                        //alert("L'identifiant de la première discussion est : " + lastIdMessage); // On affiche l'identifiant de la première discussion pour vérifier qu'il est bien récupéré


                        // On vérifie les nouveaux messages toutes les 5 secondes
                        setInterval(function(){
                            getNewDiscussions(idMembre, pseudoMembre, lastIdMessage, function(newLastIdMessage){
                                lastIdMessage = newLastIdMessage ; // On met à jour l'identifiant du dernier message pour la prochaine vérification
                                //alert("L'identifiant du dernier message est : " + lastIdMessage); // On affiche l'identifiant du dernier message pour vérifier qu'il est bien mis à jour
                            });
                        }, 500);


                        
                    });









                   
                });
            </script>
        </body>
        </html>


    <?php
    }
        else{
            header("Location:index.php");

        }

?>