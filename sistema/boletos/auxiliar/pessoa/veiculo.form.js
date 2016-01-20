function carregaModelos(){
    $.getJSON(oficinaUrlBase+'/modelo/listarMarcaJSON/'+$('#idMarca').attr('value'), function(modelos){
          $('#idModelo').empty();
          $.each(modelos,function (i,item){
             $('<option>').attr('value',item.id).text(item.nome+' ').appendTo('#idModelo');

          });
    });
    
}