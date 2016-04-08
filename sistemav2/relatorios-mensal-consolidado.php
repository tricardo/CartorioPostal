<?php
require("includes.php");

$permissao = verifica_permissao('Rel_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE' and verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' or $controle_id_empresa!=1){
    header('location:pagina-erro.php');
    exit;
}

if($_POST){
    require("includes/geraexcel/excelwriter.inc.php");
    
    $relatorioDAO = new RelatorioDAO();
    
    pt_register('POST','mes');
    pt_register('POST','ano');
    
    $arquivoDiretorio = "exporta/mens-consol-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    $arquivoConteudo = 'Referência;'.$mes.'/'.$ano.';
        Franquia;Royalties;Fundo de Propaganda;Faturamento;Despesa;Tipo
        ';
    

    $roy_t = 0;
    $fpp_t = 0;
    $fat_t = 0;
    $des_t = 0;
    
    $royalties = $relatorioDAO->listaRoyalties($ano,$mes);
    foreach($royalties as $i=>$roy){
	
        if($roy->fixo==''){
                #$t_sub_pagar = (float)((float)($roy->faturamento)-(float)((float)($roy->faturamento)/100*(float)($roy->imposto)))-(float)($roy->despesa);
                #$roy->valor_royalties = (float)((float)($t_sub_pagar)/100)*(float)($roy->royalties);
                $tipo_fat = $roy->royalties.'%';
                if($roy->imposto=='' or $roy->imposto=='0') $tipo_fat.=' do Bruto'; else $tipo_fat.=' do Líquido';
        } else {
                $tipo_fat = 'Fixo '.$roy->fixo.' semestre';
        }
        #$roy->valor_propaganda = (float)((float)($t_sub_pagar)/100)*(float)(2);
		

        $roy_t = (float)($roy_t)+(float)($roy->valor_royalties);
        $fpp_t = (float)($fpp_t)+(float)($roy->valor_propaganda);
        $fat_t = (float)($fat_t)+(float)($roy->faturamento);
        $des_t = (float)($des_t)+(float)($roy->despesa);
        $arquivoConteudo .= utf8_encode($roy->franquia).';R$ '.number_format($roy->valor_royalties,2,",",".").';R$ '.number_format($roy->valor_propaganda,2,",",".").';R$ '.number_format($roy->faturamento,2,",",".").';R$ '.number_format($roy->despesa,2,",",".").';'.$tipo_fat.'
';
        #$relatorioDAO->RelFixo($ano."-".$mes,$roy->valor_royalties,$roy->id_empresa,$semestre);	
        #$relatorioDAO->insertRelFixo($roy->id_empresa,$ano."-".$mes.'-01',$roy->valor_royalties,$roy->valor_propaganda,$roy->faturamento,$roy->despesa,$roy->imposto,$roy->royalties,$roy->fixo);
    }

    $arquivoConteudo .= 'Total;R$ '.number_format($roy_t,2,",",".").';R$ '.number_format($fpp_t,2,",",".").';R$ '.number_format($fat_t,2,",",".").';R$ '.number_format($des_t,2,",",".").'
';
    
    if(is_file($arquivoDiretorio)) {
        unlink($arquivoDiretorio);
    }	
    $erro = '';
    if(fopen($arquivoDiretorio,"w+")) {
        if (!$handle = fopen($arquivoDiretorio, 'w+')) {
            $erro = "FALHA AO CRIAR O ARQUIVO: ".$nomeArquivo;
        }
        if(!fwrite($handle, $arquivoConteudo)) {
            $erro = "FALHA AO ESCREVER NO ARQUIVO: ".$nomeArquivo;
        }
        if(strlen($erro) == 0){
            header ("Content-type: octet/stream");
            header ("Content-disposition: attachment; filename=".$arquivoDiretorio.";");
            header("Content-Length: ".filesize($arquivoDiretorio));
            readfile($arquivoDiretorio);
            exit;
        }
    } else {
        $erro = "ERRO AO CRIAR O ARQUIVO: ".$nomeArquivo;
    }

    pt_register('GET','pg');
    $pagina = RelTipTit($pg);
    $bt = '05';
    $titulo = "'relatórios &rsaquo;&rsaquo; <a href=\"".$pagina['retorno']."\" id=\"voltar\">".$pagina['titulo']."</a> &rsaquo;&rsaquo; Mensal Consolidado'";
    $h3 = $erro;
    
    include('template.php');
    
} else {
    pt_register('GET','pg');
    pt_register('POST','mes');
    pt_register('POST','ano');
    $pagina = RelTipTit($pg);
    
    $c = new stdClass();
    $c->ano        = isset($mes) ? $mes : date('Y');
    $c->mes        = isset($ano) ? $ano : date('m');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Mensal Consolidado');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Mensal Consolidado</legend>
                <dt>Mês:</dt>
                <dd>
                    <select id="mes" name="mes" class="chzn-select">
                        <?php foreach(DataAno() AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->mes ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Ano:</dt>
                <dd>
                    <select id="ano" name="ano" class="chzn-select">
                        <?php foreach(DataAno(2) AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->ano ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <div class="buttons">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
                </div>
            </dl>
        </form>
        <script>preencheCampo()</script>
    </div>
    <div class="content-list-table">
        <?php if($_POST){
            RetornaVazio();
        } else {
            RetornaVazio(2); } ?>
    </div>
    <?php include('footer.php'); 
}?>