$(function(){
    $("#addClass").click(function () {
        $('#qnimate').addClass('popup-box-on');
        $('#addClass').hide("slow").css('display','none');
    });

    $("#removeClass").click(function () {
        $('#qnimate').removeClass('popup-box-on');
        $('#addClass').show("slow").css('display','block');
    });
})