<?
require('header.php');
$alert_done = '';
?>
<div id="topo">
    <?
    $departamento_s = explode(',', $controle_id_departamento_s);
    $departamento_p = explode(',', $controle_id_departamento_p);
    pt_register('GET', 'id');
    pt_register('GET', 'ordem');
    pt_register('COOKIE', 'aba');

    $id_pedido = $id;
    $empresaDAO = new EmpresaDAO();
    $pedidoDAO = new PedidoDAO();
    $pedidoverificaDAO = new PedidoVerificaDAO();
    $servicosDAO = new ServicoDAO();
    $financeiroDAO = new FinanceiroDAO();
    $cartorioDAO = new CartorioDAO();

    
#verifica permissão de alterar o pedido e carrega variavel com data de encerramento
    $res = $pedidoverificaDAO->verificaPermissaoEditPedido($id_pedido, $ordem, $controle_id_empresa);
    $id_pedido_item = $res->id_pedido_item;
    $id_empresa = $res->id_empresa;
    $id_servico = $res->id_servico;
    $inicio = $res->inicio;
    $encerramento_pedido = $res->encerramento;
    $servicocampos = $servicosDAO->listaCampos($id_servico);

    $lista = $empresaDAO->listarTodasFranquias();
    foreach ($lista as $l) {
        $vardir[$l->id_empresa] = $l;
    }

#só faz essa pesquisa se não encontrar nada na pesquisa acima.
    if ($id == '' or $id_pedido_item == '' or $ordem == '') {
        echo 'Procedimento Incorreto. Entre em contato com o suporte técnico!!! ';
        $pedido = $pedidoDAO->selectPedidoPorId($id_pedido, $ordem);
        if ($pedido->id_empresa_resp != '') {
            echo '<br>Esse pedido pertence à franquia';
            echo ' <b>' . $vardir[$pedido->id_empresa_resp]->fantasia . '</b>';
        } else {
            echo '<br>Esse pedido pertence à franquia';
            echo ' <b>' . $vardir[$pedido->id_empresa_atend]->fantasia . '</b>';
        }
        exit;
    }

	function DadosServico($id_empresa, $controle_id_empresa, $id_pedido, $status, $data_prazo){
		$pedidoDAO = new PedidoDAO();
		#conta ordens, proximo, anterior, valor, fechadas e canceladas
		if ($id_empresa == $controle_id_empresa) {
			#conta servicos para criar link anterior e proximo
			$ordens = $pedidoDAO->contaOrdens($id_pedido);
			if ($ordens->total > 1)
				$ordem_anterior = (int) ($ordem) - (int) (1);
			if ($ordens->total > $ordem)
				$ordem_proximo = (int) ($ordem) + (int) (1);
			#conta cancelados e não cancelados
			#$contafechado = $pedidoDAO->contaOrdemFechado($id_pedido);
			#$ordenscanceladas = $ordens->total-$contafechado->fechado;
			
			$p_valor .= "<strong>Status Atual:</strong> " . $status . " &nbsp;&nbsp;|&nbsp;&nbsp";
			if ($id_empresa == $controle_id_empresa) {
				$p_valor .= '<strong>Valor Total:</strong> R$ ' . number_format($ordens->valor, 2, ".", "");
				if ($permissao_financeiro == 'TRUE') {
					//$pf = $pedidoDAO->listaDespesaOrdem($id_pedido, $id_pedido_item);
					//$p_valor .= ' | <strong>Despesas Totais:</strong> R$ ' . number_format($pf->valor, 2, ".", "");
					//$financeiro_valor_d = 'R$ ' . number_format($pf->valor_item, 2, ".", "");
					//$p_valor .= " | <strong>Despesas do Serviço:</strong> " . $financeiro_valor_d;
				}
				#$pf = $pedidoDAO->listaDespesaItem($id_pedido_item,$controle_id_empresa);
			}
			$p_valor .= " | <strong>Prazo:</strong> " . $data_prazo;
			echo "<script>document.getElementById('dados_valores').innerHTML = '".$p_valor."'</script>";
		}
	}
    ?>
    <form enctype="multipart/form-data" action="" method="get" name="pedido_outra_ordem" style="padding: 0; margin: 0">
        <h1 class="tit">
            <img src="../images/tit/tit_pedido.png" alt="Título" />	Pedido # 
            <input type="text" name="id" class="form_estilo" style="width:70px" value="<?= $id ?>" /> / 
            <input type="text" name="ordem" class="form_estilo" style="width: 40px;" value="<?= $ordem ?>" />
            <input type="submit" name="submit_outraordem" class="button_busca" value="Abrir" />
            &nbsp;&nbsp;&nbsp;&nbsp; 
            Itens: <?= $ordens->total . '/' . $contafechado->fechado . '/' . $ordenscanceladas ?>
            &nbsp;&nbsp;&nbsp; <a href="pedido.php"> Buscar Pedidos</a> &nbsp;&nbsp;
            <?
            $permissao_financeiro = $perm_fin;
            if ($permissao_financeiro == 'TRUE') {
                echo '|&nbsp;&nbsp;<a href="financeiro_pagamento.php"> Recebimentos</a>';
            }
            ?> &nbsp;&nbsp;&nbsp; 
            <? if ($ordem_anterior <> '' and $id_empresa == $controle_id_empresa) { ?> 
                <a href="pedido_edit.php?id=<?= $id ?>&ordem=<?= $ordem_anterior ?>"><< Anterior</a> 
            <? }
            if ($ordem_proximo <> '' and $id_empresa == $controle_id_empresa) { ?> | 
                <a href="pedido_edit.php?id=<?= $id ?>&ordem=<?= $ordem_proximo ?>">Próximo >></a> 
                <?
            }
            if ($id_empresa == $controle_id_empresa) {
                ?>
                &nbsp;&nbsp;&nbsp;
                <input type="button" name="protocolo" class="button_busca" value="Protocolo" onclick="window.open('pedido_protocolo.php?id_pedido=<?= $id_pedido ?>&ordem=<?= $ordem ?>','_blank')"/>
            <? } ?>
        </h1>
        <hr class="tit" />

    </form>

    <!-- box mensagem -->
    <div id="windowMensagem">
        <div id="windowMensagemTop">
            <div id="windowMensagemTopContent"><img src="../images/icon/icon_mensagem.png" style="border: 0" /> Ação</div>
            <img id="windowMensagemClose" src="../images/window_close.jpg">
        </div>
        <div id="windowMensagemBottom"><div id="windowMensagemBottomContent"></div></div>
        <div id="windowMensagemContent"><div id="carrega_mensagem_input"></div></div>
    </div>
</div>
<div id="meio">
    <?
    pt_register('POST', 'submit_solicitante');
    pt_register('POST', 'submit_servico');
    pt_register('POST', 'submit_status');
    pt_register('POST', 'submit_mensagem');
    pt_register('POST', 'submit_cartorio');
    pt_register('POST', 'submit_cartorio_deleta');
    pt_register('POST', 'submit_atualiza_cart');
    pt_register('POST', 'submit_anexo');
    pt_register('POST', 'submit_anexo_deleta');
    pt_register('POST', 'submit_financeiro');
    pt_register('POST', 'submit_financeiro_edit');
    pt_register('POST', 'submit_financeiro_edit_r');
    pt_register('POST', 'submit_financeiro_edit_r_d');

    if ($submit_servico) {
        $aba = 'aba0';
        $error = "<b>Ocorreram os seguintes erros:</b><ul>";
        pt_register('POST', 'urgente');
        pt_register('POST', 'valor');
        pt_register('POST', 'controle_cliente');
        pt_register('POST', 'old_valor');
        pt_register('POST', 'id_fatura');
        pt_register('POST', 'dias');
        pt_register('POST', 'old_dias');
        pt_register('POST', 'obs');
        pt_register('POST', 'id_servico');
        pt_register('POST', 'id_servico_var');
        pt_register('POST', 'ocor');
        pt_register('POST', 'regi');
        pt_register('POST', 'motivo_atraso');
        pt_register('POST', 'custas');
        pt_register('POST', 'certidao_resultado');

        $p->urgente = $urgente;
        $p->obs = $obs;
        $p->valor = $valor;
        $p->controle_cliente = $controle_cliente;
        $p->dias = $dias;
        $p->old_valor = $old_valor;
        $p->id_fatura = $id_fatura;
        $p->id_servico = $id_servico;
        $p->id_servico_var = $id_servico_var;
        $p->ocor = $ocor;
        $p->regi = $regi;
        $p->motivo_atraso = $motivo_atraso;
        $p->custas = $custas;
        $p->certidao_resultado = $certidao_resultado;
        foreach ($servicocampos as $servicocampo) {
            pt_register('POST', $servicocampo->campo);
            $p->{$servicocampo->campo} = ${$servicocampo->campo};
        }

        $p_verifica = $pedidoverificaDAO->verificaPermissaoEdit($id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s, $p);
        $p->data_prazo = $p_verifica['data_prazo'];
        if ($p_verifica['error'] == "") {
            $atualiza_ordem = $pedidoDAO->atualizaPedidoItem($p, $id_pedido_item, $controle_id_usuario);
            $alert_done .= "Serviço atualizado com sucesso!";
        } else {
            echo '<div class="erro">' . $p_verifica['error'] . '</div>';
        }
    }

    if ($submit_solicitante) {
        $aba = 'aba1';
        pt_register('POST', 'id_pacote');
        pt_register('POST', 'contato');
        pt_register('POST', 'contato_rg');
        pt_register('POST', 'nome');
        pt_register('POST', 'cpf');
        pt_register('POST', 'tel2');
        pt_register('POST', 'tel');
        pt_register('POST', 'ramal');
        pt_register('POST', 'ramal2');
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
        pt_register('POST', 'complemento_f');
        pt_register('POST', 'numero_f');
        pt_register('POST', 'endereco_f');
        pt_register('POST', 'bairro_f');
        pt_register('POST', 'cidade_f');
        pt_register('POST', 'estado_f');
        pt_register('POST', 'cep_f');
        pt_register('POST', 'omesmo');
        pt_register('POST', 'retem_iss');
        pt_register('POST', 'restricao');
        pt_register('POST', 'retirada');
        pt_register('POST', 'forma_pagamento');
        pt_register('POST', 'dados_bancarios');
        pt_register('POST', 'origem');
        pt_register('POST', 'id_ponto');

        $p->id_pacote = $id_pacote;
        $p->contato = $contato;
        $p->contato_rg = $contato_rg;
        $p->nome = $nome;
        $p->cpf = $cpf;
        $p->tel2 = $tel2;
        $p->tel = $tel;
        $p->ramal = $ramal;
        $p->ramal2 = $ramal2;
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
        $p->complemento_f = $complemento_f;
        $p->numero_f = $numero_f;
        $p->endereco_f = $endereco_f;
        $p->bairro_f = $bairro_f;
        $p->cidade_f = $cidade_f;
        $p->estado_f = $estado_f;
        $p->cep_f = $cep_f;
        $p->omesmo = $omesmo;
        $p->retem_iss = $retem_iss;
        $p->restricao = $restricao;
        $p->retirada = $retirada;
        $p->forma_pagamento = $forma_pagamento;
        $p->dados_bancarios = $dados_bancarios;
        $p->origem = $origem;
        $p->id_ponto = $id_ponto;

        $p_verifica = $pedidoverificaDAO->verificaPermissaoEditSolicitante($id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s, $p);
        if ($p_verifica['error'] == '') {
            $atualiza_pedido = $pedidoDAO->atualizaPedido($p, $id_pedido, $controle_id_usuario);
            $alert_done .= "Solicitante atualizado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $p_verifica['error'] . '</div>';
        }
    }

    if ($submit_status) {//check for errors
        $aba = 'aba2';
        $atividadeDAO = new AtividadeDAO();
        $atividadeverificaDAO = new AtividadeVerificaDAO();
        pt_register('POST', 'id_atividade');
        pt_register('POST', 'status_obs');
        pt_register('POST', 'status_dias');
        pt_register('POST', 'status_hora');

        $s->status_obs = $status_obs;
        $s->status_dias = $status_dias;
        $s->status_hora = $status_hora;
        $p_verifica = $atividadeverificaDAO->AtividadeVerifica($controle_id_empresa, $id_atividade, $status_obs, $departamento_p, $departamento_s, $id_pedido_item);

        if ($p_verifica['error'] == '') {
            $done = $atividadeDAO->inserirAtividade($id_atividade, $s, $controle_id_usuario, $id_pedido_item);
            $alert_done .= "Atividade atualizada com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $p_verifica['error'] . '</ul></div>';
        }
    }

    if ($submit_mensagem) {
        $aba = 'aba3';
        $errors = array();
        $error = "";
        $mensagemDAO = new MensagemDAO();
        pt_register('POST', 'para');
        pt_register('POST', 'mensagem');
        if (!$id_pedido_item || !$mensagem || !$para) {
            if ($mensagem == '')
                $errors['mensagem'] = 1;
            if ($para == '')
                $errors['para'] = 1;
            $error.="<li><b>Todos os campos são obrigatórios.</b></li>";
        }
        if (COUNT($errors) == 0) {
            $done = $mensagemDAO->inserir($id_pedido_item, $controle_id_usuario, $controle_nome, $para, $mensagem);
            $alert_done .= "Mensagem enviada com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $error . '</div>';
        }
    }

    if ($submit_cartorio) {
        $aba = 'aba4';
        $errors = array();
        $error = '';
        pt_register('POST', 'cartorio_estado');
        pt_register('POST', 'cartorio_cidade');
        pt_register('POST', 'cartorio_cartorio');
        pt_register('POST', 'cartorio_atribuicao');

        $p_verifica = $pedidoverificaDAO->verificaPermissaoCart($id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s);
        if ($p_verifica <> '') {
            $errors['error'] = 1;
            $error.=$p_verifica;
        }

        if (!$cartorio_cartorio) {
            $errors['cartorio'] = 1;
            $error.="<li><b>Selecione um cartório.</b></li>";
        }
        if (COUNT($errors) == 0) {
            $c->cartorio_cidade = $cartorio_cidade;
            $c->cartorio_estado = $cartorio_estado;
            $c->cartorio_atribuicao = $cartorio_atribuicao;
            $c->cartorio_cartorio = $cartorio_cartorio;
            $done = $pedidoDAO->inserirCartorio($id_pedido_item, $controle_id_usuario, $c);

            $alert_done .= "Cartório adicionado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $error . '</div>';
        }
    }

    if ($submit_cartorio_deleta) {
        $aba = 'aba4';
        $errors = array();
        $error = "";
        $id_pedido_cartorio = str_replace('Desconsiderar ', '', $submit_cartorio_deleta);

        $p_verifica = $pedidoverificaDAO->verificaPermissaoCart($id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s);

        if ($p_verifica == '') {
            $done = $pedidoDAO->desconsideraCartorio($controle_id_usuario, $id_pedido_cartorio, $id_pedido_item);
            $alert_done .= "Cartório desconsiderado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $p_verifica . '</div>';
        }
    }

    if ($submit_atualiza_cart and $controle_id_empresa == '1') {//check for errors
        $aba = 'aba4';
        $errors = array();
        pt_register('POST', 'id_cartorio');
        pt_register('POST', 'nome');
        pt_register('POST', 'fantasia');
        pt_register('POST', 'cpf');
        pt_register('POST', 'rg');
        pt_register('POST', 'endereco');
        pt_register('POST', 'numero');
        pt_register('POST', 'complemento');
        pt_register('POST', 'bairro');
        pt_register('POST', 'cidade');
        pt_register('POST', 'estado');
        pt_register('POST', 'cep');
        pt_register('POST', 'distrito');
        pt_register('POST', 'comarca');
        pt_register('POST', 'contato');
        pt_register('POST', 'tel');
        pt_register('POST', 'ramal');
        pt_register('POST', 'cel');
        pt_register('POST', 'fax');
        pt_register('POST', 'email');
        pt_register('POST', 'site');
        pt_register('POST', 'id_banco');
        pt_register('POST', 'banco');
        pt_register('POST', 'cod_banco');
        pt_register('POST', 'agencia');
        pt_register('POST', 'conta');
        pt_register('POST', 'favorecido');
        pt_register('POST', 'status');
        pt_register('POST', 'obs');
        pt_register('POST', 'valor_busca');
        pt_register('POST', 'valor_certidao');
        pt_register('POST', 'tel2');
        pt_register('POST', 'ramal2');
        pt_register('POST', 'atribuicao');

        if (strlen($id_banco) == 0) {
            $id_banco = 0;
        }

        $c = new stdClass();
        $c->id_cartorio = trim($id_cartorio);
        $c->nome = trim($nome);
        $c->fantasia = trim($fantasia);
        $c->tipo = $tipo;
        $c->cpf = trim($cpf);
        $c->rg = $rg;
        $c->endereco = $endereco;
        $c->numero = $numero;
        $c->complemento = $complemento;
        $c->bairro = $bairro;
        $c->cidade = $cidade;
        $c->estado = $estado;
        $c->cep = $cep;
        $c->distrito = $distrito;
        $c->comarca = $comarca;
        $c->contato = $contato;
        $c->tel = $tel;
        $c->ramal = $ramal;
        $c->cel = $cel;
        $c->fax = $fax;
        $c->email = $email;
        $c->site = $site;
        $c->id_banco = $id_banco;
        $c->cod_banco = $cod_banco;
        $c->agencia = $agencia;
        $c->conta = $conta;
        $c->favorecido = $favorecido;
        $c->status = $status;
        $c->obs = $obs;
        $c->valor_busca = $valor_busca;
        $c->valor_certidao = $valor_certidao;
        $c->tel2 = $tel2;
        $c->ramal2 = $ramal2;
        $c->atribuicao = $atribuicao;

        $cartorioverificaDAO = new CartorioVerificaDAO();
        $errors = $cartorioverificaDAO->verificaAtualizacao($c);

        if (count($errors) == 0) {
            $id = $cartorioDAO->atualizar($c);
            $done = 1;
            $alert_done .= "Registro atualizado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $errors['error'] . '</ul></div>';
        }
    }

#alterado
    if ($submit_anexo) {
        $aba = 'aba5';
        $p_verifica = array();
        pt_register('POST', 'anexo_nome');
        pt_register('POST', 'certidao_resultado');

        $anexoverificaDAO = new AnexoVerificaDAO();
        $p_verifica = $anexoverificaDAO->AnexoVerifica($controle_id_empresa, $departamento_p, $departamento_s, $id_pedido_item);

        #upload de imagens
        $config = array();
        // Tamanho máximo do file_anexo (em bytes)
        $config["tamanho"] = 999999;
        // Largura máxima (pixels)
        $config["largura"] = 1024;
        // Altura máxima (pixels)
        $config["altura"] = 1024;
        // Upload do RG
        $file_anexo = isset($_FILES["file_anexo"]) ? $_FILES["file_anexo"] : FALSE;
        // Formulário postado... executa as ações
        if ($file_anexo['name'] <> '') {
            $error_image = valida_upload_pdf($file_anexo, $config);
            if ($error_image) {
                $p_verifica['error'] .= $error_image;
            }
        } else {
            $p_verifica['error'] .= '<li><b>Selecione o arquivo para fazer upload</b></li>';
        }
        #fim do upload foto

        if (COUNT($p_verifica) == 0) {
            $file_path = "../anexosnovos/" . date('m') . '' . date('Y') . '/'; #alterado => "../anexos/"
            if (!is_dir($file_path)) {
                mkdir($file_path, 0777);
            }#alterado
            if ($file_anexo['name']) {
                // Pega extensão do file_anexo
                preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext);
                // Gera um nome único para a imagem
                $imagem_nome = $controle_id_usuario . $id_pedido_item . md5(uniqid(time())) . "." . $ext[1];
                // Caminho de onde a imagem ficará
                $imagem_dir = $file_path . $imagem_nome;
                // Faz o upload da imagem
                move_uploaded_file($file_anexo["tmp_name"], $imagem_dir);
                $file_anexo_name = $imagem_nome;
            }

            $ane->anexo = $file_path . $file_anexo_name; #alterado => $file_anexo_name
            $ane->anexo_nome = $anexo_nome;
            $ane->id_pedido_item = $id_pedido_item;
            $ane->id_usuario = $controle_id_usuario;

            $done = $pedidoDAO->inserirAnexo($ane);

            if ($anexo_nome == 'Certidão') {
                $c = new stdClass();
                $c->certidao_resultado = $certidao_resultado;
                $c->id_pedido_item = $id_pedido_item;
                $anexoDAO = new AnexoDAO();
                $altera_resultado = $anexoDAO->AlterarResultado($c);
            }
            $alert_done .= "Anexo adicionado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $p_verifica['error'] . '</div>';
        }
    }

#alterado
    if ($submit_anexo_deleta <> '') {
        $aba = 'aba5';
        $id_pedido_anexo = str_replace('Deletar Anexo ', '', $submit_anexo_deleta);
        $anexoverificaDAO = new AnexoVerificaDAO();
        $p_verifica = $anexoverificaDAO->AnexoVerificaDeleta($controle_id_empresa, $controle_id_usuario, $id_pedido_anexo, $departamento_p, $departamento_s, $id_pedido_item);

        if ($p_verifica['error'] == "") {
            $pos = strrpos($p_verifica['anexo'], "../"); #alterado
            $file_path = ""; #alterado
            if ($pos === false) {
                $file_path = "../anexos/";
            }#alterado

            if (file_exists($file_path . $p_verifica['anexo']) and $p_verifica['anexo'] <> '')
                unlink($file_path . $p_verifica['anexo']);

            $done = $pedidoDAO->deletaAnexoPedido($id_pedido_item, $id_pedido_anexo, $controle_id_usuario);
            $alert_done .= "Anexo deletado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul><li>' . $p_verifica['error'] . '</li><ul></div>';
        }
    }

    if ($submit_financeiro) {
        $aba = 'aba6';
        $errors = new stdClass();
        pt_register('POST', 'financeiro_classificacao');
        pt_register('POST', 'financeiro_banco');
        pt_register('POST', 'financeiro_agencia');
        pt_register('POST', 'financeiro_conta');
        pt_register('POST', 'financeiro_identificacao');
        pt_register('POST', 'financeiro_favorecido');
        pt_register('POST', 'financeiro_cpf');
        pt_register('POST', 'financeiro_descricao');
        pt_register('POST', 'financeiro_desembolsado');
        pt_register('POST', 'financeiro_troco');
        pt_register('POST', 'financeiro_valor');
        pt_register('POST', 'financeiro_rateio');
        pt_register('POST', 'financeiro_sedex');
        pt_register('POST', 'financeiro_forma');

        $f = new stdClass();
        $f->financeiro_classificacao = $financeiro_classificacao;
        $f->financeiro_banco = $financeiro_banco;
        $f->financeiro_agencia = $financeiro_agencia;
        $f->financeiro_conta = $financeiro_conta;
        $f->financeiro_identificacao = $financeiro_identificacao;
        $f->financeiro_favorecido = $financeiro_favorecido;
        $f->financeiro_cpf = $financeiro_cpf;
        $f->financeiro_descricao = $financeiro_descricao;
        $f->financeiro_desembolsado = $financeiro_desembolsado;
        $f->financeiro_troco = $financeiro_troco;
        $f->financeiro_valor = $financeiro_valor;
        $f->financeiro_rateio = $financeiro_rateio;
        $f->financeiro_sedex = $financeiro_sedex;
        $f->financeiro_forma = $financeiro_forma;

        $financeiroverificaDAO = new FinanceiroVerificaDAO();
        $errors = $financeiroverificaDAO->inserir($id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s, $f);
        $f->des2 = $errors->des2;

        if ($errors->error == '') {
            $financeiro_inDAO = new FinanceiroDAO();
            $done = $financeiro_inDAO->inserirDesembolso($id_pedido_item, $controle_id_usuario, $f, $controle_id_empresa);
            $alert_done .= "Desembolso solicitado com sucesso!";

            unset($financeiro_classificacao);
            unset($financeiro_banco);
            unset($financeiro_agencia);
            unset($financeiro_conta);
            unset($financeiro_identificacao);
            unset($financeiro_favorecido);
            unset($financeiro_cpf);
            unset($financeiro_descricao);
            unset($financeiro_desembolsado);
            unset($financeiro_troco);
            unset($financeiro_valor);
            unset($financeiro_rateio);
            unset($financeiro_sedex);
            unset($financeiro_forma);
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $errors->error . '</ul></div>';
        }
    }

    if ($submit_financeiro_edit) {
        $aba = 'aba6';
        $errors = new stdClass();

        pt_register('POST', 'id_pedido_item');
        pt_register('POST', 'id_financeiro');
        pt_register('POST', 'financeiro_conferido');
        pt_register('POST', 'financeiro_nossa_conta');
        pt_register('POST', 'financeiro_classificacao');
        pt_register('POST', 'financeiro_banco');
        pt_register('POST', 'financeiro_agencia');
        pt_register('POST', 'financeiro_conta');
        pt_register('POST', 'financeiro_identificacao');
        pt_register('POST', 'financeiro_favorecido');
        pt_register('POST', 'financeiro_cpf');
        pt_register('POST', 'financeiro_descricao');
        pt_register('POST', 'financeiro_desembolsado');
        pt_register('POST', 'financeiro_troco');
        pt_register('POST', 'financeiro_valor');
        pt_register('POST', 'financeiro_rateio');
        pt_register('POST', 'financeiro_sedex');
        pt_register('POST', 'financeiro_forma');
        pt_register('POST', 'financeiro_autorizacao');
        pt_register('POST', 'financeiro_old_autorizacao');

        $f = new stdClass();
        $f->financeiro_nossa_conta = $financeiro_nossa_conta;
        $f->financeiro_classificacao = $financeiro_classificacao;
        $f->financeiro_banco = $financeiro_banco;
        $f->financeiro_conferido = $financeiro_conferido;
        $f->financeiro_agencia = $financeiro_agencia;
        $f->financeiro_conta = $financeiro_conta;
        $f->financeiro_identificacao = $financeiro_identificacao;
        $f->financeiro_favorecido = $financeiro_favorecido;
        $f->financeiro_cpf = $financeiro_cpf;
        $f->financeiro_descricao = $financeiro_descricao;
        $f->financeiro_desembolsado = $financeiro_desembolsado;
        $f->financeiro_troco = $financeiro_troco;
        $f->financeiro_valor = $financeiro_valor;
        $f->financeiro_rateio = $financeiro_rateio;
        $f->financeiro_sedex = $financeiro_sedex;
        $f->financeiro_forma = $financeiro_forma;
        $f->financeiro_autorizacao = $financeiro_autorizacao;
        $f->financeiro_old_autorizacao = $financeiro_old_autorizacao;

        $financeiroverificaDAO = new FinanceiroVerificaDAO();
        $errors = $financeiroverificaDAO->editar($id_pedido_item, $id_financeiro, $controle_id_empresa, $departamento_p, $departamento_s, $f);

        if ($errors->error == '') {
            $financeiro_inDAO = new FinanceiroDAO();
            $done = $financeiro_inDAO->editarDesembolso($id_pedido_item, $id_financeiro, $controle_id_usuario, $f, $departamento_p);
            $alert_done .= "Desembolso atualizado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $errors->error . '</ul></div>';
        }
        unset($financeiro_classificacao);
        unset($financeiro_banco);
        unset($financeiro_agencia);
        unset($financeiro_conta);
        unset($financeiro_identificacao);
        unset($financeiro_favorecido);
        unset($financeiro_cpf);
        unset($financeiro_descricao);
        unset($financeiro_desembolsado);
        unset($financeiro_troco);
        unset($financeiro_valor);
        unset($financeiro_rateio);
        unset($financeiro_sedex);
        unset($financeiro_forma);
    }

    if ($submit_financeiro_edit_r_d) {
        $aba = 'aba6';
        $errors = new stdClass();
        pt_register('POST', 'id_financeiro');

        $financeiroverificaDAO = new FinanceiroVerificaDAO();
        $errors = $financeiroverificaDAO->verificaDeletaReceb($id_financeiro, $controle_id_empresa, $departamento_p, $departamento_s);
        if ($errors->error == '') {
            $financeiro_inDAO = new FinanceiroDAO();
            $done = $financeiro_inDAO->deletaRecebimento($id_financeiro, $errors->id_pedido_item, $errors->valor);
            $alert_done .= "Recebimento deletado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $errors->error . '</ul></div>';
        }
        unset($financeiro_classificacao);
        unset($financeiro_banco);
        unset($financeiro_agencia);
        unset($financeiro_conta);
        unset($financeiro_identificacao);
        unset($financeiro_favorecido);
        unset($financeiro_cpf);
        unset($financeiro_descricao);
        unset($financeiro_desembolsado);
        unset($financeiro_troco);
        unset($financeiro_valor);
        unset($financeiro_rateio);
        unset($financeiro_sedex);
        unset($financeiro_forma);
    }


    if ($submit_financeiro_edit_r) {
        $aba = 'aba6';
        $errors = new stdClass();

        pt_register('POST', 'id_pedido_item');
        pt_register('POST', 'id_financeiro');
        pt_register('POST', 'financeiro_nossa_conta');
        pt_register('POST', 'financeiro_classificacao');
        pt_register('POST', 'financeiro_banco');
        pt_register('POST', 'financeiro_agencia');
        pt_register('POST', 'financeiro_conta');
        pt_register('POST', 'financeiro_identificacao');
        pt_register('POST', 'financeiro_favorecido');
        pt_register('POST', 'financeiro_cpf');
        pt_register('POST', 'financeiro_descricao');
        pt_register('POST', 'financeiro_desembolsado');
        pt_register('POST', 'financeiro_troco');
        pt_register('POST', 'financeiro_valor');
        pt_register('POST', 'financeiro_forma');
        pt_register('POST', 'financeiro_autorizacao');
        pt_register('POST', 'financeiro_data_p');
        pt_register('POST', 'financeiro_old_autorizacao');
        $financeiro_data_p = invert($financeiro_data_p, '-', 'SQL');

        $errors = new stdClass();
        $f->financeiro_nossa_conta = $financeiro_nossa_conta;
        $f->financeiro_classificacao = $financeiro_classificacao;
        $f->financeiro_banco = $financeiro_banco;
        $f->financeiro_agencia = $financeiro_agencia;
        $f->financeiro_conta = $financeiro_conta;
        $f->financeiro_identificacao = $financeiro_identificacao;
        $f->financeiro_favorecido = $financeiro_favorecido;
        $f->financeiro_cpf = $financeiro_cpf;
        $f->financeiro_descricao = $financeiro_descricao;
        $f->financeiro_desembolsado = $financeiro_desembolsado;
        $f->financeiro_troco = $financeiro_troco;
        $f->financeiro_valor = $financeiro_valor;
        $f->financeiro_forma = $financeiro_forma;
        $f->financeiro_autorizacao = $financeiro_autorizacao;
        $f->financeiro_data_p = $financeiro_data_p;
        $f->financeiro_old_autorizacao = $financeiro_old_autorizacao;

        $financeiroverificaDAO = new FinanceiroVerificaDAO();
        $errors = $financeiroverificaDAO->verificaEditaReceb($id_financeiro, $id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s, $f);

        if ($errors->error == '') {
            $financeiro_inDAO = new FinanceiroDAO();
            $done = $financeiro_inDAO->editarRecebimento($id_financeiro, $id_pedido_item, $controle_id_empresa, $departamento_p, $departamento_s, $f);
            $alert_done .= "Registro atualizado com sucesso!";
        } else {
            echo '<div class="erro"><b>Ocorreram os seguintes erros:</b><ul>' . $errors->error . '</ul></div>';
        }
        unset($financeiro_classificacao);
        unset($financeiro_banco);
        unset($financeiro_agencia);
        unset($financeiro_conta);
        unset($financeiro_identificacao);
        unset($financeiro_favorecido);
        unset($financeiro_cpf);
        unset($financeiro_descricao);
        unset($financeiro_desembolsado);
        unset($financeiro_troco);
        unset($financeiro_valor);
        unset($financeiro_rateio);
        unset($financeiro_sedex);
        unset($financeiro_forma);
    }
    
    #seleciona dados do pedido
    foreach ($servicocampos as $servicocampo) {
        $p_campos.= ','.$servicocampo->campo;
    }
    
    $p = $pedidoDAO->selectPedidoEditPorIdNovo($id_pedido, $ordem, $controle_id_empresa,$p_campos);
    if ($p->id_pedido == '') {
        echo 'Você não tem permissão de alterar essa ordem';
        exit;
    }
    $rodape_pedido = '';
    if ($p->id_empresa != '0') {
        $rodape_pedido .= '<b>Responsável pelo cadastro  ';
        $rodape_pedido .= ($p->id_empresa_resp == '0') ? ' e execução do pedido' : '';
        $rodape_pedido .= '</b><br>';
        $rodape_pedido .= '<b>Franquia:</b> ' . $vardir[$p->id_empresa]->fantasia . '<br>
		<b>Tel/Fax:</b> ' . $vardir[$p->id_empresa]->tel . ' - ' . $vardir[$p->id_empresa]->fax . '<br>
		<b>Endereço:</b> ' . $vardir[$p->id_empresa]->endereco . $vardir[$p->id_empresa]->numero . $vardir[$p->id_empresa]->complemento . ' - <b>Bairro: </b>' . $vardir[$p->id_empresa]->bairro . ' - ' . $vardir[$p->id_empresa]->cidade . ' - ' . $vardir[$p->id_empresa]->estado;
    }
    if ($p->id_empresa_resp != '0') {
        if ($p->id_empresa != '0') {
            $rodape_pedido.='<br><br>';
        }
        $rodape_pedido .= '<b>Responsável pela execução do pedido</b><br>';
        $rodape_pedido .= '<b>Franquia:</b> ' . $vardir[$p->id_empresa_resp]->fantasia . '<br>
		<b>Tel/Fax:</b> ' . $vardir[$p->id_empresa_resp]->tel . ' - ' . $vardir[$p->id_empresa_resp]->fax . '<br>
		<b>Endereço:</b> ' . $vardir[$p->id_empresa_resp]->endereco . $vardir[$p->id_empresa_resp]->numero . $vardir[$p->id_empresa_resp]->complemento . ' - <b>Bairro: </b>' . $vardir[$p->id_empresa_resp]->bairro . ' - ' . $vardir[$p->id_empresa_resp]->cidade . ' - ' . $vardir[$p->id_empresa_resp]->estado;
    }
    ?>
    <table width="100%" border="0" cellspacing="0">
        <tr>
            <td valign="top" align="center">	

                <?
                $p_valor = "";

                if ($controle_id_empresa == 1 or $p->adendo == 1) {
                    if ($p->id_empresa_dir <> 0 and $controle_id_empresa != $p->id_empresa_dir and $p->id_empresa_resp == 0 and $p->operacional == '0000-00-00')
                        $p_valor .= "<font style=\"color:#ff0000; font-weight:bold\">Esse pedido precisa ser executado pela franquia de " . $vardir[$p->id_empresa_dir]->fantasia . "</font><br><br>";
                }

                if ($controle_id_empresa == 1 and $p->id_afiliado<>0) {
                    $p_valor .= "<font style=\"color:#ff0000; font-weight:bold\">Esse pedido foi originado por um afiliado </font><br><br>";
                }
				
                /*$p_valor .= "<strong>Status Atual:</strong> " . $p->status . " &nbsp;&nbsp;|&nbsp;&nbsp";
                if ($id_empresa == $controle_id_empresa) {
                    $p_valor .= '<strong>Valor Total:</strong> R$ ' . number_format($ordens->valor, 2, ".", "");
                    if ($permissao_financeiro == 'TRUE') {
                        //$pf = $pedidoDAO->listaDespesaOrdem($id_pedido, $id_pedido_item);
                        //$p_valor .= ' | <strong>Despesas Totais:</strong> R$ ' . number_format($pf->valor, 2, ".", "");
                        //$financeiro_valor_d = 'R$ ' . number_format($pf->valor_item, 2, ".", "");
                        //$p_valor .= " | <strong>Despesas do Serviço:</strong> " . $financeiro_valor_d;
                    }
                    #$pf = $pedidoDAO->listaDespesaItem($id_pedido_item,$controle_id_empresa);
                }
                $p_valor .= " | <strong>Prazo:</strong> " . $p->data_prazo;*/
				echo '<div id="dados_valores"></div>';
				DadosServico($id_empresa, $controle_id_empresa, $id_pedido, $p->status, $p->data_prazo);
                ?>
                <div id="carrega_ordem_input"><!-- abas -->
                    <div style="position: relative; width: 800px; margin: auto;" id="container-hotsite">
                        <ul>
                            <li><a href="#aba0" onclick="eraseCookie('aba'); if(document.pedido_add.servico.value==''){ carrega_servico_edit('<?= $id_pedido ?>','<?= $ordem ?>'); }">Dados do serviço</a></li>
                            <li><a href="#aba1" onclick="eraseCookie('aba'); createCookie('aba','aba1','1','1'); if(document.p_solicitante.solicitante.value==''){ carrega_solicitante_edit('<?= $id_pedido ?>','<?= $ordem ?>'); }">Solicitante</a></li>
                            <li><a href="#aba2" onclick="eraseCookie('aba'); createCookie('aba','aba2','1','1'); if(document.p_atividade.p_atividade.value==''){ carrega_atividade('<?= $id_pedido_item ?>'); }">Atividade</a></li>
                            <li><a href="#aba3" onclick="eraseCookie('aba'); createCookie('aba','aba3','1','1'); if(document.p_mensagem.p_mensagem.value==''){ carrega_mensagem_edit('<?= $id_pedido_item ?>'); }">Mensagem</a></li>
                            <li><a href="#aba4" onclick="eraseCookie('aba'); createCookie('aba','aba4','1','1'); if(document.p_cartorio.p_cartorio.value==''){ carrega_cartorio_edit('<?= $id_pedido_item ?>'); }">Cartórios</a></li>
                            <li><a href="#aba5" onclick="eraseCookie('aba'); createCookie('aba','aba5','1','1'); if(document.p_anexo.p_anexo.value==''){ carrega_anexo_edit('<?= $id_pedido_item ?>'); }">Anexos</a></li>
                            <li><a href="#aba6" onclick="eraseCookie('aba'); createCookie('aba','aba6','1','1'); if(document.p_financeiro.p_financeiro.value==''){ carrega_p_financeiro_edit('<?= $id_pedido_item ?>'); }">Financeiro</a></li>
                        </ul>

                        <div id="aba0" style="position: relative; width: 800px; margin: auto">
                            <div id="carrega_pedido_add">
                                <?
                                #if($aba==''){
                                require('../carrega_pedido/p_servico_edit.php');
                                #} else {
                                #
				#	<form action="" method="post" name="pedido_add" enctype="multipart/form-data">
                                #		<input type="hidden" name="servico" value="">
                                #	</form>
                                # } 
                                ?>
                            </div>
                        </div>

                        <div id="aba1" style="position: relative; width: 800px; margin: auto">
                            <div id="carrega_solic">
                                <?
                                if ($aba == 'aba1') {
                                    require('../carrega_pedido/p_solicitante_edit.php');
                                } else {
                                    echo '<form name="p_solicitante" id="p_solicitante"><input type="hidden" name="solicitante" value=""></form>';
                                }
                                ?>
                            </div>
                        </div>

                        <div id="aba2" style="position: relative; width: 800px; margin: auto">
                            <div id="carrega_ativ">
                                <?
                                if ($aba == 'aba2') {
                                    require('../carrega_pedido/p_atividade.php');
                                } else {
                                    ?>
                                    <form action="#aba2" method="post" name="p_atividade" id="p_atividade" enctype="multipart/form-data">
                                        <input type="hidden" name="p_atividade" value="">
                                    </form>
                                    <?
                                }
                                ?>
                            </div>
                        </div>

                        <div id="aba3" style="position: relative; width: 800px; margin: auto">
                            <div id="carrega_mensagem_edit">
                                <?
                                if ($aba == 'aba3') {
                                    require('../carrega_pedido/p_mensagem.php');
                                } else {
                                    ?>
                                    <form action="#aba3" method="post" name="p_mensagem" id="p_mensagem" enctype="multipart/form-data">
                                        <input type="hidden" name="p_mensagem" value="">
                                    </form>
                                    <?
                                }
                                ?>
                            </div>
                        </div>

                        <div id="aba4" style="position: relative; width: 800px; margin: auto">			
                            <div id="carrega_cartorio_edit">
                                <?
                                if ($aba == 'aba4') {
                                    require('../carrega_pedido/p_cartorio.php');
                                } else {
                                    ?>
                                    <form action="#aba3" method="post" name="p_cartorio" id="p_cartorio" enctype="multipart/form-data">
                                        <input type="hidden" name="p_cartorio" value="">
                                    </form>
                                    <?
                                }
                                ?>
                            </div>
                        </div>

                        <div id="aba5" style="position: relative; width: 800px; margin: auto">
                            <div id="carrega_anexo_edit">
                                <?
                                if ($aba == 'aba5') {
                                    require('../carrega_pedido/p_anexo.php');
                                } else {
                                    ?>
                                    <form action="#aba5" method="post" name="p_anexo" id="p_anexo" enctype="multipart/form-data">
                                        <input type="hidden" name="p_anexo" value="">
                                    </form>
                                    <?
                                }
                                ?>
                            </div>
                        </div>

                        <div id="aba6" style="position: relative; width: 800px; margin: auto">
                            <div id="carrega_p_financeiro_edit">
                                <?
                                if ($aba == 'aba6') {
                                    require('../carrega_pedido/p_financeiro.php');
                                } else {
                                    ?>
                                    <form action="#aba6" method="post" name="p_financeiro" id="p_financeiro" enctype="multipart/form-data">
                                        <input type="hidden" name="p_financeiro" value="">
                                    </form>
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Fim aba --> 
                    <?= $rodape_pedido ?>
                </div>
                <div id="resgata_endereco"></div>
            </td>
        </tr>
    </table>
    <script type="text/javascript">
        $(document).ready(
        function()
        {
            $('#windowMensagemClose').bind(
            'click',
            function()
            {
                $('#windowMensagem').hide();
            }
        );
        }
    );
<?
if ($alert_done) {
    echo "
                    openAlertBox('Mensagem da página web','" . $alert_done . "','');
                    ";
}

#Direcionamento de aba
#var url=location.href;
#var onde = url.split('#')[1];
#if(onde!='<= $aba >'){
#	location.href="#<= $aba >";
#}
?>
    </script>
</div>
<?php
require('footer.php');
?>