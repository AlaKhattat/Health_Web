function verifPoid(poidVerif,dive) {

    var poids=  Number(poidVerif);
    if(poids.toLocaleString()==="NaN") {
       console.log( $(dive).find("span")[0]);
        $(dive).removeClass("has-succes").addClass("has-error");
        $(dive).find($(dive).find("span")[0]).css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
        $(dive).find($(dive).find("span")[1]).css("display","block").slideDown("slow").text("Veullez saisir un nombre correcte");
        return false;
    }
    else
    {
        if((poids<=0) || (poids>=1 && poids <=10) || (poids > 560)) {
            $(dive).removeClass("has-succes").addClass("has-error");
            $(dive).find($(dive).find("span")[0]).css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
            $(dive).find($(dive).find("span")[1]).css("display","block").slideDown("slow").text("Veullez saisir un poid valide");
            return false;

        }
        else if((poids > 10) &&(poids <= 560))
        {
            $(dive).removeClass("has-error").addClass("has-success");
            $(dive).find($(dive).find("span")[0]).css("display","block").removeClass("glyphicon glyphicon-remove").addClass("glyphicon glyphicon-ok ").slideDown("slow");
            $(dive).find($(dive).find("span")[1]).css("display","none").slideUp("slow");
            return true;
        }
    }
    return false;
}
function verifTaille(tailleVerif,diveTaille) {
    var taille=  Number(tailleVerif);
      console.log(taille);
    if(taille.toLocaleString()==="NaN") {
        $(diveTaille).removeClass("has-succes").removeClass("has-error").addClass("has-error");
        $(diveTaille).find($(".divTaille").find("span")[0]).css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
        $(diveTaille).find($(".divTaille").find("span")[1]).css("display","block").slideDown("slow").text("Veullez saisir un nombre correcte");
        return false;
    }
    else
    {
        if((taille<=0) || (taille>=1 && taille <=57) || (taille > 280)) {
            $(diveTaille).removeClass("has-succes").removeClass("has-error").addClass("has-error");
            $(diveTaille).find($(diveTaille).find("span")[0]).css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
            $(diveTaille).find($(diveTaille).find("span")[1]).css("display","block").slideDown("slow").text("Veullez saisir votre taille en cm");
            return false;

        }
        else
        {
            $(diveTaille).removeClass("has-error").removeClass("has-succes").addClass("has-success");
            $(diveTaille).find($(".divTaille").find("span")[0]).css("display","block").removeClass("glyphicon glyphicon-remove").addClass("glyphicon glyphicon-ok ").slideDown("slow");
            $(diveTaille).find($(".divTaille").find("span")[1]).css("display","none").slideUp("slow");
            return true;
        }
    }
    return false;
}
function verifSexe(sexeVerif,dive) {
    var sexe=  Number(sexeVerif);
    if(sexe.toLocaleString()==="Sexe") {
        $(dive).removeClass("has-succes").addClass("has-error");
        $(dive).find("help-block").css("display","block").slideDown("slow").text("Veullez choisir un Homme/Femme");
        return false;
    }
    else
    {
        $(dive).removeClass("has-error").addClass("has-success");
        $(dive).find("help-block").css("display","none").slideUp("slow");
        return true;
    }
    return false;
}

function verifAge(ageVerif,dive) {
    var age=  Number(ageVerif);

    if(age.toLocaleString()==="NaN") {
        $(dive).removeClass("has-succes").addClass("has-error");
        $(dive).find($(".divAge").find("span")[0]).css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
        $(dive).find($(".divAge").find("span")[1]).css("display","block").slideDown("slow").text("Veullez saisir un nombre correcte");
        return false;
    }
    else
    {
        if((age<=0)  || (age > 100)) {
            $(dive).removeClass("has-succes").addClass("has-error");
            $(dive).find($(".divAge").find("span")[0]).css("display","block").addClass("glyphicon glyphicon-remove ").slideDown("slow");
            $(dive).find($(".divAge").find("span")[1]).css("display","block").slideDown("slow").text("Veullez saisir votre age correctement");
            return false;

        }
        else
        {
            $(dive).removeClass("has-error").addClass("has-success");
            $(dive).find($(".divAge").find("span")[0]).css("display","block").removeClass("glyphicon glyphicon-remove").addClass("glyphicon glyphicon-ok ").slideDown("slow");
            $(dive).find($(".divAge").find("span")[1]).css("display","none").slideUp("slow");
            return true;
        }
    }
    return false;
}