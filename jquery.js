$(document).ready(function(){
    $('#btn1').on("click", function() { 
    $("#consoleRecherche").empty();
 });

  var iNew = 0;
  $('#formNew').submit(function(event) {
      event.preventDefault()

        var libelle_equipe1 = $('#libelle_equipe1').val();
        var libelle_equipe2 = $('#libelle_equipe2').val();
        var id_equipe1 = $('#id_equipe1').val();
        var id_equipe2 = $('#id_equipe2').val();
        var cote1 = $('#cote1').val();
        var coteN = $('#coteN').val();
        var cote2 = $('#cote2').val();
        var date = $('#date').val();
        var heure = $('#heure').val();
        

    $.ajax({
      url: 'confrontations/creer.php',
      method: 'POST',
        
      data :{ libelle_equipe1 : libelle_equipe1,
              libelle_equipe2 : libelle_equipe2,
              id_equipe1 : id_equipe1,
              id_equipe2 : id_equipe2,
              cote1 : cote1,
              coteN : coteN,
              cote2 : cote2,
              date : date,
              heure : heure       
      },  
      success: function(data) {
          iNew++;
          console.log(data['message']);
          var message = data['message'];
            $("#consoleRecherche").append("<span>"+ iNew + ": " + message +
             "<br/>- idE1: "+id_equipe1+ " - idE2: " + id_equipe2 + " - date: "+
             date +" - heure: "+heure +"</span><br/>" );
             document.getElementById('consoleRecherche').scrollTop = 
             document.getElementById('consoleRecherche').scrollHeight;   
      },
      error: function() {
        $("#consoleRecherche").append('<span>La requête n\'a pas abouti<span><br/>'); }
    });    
  }); 

  var iMaj = 0;
  $('#formMaj').submit(function(event) {
      event.preventDefault()
      var idMatch = $('#id_matchX').val()
      var result = $('#resultatX').val()
    $.ajax({
      url: 'confrontations/modifier.php',
      method: 'POST',
      dataType : "json",  
      data :{ id_match : idMatch,
              resultat : result        
      },  
      success: function(data) {
          iMaj++;
          console.log(data['message']);
          var message = data['message'];
            $("#consoleRecherche").append("<span>"+ iMaj + ": " + message + "  - id match:  " + idMatch + "  -  résultat:  "+ result +"</span><br/>" );
            document.getElementById('consoleRecherche').scrollTop = 
            document.getElementById('consoleRecherche').scrollHeight;   
      },
      error: function() {
        $("#consoleRecherche").append('<span>La requête n\'a pas abouti<span><br/>'); }
    });    
  }); 

  var iSup = 0;
  $('#formSup').submit(function(event) {
      event.preventDefault()
        var id_match = $('#id_matchR').val();

    $.ajax({
      url: 'confrontations/supprimer.php',
      method: 'POST',
        
      data :{ id_match : id_match                
      },  
      success: function(data) {
          iSup++;
          console.log(data['message']);
          var message = data['message'];
            $("#consoleRecherche").append("<span>"+ iSup + ": " + message +
             "<br/>- id Match: "+id_match+"</span><br/>" );
             document.getElementById('consoleRecherche').scrollTop = 
             document.getElementById('consoleRecherche').scrollHeight;   
      },
      error: function() {
        $("#consoleRecherche").append('<span>La requête n\'a pas abouti<span><br/>'); }
    });    
  }); 

  
  $('#formRecherche').submit(function(event) {
      event.preventDefault()
        var annee = $('#annee').val();
        var semaine = $('#semaine').val();

    $.ajax({
      url: 'confrontations/lire.php',
      method: 'GET',
    
      data :{ 
          annee : annee,
          semaine : semaine 
      },  
      success: function(data) {
        if (data["message"] == null){
         var result = data['match'];
           console.log(result);
            var i = 0;

           while (result[i] != null){
            var match = `<p>
            Id match : ${result[i].id_match}<br/>
            ligue : ${result[i].libelle_ligue}<br/>
            Nom équipe 1 : ${result[i].libelle_equipe1}<br/>
            Id équipe 1 : ${result[i].id_equipe1}<br/>
            Nom équipe 2 : ${result[i].libelle_equipe2}<br/>
            Id équipe 2 : ${result[i].id_equipe2}<br/>
            Cote 1 : ${result[i].cote1}<br/>
            Cote N : ${result[i].coteN}<br/>
            Cote 2 : ${result[i].cote2}<br/>
            Date : ${result[i].date}<br/>
            Heure : ${result[i].heure}<br/>
            Résultat : ${result[i].resultat}<br/>
            Semaine : ${result[i].semaine}<br/>
            </p>`;

            $("#consoleRecherche").append("<span>"+ match +
            "</span><br/>" ); 
             i++
            }
            document.getElementById('consoleRecherche').scrollTop = 
            document.getElementById('consoleRecherche').scrollHeight;   
            
        }
        else{
            console.log(data['message']);
            var message = data['message'];
            $("#consoleRecherche").append("<span>"+ message +
             "</span><br/>" );
        }

      },
      error: function() {
        $("#consoleRecherche").append('<span>La requête n\'a pas abouti<span><br/>'); }
    });    
  }); 

  var iRecherche = 0;
  $('#formRechercheId').submit(function(event) {
      event.preventDefault()
        var id_match = $('#id_match').val();

    $.ajax({
      url: 'confrontations/lire_un.php',
      method: 'GET',
        
      data :{ id_match : id_match                
      },  
      success: function(data) {
        if (data["message"] == null){
            var match = `<p>
            Id match : ${data.id_match}<br/>
            ligue : ${data.libelle_ligue}<br/>
            Nom équipe 1 : ${data.libelle_equipe1}<br/>
            Id équipe 1 : ${data.id_equipe1}<br/>
            Nom équipe 2 : ${data.libelle_equipe2}<br/>
            Id équipe 2 : ${data.id_equipe2}<br/>
            Cote 1 : ${data.cote1}<br/>
            Cote N : ${data.coteN}<br/>
            Cote 2 : ${data.cote2}<br/>
            Date : ${data.date}<br/>
            Heure : ${data.heure}<br/>
            Résultat : ${data.resultat}<br/>
            Semaine : ${data.semaine}<br/>
            </p>`;

            $("#consoleRecherche").append("<span>"+ match +
            "</span><br/>" );
            document.getElementById('consoleRecherche').scrollTop = 
            document.getElementById('consoleRecherche').scrollHeight;  

        }
        else{
            console.log(data['message']);
            var message = data['message'];
            $("#consoleRecherche").append("<span>"+ message +
             "</span><br/>" );
        }
      },
      error: function() {
        $("#consoleRecherche").append('<span>La requête n\'a pas abouti<span><br/>'); }
    });    
  }); 

  $('#rechercheTous').on("click", function(event) { 
    event.preventDefault()
        var annee = $('#annee').val();
        var semaine = $('#semaine').val();

    $.ajax({
      url: 'confrontations/lire.php',
      method: 'GET',
     
      success: function(data) {
        if (data["message"] == null){
         var result = data['match'];
         var i = 0;
           while (result[i] != null){
            var match = `<p>
            Id match : ${result[i].id_match}<br/>
            ligue : ${result[i].libelle_ligue}<br/>
            Nom équipe 1 : ${result[i].libelle_equipe1}<br/>
            Id équipe 1 : ${result[i].id_equipe1}<br/>
            Nom équipe 2 : ${result[i].libelle_equipe2}<br/>
            Id équipe 2 : ${result[i].id_equipe2}<br/>
            Cote 1 : ${result[i].cote1}<br/>
            Cote N : ${result[i].coteN}<br/>
            Cote 2 : ${result[i].cote2}<br/>
            Date : ${result[i].date}<br/>
            Heure : ${result[i].heure}<br/>
            Résultat : ${result[i].resultat}<br/>
            Semaine : ${result[i].semaine}<br/>
            </p>`;

            $("#consoleRecherche").append("<span>"+ match +
            "</span><br/>" ); 
             i++
            }
            document.getElementById('consoleRecherche').scrollTop = 
            document.getElementById('consoleRecherche').scrollHeight;   
            
        }
        else{
            console.log(data['message']);
            var message = data['message'];
            $("#consoleRecherche").append("<span>"+ message +
             "</span><br/>" );
        }

      },
      error: function() {
        $("#consoleRecherche").append('<span>La requête n\'a pas abouti<span><br/>'); }
    });    
  }); 
    


});

