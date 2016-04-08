<?php
require("includes.php");

if($controle_id_empresa!=1){
    header('location:pagina-erro.php');
    exit;
}

if($_POST){
    
    require("includes/geraexcel/excelwriter.inc.php");
    
    $empresaDAO = new EmpresaDAO();
    $empresas = $empresaDAO->listaAdendo();
    
    $arquivoDiretorio = "exporta/adendo-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    $excel=new ExcelWriter($arquivoDiretorio);
    if($excel==false){
        echo $excel->error;
        exit;
    }

    $excel->writeLine(array('Cidades','Estado','Fone/Loja',utf8_decode('Endereço'),'CEP','E-MAIL',
        utf8_decode('Razão Social'),'CNPJ',utf8_decode('Dados Bancários'),'Data adendo'));
    foreach($empresas as $e){
            $cidades='';

            $excel->writeCol($e->regioes[0]->cidade);
            $excel->writeCol($e->regioes[0]->estado);
            $excel->writeCol($e->tel.' '.$e->ramal);
            $excel->writeCol($e->endereco.','.$e->numero.' '.$e->complemento);
            $excel->writeCol($e->cep);	
            $excel->writeCol($e->email);	
            $excel->writeCol($e->empresa);	
            $excel->writeCol($e->cpf);	
            $excel->writeCol('Ag.:'.$e->agencia.'|Conta:'.$e->conta.'|Banco:'.$e->banco.'|'.$e->favorecido);	
            $excel->writeCol(invert($e->adendo_data,'/','php'));
            foreach($e->regioes as $i=>$r){
                    if($i>0){
                            $excel->writeRow();			
                            $excel->writeCol($r->cidade,2);
                            $excel->writeCol($r->estado);
                    }
            }
            $excel->writeRow();
    }
    $excel->close();

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
    $c->ano        = isset($mes) ? $mes : '';
    $c->mes        = isset($ano) ? $ano : '';
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Adendo');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Adendo</legend>
                <div class="buttons">
                    <input type="hidden" value="1" id="f" name="f">
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