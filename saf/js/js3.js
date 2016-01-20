function carrega_campo(id,id_pedido_item){
	ajaxGet("http://www.cartoriopostal.com.br/novosite/includes/carrega_campos.php?id="+id+"&id_pedido_item="+id_pedido_item,document.getElementById("carrega_campos_input"), true)
}

function carrega_servico_var(id_servico,id_servico_var){
	ajaxGet("http://www.cartoriopostal.com.br/novosite/includes/carrega_servico_var.php?id_servico="+id_servico+"&id_servico_var="+id_servico_var,document.getElementById("id_servico_var"), true)
}

function carrega_cidades(estado,id_cidade){
	ajaxGet("http://www.cartoriopostal.com.br/novosite/includes/carrega_cidades.php?estado="+estado+"&id_cidade="+id_cidade,document.getElementById("carrega_cidade"), true)
}

function masc_numeros(obj,mascara) {
		str   = obj.value
		len   = str.length
		str2  = ""
		digito = /^\d$/
		for (i = 0; i < len ; i ++ ) {
			if (digito.test(str.charAt(i))) str2 += str.charAt(i)

		}

		str   = str2

		len   = str.length

		str2  = ""

		for (i = 0 , j = 0 ; j < len && i<mascara.length; i ++ ) {

			if (mascara.charAt(i) == "#") {

				str2 += str.charAt(j)

				j++

			} else {

				str2 += mascara.charAt(i)

			}

		}

		obj.value = str2

}


function moeda(k,valor,id) {
    var done='';
    if(k==48 || k==96 || k==9) { done=1; }
    if(k==49 || k==97) { done=1; }
    if(k==50 || k==98) { done=1; }
    if(k==51 || k==99) { done=1; }
	if(k==52 || k==100){ done=1; }
	if(k==53 && shif==false || k==101) { done=1; }
	if(k==54 || k==102) { done=1; }
	if(k==55 || k==103) { done=1; }
	if(k==56 && shif==false || k==104) { done=1; }
	if(k==57 || k==105) { done=1; }
	if(k==190 || k==194 || k==8) {done=1; }
    if(k==46 || k==13 || k==37 || k==38 || k==39 || k==40 ) {done=1; }

   if (done!=1){
       document.getElementById(id).value='';
       alert('O formato do valor deve ser ###.##'+k);
   }
}

