<?php
require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../includes/dias_uteis.php");
require("../includes/geraexcel/excelwriter.inc.php");
$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul>";

$arquivoDiretorio = "./exporta/".$controle_id_usuario.".xls";
$nomeArquivo = $controle_id_usuario.".xls";

$excel=new ExcelWriter($arquivoDiretorio);

if($excel==false){
	echo $excel->error;
	exit;
}

pt_register('GET','mes');
pt_register('GET','ano');

if($mes=='') $mes = date('m');
if($ano=='') $ano = date('Y');
//Escreve o nome dos campos de uma tabela
$linha_arq = 'Relatório de Comissão por Atendente';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);
 

$sql = $objQuery->SQLQuery("select COUNT(0) as total, uu.nome, replace(format(SUM(pi.valor),2),',','') as valor, 
	replace(format(SUM(pi.valor_rec),2),',','') as valor_rec,
	p.origem, date_format(pi.data,'%d/%m/%Y') as data, pi.id_usuario, pi.id_status
	from vsites_pedido_item as pi ,
	vsites_user_usuario as uu,
	vsites_pedido as p where 
	pi.id_status!='14' and
	pi.id_empresa_atend='".$controle_id_empresa."' and
	DATE_FORMAT(pi.data,'%Y-%m')='".$ano."-".$mes."' and
	pi.id_status<>'' and
	pi.id_usuario=uu.id_usuario and
	pi.id_pedido=p.id_pedido
	group by pi.id_usuario, pi.id_status, p.origem
	order by pi.id_usuario, p.origem");

$linha_arq = 'Ref. '.$mes.'/'.$ano;
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$linha_arq = '';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);

$linha_arq = 'Atendente;Google/Site;Fechado;Orçamento/Aberto;Pago;Á Receber;Telefone;Fechado;Orçamento/Aberto;Pago;Á Receber;Balcão;Fechado;Orçamento/Aberto;Pago;Á Receber;Correios;Fechado;Orçamento/Aberto;Pago;Á Receber;Outros;Fechado;Orçamento/Aberto;Pago;Á Receber;Total;Total Fechado;Total Orçamento/Aberto;Total Pago;Total Á Receber;';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);
$id_usuario = '';
while($res = mysql_fetch_array($sql)){
	$linha_arq='';

	if($id_usuario!=$res['id_usuario']){
		if($id_usuario<>''){
		
			$outros->total2=$google->total+$telefone->total+$balcao->total+$correios->total+$outros->total;
			$outros->fechado2=$google->fechado+$telefone->fechado+$balcao->fechado+$correios->fechado+$outros->fechado;
			$outros->orc2=$google->orc+$telefone->orc+$balcao->orc+$correios->orc+$outros->orc;
			$outros->valor_rec2=(float)($google->valor_rec)+(float)($telefone->valor_rec)+(float)($balcao->valor_rec)+(float)($correios->valor_rec)+(float)($outros->valor_rec);
			$outros->valor2=(float)($google->valor)+(float)($telefone->valor)+(float)($balcao->valor)+(float)($correios->valor)+(float)($outros->valor);

			$linha_arq = $nome.';';
			$linha_arq .= $google->total.';'.$google->fechado.';'.$google->orc.';R$ '.number_format($google->valor_rec,2,",","").';R$ '.number_format($google->valor,2,",","").';';
			$linha_arq .= $telefone->total.';'.$telefone->fechado.';'.$telefone->orc.';R$ '.number_format($telefone->valor_rec,2,",","").';R$ '.number_format($telefone->valor,2,",","").';';
			$linha_arq .= $balcao->total.';'.$balcao->fechado.';'.$balcao->orc.';R$ '.number_format($balcao->valor_rec,2,",","").';R$ '.number_format($balcao->valor,2,",","").';';
			$linha_arq .= $correios->total.';'.$correios->fechado.';'.$correios->orc.';R$ '.number_format($correios->valor_rec,2,",","").';R$ '.number_format($correios->valor,2,",","").';';
			$linha_arq .= $outros->total.';'.$outros->fechado.';'.$outros->orc.';R$ '.number_format($outros->valor_rec,2,",","").';R$ '.number_format($outros->valor,2,",","").';';
			$linha_arq .= $outros->total2.';'.$outros->fechado2.';'.$outros->orc2.';R$ '.number_format($outros->valor_rec2,2,",","").';R$ '.number_format($outros->valor2,2,",","").';';
				
			$myArr = explode(';',$linha_arq);
			$excel->writeLine($myArr);

			$total->google_total = (float)($total->google_total)+$google->total;
			$total->google_fechado = (float)($total->google_fechado)+$google->fechado;
			$total->google_orc = (float)($total->google_orc)+$google->orc;
			$total->google_valor_rec = (float)($total->google_valor_rec)+(float)($google->valor_rec);
			$total->google_valor = (float)($total->google_valor)+(float)($google->valor);
			
			$total->telefone_total = (float)($total->telefone_total)+$telefone->total;
			$total->telefone_fechado = (float)($total->telefone_fechado)+$telefone->fechado;
			$total->telefone_orc = (float)($total->telefone_orc)+$telefone->orc;
			$total->telefone_valor_rec = (float)($total->telefone_valor_rec)+(float)($telefone->valor_rec);
			$total->telefone_valor = (float)($total->telefone_valor)+(float)($telefone->valor);

			$total->correios_total = (float)($total->correios_total)+$correios->total;
			$total->correios_fechado = (float)($total->correios_fechado)+$correios->fechado;
			$total->correios_orc = (float)($total->correios_orc)+$correios->orc;
			$total->correios_valor_rec = (float)($total->correios_valor_rec)+(float)($correios->valor_rec);
			$total->correios_valor = (float)($total->correios_valor)+(float)($correios->valor);

			$total->balcao_total = (float)($total->balcao_total)+$balcao->total;
			$total->balcao_fechado = (float)($total->balcao_fechado)+$balcao->fechado;
			$total->balcao_orc = (float)($total->balcao_orc)+$balcao->orc;
			$total->balcao_valor_rec = (float)($total->balcao_valor_rec)+(float)($balcao->valor_rec);
			$total->balcao_valor = (float)($total->balcao_valor)+(float)($balcao->valor);
			
			$total->outros_total = (float)($total->outros_total)+$outros->total;
			$total->outros_fechado = (float)($total->outros_fechado)+$outros->fechado;
			$total->outros_orc = (float)($total->outros_orc)+$outros->orc;
			$total->outros_valor_rec = (float)($total->outros_valor_rec)+(float)($outros->valor_rec);
			$total->outros_valor = (float)($total->outros_valor)+(float)($outros->valor);

			#if($nome=='Ana Santana'){
			##	exit;
			#}
			unset($google);
			unset($telefone);
			unset($balcao);
			unset($correios);
			unset($outros);
		}
		
		switch ($res['origem']){
			case 'Google':
				$google->total = (float)($google->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					case '16':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					default:
						$google->fechado = (float)($google->fechado)+(float)($res['total']);
						$google->valor = (float)($google->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$google->valor_rec = (float)($google->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Site':
				$google->total = (float)($google->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '16':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					case '1':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					default:
						$google->fechado = (float)($google->fechado)+(float)($res['total']);
						$google->valor = (float)($google->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$google->valor_rec = (float)($google->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Telefone':
				$telefone->total = (float)($telefone->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$telefone->orc = (float)($telefone->orc)+(float)($res['total']);
						break;
					case '16':
						$telefone->orc = (float)($telefone->orc)+(float)($res['total']);
						break;
					default:
						$telefone->fechado = (float)($telefone->fechado)+(float)($res['total']);
						$telefone->valor = (float)($telefone->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
						break;
				}
				$telefone->valor_rec = (float)($telefone->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Balcão':
				$balcao->total = (float)($balcao->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$balcao->orc = (float)($balcao->orc)+(float)($res['total']);
						break;
					case '16':
						$balcao->orc = (float)($balcao->orc)+(float)($res['total']);
						break;
					default:
						$balcao->fechado = (float)($balcao->fechado)+(float)($res['total']);
						$balcao->valor = (float)($balcao->valor)+(float)($res['valor'])-(float)($res['valor_rec']);						
				}
				$balcao->valor_rec = (float)($balcao->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Correios':
				$correios->total = (float)($correios->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$correios->orc = (float)($correios->orc)+(float)($res['total']);
						break;
					case '16':
						$correios->orc = (float)($correios->orc)+(float)($res['total']);
						break;
					default:
						$correios->fechado = (float)($correios->fechado)+(float)($res['total']);
						$correios->valor = (float)($correios->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$correios->valor_rec = (float)($correios->valor_rec)+(float)($res['valor_rec']);
				break;
			default:
				$outros->total = (float)($outros->total)+(float)($res['total']);			
				switch ($res['id_status']){
					case '1':
						$outros->orc = (float)($outros->orc)+(float)($res['total']);
						break;
					case '16':
						$outros->orc = (float)($outros->orc)+(float)($res['total']);
						break;
					default:
						$outros->fechado = (float)($outros->fechado)+(float)($res['total']);
						$outros->valor = (float)($outros->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$outros->valor_rec = (float)($outros->valor_rec)+(float)($res['valor_rec']);
				break;
		}
	} else {
		switch ($res['origem']){
			case 'Google':
				$google->total = (float)($google->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					case '16':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					default:
						$google->fechado = (float)($google->fechado)+(float)($res['total']);
						$google->valor = (float)($google->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$google->valor_rec = (float)($google->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Site':
				$google->total = (float)($google->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					case '16':
						$google->orc = (float)($google->orc)+(float)($res['total']);
						break;
					default:
						$google->fechado = (float)($google->fechado)+(float)($res['total']);
						$google->valor = (float)($google->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$google->valor_rec = (float)($google->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Telefone':
				$telefone->total = (float)($telefone->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$telefone->orc = (float)($telefone->orc)+(float)($res['total']);
						break;
					case '16':
						$telefone->orc = (float)($telefone->orc)+(float)($res['total']);
						break;
					default:
						$telefone->fechado = (float)($telefone->fechado)+(float)($res['total']);
						$telefone->valor = (float)($telefone->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$telefone->valor_rec = (float)($telefone->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Balcão':
				$balcao->total = (float)($balcao->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$balcao->orc = (float)($balcao->orc)+(float)($res['total']);						
						break;
					case '16':
						$balcao->orc = (float)($balcao->orc)+(float)($res['total']);
						break;
					default:
						$balcao->fechado = (float)($balcao->fechado)+(float)($res['total']);
						$balcao->valor = (float)($balcao->valor)+(float)($res['valor'])-(float)($res['valor_rec']);						
				}
				$balcao->valor_rec = (float)($balcao->valor_rec)+(float)($res['valor_rec']);
				break;
			case 'Correios':
				$correios->total = (float)($correios->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$correios->orc = (float)($correios->orc)+(float)($res['total']);
						break;
					case '16':
						$correios->orc = (float)($correios->orc)+(float)($res['total']);
						break;
					default:
						$correios->fechado = (float)($correios->fechado)+(float)($res['total']);
						$correios->valor = (float)($correios->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$correios->valor_rec = (float)($correios->valor_rec)+(float)($res['valor_rec']);
				break;
			default:
				$outros->total = (float)($outros->total)+(float)($res['total']);
				switch ($res['id_status']){
					case '1':
						$outros->orc = (float)($outros->orc)+(float)($res['total']);
						break;
					case '16':
						$outros->orc = (float)($outros->orc)+(float)($res['total']);
						break;
					default:
						$outros->fechado = (float)($outros->fechado)+(float)($res['total']);
						$outros->valor = (float)($outros->valor)+(float)($res['valor'])-(float)($res['valor_rec']);
				}
				$outros->valor_rec = (float)($outros->valor_rec)+(float)($res['valor_rec']);
				break;
		}
	}
	$id_usuario=$res['id_usuario'];
	$nome=$res['nome'];
}

if($id_usuario<>''){

	$outros->total2=$google->total+$telefone->total+$balcao->total+$correios->total+$outros->total;
	$outros->fechado2=$google->fechado+$telefone->fechado+$balcao->fechado+$correios->fechado+$outros->fechado;
	$outros->orc2=$google->orc+$telefone->orc+$balcao->orc+$correios->orc+$outros->orc;
	$outros->valor_rec2=(float)($google->valor_rec)+(float)($telefone->valor_rec)+(float)($balcao->valor_rec)+(float)($correios->valor_rec)+(float)($outros->valor_rec);
	$outros->valor2=(float)($google->valor)+(float)($telefone->valor)+(float)($balcao->valor)+(float)($correios->valor)+(float)($outros->valor);

	if($google->valor<0) $google->valor=0;
	//if($telefone->valor<0) 
	$telefone->valor=0;
	if($balcao->valor<0) $balcao->valor=0;
	if($correios->valor<0) $correios->valor=0;
	if($outros->valor<0) $outros->valor=0;
	if($outros->valor2<0) $outros->valor2=0;
	
	$linha_arq = $nome.';';
	$linha_arq .= $google->total.';'.$google->fechado.';'.$google->orc.';R$ '.number_format($google->valor_rec,2,",","").';R$ '.number_format($google->valor,2,",","").';';
	$linha_arq .= $telefone->total.';'.$telefone->fechado.';'.$telefone->orc.';R$ '.number_format($telefone->valor_rec,2,",","").';R$ '.number_format($telefone->valor,2,",","").';';
	$linha_arq .= $balcao->total.';'.$balcao->fechado.';'.$balcao->orc.';R$ '.number_format($balcao->valor_rec,2,",","").';R$ '.number_format($balcao->valor,2,",","").';';
	$linha_arq .= $correios->total.';'.$correios->fechado.';'.$correios->orc.';R$ '.number_format($correios->valor_rec,2,",","").';R$ '.number_format($correios->valor,2,",","").';';
	$linha_arq .= $outros->total.';'.$outros->fechado.';'.$outros->orc.';R$ '.number_format($outros->valor_rec,2,",","").';R$ '.number_format($outros->valor,2,",","").';';
	$linha_arq .= $outros->total2.';'.$outros->fechado2.';'.$outros->orc2.';R$ '.number_format($outros->valor_rec2,2,",","").';R$ '.number_format($outros->valor2,2,",","").';';
	
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);

	$total->google_total = (float)($total->google_total)+$google->total;
	$total->google_fechado = (float)($total->google_fechado)+$google->fechado;
	$total->google_orc = (float)($total->google_orc)+$google->orc;
	$total->google_valor_rec = (float)($total->google_valor_rec)+(float)($google->valor_rec);
	$total->google_valor = (float)($total->google_valor)+(float)($google->valor);
	
	$total->telefone_total = (float)($total->telefone_total)+$telefone->total;
	$total->telefone_fechado = (float)($total->telefone_fechado)+$telefone->fechado;
	$total->telefone_orc = (float)($total->telefone_orc)+$telefone->orc;
	$total->telefone_valor_rec = (float)($total->telefone_valor_rec)+(float)($telefone->valor_rec);
	$total->telefone_valor = (float)($total->telefone_valor)+(float)($telefone->valor);

	$total->correios_total = (float)($total->correios_total)+$correios->total;
	$total->correios_fechado = (float)($total->correios_fechado)+$correios->fechado;
	$total->correios_orc = (float)($total->correios_orc)+$correios->orc;
	$total->correios_valor_rec = (float)($total->correios_valor_rec)+(float)($correios->valor_rec);
	$total->correios_valor = (float)($total->correios_valor)+(float)($correios->valor);

	$total->balcao_total = (float)($total->balcao_total)+$balcao->total;
	$total->balcao_fechado = (float)($total->balcao_fechado)+$balcao->fechado;
	$total->balcao_orc = (float)($total->balcao_orc)+$balcao->orc;
	$total->balcao_valor_rec = (float)($total->balcao_valor_rec)+(float)($balcao->valor_rec);
	$total->balcao_valor = (float)($total->balcao_valor)+(float)($balcao->valor);
	
	$total->outros_total = (float)($total->outros_total)+$outros->total;
	$total->outros_fechado = (float)($total->outros_fechado)+$outros->fechado;
	$total->outros_orc = (float)($total->outros_orc)+$outros->orc;
	$total->outros_valor_rec = (float)($total->outros_valor_rec)+(float)($outros->valor_rec);
	$total->outros_valor = (float)($total->outros_valor)+(float)($outros->valor);

	unset($google);
	unset($telefone);
	unset($balcao);
	unset($correios);
	unset($outros);
}

$total->total2=$total->google_total+$total->telefone_total+$total->balcao_total+$total->correios_total+$total->outros_total;
$total->fechado2=$total->google_fechado+$total->telefone_fechado+$total->balcao_fechado+$total->correios_fechado+$total->outros_fechado;
$total->orc2=$total->google_orc+$total->telefone_orc+$total->balcao_orc+$total->correios_orc+$total->outros_orc;
$total->valor_rec2=(float)($total->google_valor_rec)+(float)($total->telefone_valor_rec)+(float)($total->balcao_valor_rec)+(float)($total->correios_valor_rec)+(float)($total->outros_valor_rec);
$total->valor2=(float)($total->google_valor)+(float)($total->telefone_valor)+(float)($total->balcao_valor)+(float)($total->correios_valor)+(float)($total->outros_valor);

if($total->google_valor<0) $total->google_valor=0;
if($total->telefone_valor<0) $total->telefone_valor=0;
if($total->balcao_valor<0) $total->balcao_valor=0;
if($total->correios_valor<0) $total->correios_valor=0;
if($total->outros_valor<0) $total->outros_valor=0;
if($total->valor2<0) $total->valor2=0;

$linha_arq = 'Total;';
$linha_arq .= $total->google_total.';'.$total->google_fechado.';'.$total->google_orc.';R$ '.number_format($total->google_valor_rec,2,",","").';R$ '.number_format($total->google_valor,2,",","").';';
$linha_arq .= $total->telefone_total.';'.$total->telefone_fechado.';'.$total->telefone_orc.';R$ '.number_format($total->telefone_valor_rec,2,",","").';R$ '.number_format($total->telefone_valor,2,",","").';';
$linha_arq .= $total->balcao_total.';'.$total->balcao_fechado.';'.$total->balcao_orc.';R$ '.number_format($total->balcao_valor_rec,2,",","").';R$ '.number_format($total->balcao_valor,2,",","").';';
$linha_arq .= $total->correios_total.';'.$total->correios_fechado.';'.$total->correios_orc.';R$ '.number_format($total->correios_valor_rec,2,",","").';R$ '.number_format($total->correios_valor,2,",","").';';
$linha_arq .= $total->outros_total.';'.$total->outros_fechado.';'.$total->outros_orc.';R$ '.number_format($total->outros_valor_rec,2,",","").';R$ '.number_format($total->outros_valor,2,",","").';';
$linha_arq .= $total->total2.';'.$total->fechado2.';'.$total->orc2.';R$ '.number_format($total->valor_rec2,2,",","").';R$ '.number_format($total->valor2,2,",","").';';
$myArr = explode(';',$linha_arq);
$excel->writeLine($myArr);


header ("Content-type: octet/stream");
header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
header("Content-Length: ".filesize($arquivoDiretorio));
readfile($arquivoDiretorio);
?>