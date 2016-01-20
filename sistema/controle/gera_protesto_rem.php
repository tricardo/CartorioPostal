<?php

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

pt_register('GET', 'id');

$sql = $objQuery->SQLQuery("SELECT p.*, count(pr.id_protesto_rem) as qtdd, p.sequencia,
                            (select COUNT(pr_tit.id_protesto) from vsites_protesto_rem as pr_tit where pr_tit.id_protesto=p.id_protesto and pr_tit.dev_num=1 group by pr_tit.id_protesto) as qtdd_tit,
                            (select COUNT(pr_tit.id_protesto) from vsites_protesto_rem as pr_tit where pr_tit.id_protesto=p.id_protesto and (pr_tit.especie='DMI' or pr_tit.especie='DRI' or pr_tit.especie='CBI') group by pr_tit.id_protesto) as qtdd_especie,
                            (select COUNT(pr_tit.id_protesto) from vsites_protesto_rem as pr_tit where pr_tit.id_protesto=p.id_protesto and pr_tit.especie!='DMI' and pr_tit.especie!='DRI' and pr_tit.especie!='CBI' group by pr_tit.id_protesto) as qtdd_n_especie
			from vsites_protesto as p, vsites_protesto_rem as pr, vsites_user_usuario as uu where
                            p.id_protesto = '" . $id . "' and 
                            p.id_usuario = uu.id_usuario and 
                            uu.id_empresa = '$controle_id_empresa' and 
                            p.id_protesto = pr.id_protesto 
                                group by pr.id_protesto");
$res = mysql_fetch_array($sql);

#campo2 header, transacao e TRAILLER
$portador_car = substr($res['portador'], 0, 3);
$carac = strlen($portador_car);
while ($carac < 3) {
    $portador .= '0';
    $carac++;
}
$portador .= $portador_car;

#campo3 header e TRAILLER
$portador_nome_car = substr($res['portador_nome'], 0, 40);
$carac = strlen($portador_nome_car);
$portador_nome .= $portador_nome_car;
while ($carac < 40) {
    $portador_nome .= ' ';
    $carac++;
}

#campo4 header e TRAILLER
$data_movimento = invert($res['data_movimento'], '', 'PHP');

#campo8 header
$sequencia_car = $res['sequencia'];
$carac = strlen($sequencia_car);
$sequencia = '';
while ($carac < 6) {
    $sequencia .= '0';
    $carac++;
}
$sequencia .= $sequencia_car;

#campo9 header
$qtdd_car = $res['qtdd'];
$soma_seguranca = $soma_seguranca + $qtdd_car;
$carac = strlen($qtdd_car);
while ($carac < 4) {
    $qtdd .= '0';
    $carac++;
}
$qtdd .= $qtdd_car;

#campo10 header
$qtdd_tit_car = $res['qtdd_tit'];
$soma_seguranca = $soma_seguranca + $qtdd_tit_car;
$carac = strlen($qtdd_tit_car);
while ($carac < 4) {
    $qtdd_tit .= '0';
    $carac++;
}
$qtdd_tit .= $qtdd_tit_car;

#campo11 header
$qtdd_especie_car = $res['qtdd_especie'];
$soma_seguranca = $soma_seguranca + $qtdd_especie_car;
$carac = strlen($qtdd_especie_car);
while ($carac < 4) {
    $qtdd_especie .= '0';
    $carac++;
}
$qtdd_especie .= $qtdd_especie_car;

#campo12 header
$qtdd_n_especie_car = $res['qtdd_n_especie'];
$soma_seguranca = $soma_seguranca + $qtdd_n_especie_car;
$carac = strlen($qtdd_n_especie_car);
while ($carac < 4) {
    $qtdd_n_especie .= '0';
    $carac++;
}
$qtdd_n_especie .= $qtdd_n_especie_car;

#campo13 header
$agencia_centralizadora_car = substr($res['agencia_centralizadora'], '0', '6');
$carac = strlen($agencia_centralizadora_car);
while ($carac < 6) {
    $agencia_centralizadora .= ' ';
    $carac++;
}
$agencia_centralizadora .= $agencia_centralizadora_car;

#campo15 header corrigir
$ibge_cidade = substr($res['ibge_cidade'], '0', '7');
if($ibge_cidade=='') $ibge_cidade='3500000';
$carac = strlen($ibge_cidade);
while ($carac < 7) {
    $ibge_cidade_car .= '0';
    $carac++;
}
$ibge_cidade = $ibge_cidade_car.$ibge_cidade;

#campo3
$cedente_agencia_car = substr($res['cedente_agencia'], '0', '15');
$carac = strlen($cedente_agencia_car);
$cedente_agencia .= $cedente_agencia_car;
while ($carac < 15) {
    $cedente_agencia .= ' ';
    $carac++;
}


#campo4
$cedente_nome_car = substr($res['cedente_nome'], '0', '45');
$carac = strlen($cedente_nome_car);
$cedente_nome = '';
while ($carac < 45) {
    $cedente_nome .= ' ';
    $carac++;
}
$cedente_nome .= $cedente_nome_car;

#campo5
$sacado_nome_car = substr($res['sacado_nome'], '0', '45');
$carac = strlen($sacado_nome_car);
$sacado_nome .= $sacado_nome_car;
while ($carac < 45) {
    $sacado_nome .= ' ';
    $carac++;
}

#campo6
$sacado_documento_car = substr($res['sacado_documento'], '0', '14');
$carac = strlen($sacado_documento_car);
$sacado_documento = '';
while ($carac < 14) {
    $sacado_documento .= ' ';
    $carac++;
}
$sacado_documento .= $sacado_documento_car;

#campo7
$sacado_endereco_car = substr($res['sacado_endereco'], '0', '45');
$carac = strlen($sacado_endereco_car);
$sacado_endereco .= $sacado_endereco_car;
while ($carac < 45) {
    $sacado_endereco .= ' ';
    $carac++;
}

#campo8
$sacado_cep_car = substr(str_replace('-', '', $res['sacado_cep']), '0', '8');
$carac = strlen($sacado_cep_car);
$sacado_cep = '';
while ($carac < 8) {
    $sacado_cep .= ' ';
    $carac++;
}
$sacado_cep .= $sacado_cep_car;

#campo9
$sacado_cidade_car = substr($res['sacado_cidade'], '0', '20');
$carac = strlen($sacado_cidade_car);
$sacado_cidade .= $sacado_cidade_car;
while ($carac < 20) {
    $sacado_cidade .= ' ';
    $carac++;
}

#campo10
$sacado_estado_car = substr($res['sacado_estado'], '0', '2');
$carac = strlen($sacado_estado_car);
$sacado_estado = '';
while ($carac < 2) {
    $sacado_estado .= ' ';
    $carac++;
}
$sacado_estado .= $sacado_estado_car;


#campo16
$tipo_moeda_car = substr($res['tipo_moeda'], '0', '3');
$carac = strlen($tipo_moeda_car);
$tipo_moeda = '';
while ($carac < 3) {
    $tipo_moeda .= '0';
    $carac++;
}
$tipo_moeda .= $tipo_moeda_car;
#header
$arquivoConteudo = '0' . $portador . $portador_nome . $data_movimento . 'BFOSDTTPR' . $sequencia . $qtdd . $qtdd_tit . $qtdd_especie . $qtdd_n_especie . $agencia_centralizadora . '042'.$ibge_cidade.'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 0001
';

$sql = $objQuery->SQLQuery("SELECT pr.* from vsites_protesto_rem as pr where
			pr.id_protesto = '" . $id . "' order by pr.id_protesto_rem");
$cont = 1;
while ($res = mysql_fetch_array($sql)) {

    $cont++;
    $carac = strlen($cont);
    $cont_ = '';
    while ($carac < 4) {
        $cont_ .= '0';
        $carac++;
    }
    $cont_ .= $cont;

	#campo11
	$nosso_numero_car = substr($res['nosso_numero'], '0', '15');
	$carac = strlen($nosso_numero_car);
	$nosso_numero = '';
	while ($carac < 15) {
		$nosso_numero .= ' ';
		$carac++;
	}
	$nosso_numero .= $nosso_numero_car;
	
    #campo12
    $especie_car = substr($res['especie'], '0', '3');
    $carac = strlen($especie_car);
    $especie = $especie_car;
    while ($carac < 3) {
        $especie .= ' ';
        $carac++;
    }


    #campo13
    $tit_num_car = substr($res['tit_num'], '0', '11');
    $carac = strlen($tit_num_car);
    $tit_num = '';
    while ($carac < 11) {
        $tit_num .= ' ';
        $carac++;
    }
    $tit_num .= $tit_num_car;

    #campo14
    $data_emissao = invert($res['data_emissao'], '', 'PHP');

    #campo15
    $data_vencimento = invert($res['data_vencimento'], '', 'PHP');

    #campo17
    $valor_car = substr(str_replace('.', '', str_replace(',', '', $res['valor'])), '0', '14');
    $carac = strlen($valor_car);
    $valor = '';
    while ($carac < 14) {
        $valor .= '0';
        $carac++;
    }
    $valor .= $valor_car;

    #campo18
    $saldo_car = substr(str_replace('.', '', str_replace(',', '', $res['saldo'])), '0', '14');
    $valor_total = $valor_total + $saldo_car;
    $carac = strlen($saldo_car);
    $saldo = '';
    while ($carac < 14) {
        $saldo .= '0';
        $carac++;
    }
    $saldo .= $saldo_car;

    #campo19
    $praca_pagamento_car = substr($res['praca_pagamento'], '0', '20');
    $carac = strlen($praca_pagamento_car);
    $praca_pagamento = '';
    while ($carac < 20) {
        $praca_pagamento .= ' ';
        $carac++;
    }
    $praca_pagamento .= $praca_pagamento_car;

    #campo20
    $tipo_endosso = substr($res['tipo_endosso'], '0', '1');
    $carac = strlen($tipo_endosso);
    while ($carac < 1) {
        $tipo_endosso = ' ';
        $carac++;
    }

    #campo21
    $aceite = substr($res['aceite'], '0', '1');
    $carac = strlen($aceite);
    while ($carac < 1) {
        $aceite = ' ';
        $carac++;
    }

    #campo22
    $dev_num = substr($res['dev_num'], '0', '15');
    $carac = strlen($dev_num);
    while ($carac < 1) {
        $dev_num = ' ';
        $carac++;
    }

    #campo23
    $dev_nome_car = substr($res['dev_nome'], '0', '45');
    $carac = strlen($dev_nome_car);
    $dev_nome .= $dev_nome_car;
    while ($carac < 45) {
        $dev_nome .= ' ';
        $carac++;
    }

    #campo24
    $tipo = $res['tipo'];
    if ($tipo == 'cnpj')
        $tipo = '001';
    else
        $tipo = '002';

    #campo25
    $cpf_car = substr(str_replace('/', '', str_replace('-', '', str_replace('.', '', str_replace(',', '', $res['cpf'])))), '0', '14');
    $carac = strlen($cpf_car);
    $cpf = '';
    while ($carac < 14) {
        $cpf .= '0';
        $carac++;
    }
    $cpf .= $cpf_car;

    #campo26
    $outro_doc_car = substr(str_replace('/', '', str_replace('-', '', str_replace('.', '', str_replace(',', '', $res['outro_doc'])))), '0', '11');
    $carac = strlen($outro_doc_car);
    $outro_doc = '';
    while ($carac < 11) {
        $outro_doc .= ' ';
        $carac++;
    }
    $outro_doc .= $outro_doc_car;

    #campo27
    $dev_endereco_car = substr($res['dev_endereco'], '0', '45');
    $carac = strlen($dev_endereco_car);
    $dev_endereco .= $dev_endereco_car;
    while ($carac < 45) {
        $dev_endereco .= ' ';
        $carac++;
    }

    #campo28
    $dev_cep_car = substr(str_replace('-', '', $res['dev_cep']), '0', '8');
    $carac = strlen($dev_cep_car);
    $dev_cep = '';
    while ($carac < 8) {
        $dev_cep .= '0';
        $carac++;
    }
    $dev_cep .= $dev_cep_car;

    #campo29
    $dev_cidade_car = substr($res['dev_cidade'], '0', '20');
    $carac = strlen($dev_cidade_car);
    $dev_cidade .= $dev_cidade_car;
    while ($carac < 20) {
        $dev_cidade .= ' ';
        $carac++;
    }

    #campo30
    $dev_estado_car = substr($res['dev_estado'], '0', '2');
    $carac = strlen($dev_estado_car);
    $dev_estado = '';
    while ($carac < 2) {
        $dev_estado .= ' ';
        $carac++;
    }
    $dev_estado .= $dev_estado_car;

    #campo31
    $num_car = substr($res['num'], '0', '2');
    $carac = strlen($num_car);
    $num = '';
    while ($carac < 2) {
        $num .= '0';
        $carac++;
    }
    $num .= $num_car;

    #campo32
    $num_pro_car = substr($res['num_pro'], '0', '10');
    $carac = strlen($num_pro_car);
    $num_pro = '';
    while ($carac < 10) {
        $num_pro .= ' ';
        $carac++;
    }
    $num_pro .= $num_pro_car;

    #campo33
    $oco_tipo_car = substr($res['oco_tipo'], '0', '1');
    $carac = strlen($oco_tipo_car);
    $oco_tipo = '';
    while ($carac < 1) {
        $oco_tipo .= ' ';
        $carac++;
    }
    $oco_tipo .= $oco_tipo_car;

    #campo34
    $data_protocolo = invert($res['data_protocolo'], '', 'PHP');

    #campo35
    $custas_car = substr(str_replace('.', '', str_replace(',', '', $res['custas'])), '0', '10');
    $carac = strlen($custas_car);
    $custas = '';
    while ($carac < 10) {
        $custas .= '0';
        $carac++;
    }
    $custas .= $custas_car;

    #campo36
    $decla_portador_car = substr($res['decla_portador'], '0', '1');
    $carac = strlen($decla_portador_car);
    $decla_portador = '';
    while ($carac < 1) {
        $decla_portador .= ' ';
        $carac++;
    }
    $decla_portador .= $decla_portador_car;

    #campo37
    $data_ocorrencia = invert($res['data_ocorrencia'], '', 'PHP');

    #campo38
    $oco_irr_car = substr($res['oco_irr'], '0', '2');
    $carac = strlen($oco_irr_car);
    $oco_irr = '';
    while ($carac < 2) {
        $oco_irr .= ' ';
        $carac++;
    }
    $oco_irr .= $oco_irr_car;

    #campo39
    $dev_bairro_car = substr($res['dev_bairro'], '0', '20');
    $carac = strlen($dev_bairro_car);
    $dev_bairro = '';
    while ($carac < 20) {
        $dev_bairro .= ' ';
        $carac++;
    }
    $dev_bairro .= $dev_bairro_car;

    #campo40
    $custas_cart_car = substr(str_replace('.', '', str_replace(',', '', $res['custas_cart'])), '0', '10');
    $carac = strlen($custas_cart_car);
    $custas_cart = '';
    while ($carac < 10) {
        $custas_cart .= '0';
        $carac++;
    }
    $custas_cart .= $custas_cart_car;

    #campo41
    $registro_distr_car = substr($res['registro_distr'], '0', '6');
    $carac = strlen($registro_distr_car);
    $registro_distr = '';
    while ($carac < 6) {
        $registro_distr .= '0';
        $carac++;
    }
    $registro_distr .= $registro_distr_car;

    #campo42
    $custas_gravacao_car = substr(str_replace('.', '', str_replace(',', '', $res['custas_gravacao'])), '0', '10');
    $carac = strlen($custas_gravacao_car);
    $custas_gravacao = '';
    while ($carac < 10) {
        $custas_gravacao .= '0';
        $carac++;
    }
    $custas_gravacao .= $custas_gravacao_car;

    #campo43
    $oper_banco_car = substr(str_replace('.', '', str_replace(',', '', $res['oper_banco'])), '0', '5');
    $carac = strlen($oper_banco_car);
    $oper_banco = '';
    while ($carac < 5) {
        $oper_banco .= '0';
        $carac++;
    }
    $oper_banco .= $oper_banco_car;

    #campo44
    $contrato_banco_car = substr(str_replace('.', '', str_replace(',', '', $res['contrato_banco'])), '0', '15');
    $carac = strlen($contrato_banco_car);
    $contrato_banco = '';
    while ($carac < 15) {
        $contrato_banco .= '0';
        $carac++;
    }
    $contrato_banco .= $contrato_banco_car;

    #campo45
    $parcela_contrato_car = substr(str_replace('.', '', str_replace(',', '', $res['parcela_contrato'])), '0', '3');
    $carac = strlen($parcela_contrato_car);
    $parcela_contrato = '';
    while ($carac < 3) {
        $parcela_contrato .= '0';
        $carac++;
    }
    $parcela_contrato .= $parcela_contrato_car;

    #campo46
    $tipo_cam_car = substr(str_replace('.', '', str_replace(',', '', $res['tipo_cam'])), '0', '1');
    $carac = strlen($tipo_cam_car);
    $tipo_cam = '';
    while ($carac < 1) {
        $tipo_cam .= ' ';
        $carac++;
    }
    $tipo_cam .= $tipo_cam_car;

    #campo47
    $comp_irr_car = substr(str_replace('.', '', str_replace(',', '', $res['comp_irr'])), '0', '8');
    $carac = strlen($comp_irr_car);
    $comp_irr = '';
    while ($carac < 8) {
        $comp_irr .= ' ';
        $carac++;
    }
    $comp_irr .= $comp_irr_car;

    #campo48
    $motivo_falencia = $res['motivo_falencia'];
    if ($motivo_falencia == 'on')
        $motivo_falencia = 'F'; else
        $motivo_falencia = ' ';

    #campo49
    $comp_registro = '                              ';

    $instrumento_protesto = ' ';
    $demais_despesas = '          ';

    $arquivoConteudo .= '1' . $portador . $cedente_agencia . $cedente_nome . $sacado_nome . $sacado_documento . $sacado_endereco . $sacado_cep . $sacado_cidade . $sacado_estado . $nosso_numero . $especie . $tit_num . $data_emissao . $data_vencimento . $tipo_moeda . $valor . $saldo . $praca_pagamento . $tipo_endosso . $aceite . $dev_num . $dev_nome . $tipo . $cpf . $outro_doc . $dev_endereco . $dev_cep . $dev_cidade . $dev_estado . $num . $num_pro . $oco_tipo . $data_protocolo . $custas . $decla_portador . $data_ocorrencia . $oco_irr . $dev_bairro . $custas_cart . $registro_distr . $custas_gravacao . $oper_banco . $contrato_banco . $parcela_contrato . $tipo_cam . $comp_irr . $motivo_falencia . $comp_registro . $cont_ . '
';
}

$cont++;
$carac = strlen($cont);
$cont_ = "";
while ($carac < 4) {
    $cont_ .= '0';
    $carac++;
}
$cont_ .= $cont;

#campo5 TRAILLER
$soma_seguranca_ = '';
$carac = strlen($soma_seguranca);
while ($carac < 5) {
    $soma_seguranca_ .= '0';
    $carac++;
}
$soma_seguranca_ .= $soma_seguranca;

#campo6 TRAILLER
$valor_remessa = '';
$carac = strlen($valor_total);
while ($carac < 18) {
    $valor_remessa .= '0';
    $carac++;
}
$valor_remessa .= $valor_total;

#campo7
$complemento = '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ';

$arquivoConteudo .= '9' . $portador . $portador_nome . $data_movimento . $soma_seguranca_ . $valor_remessa . $complemento . $cont_;

$arquivoDiretorio = "./exporta/protesto/B" . $portador . date(dm) . "." . date(y) . "1";
$nomeArquivo = 'B' . $portador . date(dm) . "." . date(y) . "1";

if (is_file($arquivoDiretorio)) {
    unlink($arquivoDiretorio);
}

if (fopen($arquivoDiretorio, "w+")) {

    if (!$handle = fopen($arquivoDiretorio, 'w+')) {
        echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>" . $nomeArquivo . "</b>.</font><br />";
        exit;
    }

    if (!fwrite($handle, $arquivoConteudo)) {
        echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>" . $nomeArquivo . "</b>.</font><br />";
        exit;
    }

    header("Content-type: octet/stream");
    header("Content-disposition: attachment; filename=" . $nomeArquivo . ";");
    header("Content-Length: " . filesize($arquivoDiretorio));
    readfile($arquivoDiretorio);
} else {
    echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>" . $nomeArquivo . "</b>.</font><br />";
    exit;
}
?>