<?php 
#var
pt_register('GET','id_franquia_regiao');
$id_franquia_regiao = isset($id_franquia_regiao) ? $id_franquia_regiao : 0;

$f_emp     = new stdClass();
$emp =  CriarVar(array('cep_i','cep_f','latitude','longitude','cdt','distancia','apelido','loja','cidade','estado'));
if($_POST AND isset($opcoes_form) AND $opcoes_form == 13){
    $f_emp = UTF_Encodes(Post_StdClass($_POST),2);
    $f_emp->id_franquia_regiao = $id_franquia_regiao;
    $f_emp->empresa = $id;
    $f_emp->estado = $f_emp->estados;
    $franquia->faixa_cep($f_emp);  
    
    if(count($franquia->checklist_edit(7,0,$id)) == 0){
        $f_emp = new stdClass();
        $f_emp->datah1 = date('d/m/Y');
        $f_emp->datah2 = date('d/m/Y');
        $f->id_empresa_chk = 0;
        $f->id_empresa = $id;
        $f->passo = 7;
        $franquia->checklist_exec($f_emp);
    }    
    $msgbox .= MsgBox(($id_franquia_regiao > 0) ? 1 : 2);
} 
$cad = 0;
if(isset($id_franquia_regiao) AND is_numeric($id_franquia_regiao) AND $id_franquia_regiao > 0){
    $emp = UTF_Encodes($franquia->listar(6, $id_franquia_regiao));
    $cad = count($emp) > 0 ? 1 : 0;
    $emp = count($emp) > 0 ? $emp[0] : new stdClass();
} ?>
<form enctype="multipart/form-data" method="post" id="form13" action="<?=$link?>&opcoes_form=13&id_franquia_regiao=<?=$id_franquia_regiao?>" onsubmit="$('#form13').attr('action', $('#form13').attr('action')">
    <h3>faixa de cep</h3>
    <dl>
        <dt>Faixa Incial:</dt>
        <dd>
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" class="cep" name="cep_i" id="cep_i" value="<?=$emp->cep_i?>" placeholder="Faixa Inicial">
        </dd>
        <dt>Faixa Final:</dt>
	<dd>
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" class="cep" name="cep_f" id="cep_f" value="<?=$emp->cep_f?>" placeholder="Faixa Final">
        </dd>
        <dt>Latitude:</dt>
        <dd>
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" name="latitude" id="latitude" value="<?=$emp->latitude?>" placeholder="Latitude">
        </dd>
	<dt>Longitude:</dt>
        <dd>
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" name="longitude" id="longitude" value="<?=$emp->longitude?>" placeholder="Longitude">
        </dd>
        <dt>CDT:</dt>
        <dd>	
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" name="cdt" id="cdt" class="numero" value="<?=$emp->cdt?>" placeholder="CDT">
        </dd>
	<dt>Distância:</dt>
        <dd>
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" name="distancia" id="distancia" class="money" value="<?=$emp->distancia?>" placeholder="Distância">
        </dd>
        <dt>Apelido:</dt>
        <dd>
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" name="apelido" id="apelido" value="<?=$emp->apelido?>" placeholder="Apelido">
        </dd>
	<dt>Loja:</dt>
        <dd>
            <select class="chzn-select" name="loja" id="loja" <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?>>
                <?php $stt = TiposDeStatus(4);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($emp->loja==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Cidade:</dt>
        <dd>
            <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="text" name="cidade" id="cidade" value="<?=$emp->cidade?>" placeholder="Cidade">
        </dd>
	<dt>UF:</dt>
        <dd>
            <select class="chzn-select" name="estados" id="estados" <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?>>
                    <?php $estado = array('AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT',
                            'MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP',
                            'SE','TO');
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $emp->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
            </select>
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <?php if($cad == 1){?>
                <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="button" onclick="location.href='<?=$link?>&opcoes_form=13&id_franquia_regiao=0'" value="novo &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cep1">
                <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cep2">     
            <?php } else { ?>
                <input <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> type="submit" value="inserir &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cep1">
            <?php } ?>
        </div>
    </dl>
    <?php
    $listar = $franquia->listar(3, $id); 
    if(count($listar) > 0){ ?>
    <h3>Faixas</h3>
    <dl class="box">
        <table class="table1">
            <thead>
                <tr>
                    <th class="size100 size200" colspan="2">cep</th>
                    <th>apelido</th>
                    <th>cidade</th>
                    <th class="size100 size50">uf</th>
                    <th class="size50">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
		foreach($listar AS $f){ 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; 
                    $color = ($id_franquia_regiao == $f->id_franquia_regiao) ? '#D9FF88' : $color; ?>
                <tr <?=TRColor($color)?>>
                        <td class="size100"><?=$f->cep_i?></td>
                        <td class="size100"><?=$f->cep_f?></td>
                        <td><?=  utf8_encode($f->apelido)?></td>
                        <td><?=utf8_encode($f->cidade)?></td>
                        <td class="size100 size50"><?=$f->estado?></td>
                        <td class="size100 size50"><a <?=($controle_id_usuario != 1) ? 'disabled="disabled"' : ''?> href="<?=$link?>&opcoes_form=13&id_franquia_regiao=<?=$f->id_franquia_regiao?>"><img src="images/bt-edit.png"></a></td>
                    </tr>
		<?php } ?>
            </tbody>
        </table>
    </dl>
    <?php } ?>
</form>
<?php if($_POST AND isset($opcoes_form) AND $opcoes_form == 13){ ?>
    <div class="msgbox">
        <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
        <div class="text"></div>
    </div>
    <script>
        BoxMsg(<?=($_POST) ? 1 : 0?>,<?=$errors?>,'<?=$campos?>','<?=$msgbox?>');
    </script>
<?php } ?>