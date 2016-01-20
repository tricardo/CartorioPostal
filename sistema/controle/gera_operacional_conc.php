<?
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require('../includes/dias_uteis.php');
require("../includes/geraexcel/excelwriter.inc.php");

pt_register('POST','busca_data_i_co');
pt_register('POST','busca_data_f_co');
pt_register('POST','id_conveniado');	
pt_register('POST','id_usuario');	
$permissao = verifica_permissao('Rel_n_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

if(!in_array(9,explode(',',$controle_id_departamento_s))
	&& !in_array(3,explode(',',$controle_id_departamento_s))
	&& !in_array(5,explode(',',$controle_id_departamento_s))
	&& !in_array(8,explode(',',$controle_id_departamento_s))
	&& !in_array(6,explode(',',$controle_id_departamento_s))){
	$id_usuario=$controle_id_usuario;
}

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

    $excel=new ExcelWriter($arquivoDiretorio);

    if($excel==false){
        echo $excel->error;
		exit;
    }

   //Escreve o nome dos campos de uma tabela
   $linha_arq = 'Relatorio dos Concluídos Operacional;';
   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	

   $linha_arq = 'Referência:; '.$busca_data_i_co.'/'.$busca_data_f_co.';';
   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	   

   $linha_arq = 'Contato;#;Data de Abertura;Prazo;Concluído Operacional;Status;CPF;CNPJ;Documento de;Responsável;Servico;UF;Cidade;Atividade;Resultado;Motivo do Atraso';
   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	   

 
	$busca_data_f_co = invert($busca_data_f_co,'/','SQL');
	$busca_data_i_co = invert($busca_data_i_co,'/','SQL');
	
	if((strtotime($busca_data_f_co)-strtotime($busca_data_i_co))/(60*60*24) > 31){
		echo "período de ".(strtotime($busca_data_f_co)-strtotime($busca_data_i_co))/(60*60*24)." dias é  muito longo ";
		die();
	}
	
	$departamento_p = "'".str_replace(',' ,"','",$controle_id_departamento_p)."A'";
	
	$where_usuario = ($id_usuario!='')?' AND uu.id_usuario = '.$id_usuario:'';
	if($id_conveniado!=''){
		if($id_conveniado>0)
		$where_conveniado = ' AND p.id_conveniado = '.$id_conveniado ;
		else
		$where_conveniado = ' AND p.id_conveniado != '.($id_conveniado*-1);
	}
	
	$sql_todos = $objQuery->SQLQuery("select ".$data_prazo_inc ." as prazo, uu.nome as responsavel, p.contato, pi.data_atividade, pi.id_pedido, pi.operacional, pi.ordem, pi.inicio, st.status, pi.certidao_cpf, pi.certidao_cnpj, pi.certidao_nome, pi.certidao_cidade, pi.certidao_estado, pi.certidao_resultado, pi.motivo_atraso, s.descricao as servico, a.atividade, uu.nome,p.id_conveniado
	from vsites_pedido as p, vsites_pedido_item as pi, vsites_status as st, vsites_servico as s, vsites_atividades as a, vsites_servico_departamento as sd, vsites_user_usuario as uu 
	where
		pi.operacional>='".$busca_data_i_co."' and pi.operacional<='".$busca_data_f_co."' and pi.id_servico_departamento=sd.id_servico_departamento and sd.id_departamento_resp IN (".$departamento_p.") and pi.id_usuario_op=uu.id_usuario and (uu.id_empresa='".$controle_id_empresa."' or pi.id_empresa_resp = '".$controle_id_empresa."') and
		pi.id_servico = s.id_servico and pi.id_status=st.id_status and pi.id_atividade=a.id_atividade and pi.id_status!='14' and p.id_pedido=pi.id_pedido ".
		$where_usuario." ".
		$where_conveniado);
	while($res = mysql_fetch_array($sql_todos)){
		if($res['certidao_resultado']<>"" and $res['certidao_resultado']!="Negativa") $resultado = "Positiva"; else $resultado = $res['certidao_resultado'];
		$linha_arq = $res['contato'].';'.$res['id_pedido'].'/'.$res['ordem'].';'.invert($res['inicio'],'/','PHP').';'.invert($res['prazo'],'/','PHP').';'.invert($res['operacional'],'/','PHP').';'.invert($res['data_atividade'],'/','PHP').';'.$res['certidao_cpf'].'. ;'.$res['certidao_cnpj'].'. ;'.$res['certidao_nome'].';'.$res['responsavel'].';'.$res['servico'].';'.$res['certidao_estado'].';'.$res['certidao_cidade'].';'.$res['atividade'].';'.$resultado.';'.$res['motivo_atraso'];
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);
	}
	
    header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
	
?>