function verifPoid($poidVerif) {

    var poids=  Number($poidVerif);
    if(poids.toLocaleString()==="NaN") {
        $("#divPoids").removeClass("has-succes").addClass("has-error");
        $("#spanPoids").css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
        $("#helpPoids").css("display","block").slideDown("slow").text("Veullez saisir un nombre correcte");
        return false;
    }
    else
    {
        if((poids<=0) || (poids>=1 && poids <=10) || (poids > 560)) {
            $("#divPoids").removeClass("has-succes").addClass("has-error");
            $("#spanPoids").css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
            $("#helpPoids").css("display","block").slideDown("slow").text("Veullez saisir un poid valide");
            return false;

        }
        else if((poids > 10) &&(poids <= 560))
        {
            $("#divPoids").removeClass("has-error").addClass("has-success");
            $("#spanPoids").css("display","block").removeClass("glyphicon glyphicon-remove").addClass("glyphicon glyphicon-ok ").slideDown("slow");
            $("#helpPoids").css("display","none").slideUp("slow");
            return true;
        }
    }
    return false;
}
function verifTaille(tailleVerif) {
    var taille=  Number(tailleVerif);

    if(taille.toLocaleString()==="NaN") {
        $("#divTaille").removeClass("has-succes").addClass("has-error");
        $("#spanTaille").css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
        $("#helpTaille").css("display","block").slideDown("slow").text("Veullez saisir un nombre correcte");
        return false;
    }
    else
    {
        if((taille<=0) || (taille>=1 && taille <=57) || (taille > 280)) {
            $("#divTaille").removeClass("has-succes").addClass("has-error");
            $("#spanTaille").css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
            $("#helpTaille").css("display","block").slideDown("slow").text("Veullez saisir votre taille en cm");
            return false;

        }
        else
        {
            $("#divTaille").removeClass("has-error").addClass("has-success");
            $("#spanTaille").css("display","block").removeClass("glyphicon glyphicon-remove").addClass("glyphicon glyphicon-ok ").slideDown("slow");
            $("#helpTaille").css("display","none").slideUp("slow");
            return true;
        }
    }
    return false;
}
function verifSexe(sexeVerif) {
    var sexe=  Number(sexeVerif);

    if(sexe.toLocaleString()==="Sexe") {
        $("#divSexe").removeClass("has-succes").addClass("has-error");
        $("#helpSexe").css("display","block").slideDown("slow").text("Veullez choisir un Homme/Femme");
        return false;
    }
    else
    {
        $("#divSexe").removeClass("has-error").addClass("has-success");
        $("#helpSexe").css("display","none").slideUp("slow");
        return true;
    }
    return false;
}

function verifAge(ageVerif) {
    var age=  Number(ageVerif);

    if(age.toLocaleString()==="NaN") {
        $("#divAge").removeClass("has-succes").addClass("has-error");
        $("#spanAge").css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
        $("#helpAge").css("display","block").slideDown("slow").text("Veullez saisir un nombre correcte");
        return false;
    }
    else
    {
        if((age<=0)  || (age > 100)) {
            $("#divAge").removeClass("has-succes").addClass("has-error");
            $("#spanAge").css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
            $("#helpAge").css("display","block").slideDown("slow").text("Veullez saisir votre age correctement");
            return false;

        }
        else
        {
            $("#divAge").removeClass("has-error").addClass("has-success");
            $("#spanAge").css("display","block").removeClass("glyphicon glyphicon-remove").addClass("glyphicon glyphicon-ok ").slideDown("slow");
            $("#helpAge").css("display","none").slideUp("slow");
            return true;
        }
    }
    return false;
}