function gera_invoice(id_anunciante,sigla_estado,id_cidade) {
	var url = "";
	var width = "";
	var height = "";

	if (id_anunciante != "" && sigla_estado != "" && id_cidade != "") {
		url = "invoice.php?id_anunciante="+ id_anunciante + "&sigla_estado=" + sigla_estado + "&id_cidade=" + id_cidade;
		width = "700";
		height = "600";
		janela = window.open(url,"janela","toolbar=no,location=no,status=no,scrollbars=no,directories=no,width="+width+",height="+height+",top=100,left=100");
		janela.focus();
	}
}