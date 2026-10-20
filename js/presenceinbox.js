
function verificationPresenceInbox(idReceiver, idSender){

    $.ajax({
        url: 'verificationpresenceinbox.php',
        type: 'GET',
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        data: {
            idSenderAjax: idSender,
            idReceiverAjax: idReceiver
        },
        success : function(response){
            if(response.status === "success"){
                alert(response.message);
                

            }
            



            
        },
        error : function(resultat, statut, erreur){
            alert("erreur lors de l'insertion de la présence dans la base de données");
        },
        complete : function(resultat, statut){
            //alert("requette terminée");

        }

    });


}

verificationPresenceInbox(idReceiver, idSender);
