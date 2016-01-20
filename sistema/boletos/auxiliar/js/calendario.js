
$(document).ready(function(){
    $(".mesAnt").click(function(){
        $("#calendario").load($("#mesAntUrl").val(),{ajax:1});
        return false;
    });

    $(".mesProx").click(function(){
        $("#calendario").load($("#mesProxUrl").val(),{ajax:1});
        return false;
    })

});

