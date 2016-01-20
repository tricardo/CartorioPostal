
$(document).ready(function(){

    $(".addFoto").live('click',function(){
        $.get(oficinaUrlBase+"/veiculo/novaFoto/"+($("#veiculoFotos").children().length), function(data){
          $(data).appendTo('#veiculoFotos');
        });
        return false;
    });

    $(".remFoto").live('click',function(){
        inp = $('<input type="hidden">');
        inp.attr('name','idFotoEx[]');
        inp.attr('value',$(this).attr('rel'));
        inp.appendTo('#fotosExcluir');
        $(this).parent().remove();
        
        return false;
    });

    $('.imagem').live('click',function(){
//        $('#verFoto').slideUp();
        $('#verFoto').empty();
        $('<img>').attr('src',$(this).attr('rel')).appendTo('#verFoto');
//        $('#verFtoto').slideDown('slow');
        return false;
    })


})