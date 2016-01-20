<?php
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../includes/geraexcel/excelwriter.inc.php");
pt_register('POST','datai');
pt_register('POST','dataf');
$datai_sql = invert($datai,'-','SQL').' '.substr($datai,11, 8);
$dataf_sql = invert($dataf,'-','SQL').' '.substr($dataf,11, 8);

//Você pode colocar aqui o nome do arquivo que você deseja salvar.
	$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
	$nomeArquivo = $controle_id_usuario.".xls";

    $excel=new ExcelWriter($arquivoDiretorio);

    if($excel==false){
        echo $excel->error;
		exit;
	}

	//Escreve o nome dos campos de uma tabela
	$myArr=array('COMISSIONADO','PEDIDO','CLIENTE','VALOR RECEBIDO','COMISSÃO');
	$excel->writeLine($myArr);
	
	$sql = $objQuery->SQLQuery("SELECT SUM(f.financeiro_valor) as valor, SUM(f.financeiro_valor/100*1.5) as comissao, pi.ordem, pi.id_pedido, c.nome as nome_cli, ucom.nome, ucom.id_usuario from
    vsites_pedido_item as pi, vsites_pedido as p, (select u.id_usuario, u.id_empresa from vsites_user_usuario as u) as u, vsites_user_usuario as ucom, vsites_financeiro as f, (select * from vsites_user_cliente as c where c.id_usuario_com<>'' group by cpf) as c where
    u.id_empresa='".$controle_id_empresa."' and
	u.id_usuario = pi.id_usuario and
	pi.id_status != '14' and
	pi.id_pedido = p.id_pedido and
	p.cpf = c.cpf and
	p.cpf!='000.000.000-00' and 
	p.cpf!='00.000.000/0000-00' and 
	p.cpf!='' and
	c.id_usuario_com=ucom.id_usuario and
	pi.id_pedido_item=f.id_pedido_item and
	f.financeiro_tipo='Recebimento' and
    f.financeiro_autorizacao='Aprovado' and
    f.financeiro_autorizacao_data >= '".$datai_sql."' and
    f.financeiro_autorizacao_data <= '".$dataf_sql."'
	group by f.id_pedido_item
    order by ucom.nome, pi.id_pedido, pi.ordem");

            $total_comissao = 0;
            $total = 0;
			$cont=0;
			$old_id_usuario='';
			while($res = mysql_fetch_array($sql)){
				$id_usuario = $res['id_usuario'];
				
			    if($old_id_usuario!=$id_usuario and $cont>='1')	{
					$myArr=array('','','Total',$total,$total_comissao);
					$excel->writeLine($myArr);
					$total_comissao = "";
					$total = "";
					$myArr=array('','','','','');
					$excel->writeLine($myArr);
			    }
				$old_id_usuario = $id_usuario;
				$myArr=array($res['nome'],'#'.$res['id_pedido'].'/'.$res['ordem'],$res['nome_cli'],$res['valor'],$res['comissao']);
				$excel->writeLine($myArr);
				
                $total=(float)($total)+(float)($res['valor']);
                $total_comissao=(float)($total_comissao)+(float)($res['comissao']);
            }
			$myArr=array('','','Total',$total,$total_comissao);
			$excel->writeLine($myArr);
			$total_comissao = "";
			$total = "";
			$myArr=array('','','','','');
			$excel->writeLine($myArr);
			$excel->close();
    header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);						
?>