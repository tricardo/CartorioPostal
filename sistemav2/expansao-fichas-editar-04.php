<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=4" <?=$travar?>>
    <h3>informações jurídicas</h3>
    <dl>
        <dt>Tipo da Franquia <span>*</span>:</dt>
        <dd>
            <select name="tipo_franquia" id="tipo_franquia" class="required chzn-select">
                <?php $stt = TiposDeStatus(2);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($c->tipo_franquia==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
            </dd>

        <dt>N.º COF:</dt>
        <dd>
            <input name="num_cof2" value="<?=$c->num_cof2?>" type="text" id="num_cof2" placeholder="N.º COF" maxlength="7"  class="required" required>
        </dd>

        <dt>Valor da COF:</dt>
        <dd><input name="valor_cof" value="<?=$c->valor_cof?>" type="text" id="valor_cof"  maxlength="14" class="money required" required placeholder="Valor da COF"></dd>

        <dt>Forma de Pagto. <span>*</span>:</dt>
        <dd><input class="required" required name="forma_pagto" value="<?=$c->forma_pagto?>" type="text" id="forma_pagto" maxlength="30" placeholder="Forma de Pagto."></dd>

        <dt>Origem:</dt>
        <dd>
            <select name="origem2" id="origem2" class="chzn-select">
                <option value="0" <?=($c->origem2==0)?'selected':'';?>>Origem</option>
                <option value="1" <?=($c->origem2==1)?'selected':'';?>>ABF</option>
                <option value="2" <?=($c->origem2==2)?'selected':'';?>>E-mail</option>
                <option value="3" <?=($c->origem2==3)?'selected':'';?>>Site</option>
            </select>
        </dd>
        <dt>Valor Efetivo <span>*</span>:</dt>
        <dd><input class="money required" required name="valor_efetivo" value="<?=$c->valor_efetivo?>" type="text" id="valor_efetivo" maxlength="14" placeholder="Valor Efetivo">

        <dt>Valor do Royaltie: </dt>
        <dd><input class="money required" required name="valor_royaltie" value="<?=$c->valor_royaltie?>" type="text" id="valor_royaltie" maxlength="14" placeholder="Valor do Royaltie">

        <dt>N.º COF Emitido:</dt>
        <dd class="checks">
            <input  id="cof_emitido1" name="num_cof_emitida[]" type="radio" value="1" <?=($c->num_cof_emitida==1)?'checked':'';?>>
            <span>Sim</span>
            <input id="cof_emitido2" name="num_cof_emitida[]" type="radio" value="0" <?=($c->num_cof_emitida==0)?'checked':'';?>>
            <span>Não</span>
        </dd>
        <dt>Tipo do Arquivo:</dt>
        <dd>
            <select name="tipo_upload" id="tipo_upload" class="chzn-select">
                <?php $tipo_up = $expansaoDAO->tipo_upload(2,0);
                for($i = 0; $i < count($tipo_up[0]); $i++){ ?>
                    <option value="<?=$tipo_up[0][$i]?>"><?=$tipo_up[1][$i]?></option>
                <?php } ?>				
            </select>
        </dd>
        <dt>Arquivo:</dt>
        <dd>
            <input type="file" name="arquivo" id="arquivo" placeholder="Arquivo">
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_ficha > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_juridica">
        </div>
    </dl>  
    <?php
    $dt = $expansaoDAO->listaAnexo($id_ficha);
    if(count($dt) > 0){ ?>
    <h3>Arquivos</h3>
    <dl class="box">
        <table class="table1">
                <thead>
                    <tr>
                    <th>Tipo do arquivo</th>
                    <th>arquivo</th>
                    <th>usuário</th>
                    <th class="size100">excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $color = '#FFFEEE';
                    foreach ($dt as $res) { 
                        $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';
                        $tipo = trim($expansaoDAO->tipo_upload(1,$res->tipo_upload));?>
                    <tr <?=TRColor($color)?>>
                        <td><?=substr($tipo,0,15)?></td>
                        <td><a href="anexos_expansao/<?=$res->arquivo?>" target="_blank"><?=utf8_encode(substr(trim($res->nome),0,10))?></a></td>
                        <td><?=utf8_encode($res->consultor)?></td>
                        <td class="buttons">
                            <?php if($controle_id_usuario != 1 OR $res->id_usuario != $controle_id_usuario){ 
                                echo '-';
                            } else { ?>                             
                                <a href="<?=$link?>&opcoes_form=4&excluir=1&id_arquivo=<?=$res->id_anexo?>"><img src="images/bt-del.png"></a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
        </table>
    </dl>
    <?php } ?>
</form>
