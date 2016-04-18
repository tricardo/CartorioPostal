<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=5" <?=$travar?>>
    <h3>histórico</h3>
    <dl>
        <dt>Status:</dt>
        <dd class="line1">
            <strong><?php
            $status = $expansaoDAO->list_forms_historico_status($c->id_status);
            echo utf8_encode($status[0]->status);
            ?></strong></dd>
        <dt>Atividade: <span>*</span></dt>
        <dd class="line1">
            <select id="id_status" name="id_status" class="required line1 chzn-select" onchange="VerificaStatus(this.value)">
                <?php
                $arr_st = array();
                foreach($expansaoStatusDAO->buscaRelStatus($c->id_status) as $j => $brs){
                    $arr_st[] = array($brs->status,$brs->id_status);
                }
                if($controle_id_usuario == 1 && $c->id_status == 20){
                     $arr_st[] = array('Aberto',1);
                }
                if($c->id_status != 16 && $c->id_status != 14 && $c->id_status != 13){
                    $arr_st[] = array('Cancelar',16);
                    $arr_st[] = array('Contato com Candidato',19);
                }
                $permissao = verifica_permissao('EXPANSAO_S',$controle_id_departamento_p,$controle_id_departamento_s);
                if($controle_id_usuario == 1 OR permissao != 'FALSE'){
                    $arr_st[] = array('Contato com o Consultor',21);
                    $arr_st[] = array('Excluir',20);
                }
                sort($arr_st);
                foreach($arr_st AS $f){ ?>
                    <option value="<?=$f[1]?>"><?=utf8_encode($f[0])?></option>
                <?php } ?>
            </select>
        </dd>
        
        <dt id="h_reuniao">Data da Reunião:</dt>
        <dd>
            <input type="text" id="data_reuniao" name="data_reuniao" placeholder="Data da Reunião" class="data">
        </dd>    
                
        <dt id="contato">Forma de Contato:</dt>
        <dd>
            <select id="forma_pagto2" name="forma_pagto2" class="chzn-select">
                <option value="0">Forma de Contato</option>
                <?php 
                foreach($expansaoDAO->forma_pagto2() AS $vlr => $txt){?>
                    <option value="<?=$vlr?>"><?=$txt?></option>
                <?php } ?>
            </select>
        </dd>
        
        <dt id="h_obs">Observações:</dt>
        <dd class="line1 txta-h">
            <textarea name="observacao_expansao" id="observacao_expansao" placeholder="Observações"></textarea>
        </dd>
        

        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_ficha > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_historico">
        </div>
        <script>VerificaStatus($('#id_status').val())</script>
    </dl>       
    
    
    <?php
    $dt = $expansaoStatusDAO->buscaHistorico($id_ficha);
    $f = $expansaoDAO->buscaDataInclude($id_ficha);
    if(count($dt) > 0){ ?>
    <h3>Atividades</h3>
    <dl class="box">
        <table class="table1">
                <thead>
                    <tr>
                    <th>status</th>
                    <th>consultor</th>
                    <th>forma de contato</th>
                    <th class="size100 buttons">reunião</th>
                    <th class="size100 buttons">data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $color = '#FFFEEE';
                    foreach ($dt as $res) { 
                        $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                    <tr <?=TRColor($color)?>>
                        <td><?=($res->status == 'Excluído') ? 'Arquivo Morto' : $res->status;?></td>
                        <td><?php
                          if($res->id_user_alt == 0){ echo 'Sistema';	} else {
				$u = $expansaoDAO->pega_usuario($res->id_user_alt);
				echo utf8_encode($u[0]->nome);
                          }
                        ?></td>
                        <td><?=$expansaoDAO->forma_pagto2(2, $res->forma_pagto);?></td>
                        <td class="buttons"><?php 
                        if($res->data_reuniao != '0000-00-00'){
                            switch($res->id_status){
                                case 5: case 10: case 12: case 19:
                                    echo verifica_invert_data($res->data_reuniao, 1, '/', '', $hora = '');
                                    break;
                                default: echo '-';
                            }
                        }?></td>
                        <td class="buttons">
                            <?php 
                            if($res->data_inclusao == '0000-00-00 00:00:00'){
                                $data = explode('-', $f->data);
                                echo $data[2].'/'.$data[1].'/'.$data[0];
                            } else {
                                    $d = explode(' ', $res->data_inclusao);
                                    $data = explode('-', $d[0]);
                                    $hora = explode(':', $d[1]);
                                    echo $data[2].'/'.$data[1].'/'.$data[0] . ' ' . $hora[0].':'.$hora[1];
                            } ?>
                        </td>
                    </tr>
                    <?php if(strlen($res->observacao) > 0){?>
                    <tr <?=TRColor($color)?>>
                        <td colspan="5" class="borda3"><strong>Obs.:</strong> <?=utf8_encode($res->observacao);  ?> </td>
                    </tr>
                    <?php }} ?>
                </tbody>
        </table>
    </dl>
    <?php } ?>
    
</form>
<?php if($_POST){ ?>
    <div class="msgbox">
        <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
        <div class="text"></div>
    </div>
    <script>
        BoxMsg(<?=($_POST) ? 1 : 0?>,<?=$errors?>,'<?=$campos?>','<?=$msgbox?>');
    </script>
<?php
}
$errors=0;
$campos='';
$msgbox='';
?>