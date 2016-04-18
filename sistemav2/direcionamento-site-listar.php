<?php include('header.php'); 

$permissao = verifica_permissao('Direcionamento_site',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$usuarioDAO = new UsuarioDAO();
$afiliadoDAO = new AfiliadoDAO();
$pedidoDAO = new PedidoDAO();
$empresaDAO = new EmpresaDAO();

$onde='';
$show_msgbox = 0;

$exibe = 0;
$inc_status_obs = '';
if(isset($_SESSION['monitoramento_id_empresa']) AND $_SESSION['monitoramento_id_empresa'] == 1){
    $exibe = 1;
    $inc_status_obs = "[".$_SESSION['monitoramento_nome']."] - ";
} elseif($controle_id_empresa == 1){
    $exibe = 1;
    $inc_status_obs = "[".$controle_id_usuario.' : '.$controle_nome."] - ";
}

$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca_id_pedido = isset($c->busca_id_pedido) ? $c->busca_id_pedido : '';
$c->id_usuario_franquia = isset($c->id_usuario_franquia) ? $c->id_usuario_franquia : '';
$c->id_usuario = isset($c->id_usuario) ? $c->id_usuario : '';
$c->estado = isset($c->estado) ? $c->estado : '';
$c->id_pedido = 0;
$c->ordem = 0;
if(strlen($c->busca_id_pedido) > 0){
    $c->id_pedido = $c->busca_id_pedido;
    if(substr_count($c->busca_id_pedido,"/") > 0){
        $items = explode('/',$c->busca_id_pedido);
        $c->id_pedido = $items[0];
        $c->ordem = $items[1];
    }
}

$busca = new stdClass();
$busca->busca_id_pedido = $c->busca_id_pedido;
$busca->id_pedido = $c->id_pedido;
$busca->ordem = $c->ordem;
$busca->id_empresa = $controle_id_empresa;
$busca->estado = $c->estado;

$afi = $afiliadoDAO->listarTodos();
$afiliado = array();
foreach($afi as $l){
    $afiliado[$l->id_afiliado]=$l->nome;
}        

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca_id_pedido)) ? '&busca_id_pedido='.$c->busca_id_pedido : '';
$link .= (isset($c->id_usuario_franquia)) ? '&id_usuario_franquia='.$c->id_usuario_franquia : '';
$link .= (isset($c->id_usuario)) ? '&id_usuario='.$c->id_usuario : '';
$link .= (isset($c->estado)) ? '&estado='.$c->estado : '';

$acao_direcionamento = '';
$big_msg_box_color = '';
if($_GET OR $_POST){
    if($_POST){
        $p = UTF_Encodes(Post_StdClass($_POST), 2);
        $acao_direcionamento = isset($_POST['acao_direcionamento']) ? $p->acao_direcionamento : '';
    }
    if($acao_direcionamento == ''){
        $acao_direcionamento = isset($_GET['acao_direcionamento']) ? $c->acao_direcionamento : '';        
    }
    if($acao_direcionamento != ''){
        switch($acao_direcionamento){
            case 'colaborador_site': include('direcionamento-listar-site-colaborador.php'); break;
            case 'unidade_site': include('direcionamento-listar-site-unidade.php'); break;
            case 'duplicidade': include('direcionamento-listar-site-duplicidade.php'); break;
        }  
    }
}
?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; direcionamento do site');
    $('#sub-17').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">       
        <dl>
            <legend>Buscar Ordens</legend>
            <dt>Ordem:</dt>
            <dd>
                <input value="<?=$c->busca_id_pedido?>" type="text" name="busca_id_pedido" id="busca_id_pedido" class="ordem" placeholder="Ordem"> 
            </dd>   
            <dt>Estado:</dt>
            <dd>
                <select id="estado" name="estado" class="chzn-select">
                    <option value="">Estado</option>
                    <?php foreach(UFs(0) AS $e){ ?>
                        <option value="<?=$e?>"<?=$c->estado==$e? ' selected="selected"':''?>><?=$e?></option>
                    <?php } ?>
                </select>
            </dd>
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="direcionamento-site-listar.php<?=$link?>">
                <input type="hidden" id="acao_direcionamento" name="acao_direcionamento">
                <input type="hidden" id="hash" name="hash" value="<?=date('s')?>">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
        <?php if($_GET OR $_POST){?>
        <dl>
            <dt>Direcionar:</dt>
            <dd>
                <select name="id_usuario" id="id_usuario" class="chzn-select">
                    <option value="">Colaborador</option>
                    <?php $p_valor='';
                    foreach($usuarioDAO->listarAtivos($controle_id_empresa) as $u){
                        $departamento_p = explode(',',$u->departamento_p);
                        foreach($departamento_p as $dep){
                            if(in_array($dep,$departamento_s) and $dep<>''){
                                $p_valor .= '<option value="'.$u->id_usuario.'"';
                                if($c->id_usuario==$u->id_usuario) $p_valor .= ' selected="selected" ';
                                $p_valor .= ' >'.utf8_encode($u->nome).'</option>';
                                break;
                            }
                        }
                    }
                    echo $p_valor; ?>
		</select>
            </dd>
            <?php if($exibe == 1){ ?>
                <dt>Direcionar:</dt>
                <dd>
                    <select name="id_usuario_franquia" id="id_usuario_franquia" class="chzn-select">
                        <option value="">Unidade</option>
                        <?php $empresas = $empresaDAO->listarAtendenteEmpresa($controle_id_empresa);
			#$dir = explode('/', $_SERVER['SCRIPT_FILENAME']);
			include('../certidoes/model/roylties-a-pagar.php');
                        $p_valor = '';
			foreach($empresas as $emp){
				if($controle_id_empresa != 1){
                                    if(!in_array($emp->id_empresa, $arr)){
                                        $p_valor .= '<option value="'.$emp->id_usuario.'"';
                                        if($c->id_usuario_franquia==$emp->id_usuario) $p_valor .= ' selected="selected" ';
                                        $p_valor .= ' >'.utf8_encode($emp->fantasia).'</option>';
                                    }
				} else {
                                    $p_valor .= '<option value="'.$emp->id_usuario.'"';
                                    if($c->id_usuario_franquia==$emp->id_usuario) $p_valor .= ' selected="selected" ';
                                    $p_valor .= ' >'.utf8_encode($emp->fantasia).'</option>';
				}
			}
			echo $p_valor; ?>
                    </select>
                </dd>
            <?php } ?>
            <div class="buttons">
                <input type="button" value="duplicidade &rsaquo;&rsaquo;" onclick="DirecionamentoConfirm(1,'duplicidade')">
                | 
                <input type="button" value="colaborador &rsaquo;&rsaquo;" onclick="DirecionamentoConfirm(1,'colaborador_site')" style="width:auto">
                <?php if($exibe == 1){ ?>
                    <input type="button" value="unidade &rsaquo;&rsaquo;" onclick="DirecionamentoConfirm(1,'unidade_site');">
                <?php } ?>
            </div>
            <div class="instrictions" style="display:none">
                <p>
                    <strong class="active">Últimos 30 Pedidos Cadastrados Pelo Site:</strong><br>
                    <div id="instrictions_site"></div>
                </p>
            </div>
        </dl>
         <?php } ?>
    </form>
</div>

<div class="content-list-table">   
<?php
if($_GET){ 
    $pedidos = $pedidoDAO->buscaDirecionamentoSite($busca,$c->pagina);
    if(count($pedidos) > 0){ ?>
        <div class="paginacao">
            <?php $pedidoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons"><input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check1','direcionamento_site')"></th>
                    <th class="buttons">ordem</th>	
                    <th class="buttons">data</th>	
                    <th>solicitante</th>	
                    <th>região</th>	
                    <th>documento</th>	
                    <th>e-mail</th>	
                    <th>serviço</th>	
                    <th>cidade</th>	
                    <th class="buttons">estado</th>
                    <th>atendente</th>	
                    <th>afiliado</th>
                </tr>
            </thead>
            <tbody>
                 <?php $color = '#FFFEEE';
                $cidade = '';
                $estado = '';
                $verifica=1;
                foreach($pedidos as $p){ 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  
                    if(strlen($busca->busca_id_pedido) >= 6){
                        if(isset($cidade) AND $cidade == ''){
                            $cidade = (isset($cidade) AND $cidade == '') ? $p->cidade : '';
                            $estado = (isset($estado) AND $estado == '') ? $p->estado : '';
                        } else {
                            if($cidade != $p->certidao_cidade){
                                $verifica=0;
                            }
                        } 
                    } ?>
                     <tr <?=TRColor($color)?>>
                         <td class="buttons"><input <?=((isset($_SESSION['direcionamento_site']) AND count($_SESSION['direcionamento_site']) > 0 AND in_array($p->id_pedido_item.';'.$p->id_pedido.';'.$p->ordem, $_SESSION['direcionamento_site'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_direcionamento[]" id="id_direcionamento<?=$p->id_pedido_item?>" value="<?=$p->id_pedido_item.';'.$p->id_pedido.';'.$p->ordem?>" class="check1" onclick="CkechSession(1,this.id,'direcionamento_site')"></td>
                         <td class="buttons"><?='#'.$p->id_pedido . '/'.$p->ordem?></td>
                         <td class="buttons"><?=invert($p->data,'/','PHP')?></td>
                         <td><?= $p->cpf.' <br> '.utf8_encode(ucwords(strtolower($p->nome)))?></td>
                         <td><?= utf8_encode(ucwords(strtolower($p->cidade.'-'))).$p->estado?></td>
                         <td><?= utf8_encode(ucwords(strtolower($p->certidao_nome)))?></td>
                         <td><?= utf8_encode(strtolower($p->email))?></td>
                         <td><?= utf8_encode(ucwords(strtolower($p->desc_servico)))?></td>
                         <td><?= utf8_encode(ucwords(strtolower($p->certidao_cidade)))?></td>
                         <td class="buttons"><?= $p->certidao_estado?></td>
                         <td><?= utf8_encode(ucwords(strtolower($p->atendente)))?></td>
                         <td><?= isset($afiliado[$p->id_afiliado]) ? utf8_encode(ucwords(strtolower($afiliado[$p->id_afiliado]))) : ''?></td>
                    </tr>
                <?php } ?>
            </tbody>    
        </table>
        <div class="paginacao">
            <?php $pedidoDAO->QTDPagina(); ?>
        </div>
    <?php 
        if($controle_id_empresa == 1 AND isset($cidade) > 0 AND isset($estado) AND strlen($cidade) > 0 AND strlen($estado) > 0 AND $verifica == 1){
            $dt = $pedidoDAO->ProxDir($cidade, $estado);
            $id_empresa = array();
            foreach($dt AS $p){
                if(!in_array($p->id_empresa, $arr)){
                    if(!isset($id_empresa[$p->id_empresa])){
                        $id_empresa[$p->id_empresa] = array();
                    }
                    $id_empresa[$p->id_empresa][] = invert($p->data,'/','PHP').';#'.$p->id_pedido.';'.utf8_encode($p->fantasia);
                }
            }
            if(count($id_empresa) > 0){
                $str1 = '';
                if(count($id_empresa) > 1){
                    $str = array();
                    foreach($id_empresa AS $p){
                        $color = '#999';
                        for($i = 0; $i < count($p); $i++){
                            $items = explode(';',$p[$i]);
                            if($i == 0){
                                if(count($str) == 0){
                                    $str[0] = array(count($p), $items[2]);
                                } else {
                                    if(count($p) <= $str[0][0]){
                                        $str[0] = array(count($p), $items[2]);
                                    }
                                }
                                $str1 .= '<strong>'.$items[2] .' ('.count($p).'</strong>):&nbsp;&nbsp;&nbsp;[';
                            }
                            $color = $color == '#777' ? '#999' : '#777';
                            $str1 .= '<span style="color:'.$color.'">'.$items[0].' - '.$items[1].'</span>';
                            $str1 .= ($i < count($p) - 1) ? ';&nbsp;&nbsp;' : ']<br>';
                        }
                    }
                    $str = 'Você deve direcionar este pedido para a unidade de <strong>'.$str[0][1].'</strong> que teve '.$str[0][0]
                            .' direcionado(s) nesses últimos 30 pedidos cadastrados pelo site.<br><br>'.$str1;
                } else {
                    $str = '';
                    foreach($id_empresa AS $p){
                        $str1 .= $p[0];
                        $str = explode(';',$p[0]);
                        $str = trim($str[2]);
                    }
                    $str = 'Você deve direcionar este pedido para a unidade de <strong>'.$str.'</strong>:<br>'.str_replace(';',' - ',$str1);
                }
                echo '<script>';
                echo "$('.instrictions').show();";
                echo "$('#instrictions_site').html('".$str."');";
                echo '</script>';
            }
        }
    } else { 
        RetornaVazio();
        $zera_sessao = 1;
    }    
} else {
    RetornaVazio(2);
    $zera_sessao = 1;
} 
if(isset($zera_sessao)){ 
    echo "<script>CkechSession(3,'.check3','zera_sessao')</script>";
} ?>
</div>
<?php include('footer.php'); ?>