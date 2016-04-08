<?php
require("includes.php");

$permissao = verifica_permissao('Rel_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

if($_POST){
    require("includes/geraexcel/excelwriter.inc.php");
    
    pt_register('POST','mes');
    pt_register('POST','ano');
    $dia    = 1;
    $c = new stdClass();
    $c->ano = $ano;
    $c->mes = $mes;
    $c->dia = $dia;
    
    $arquivoDiretorio = "exporta/por-depto-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    
    $excel=new ExcelWriter($arquivoDiretorio);
    if($excel==false){
	echo $excel->error;
	exit;
    }

    //Escreve o nome dos campos de uma tabela
    $linha_arq = utf8_decode('Número de Serviços por Departamento;');
    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);

    $linha_arq = utf8_decode('Referência:; '.$mes.'/'.$ano);
    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);

    $linha_arq = utf8_decode('Dia;2via;Processos;Imóveis;Protesto;');
    $myArr = explode(';',$linha_arq);
    $excel->writeLine($myArr);


    $p_valor='';
    $somas=array();
    $relatorioDAO = new RelatorioDAO();
    $lista = $relatorioDAO->relatorioOperacional($controle_id_empresa,$ano,$mes);

    $via=0;
    $processos=0;
    $imoveis=0;
    $protesto=0;
    $old_dia='';
    $somas =  array();
    
    
    foreach($lista as $l){
	if($old_dia!=$l->dia and $old_dia<>''){

		$linha_arq = $l->dia.';'.$via.';'.$processos.';'.$imoveis.';'.$protesto;
		$myArr = explode(';',$linha_arq);
		$excel->writeLine($myArr);
		$somas[2] 	= $somas[2]+$via;
		$somas[4] 	= $somas[4]+$processos;
		$somas[7] 	= $somas[7]+$imoveis;
		$somas[8] 	= $somas[8]+$protesto;

		$via=0;
		$processos=0;
		$imoveis=0;
		$protesto=0;
	}
	$old_dia=$l->dia;
	if($l->id_servico_departamento=='2') $via 	= $l->soma;
	if($l->id_servico_departamento=='4') $processos = $l->soma;
	if($l->id_servico_departamento=='7') $imoveis 	= $l->soma;
	if($l->id_servico_departamento=='8') $protesto 	= $l->soma;
}
if($via<>0 or $processos<>0 or $imoveis<>0 or $protesto<>0){
	$linha_arq = $old_dia.';'.$via.';'.$processos.';'.$imoveis.';'.$protesto;
	$myArr = explode(';',$linha_arq);
	$excel->writeLine($myArr);
	$somas[2] 	= $somas[2]+$via;
	$somas[4] 	= $somas[4]+$processos;
	$somas[7] 	= $somas[7]+$imoveis;
	$somas[8] 	= $somas[8]+$protesto;
    }
    $linha_arq = 'Total;0;0;0;0;0';
    if(count($somas) > 0){
        $linha_arq = 'Total;'.$somas[2].';'.$somas[4].';'.$somas[7].';'.$somas[8].';'.$somas[10];
    }
    $myArr = explode(';',$linha_arq);

    $excel->writeLine($myArr);

    header ("Content-type: octet/stream");
    header ("Content-disposition: attachment; filename=".$arquivoDiretorio.";");
    header("Content-Length: ".filesize($arquivoDiretorio));
    readfile($arquivoDiretorio);
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
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Por Departamento');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Por Departamento</legend>
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