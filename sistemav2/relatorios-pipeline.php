<?php
require("includes.php");

if($_POST){
    
    $permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
    if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
        header('location:pagina-erro.php');
        exit;
    }
   
    $expansaoDAO = new ExpansaoDAO();
    
    pt_register('POST','mes');
    pt_register('POST','ano');
    $c = new stdClass();
    $c->ano = $ano;
    $c->mes = $mes;
    
    $mesq = "10"; // Margem Esquerda (mm)
    $msup = "10"; // Margem Superior (mm) margem mínima dois pois ficou cortando)
    
    $prospect 	 = 0;
    $qualificado = 0;
    $proposta    = 0;
    $negociacao  = 0;
    $fechamento  = 0;
    $cancelado   = 0;
    $pagamento_efetivado = 0;
    $titulo      = ' Fichas Canceladas'.((strlen($c->ano) > 0) ? ((strlen($c->mes) > 0) ? ' ('.$c->mes.'/'.$c->ano.')' : ' ('.$c->ano.')') : '');
    
    foreach($expansaoDAO->pipeline($c) AS $f){
        switch($f->id_status){
            case 1:
                $prospect+=$f->total;
                break;
            case 19:
                $prospect+=$f->total;
                break;
            case 4:
                $qualificado+=$f->total;
                break;
            case 5:
                $qualificado+=$f->total;
                break;
            case 17:
                $qualificado+=$f->total;
                break;
            case 7:
                $proposta+=$f->total;
                break;
            case 9:
                $negociacao+=$f->total;
                break;
            case 10:
                $negociacao+=$f->total;
                break;
            case 11:
                $negociacao+=$f->total;
                break;
            case 13:
                $fechamento+=$f->total;
                break;
            case 14:
                $pagamento_efetivado+=$f->total;
                break;		
            case 2:
                $cancelado+=$f->total;
                break;		
            case 3:
                $cancelado+=$f->total;
                break;		
            case 16:
                $cancelado+=$f->total;
                break;		
	}
    }
    
    require("includes/fpdf/fpdf.php");
    $pdf=new FPDF('L','cm', 'Letter'); //papel personalizado
    $pdf->Open();
    $pdf->SetMargins(2, 2); //seta as margens do documento
    $pdf->SetAuthor('Cartório Postal');
    $pdf->SetFont('times','', 7);
    $pdf->SetDisplayMode(100, 'continuous'); //define o nivel de zoom do documento PDF

    $pdf->AddPage();	
    $pdf->Image('images/pipeline.jpg','2.5','1','23','auto','JPG');
    $pdf->SetFont('times','',14.8);	

    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(11.5,4.2,$prospect,0,1,'C');
    $pdf->Cell(11.5,-0.3,$qualificado,0,1,'C');
    $pdf->Cell(11.5,3.9,$proposta,0,1,'C');
    $pdf->Cell(11.5,0,$negociacao,0,1,'C');
    $pdf->Cell(11.5,3.3,$fechamento,0,1,'C');
    $pdf->Cell(11.5,0.3,$pagamento_efetivado,0,1,'C');

    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(11.5,2,$cancelado.$titulo,0,1,'C');
    $pdf->Output(); //imprime a saidas
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
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Pipeline');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Pipeline</legend>
                <dt>Mês:</dt>
                <dd>
                    <select id="mes" name="mes" class="chzn-select">
                        <option value="">Mês</option>
                        <?php foreach(DataAno() AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->mes ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Ano:</dt>
                <dd>
                    <select id="ano" name="ano" class="chzn-select">
                        <option value="">Ano</option>
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