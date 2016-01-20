     $(document).ready(function() {
    	 $("#fornecedor").change(function(){
    		 	$.getJSON('fornecedor_dados.php?id='+$(this).val(), function(data) {
    			  $("#id_banco").val(data.id_banco);
    			  $("#agencia").val(data.agencia);
    			  $("#conta").val(data.conta);
    			  $("#favorecido").val(data.favorecido);
    			});
    	 });
      });

