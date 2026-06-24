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
    <link rel="stylesheet" href="css/index-style.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center">
        <div class="box-login">
            <div class="box-title">
                <h2>Login</h2>
            </div>
            <div class="info" >
                <p id="info">Mot de passe incorrect</p>
            </div>
            <div class="box-form">
               <form action="" method="post" id="formulaireLogin">
                    <div class="pseudo">
                        <div class="icon-pseudo">
                            <span><i class="bi bi-person-fill"></i></span>

                        </div>
                        <input type="text" class="" placeholder="Username" id="pseudoLogin" >               
                    </div>

                    <div class="password">
                        <div class="icon-password">
                            <span><i class="bi bi-lock-fill"></i></span>

                        </div>
                        <input type="password" class="" placeholder="password" id="passwordLogin" >
                    </div>
                    <p><a href="#">Forgot password ?</a></p>
                    <input type="submit" class="send" value="LOGIN">
               </form>

            </div>
            <div class="box-footer">
                <p>Vous n'avez pas encore de compte, <a href="sign-up.php">inscrivez-vous ici</a></p>
            </div>
        </div>

    </div>
    





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <script>
        jQuery(function($){
            $('#formulaireLogin').submit(function(e){
                e.preventDefault();
                //alert("bb");

                let pseudoLogin = $('#pseudoLogin').val().trim() ;
                let passwordLogin = $('#passwordLogin').val() ;
                //alert(passwordLogin);


                $.ajax({
                    url: 'login-data.php',
                    type: 'POST',
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data: {
                        pseudoAjax: pseudoLogin, 
                        passwordAjax : passwordLogin

                    },
                    success : function(response){
                            // message envoyé avec succès
                            //alert(resultat);
                            if(response.status === "success"){
                                //alert(response.message);

                                $(location).attr('href','hello-home.php'); // On redirige l'utilisateur vers la page d'accueil

                                //$('#info').css('visibility','bloc');
                                //$('#info').text('Pseudo ou mot de passe incorrect');

                            }else{
                                alert(response.message);
                            }
                        
                    
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // 🔥 debug réel
                        alert("Erreur avec la communication avec la BD");
                    }
                
                });


            })
        });

    </script>
</body>
</html>