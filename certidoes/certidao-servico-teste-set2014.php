<? 
pt_register('POST', 'submit_pedido');
pt_register('POST', 'id_servico');
pt_register('GET', 'id_afiliado');
pt_register('GET', 'id');


require("geoip/geoipcity.inc.php");
require("geoip/geoipregionvars.php");
$gi = geoip_open("geoip/GeoIPCity.dat", GEOIP_STANDARD);
$record = geoip_record_by_addr($gi, $ip);
$pais = $record->country_name;
#echo $pais.'<br>';
#echo $ip.'<br>';
#print_r($gi);
#print_r($record);

pt_register('GET', 'p_novo');
if ($p_novo == 1) {
    unset($_SESSION['p']);
    unset($_SESSION['id_pedido']);
}
$p = $_SESSION['p'];
if ($id <> '' and $id_servico == '')
    $id_servico = $id;
if ($id_afiliado != '')
    setcookie("id_afiliado", $id_afiliado);

$pedidoDAO = new PedidoTesteDAO();
$servicosDAO = new ServicoTesteDAO();
$servicocampos = $servicosDAO->listaCamposSite($id_servico);

if ($submit_pedido <> '') {//check for errors
    $errors = array();
/*
    pt_register('POST', 'nome');
    pt_register('POST', 'tel2');
    pt_register('POST', 'tel');
    pt_register('POST', 'ramal2');
    pt_register('POST', 'ramal');
    pt_register('POST', 'fax');
    pt_register('POST', 'outros');
    pt_register('POST', 'email');
    pt_register('POST', 'cpf');
    pt_register('POST', 'rg');
    pt_register('POST', 'tipo');
    pt_register('POST', 'complemento');
    pt_register('POST', 'numero');
    pt_register('POST', 'endereco');
    pt_register('POST', 'bairro');
    pt_register('POST', 'cidade');
    pt_register('POST', 'estado');
    pt_register('POST', 'cep');
    pt_register('POST', 'id_servico');
    pt_register('POST', 'id_servico_var');
    pt_register('POST', 'obs');
    pt_register('POST', 'contato');
    pt_register('POST', 'contato_rg');
	
	*/

	if(isset($_POST)){
		foreach($_POST as $cp => $valor){ $$cp = char_upper(strtoupper(strtolower($valor)));  }
		
	}
	
	
    if ($nome == "" || $id_servico == "" || $id_servico_var == "" || $tel == "" || $email == "" || $cep == "") {
        if ($nome == "")
            $errors['nome'] = 1;
        if ($id_servico == "" or $id_servico == "0")
            $errors['id_servico'] = 1;
        if ($id_servico_var == "" or $id_servico_var == "0")
            $errors['id_servico_var'] = 1;
        if ($tel == "")
            $errors['tel'] = 1;
        if ($email == "")
            $errors['email'] = 1;
        if ($cep == "") {
            $errors['cep'] = 1;
            if ($endereco == "")
                $errors['endereco'] = 1;
            if ($numero == "")
                $errors['numero'] = 1;
            if ($bairro == "")
                $errors['bairro'] = 1;
            if ($cidade == "")
                $errors['cidade'] = 1;
            if ($estado == "")
                $errors['estado'] = 1;
        }
        $error .= "<span style='font: 12px Arial; color:#000000;'>Os campos em vermelho são obrigatórios.</span><br />";
    }
    if (strtolower($tipo) == 'cpf' and $cpf <> '') {
        $valida = validaCPF($cpf);
        if ($valida == 'false') {
            $errors['cpf'] = 1;
            $error.="<span style='font: 12px Arial; color:#000000;'>CPF Inválido, digite corretamente.</span><br />";
        }
    } else {
        if (strtolower($tipo) == 'cnpj' and $cpf <> '') {
            $valida = validaCNPJ($cpf);
            if ($valida == 'false') {
                $errors['cpf'] = 1;
                $error.="<span style='font: 12px Arial; color:#000000;'>CNPJ Inválido, digite corretamente.</span><br />";
            }
        }
    }

    $resvalor = $pedidoDAO->selectDepartamentoResp($id_servico_var);
    $id_servico_departamento = $resvalor->id_departamento;

    if ($id_servico_departamento == '' and $id_servico_var <> '') {
        if ($errors != 1) {
            $error.="<span style='font: 12px Arial; color:#000000;'>Erro ao cadastrar o pedido. Por favor entre em contato com nossa central de atendimento (11) 3103-0800</span>";
        }
        $errors['id_servico'] = 1;
    }

    $p = new stdClass();
    $p->nome = $nome;
    $p->origem = 'Site';
    $p->id_ponto = '';
    $p->id_pacote = '';
    $p->retem_iss = '';
    $p->urgente = '';
    $p->restricao = '';
    $p->id_conveniado = '';
    $p->id_cliente = '';
    $p->tel2 = $tel2;
    $p->tel = $tel;
    $p->ramal2 = $ramal2;
    $p->ramal = $ramal;
    $p->fax = $fax;
    $p->outros = $outros;
    $p->email = $email;
    $p->cpf = $cpf;
    $p->rg = $rg;
    $p->tipo = $tipo;
    $p->complemento = $complemento;
    $p->numero = $numero;
    $p->endereco = $endereco;
    $p->bairro = $bairro;
    $p->cidade = $cidade;
    $p->estado = $estado;
    $p->cep = $cep;
    $p->omesmo = 'on';
    $p->controle_cliente = '';
    $p->complemento_f = $complemento;
    $p->numero_f = $numero;
    $p->endereco_f = $endereco;
    $p->bairro_f = $bairro;
    $p->cidade_f = $cidade;
    $p->estado_f = $estado;
    $p->cep_f = $cep;
    $p->forma_pagamento = 'DEPÓSITO';
    $p->dados_bancarios = '';
    $p->id_servico = $id_servico;
    $p->id_servico_departamento = $id_servico_departamento;
    $p->id_servico_var = $id_servico_var;
    $p->obs = $obs;
    $p->contato = $contato;
    $p->contato_rg = $contato_rg;
    $p->id_afiliado = (int) ($_COOKIE['id_afiliado']);
    $p->retirada = '';

    $ip = explode(',', $_SERVER["HTTP_X_FORWARDED_FOR"]);
    $p->ip = $ip[0];
    foreach ($servicocampos as $servicocampo) {
        pt_register('POST', $servicocampo->campo);
        $p->{$servicocampo->campo} = char_upper(strtoupper(strtolower(${$servicocampo->campo})));
    }
    #$_SESSION['p'] = $p;
    
    if (count($errors) < 1) {
        if ($_SESSION['id_pedido'] == '') {
            #verifica direcionamento
            $res = $pedidoDAO->selectEmpresaCEP($cep,$pais);
			$res->id_empresa = $res->id_empresa == 25 ? 429 : $res->id_empresa;
			$res->id_usuario = $res->id_empresa == 25 ? 4027 : $res->id_usuario;

            $controle_id_empresa = $res->id_empresa;
            $controle_id_usuario = $res->id_usuario;

            if ($_COOKIE['id_afiliado'] <> '') {
                $resafi = $pedidoDAO->selectAfiliado($_COOKIE['id_afiliado']);
                if ($_COOKIE['id_afiliado'] != 10 or $_COOKIE['id_afiliado'] == 10 and str_replace('Ã', 'a', str_replace('ã', 'a', strtolower($cidade))) == 'sao paulo') {
                    $controle_id_empresa = $resafi->id_empresa;
                    $controle_id_usuario = $resafi->id_usuario;
                }
            }
            if ($controle_id_empresa == '') {
                $controle_id_empresa = '1';
                $controle_id_usuario = '1';
            }

            #atribui o id_empresa, e  id_usuario
            $p->id_empresa_atend = $controle_id_empresa;
            $p->id_usuario = $controle_id_usuario;
            $p->valor = $resvalor->{'valor_' . $controle_id_empresa};
            $p->dias = $resvalor->{'dias_' . $controle_id_empresa};

            $cadastrar_pedido = $pedidoDAO->inserir($p);
        } else {
            #atribui o id_empresa, e  id_usuario
            $p->id_empresa_atend = $_SESSION['p_id_empresa_atend'];
            $p->id_usuario = $_SESSION['p_id_usuario'];
            $p->valor = $resvalor->{'valor_' . $_SESSION['p_id_empresa_atend']};
            $p->dias = $resvalor->{'dias_' . $_SESSION['p_id_empresa_atend']};
            $cadastrar_pedido = $_SESSION['id_pedido'] . '/' . $pedidoDAO->inserir_item($p, $_SESSION['id_pedido']);
        }
        $verificacliente = $pedidoDAO->verificaCliente($p);
        $cadastrar_pedido_exp = explode('/', str_replace('#', '', $cadastrar_pedido));
        $_SESSION['id_pedido'] = $cadastrar_pedido_exp[0];
        ?>
        <!-- Google Code for Convers&otilde;es Conversion Page -->
        <script type="text/javascript">
            <!--
            var google_conversion_id = 1030969530;
            var google_conversion_language = "pt_BR";
            var google_conversion_format = "2";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "2maDCLjluAEQurHN6wM";
            var google_conversion_value = 0;
            //-->
        </script>
        <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
        </script>

        <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1030969530/?label=2maDCLjluAEQurHN6wM&amp;guid=ON&amp;script=0"/>
        </div>
        </noscript>
        <script>
            if(confirm('Pedido enviado com sucesso!\nO número da ordem é: <?= $cadastrar_pedido ?>\n\nDeseja Solicitar outro serviço?')){
                window.location="/certidoes/certidao.php";
            }else{
                window.location="index.php";
            }
        </script>
        <?
        exit;
    }
}
#fim do submit
?>
<form name="form_orcamento1" id="form_orcamento1" action="" method="post" enctype="multipart/form-data">
    <table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
        <tr>
            <td colspan="5">
				<p>
					Solicite seu orçamento e em breve nossa equipe entrará em contato para informar os valores e confirmar sua solicitação!<br /><br/>
				</p>		

                <strong>Dados do Solicitante</strong>					
                <? if ($_SESSION['id_pedido'] == '') { ?>
                    <div></div>
                    <? } else { ?>
                        <p><strong>Prezado(a) <?= $p->nome ?>, </strong><br />
                            Seus dados de contato já estão armazenados em nosso sistema.<br />
                            Em breve nossa equipe entrará em contato para confirmar sua solicitação!<br />
                            <strong>Para solicitar um novo serviço, preencha os campos abaixo, caso contrário <a href="<?= URL_SITE; ?>certidao.php?p_novo=1">clique aqui!</a></strong>
                        </p>					
                        <div style="display: none; height: 0px"></div>
                        <? } ?>
                        </td>
                        </tr>
						<tr>
                            <td align="left" valign="middle" colspan="4">
                                <?
                                if ($error != '') {
                                    echo '<fieldset>
                      <legend><strong style="font-size: 12px; color: #FF0000;">Ocorreram os seguintes erros:</strong></legend>';
                                    if ($errors) {
                                        echo $error;
                                    }
                                    echo '</fieldset>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="nome">Nome:</label><strong style="color: #FF0000;">*</strong></td>
                            <td colspan="4"><input type="text" name="nome" id="nome" value="<?= $p->nome ?>" <?= ($errors['nome']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                        </tr>
                        <tr>
                            <td><label for="tipo">CPF/CNPJ:</label><strong style="color: #FF0000;">*</strong></td>
                            <td>
                                <? if ($p->tipo == '')
                                    $p->tipo = 'cpf'; ?>
                                <select name="tipo" id="tipo" style="width: 70px;" <?= ($errors['tipo']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> >
                                    <option value="cpf" <? if ($p->tipo == 'cpf')
                                    echo 'selected="selected"'; ?>>CPF</option>
                                    <option value="cnpj" <? if ($p->tipo == 'cnpj')
                                                echo 'selected="selected"'; ?>>CNPJ</option>
									<? if($pais!='Brazil') { ?>
									<option value="outro" <? if ($p->tipo == 'outro')
                                                echo 'selected="selected"'; ?>>OUTRO</option>
									<? } ?>
                                </select>
                                <input type="text" name="cpf" value="<?= $p->cpf ?>" style="width: 200px;" onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else if(tipo.value=='cnpj') masc_numeros(this,'##.###.###/####-##');" <?= ($errors['cpf']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> />
                            </td>
                            <td><label for="rg">RG:</label><strong style="color: #FF0000;"></strong></td>
                            <td width="25%"><input type="text" name="rg" id="rg" value="<?= $p->rg ?>" onKeyUp="masc_numeros(this,'##.###.###-#');" <?= ($errors['rg']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                        </tr>
                        <tr>
                            <td><label for="tel">Telefone 1:</label><strong style="color: #FF0000;">*</strong></td>
                            <td><input type="text" name="tel" id="tel" value="<?= $p->tel ?>" onKeyUp="<? if($pais=='Brazil') { ?> masc_numeros(this,'(##) ####-####');<? } ?>"<?= ($errors['tel']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?>/></td>
                            <td><label for="ramal">Ramal:</label><strong style="color: #FF0000;"></strong></td>
                            <td><input type="text" name="ramal" id="ramal" value="<?= $p->ramal ?>" <?= ($errors['ramal']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                        </tr>
                        <tr>
                            <td><label for="outros">Telefone 2:</label><strong style="color: #FF0000;"></strong></td>
                            <td><input type="text" name="outros" id="outros" value="<?= $p->outros ?>" onKeyUp="<? if($pais=='Brazil') { ?>masc_numeros(this,'(##) ####-####');<? } ?>" <?= ($errors['outros']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                            <td><label for="tel2">Celular:</label><strong style="color: #FF0000;"></strong></td>
                            <td><input type="text" name="tel2" id="tel2" value="<?= $p->tel2 ?>" onKeyUp="<? if($pais=='Brazil') { ?>masc_numeros(this,'(##) ####-####');<? } ?>" <?= ($errors['tel2']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                        </tr>
                        <tr>
                            <td><label for="email">E-mail:</label><strong style="color: #FF0000;">*</strong></td>
                            <td colspan="4"><input type="text" name="email" id="email" value="<?= $p->email ?>" <?= ($errors['email']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Endereço de Entrega</strong></td>
                        </tr>
                        <tr>
                            <td><label for="endereco">Endereço:</label><strong style="color: #FF0000;">*</strong></td>
                            <td><input type="text" name="endereco" id="endereco" value="<?= $p->endereco ?>" <?= ($errors['endereco']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                            <td><label for="numero">Número:</label><strong style="color: #FF0000;"></strong></td>
                            <td><input type="text" name="numero" id="numero" value="<?= $p->numero ?>" <?= ($errors['numero']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                        </tr>
                        <tr>
                            <td><label for="complemento">Complemento:</label><strong style="color: #FF0000;"></strong></td>
                            <td><input type="text" name="complemento" id="complemento" value="<?= $p->complemento ?>" <?= ($errors['complemento']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                            <td><label for="bairro">Bairro:</label><strong style="color: #FF0000;"></strong></td>
                            <td><input type="text" name="bairro" id="bairro" value="<?= $p->bairro ?>" <?= ($errors['bairro']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                        </tr>
                        <tr>
                            <td><label for="cep">CEP:</label><strong style="color: #FF0000;">*</strong></td>
                            <td> <input type="text" name="cep" id="cep" value="<?= $p->cep ?>" <? if($pais=='Brazil') { ?>onKeyUp="masc_numeros(this,'#####-###');" <? } else echo 'onFocus="$(this).unmask();"'; ?> <?= ($errors['cep']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                            <td><label for="estado">Estado:</label><strong style="color: #FF0000;">*</strong></td>
                            <td>
                                <select name="estado" id="estado" <?= ($errors['estado']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> >
                                    <option value="">UF</option>
                                    <?
                                    $estados = $pedidoDAO->selectEstados();
                                    $p_valor = '';
                                    foreach ($estados as $serv) {
                                        $p_valor .= '<option value="' . $serv->estado . '" ';
                                        if ($p->estado == $serv->estado)
                                            $p_valor .= ' selected="selected"';
                                        $p_valor .= '>' . $serv->estado . '</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="cidade">Cidade:</label><strong style="color: #FF0000;">*</strong></td>
                            <td><input type="text" name="cidade" id="cidade" value="<?= $p->cidade ?>" <?= ($errors['cidade']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> /></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Dados do Documento</strong></td>
                        </tr>
                        <tr>
                            <td><label for="id_servico">Serviço:</label><strong style="color: #FF0000;">*</strong></td>
                            <td>
                                <?= $combo_servico; ?>
                            </td>
                            <td><label for="id_servico_var">Região:</label><strong style="color: #FF0000;">*</strong></td>
                            <td>
                                <select name="id_servico_var" id="id_servico_var" <?= ($errors['id_servico_var']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 20px;"' : ''; ?> >
                                    <option value="">Selecione a Região</option>
                                </select>
                                <? if ($id_servico <> '') { ?>
                                    <script language="javascript" type="text/javascript">
                                        carrega_servico_var('<?= $id_servico ?>','<?= char_upper(strtoupper(strtolower($id_servico_var))) ?>');
                                    </script>
                                <? } ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div id="carrega_campos_input">
                                    <?
                                    $p_valor = "<table>";
                                    foreach ($servicocampos as $servicocampo) {
                                        $p_valor .= '<tr><td><label>' . $servicocampo->nome . ': </label>';
                                        $p_valor .= ($servicocampo->obrigatorio) ? '<strong style="color:#ff0000">*</strong>' : '';
                                        $p_valor .= '</td><td>';
                                        if ($p->id_pedido <> '')
                                            $p->{$servicocampo->campo} = $res_campo->{$servicocampo->campo};
                                        if ($servicocampo->campo != 'certidao_estado' and $servicocampo->campo != 'certidao_cidade') {
                                            $p_valor .= '<input type="' . $servicocampo->tipo . '" name="' . $servicocampo->campo . '" value="' . $p->{$servicocampo->campo} . '" style="width:540px"';
                                            if ($servicocampo->mascara <> '') {
                                                $p_valor .= ' onKeyUp="masc_numeros(this,\'' . $servicocampo->mascara . '\');"';
                                            }
                                            $p_valor .= ' style="border: 1px solid #FF0000; width: 100%; height: 20px;"/>';
                                        } else {
                                            if ($servicocampo->campo == 'certidao_estado')
                                                $java_script = ' onchange="carrega_cidade2(this.value);" ';
                                            else
                                            if ($servicocampo->campo == 'certidao_cidade')
                                                $java_script = ' id="carrega_cidade_campo" ';
                                            else
                                                $java_script = '';
                                            $p_valor .= '<select name="' . $servicocampo->campo . '" style="width:140px" ' . $java_script . ' style="border: 1px solid #FF0000; width: 100%; height: 20px;">
                                     <option value="' . $p->{$servicocampo->campo} . '">' . $p->{$servicocampo->campo} . '</option>';
                                            if ($p->{$servicocampo->campo} <> '') {
                                                $p_valor .= '<option value=""></option>';
                                            }
                                            if ($servicocampo->campo == 'certidao_estado') {
                                                $servicocampo_sel = $servicosDAO->listaEstados();
                                                foreach ($servicocampo_sel as $scs) {
                                                    $p_valor .= '<option value="' . $scs->estado . '">' . $scs->estado . '</option>';
                                                }
                                            } else {
                                                if ($servicocampo->campo == 'certidao_cidade' and $certidao_estado <> '') {
                                                    $servicocampo_sel = $servicosDAO->listaCidades($certidao_estado);
                                                    foreach ($servicocampo_sel as $scs) {
                                                        $p_valor .= '<option value="' . $scs->cidade . '">' . $scs->cidade . '</option>';
                                                    }
                                                }
                                            }
                                            $p_valor .= '</select>';
                                        }
                                        if ($servicocampo->mascara <> '') {
                                            $p_valor .= 'onKeyUp="masc_numeros(this,\'' . $servicocampo->mascara . '\');"';
                                        }
                                    }
									if($p_valor!='<table>') echo $p_valor . '</td></tr></table>';
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><label for="campo1">Observação:</label><strong style="color: #FF0000;"></strong></td>
                            <td colspan="4">
                                <textarea name="obs" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?= ($errors['obs']) ? 'style="border: 1px solid #FF0000; width: 100%; height: 80px;"' : ''; ?> ><?= $p->obs ?></textarea>
                                <span id="spcontando1" style="font-size: 12px;">Ainda não temos nada digitado..</span><br />
                                <span id="sprestante1" style="font-size: 12px;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="5"><input type="submit" name="submit_pedido" class="bt_solicitar" value=" "/></td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="4">
                                <?
                                if ($error != '') {
                                    echo '<fieldset>
                      <legend><strong style="font-size: 12px; color: #FF0000;">Ocorreram os seguintes erros:</strong></legend>';
                                    if ($errors) {
                                        echo $error;
                                    }
                                    echo '</fieldset>';
                                }
                                ?>
                            </td>
                        </tr>
                        </table>
                        </form>
