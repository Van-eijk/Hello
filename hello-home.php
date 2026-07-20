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


                  


                    function loadDiscussionInbox(idMembre){
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
                                        if(discussion.sender === pseudoMembre){
                                            discussion.sender = discussion.receiver; // On remplace le pseudo de l'expéditeur par celui du destinataire si l'expéditeur est le membre connecté
                                        }

                                        if(discussion.idMembreDestinataire === idMembre){
                                            discussion.idMembreDestinataire = discussion.idMembreExpediteur; // On remplace l'identifiant du destinataire par celui de l'expéditeur si le destinataire est le membre connecté
                                        }

                                        

                            
                                       
                                        let discussionHTML = `
                                           <a href="hello-chat-inbox.php?id=${discussion.idMembreDestinataire}" class="discussion-item">
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



                                       
                                        //$('#main-content').append(discussionHTML);

                                        
                                    });


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



                    loadDiscussionInbox(idMembre);


                   
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