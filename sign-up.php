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
            <div class="info" id="info">
                <p>Mot de passe incorrect</p>
            </div>
            <div class="box-form">
               <form action="" id="form-inscription" method="post">
                    <div class="pseudo">
                        <div class="icon-pseudo">
                            <span><i class="bi bi-person-fill"></i></span>

                        </div>
                        <input type="text" class="" placeholder="Pseudo" id="pseudo" require>               
                    </div>

                    <div class="pseudo">
                        <div class="icon-pseudo">
                            <span><i class="bi bi-envelope-fill"></i></span>

                        </div>
                        <input type="email" class="" id="email" placeholder="Email" require>               
                    </div>

                    <div class="password">
                        <div class="icon-password">
                            <span><i class="bi bi-lock-fill"></i></span>

                        </div>
                        <input type="password" class="" placeholder="Password" id="password" require>
                    </div>

                    <div class="password">
                        <div class="icon-password">
                            <span><i class="bi bi-lock-fill"></i></span>

                        </div>
                        <input type="password" class="" id="confirmpassword" placeholder=" Confirm password" id="confirmpassword" require>
                    </div>
                    <input type="submit" class="send" value="SIGN UP" id="send" >
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

    <script>
        jQuery(function($){

           //alert("bobo");

            $('#form-inscription').submit(function(e){
                e.preventDefault(); // On empêche le rechargement de la page
                let pseudo = $('#pseudo').val().trim();
                let email = $('#email').val().trim();
                let password = $('#password').val();
                let confirmpassword = $('#confirmpassword').val();

                if(password === confirmpassword){
                    $('#info').css('visibility', 'hidden');

                    // On lance l'inscription à travers ajax

                    $.ajax({
                        url: 'signup-data.php',
                        type: 'POST',
                        dataType: 'json',
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        data: {
                            pseudoAjax: pseudo, 
                            emailAjax: email,
                            passwordAjax : password

                        },
                        success : function(response){
                                // message envoyé avec succès
                                //alert(resultat);
                                if(response.status === "success"){
                                    alert(response.message);
                                    $(location).attr('href','index.php'); // On redirige l'utilisateur vers la page de connexion
                                }else{
                                    alert(response.message);
                                }
                            
                        
                        },
                        error: function(xhr) {
                                    console.log(xhr.responseText); // 🔥 debug réel
                                    alert("Erreur lors de l'envoi du message");
                                }
                
                    });
                    
                }
                else{
                    $('#info').css('visibility', 'bloc');
                    $('#info').css('text-align', 'center');
                    $('#info').text('Les mots de passe sont différents !');
                    
                }


               
            });

        });
    </script>
</body>
</html>