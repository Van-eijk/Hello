<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hello groupe</title>

     <!-- lien pour integrer le framework boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/14273d579a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/hello-groupe-style.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <div class="container">
        <?php include "header.php" ; ?>
        <?php include 'popupdeconnexion.php'; //Confirmation de déconnexion de l'utilisateur ?>

        <div class="main-content">

        <!-- Bouton pour ajouter un groupe-->
            <div class="ajouter-groupe">
                <a href="hello-create-group.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                    </svg>
                    
                
                </a>
            </div>
            <a href="hello-chat-group.php">
                <div class="item-membre border">
                    <div class="info-membre">
                        <span><i class="bi bi-people-fill"></i></span>
                        <p>Promo 2018</p>
                    </div>
                    <div class="status">
                        <div class="number-members">
                            <p>10 membres</p>
                        </div>
                    </div>
                </div>
            </a>


             <a href="hello-chat-group.php">
                <div class="item-membre border">
                    <div class="info-membre">
                        <span><i class="bi bi-people-fill"></i></span>
                        <p>Promo 2018</p>
                    </div>
                    <div class="status">
                        <div class="number-members">
                            <p>10 membres</p>
                        </div>
                    </div>
                </div>
            </a>


             <a href="hello-chat-group.php">
                <div class="item-membre border">
                    <div class="info-membre">
                        <span><i class="bi bi-people-fill"></i></span>
                        <p>Promo 2018</p>
                    </div>
                    <div class="number-members">
                        <p>10 membres</p>
                    </div>
                </div>
            </a>

        </div>



    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    
</body>
</html>