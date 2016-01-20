var removTels= new Array();

function mudaForm(){
    if($("#tipo").val()=="F"){
      $("#fisica").show();
      $("#juridica").hide();
      $("#nfantasia").hide();
    }
    else {
      $("#fisica").hide();
      $("#juridica").show();
      $("#nfantasia").show();
    }
}

$(document).ready(function(){
    $("#tipo").change(function(){
        mudaForm();
    });

    $("#cpf").keyup(function(){
        cpfMasc(this);
        if($(this).attr('value').length==14){
            var cpf = cpfBD($(this).attr('value'));
            $.getJSON(urlBase+"/pessoa/verificaCPF/"+cpf,function(data){
                if(data.length>0){
                    if(confirm('CPF já cadastrado!\ncarregar seus dados?')){
                      $('#id').attr('value',data[0].id);
                      $('#nome').attr('value',data[0].nome);
                      $('#email').attr('value',data[0].email);
                    }
                }
            });
            $('#nome').focus();
        }
    });

    $("#addTelefone").click(function(){
    	$.get(urlBase+"/pessoa/novoTel/"+($("#telefoneForm").children().length-1), function(data){
          $(data).appendTo('#telefoneForm');
        });
        return false;
    });

    $(".strUpper").keyup(function(){
        toUpper(this);
    });

    $(".strLower").keyup(function(){
        toLower(this);
    });

    $(".removeTel").live('click',function(){
        var idTel = 'id'+$(this).parent().attr('id').replace(/^tel(\d)+/g,"$1");
	if( $('#'+idTel) != null){
            removTels.push( $('#'+idTel).attr('value') );
        }
	$('#removerTels').attr('value',removTels);
        $(this).parent().remove();
        return false;
    });

    $(".remEmpresa").live('click',function(){
        if(confirm('Realmente deseja remover a empresa?'))
        $('#idempresa').attr('value','');
        return false;
    });
    $(".remContato").live('click',function(){
        if(confirm('Realmente deseja remover o contato?'))
        $('#idcontato').attr('value','');
        return false;
    });
});