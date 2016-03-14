<?php
ini_set('max_execution_time', '0');
require("../model/Database.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../includes/geraexcel/excelwriter.inc.php");
$controle_id_empresa=1;
$controle_id_usuario=1;
$controle_id_departamento_p='6,';
$controle_id_departamento_p='6,';
//Ordens de processos
$atividadeverificaDAO = new AtividadeVerificaDAO();
$pedidoDAO = new PedidoDAO();
$atividadeDAO = new AtividadeDAO();

$diretorio = '../anexos_imp/atividades/'; 
// abre o diretório
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado é uma pasta
		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item à variável de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item à variável de arquivos
			$arquivos[]=$listar;
		}
   }
}

// lista os arquivos se houverem
$p_valor = '';
$s->status_obs='.';
$s->status_dias='';
$s->status_hora='';
if ($arquivos != "") {

	foreach($arquivos as $fp){

		#abre o arquivo
		$handle = @fopen($diretorio.$fp, "r");

		$linha_cont=0;
		if($handle){
			
			while( ! feof($handle)){

				$linha_cont++;
				$buffer = fgets($handle, 4096);
				$buffer = str_replace ("'",'´',$buffer);
				$buffer = explode (";",$buffer);
				$buffer[0] = str_replace('#','',$buffer[0]);
				$pedido = explode ("/",$buffer[0]);
				$res = $pedidoDAO->selectPedidoPorId($pedido[0],$pedido[1],$controle_id_empresa);
				$id_pedido_item=$res->id_pedido_item;

				$p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa,$buffer[1],'.',explode(',',$controle_id_departamento_p),explode(',',$controle_id_departamento_s),$id_pedido_item);
				if($p_verifica['error']==''){
					$atividadeDAO->inserirAtividade($buffer[1],$s,$controle_id_usuario,$id_pedido_item);
					$mail_mensagem .= '<br><b>Pedido '.$buffer[0].':</b> Atividade atualizada com sucesso</br>';
					$cont_liberado++;
					
				} else {
					$mail_mensagem .= '<ul class="erro"><li><b>Pedido '.$buffer[0].':</b></li> '.$p_verifica['error'].'</ul><br>';
					$cont_erro++;
				}
				if($linha_cont>=3000) {
					$mail_mensagem .= 'Foram importados os itens até a linha 3000';
					break;
				}
				#if($linha_cont>10) {
				#	echo $mail_mensagem;
				#	exit;
				#}
			}
		}
	}
}
unset ($arquivos);
unset($itens);

echo $error;
echo '</pre>';
?>