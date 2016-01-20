<?

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('POST','id_cliente');
pt_register('POST','id_servico');
pt_register('POST','h_tiporetorno');

if($id_cliente==''){
	echo 'Selecione um conveniado';
	exit;
}

require("../includes/exportacao/retorno_".$id_cliente.".php");

if(is_file($arquivoDiretorio)) {
    unlink($arquivoDiretorio);
}


if(fopen($arquivoDiretorio,"w+")) {

   if (!$handle = fopen($arquivoDiretorio, 'w+')) {
      echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
      exit;
   }

   if(!fwrite($handle, $arquivoConteudo)) {
      echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
      exit;
   }
  
	if($h_tiporetorno=='CONF'){
		$sql = $objQuery->SQLQuery("update vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p 
		set pi.conf='2' 
		where
		p.id_conveniado='".$id_cliente."' and
		p.id_pedido = pi.id_pedido and
		pi.id_usuario=u.id_usuario and
		u.id_empresa='".$controle_id_empresa."'
		".$onde."");
	} else {
		if($h_tiporetorno=='REGI'){
			$sql = $objQuery->SQLQuery("update vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p 
			set pi.regi='2' 
			where
			p.id_conveniado='".$id_cliente."' and
			p.id_pedido = pi.id_pedido and
			pi.id_usuario=u.id_usuario and
			u.id_empresa='".$controle_id_empresa."'
			".$onde."");
		} else {
			$sql = $objQuery->SQLQuery("update vsites_user_usuario as u, vsites_pedido_item as pi, vsites_pedido as p 
			set pi.ocor='2' 
			where
			p.id_conveniado='".$id_cliente."' and
			p.id_pedido = pi.id_pedido and
			pi.id_usuario=u.id_usuario and
			u.id_empresa='".$controle_id_empresa."'
			".$onde."");
		}
	}

	$sql = $objQuery->SQLQuery("insert into vsites_retorno (id_cliente,id_usuario,arquivo,data)
			values('".$id_cliente."','".$controle_id_usuario."','".$nomeArquivo."',NOW())");	
	header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/retorno/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
   
} else {
   echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
   exit;
}
?>