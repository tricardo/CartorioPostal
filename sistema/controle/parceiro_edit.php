<?
require('header.php');
$permissao = verifica_permissao('Parceiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
	exit;
}

$clienteDAO = new ParceiroDAO();
$pacoteDAO = new PacoteDAO();
$usuarioDAO = new UsuarioDAO();
$pedidoDAO = new PedidoDAO();

pt_register('GET', 'id');

?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="T�tulo" />
        Parceiro</h1>
    <hr class="tit" />
    <br />
</div>
<div id="meio"><?
/*
pt_register('POST','submit_anexo');
if($submit_anexo){
	pt_register("POST", "descricao");
	pt_register("POST", "id");
	
	$error='<ul>';
	if($descricao==""){
		if($descricao=="") $errors['descricao']=1;
		$error.="<li><b>Os campos com * s�o obrigat�rios.</b></li>";
	}
	#upload de imagens
	$config = array();
	// Tamanho m�ximo do file_anexo (em bytes)
	$config["tamanho"] = 999999;
	// Largura m�xima (pixels)
	$config["largura"] = 1024;
	// Altura m�xima (pixels)
	$config["altura"]  = 1024;
	// Upload do RG
	$file_anexo = $_FILES["anexo"];
	// Formul�rio postado... executa as a��es
	if($file_anexo['name']<>''){
		$error_image = valida_upload_pdf($file_anexo, $config);
		if ($error_image){
			$errors['anexo'] .= $error_image;
			$error .= '<li><b>'.$error_image.'</b></li>';
		}
	} else {
		$error.= '<li><b>Selecione o arquivo para fazer upload</b></li>';
	}
	#fim do upload foto
	$file_path = "../anexos_cliente/".date("Ym")."/";
	if(!is_dir($file_path)) mkdir($file_path);
	if($file_anexo['name']){
		// Pega extens�o do file_anexo
		preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext);
		// Gera um nome �nico para a imagem
		$imagem_nome = $id.'_'.$controle_id_usuario.md5(uniqid(time())) . "." . $ext[1];
		// Caminho de onde a imagem ficar�
		$imagem_dir = $file_path.$imagem_nome;
		// Faz o upload da imagem
		move_uploaded_file($file_anexo["tmp_name"], $imagem_dir);
	}

	$error.='</ul>';

	$a = new stdClass();
	$a->descricao = $descricao;
	$a->anexo = $imagem_dir;
	$a->id_cliente = $id;
        $a->id_empresa = $controle_id_empresa;

	if(count($errors)==0){
		$f_insert = $clienteDAO->inserirAnexo($a);
		?> <script type="text/javascript">
			alert('Documento anexado com sucesso!');
		</script> <?
	}
}
*/
pt_register('POST', 'submit');
if ($submit) {//check for errors
    $error = "";
    $errors = array();
    $error = "<b>Ocorreram os seguintes erros:</b><ul>";
    pt_register('POST','nome');
	pt_register('POST','tel2');
	pt_register('POST','tel');
	pt_register('POST','email');
	pt_register('POST','endereco');
	pt_register('POST','bairro');
	pt_register('POST','cidade');
	pt_register('POST','estado');
	pt_register('POST','cep');
	pt_register('POST','complemento');
	pt_register('POST','numero');
	pt_register('POST','cpf');
	pt_register('POST','rg');
	pt_register('POST','im');
	pt_register('POST','tipo');
	pt_register('POST','status');
	pt_register('POST','fax');
	pt_register('POST','ramal2');
	pt_register('POST','outros');
	pt_register('POST','site');
	pt_register('POST','status');
	pt_register('POST','retem_iss');
	pt_register('POST','restricao');
	pt_register('POST','ramal');
	pt_register('POST','conveniado');
	pt_register('POST','id_usuario_com');
	pt_register('POST','id_pacote');
	pt_register('POST','comissao');
	pt_register('POST','observacao');
    $c = new stdClass();
    $c->id_afiliado = $id;
    $c->nome = $nome;
    $c->tel2 = $tel2;
    $c->tel = $tel;
    $c->email = $email;
    $c->endereco = $endereco;
    $c->bairro = $bairro;
    $c->cidade = $cidade;
    $c->estado = $estado;
    $c->cep = $cep;
    $c->complemento = $complemento;
    $c->numero = $numero;
    $c->cpf = $cpf;
    $c->rg = $rg;
    $c->im = $im;
    $c->tipo = $tipo;
    $c->status = $status;
    $c->fax = $fax;
    $c->ramal2 = $ramal2;
    $c->outros = $outros;
    $c->site = $site;
   $c->comissao=$comissao;
	$c->retem_iss=$retem_iss;
	$c->restricao=$restricao;
	$c->ramal=$ramal;
	$c->conveniado=$conveniado;
	$c->observacao=$observacao;
	if($c->conveniado=='N�o')
	$c->id_usuario_com=$id_usuario_com;
	else
	$c->id_usuario_com=null;
	$c->id_usuario=$controle_id_usuario;
	$c->id_pacote=$id_pacote;

    if ($nome == "" || $tel == "" || $cep == "" || $endereco == "" || $numero == "" || $cidade == "" || $bairro == "" || $estado == "") {
        if ($nome == "")
            $errors['nome'] = 1;
        if ($tel == "")
            $errors['tel'] = 1;
        if ($cep == "")
            $errors['cep'] = 1;
        if ($endereco == "")
            $errors['endereco'] = 1;
        if ($numero == "")
            $errors['numero'] = 1;
        if ($cidade == "")
            $errors['cidade'] = 1;
        if ($bairro == "")
            $errors['bairro'] = 1;
        if ($estado == "")
            $errors['estado'] = 1;

        $error.="<li><b>Os campos com * s�o obrigat�rios.</b></li>";
    }

    if (!validaTel($tel)) {
        $errors['tel'] = 1;
        $error.="<li><b>O telefone � inv�lido.</b></li>";
    }

    #if($email!="" && validaEMAIL($email)=='false'){
    #	$errors['email']=1;
    #	$error.="<li><b>E-mail Inv�lido, digite corretamente.</b></li>";
    #}

    if ($tipo == 'cpf') {
        $valida = validaCPF($cpf);
        if ($valida == 'false') {
            $errors['cpf'] = 1;
            $error.="<li><b>CPF Inv�lido, digite corretamente.</b></li>";
        }
    } else {
        $valida = validaCNPJ($cpf);
        if ($valida == 'false') {
            $errors['cpf'] = 1;
            $error.="<li><b>CNPJ Inv�lido, digite corretamente.</b></li>";
        }
    }

    if (count($errors) < 1) {
        $clienteDAO->atualizar($c, $controle_id_empresa);
/*
        $e = $clienteDAO->buscaClienteCRM($id);
        pt_register('POST', 'data_aniversario');
        pt_register('POST', 'data_ultimo_contato');
        pt_register('POST', 'data_contrato_i');
        pt_register('POST', 'data_contrato_f');

        if (strlen($data_aniversario) == 0) {
            $data_aniversario = '0000-00-00';
        } else {
            $dt = explode('/', $data_aniversario);
            $data_aniversario = $dt[2] . '-' . $dt[1] . '-' . $dt[0];
        }
        if (strlen($data_ultimo_contato) == 0) {
            $data_ultimo_contato = '0000-00-00';
        } else {
            $dt = explode('/', $data_ultimo_contato);
            if (checkdate($dt[1], $dt[0], $dt[2])) {
                $data_ultimo_contato = $dt[2] . '-' . $dt[1] . '-' . $dt[0];
            } else {
                $data_ultimo_contato = '0000-00-00';
            }
        }
        if (strlen($data_contrato_i) == 0) {
            $data_contrato_i = '0000-00-00';
        } else {
            $dt = explode('/', $data_contrato_i);
            $data_contrato_i = $dt[2] . '-' . $dt[1] . '-' . $dt[0];
        }
        if (strlen($data_contrato_f) == 0) {
            $data_contrato_f = '0000-00-00';
        } else {
            $dt = explode('/', $data_contrato_f);
            $data_contrato_f = $dt[2] . '-' . $dt[1] . '-' . $dt[0];
        }

        $b = new stdClass();
        $b->id_cliente = $id;
        $b->data_aniversario = $data_aniversario;
        $b->ultimo_contato = $data_ultimo_contato;
        $b->data_contrato_i = $data_contrato_i;
        $b->data_contrato_f = $data_contrato_f;
        if (count($e) > 0) {
            $crm = $clienteDAO->alteraClienteCRM($b);
        } else {
            $crm = $clienteDAO->insereClienteCRM($b);
        }
        * */
        $done = 1;
    }
    if ($errors) {
        echo '<div class="erro">' . $error . '</div>';
    } elseif ($done) {
        //alterado 01/04/2011
        $titulo = 'Mensagem da p�gina web';
        $msg = 'Registro atualizado com sucesso!';
        $pagina = 'parceiro.php';
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
    }
}
if (!$submit) {
    $c = $clienteDAO->selectPorId($id);
}
?> 
    <div style="position: relative; width: 650px; margin: auto;" id="container-hotsite">
        <table width="100%" border="0" cellpadding="10" cellspacing="0">

	<tr>
		<td valign="top" align="center">

		<blockquote>
		<form enctype="multipart/form-data" action="" method="post"
			name="cliente_edit" id="cliente_edit">
			<input type="hidden" value="0" id="id_usuario_com" name="id_usuario_com" />
			<input type="hidden" value="0" id="conveniado" name="conveniado" />
			<input type="hidden" value="0" id="id_pacote" name="id_pacote" />
		<table width="650" border="0" class="tabela">
			
			<tr>
				<td colspan="4" class="tabela_tit">Dados do parceiro</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Status:</strong></div>
				</td>
				<td width="243"><select name="status" class="form_estilo"
					style="width: 150px">
					<option value="1"
					<? if($c->status==1) echo 'selected="selected"'; ?>>Ativo</option>
					<option value="0"
					<? if($c->status==0) echo 'selected="selected"'; ?>>Inativo</option>
				</select></td>
				<td width="70"></td>
				</td>
				<td width="219"></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Nome: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="nome" value="<?= $c->nome ?>"
					style="width: 470px"
					class="form_estilo <?=($errors['nome'])?'form_estilo_erro':''; ?>"><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CPF/CNPJ: </strong></div>
				</td>
				<td>
				<div style="float: left"><? if($c->tipo=='') $c->tipo='cpf'; ?> <select
					name="tipo" class="form_estilo">
					<option value="cpf"
					<? if($c->tipo=='cpf') echo 'selected="selected"'; ?>>CPF</option>
					<option value="cnpj"
					<? if($c->tipo=='cnpj') echo 'selected="selected"'; ?>>CNPJ</option>
				</select></div>
				<div id="cpf" style="float: left"><input type="text" name="cpf"
					value="<?=$c->cpf ?>" style="width: 150px"
					onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');"
					class="form_estilo <?=($errors['cpf'])?'form_estilo_erro':''; ?>" />
				</div>
				<font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>RG/IE: </strong></div>
				</td>
				<td><input type="text" name="rg" value="<?= $c->rg ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>IM: </strong></div>
				</td>
				<td><input type="text" name="im" value="<?= $c->im ?>"
					style="width: 150px" class="form_estilo" /></td>
				<td><strong>Comiss�o</strong></td>
				<td><input type="text" name="comissao" value="<?= $c->comissao ?>"
					style="width: 150px" class="form_estilo <?=($errors['comissao'])?'form_estilo_erro':''; ?>"><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel" value="<?= $c->tel ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo <?=($errors['tel'])?'form_estilo_erro':''; ?>" />
				- <input type="text" name="ramal" value="<?= $c->ramal ?>"
					style="width: 50px" onkeyup="masc_numeros(this,'####');"
					class="form_estilo" /><font color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Fax: </strong></div>
				</td>
				<td><input type="text" name="fax" value="<?= $c->fax ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Tel: </strong></div>
				</td>
				<td><input type="text" name="tel2" value="<?= $c->tel2 ?>"
					style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
					class="form_estilo" /> - <input type="text" name="ramal2"
					value="<?= $c->ramal2 ?>" style="width: 50px"
					onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Outros: </strong></div>
				</td>
				<td><input type="text" name="outros" value="<?= $c->outros ?>"
					style="width: 150px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Email: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="email"
					value="<?= $c->email ?>" style="width: 470px"
					class="form_estilo <?=($errors['email'])?'form_estilo_erro':''; ?>" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Site: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="site" value="<?= $c->site ?>"
					style="width: 470px" class="form_estilo" /></td>
			</tr>
			<tr>
				<td colspan="4" class="tabela_tit">Endere�o</td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>CEP: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="cep" style="width: 150px"
					value="<?= $c->cep ?>"
					class="form_estilo  <?=($errors['cep'])?'form_estilo_erro':''; ?>"
					onKeyUp="masc_numeros(this,'#####-###');" /> <font color="#FF0000">*</font>
				<input type="button" name="consultar2" value="Consultar"
					class="button_busca"
					onclick="carrega_endedeco(cep.value, 'cliente_edit');" /></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Endere&ccedil;o: </strong></div>
				</td>
				<td colspan="3"><input type="text" name="endereco"
					value="<?= $c->endereco ?>" style="width: 350px"
					class="form_estilo <?=($errors['endereco'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font> <strong>N&deg;</strong> <input type="text"
					name="numero" style="width: 95px" value="<?= $c->numero ?>"
					class="form_estilo <?=($errors['numero'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td>
				<div align="right"><strong>Complemento: </strong></div>
				</td>
				<td><input type="text" name="complemento" style="width: 200px"
					value="<?= $c->complemento ?>" class="form_estilo" /></td>
				<td>
				<div align="right"><strong>Bairro:</strong></div>
				</td>
				<td><input type="text" name="bairro" style="width: 150px"
					value="<?= $c->bairro ?>"
					class="form_estilo  <?=($errors['bairro'])?'form_estilo_erro':''; ?>" /><font
					color="#FF0000">*</font></td>
			</tr>

			<tr>
				<td>
				<div align="right"><strong>Cidade: </strong></div>
				</td>
				<td><input type="text" name="cidade" style="width: 200px"
					value="<?= $c->cidade ?>"
					class="form_estilo  <?=($errors['cidade'])?'form_estilo_erro':''; ?>" />
				<input type="hidden" name="id" value="<?= $id ?>" /><font
					color="#FF0000">*</font></td>
				<td>
				<div align="right"><strong>Estado:</strong></div>
				</td>
				<td><input type="text" name="estado" style="width: 150px"
					value="<?= $c->estado ?>"
					class="form_estilo  <?=($errors['estado'])?'form_estilo_erro':''; ?>"
					maxlength="2" /><font color="#FF0000">*</font></td>
			</tr>
			<tr>
				<td align="right"><strong>Observa��o:</strong></td>
				<td colspan="3"><textarea name="observacao" class="form_estilo" style="width:470px; height:100px"><?= $c->observacao ?></textarea></td>
			</tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="submit" name="submit"
					value="Atualizar" class="button_busca" /> &nbsp; <input
					type="submit" name="cancelar" value="Cancelar"
					onclick="document.cliente_edit.action='parceiro.php'"
					class="button_busca" /></div>
				</td>
			</tr>
		</table>
		<div id="resgata_endereco"></div>
		</form>
		</blockquote>
		</td>
	</tr>
</table>
    </div>
<script>/*
$(document).ready(function() {
	$(".ex").click(function(){
		if(confirm("Apagar o anexo?")){
			var id_cliente_anexo = $(this).attr('href');
			$.ajax({url: "cliente_rem_anexo.php?id_cliente_anexo="+id_cliente_anexo});
			$(this).parent().parent().remove();
		}
		return false;
	});
});
*/
</script>

    <?php
    require('footer.php');
    ?>  
