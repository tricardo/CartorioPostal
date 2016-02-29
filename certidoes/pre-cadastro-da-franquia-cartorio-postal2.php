<?
$id_meta=24;
$pg = 'paginas';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_f">
        <div id="coluna_e">
            <div class="box_h">
                <h1 style="color: #202A72;">PRÉ CADASTRO DA FRANQUIA CARTÓRIO POSTAL</h1>
                <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
                <div class="faixa_h"></div>
                <img src="<?= URL_IMAGES;?>pages/pre-cadastro-da-franquia.png" alt="pre cadastro da franquia" title="Pre cadastro da franquia Cartório Postal" style="margin: 5px 0 0 0;" />
                <strong style="font-size: 15px; color: #202A72;">PREENCHA OS CAMPOS ABAIXO</strong>
                <div class="faixa_h"></div>
                <?
                $objQuery->classQueryMulti(1);
                pt_register('POST','submit1');
                if($submit1){
                    $errors=array();
                    foreach($_POST AS $campo => $valor){
						pt_register('POST', $campo);
						$$campo = str_replace("'", "´", $$campo);
					}
					echo $cidade_interesse;
					exit;
                    pt_register('POST','estado_interesse');
                    pt_register('POST','cidade_interesse');
                    pt_register('POST','nome');
                    pt_register('POST','rg');
                    pt_register('POST','cpf');
                    pt_register('POST','email');
                    pt_register('POST','nascimento');
                    pt_register('POST','tel_res');
                    pt_register('POST','tel_rec');
                    pt_register('POST','tel_cel');
                    pt_register('POST','id_operadora');
                    pt_register('POST','estado_civil');
                    pt_register('POST','filhos');
                    pt_register('POST','filhos_quant');
                    pt_register('POST','endereco');
                    pt_register('POST','numero');
                    pt_register('POST','complemento');
                    pt_register('POST','bairro');
                    pt_register('POST','cep');
                    pt_register('POST','estado');
                    pt_register('POST','cidade');
                    pt_register('POST','observacao');
                    if($nome=="" || $email=="" || $tel_res==""){
                        if($nome=="")       $errors['nome']=1;
                        if($email=="")      $errors['email']=1;
                        if($tel_res=="")    $errors['tel_res']=1;
                        $error.="<span style='font: 12px Arial; color:#000000;'>Nome / E-mail / Telefone residencial / </span>";
                    }
                    $valida = validaEMAIL($email);
                    if($valida=='false'){
                        $errors['email']=1;
                        $error.="<span style='font: 12px Arial; color:#000000;'>E-mail Inválido, digite corretamente / </span>";
                    }
                    if(count($errors)<1){
                        $query = "INSERT INTO site_ficha_cadastro (";
			$query.= "estado_interesse, cidade_interesse, nome, rg, cpf, email, ";
			$query.= "nascimento, tel_res, tel_rec, tel_cel, id_operadora, estado_civil, ";
			$query.= "filhos, filhos_quant, endereco, numero, complemento, bairro, cep, ";
			$query.= "estado, cidade, observacao, status, data, id_status)";
                        $query .="VALUES(";
                        $query.= "'".$estado_interesse."','".$cidade_interesse."','".$nome."','".$rg."','".$cpf."','".$email."',";
			$query.= "'".$nascimento."','".$tel_res."','".$tel_rec."','".$tel_cel."','".$id_operadora."','".$estado_civil."',";
			$query.= "'".$filhos."','".$filhos_quant."','".$endereco."','".$numero."','".$complemento."','".$bairro."','".$cep."',";
			$query.= "'".$estado."','".$cidade."','".$observacao."','Pendente',NOW(),1)";
                        $result = $objQuery->SQLQuery($query);
                        $id = $objQuery->ID;
                        $done=1;
                        set_time_limit(0);
			require("includes/maladireta/config.inc.php");
			error_reporting(1);
			require("includes/maladireta/class.Email.php");
			$Sender = "Cartório Postal - Franquias <franquias@cartoriopostal.com.br>";
			$Recipiant = $email;
			$Cc = '';
			$Bcc = ''; 
			$Subject = 'Ficha de Pré Cadastro';
			$html = 'Prezado(a) '.$nome.',<br /><br />
			<div align="center">
                            <a href="'.URL_SITE.'franquia-mais-procurada-do-brasil/" title="Clique aqui" target="_blank">
                            <img src="'.URL_IMAGES.'pages/agradecimento.jpg" border="0" width="690" height="1002"/>
                            </a>
			</div>
			Obs: Caso não consigua visualizar esse a imagem clique no link abaixo.<br /><br />
			<a href="http://www.cartoriopostal.com.br/certidoes/sobre-mailing.html" title="Clique aqui" target="_blank">Mailing</a><br /><br />
			Att,<br>
			Equipe Cartório Postal<br /><br />';
			$CustomHeaders= '';
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->Cc = $Cc; 
			$message->Bcc = $Bcc; 
			$message->SetHtmlContent($html);
			$pathToServerFile ="attachments/$at[1]/$at[2]";
			$serverFileMimeType = 'multipart/gased';
			$message->Send();
                    }
                }
                if($done!=1){
                ?>
                <form name="frm" action="http://www.cartoriopostal.com.br/certidoes/pre-cadastro-da-franquia-cartorio-postal2/" method="post" enctype="multipart/form-data">
                    <table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
                        <tr>
                            <td align="left" valign="middle" colspan="4">
                                <?
                                if($error!=''){
                                        echo '
                                            <div id="apDiv_erro2">
                                                <table width="100%" border="0" height="200" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td colspan="3" align="center" valign="middle" height="50">
                                                        <strong style="font-size:15px;">OCORRERAM OS SEGUINTES ERROS</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="30%" align="center" valign="top">

                                                    </td>
                                                    <td width="70%" colspan="2" align="left" valign="top">
                                                        '.$error.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" align="center" valign="top">
                                                       <a href="#" onclick="fecharErro2()"><img src="'.URL_IMAGES.'pages/image-bt-fechar.png" alt="Clique aqui para fechar este informativo." title="Clique aqui para fechar este informativo." /></a>
                                                    </td>
                                                </tr>
                                                </table>
                                            </div>
                                            ';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong style="color: #666666;">Região de Interesse</strong></td>
                        </tr>
                        <tr>
                            <td width="50%" align="left" valign="middle">
                                 <label for="estado_interesse" accesskey="1">Estado de interesse:</label>
                            </td>
                            <td align="left" valign="middle">
                                 <label for="cidade_interesse" accesskey="2">Cidade de interesse:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <select name="estado_interesse" id="estado_interesse" onChange="carrega_cidades(this.value,'');" <?=($errors['estado_interesse'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> >
                                <option value="">---</option>
                                    <?
                                    $servicoDAO = new ServicoDAO();
                                    $lista = $servicoDAO->listaEstados();
                                    $p_valor = '';
                                    foreach ($lista as $l){
                                        $p_valor .= '<option value="'.$l->estado.'"';
                                        if($estado_interesse==$l->estado) $p_valor .= 'selected="selected"'; 
                                        $p_valor .= '>'.$l->estado.'</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                                </select>
                            </td>
                            <td align="left" valign="middle">
                                 <input name="cidade_interesse" type="text" id="cidade_interesse" value="<?= $cidade_interesse;?>" <?=($errors['cidade_interesse'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong style="color: #666666;">Dados do Interessado</strong></td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                 <label for="nome" accesskey="1">Nome:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                <input name="nome" type="text" id="nome" value="<?= $nome;?>" <?=($errors['nome'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                 <label for="rg" accesskey="1">RG:</label>
                            </td>
                            <td align="left" valign="middle">
                                 <label for="cpf" accesskey="2">CPF:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <input name="rg" type="text" id="rg" value="<?= $rg;?>" <?=($errors['rg'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                            <td align="left" valign="middle">
                                 <input name="cpf" type="text" id="cpf" value="<?= $cpf;?>" <?=($errors['cpf'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                 <label for="email" accesskey="1">E-mail:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                <input name="email" type="text" id="email" value="<?= $email;?>" <?=($errors['email'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                 <label for="nascimento" accesskey="1">Nascimento:</label>
                            </td>
                            <td align="left" valign="middle">
                                 <label for="tel_res" accesskey="2">Telefone residencial:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <input name="nascimento" type="text" id="nascimento" value="<?= $nascimento;?>" <?=($errors['nascimento'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                            <td align="left" valign="middle">
                                 <input name="tel_res" type="text" id="tel_res" value="<?= $tel_res;?>" <?=($errors['tel_res'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                 <label for="tel_rec" accesskey="1">Telefone recado:</label>
                            </td>
                            <td align="left" valign="middle">
                                 <label for="tel_cel" accesskey="2">Telefone celular:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <input name="tel_rec" type="text" id="tel_rec" value="<?= $tel_rec;?>" <?=($errors['tel_rec'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                            <td align="left" valign="middle">
                                 <input name="tel_cel" type="text" id="tel_cel" value="<?= $tel_cel;?>" <?=($errors['tel_cel'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="width: 45%;" />
                                 <select name="id_operadora" id="id_operadora" <?=($errors['id_operadora'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="width: 50%;" >
                                    <option value="">---</option>
                                    <?
                                    $SiteDAO = new SiteDAO();
                                    $lista = $SiteDAO->listaOperadora();
                                    $p_valor = '';
                                    foreach ($lista as $l){
                                        $p_valor .= '<option value="'.$l->id_operadora.'"';
                                        if($id_operadora==$l->id_operadora) $p_valor .= 'selected="selected"'; 
                                        $p_valor .= '>'.$l->operadora.'</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                 <label for="estado_civil" accesskey="1">Estado civil:</label>
                            </td>
                            <td align="left" valign="middle">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <select name="estado_civil" id="estado_civil" <?=($errors['estado_civil'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> >
                                    <option value="">---</option>
                                    <option value="Casado(a)" <? if($estado_civil=='Casado(a)') echo 'selected'; ?>>Casado(a)</option>
                                    <option value="Solteiro(a)" <? if($estado_civil=='Solteiro(a)') echo 'selected'; ?>>Solteiro(a)</option>
                                    <option value="Viuvo(a)" <? if($estado_civil=='Viuvo(a)') echo 'selected'; ?>>Viuvo(a)</option>
                                    <option value="Separado(a)" <? if($estado_civil=='Separado(a)') echo 'selected'; ?>>Separado(a)</option>
                                    <option value="Divorciado(a)" <? if($estado_civil=='Divorciado(a)') echo 'selected'; ?>>Divorciado(a)</option>
                                    <option value="Amasiado(a)" <? if($estado_civil=='Amasiado(a)') echo 'selected'; ?>>Amasiado(a)</option>
                                </select>
                            </td>
                            <td align="left" valign="middle">
                                <label for="filhos" accesskey="2">Possui filhos:</label> 
                                <select name="filhos" id="filhos" <?=($errors['estado_civil'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="width: 50px;">
                                    <option value="">---</option>
                                    <option value="Sim" <? if($filhos=='Sim') echo 'selected'; ?>>Sim</option>
                                    <option value="Não" <? if($filhos=='Não') echo 'selected'; ?>>Não</option>
                                </select>
                                <label for="filhos_quant" accesskey="2">Quantos?:</label>
                                <input name="filhos_quant" type="text" id="filhos_quant" value="<?= $filhos_quant;?>" <?=($errors['filhos_quant'])?'style="border: 1px solid #FF0000; width: 50%; height: 20px;"':''; ?>  style="width: 50px;" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                 <label for="endereco" accesskey="1">Endereço:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                <input name="endereco" type="text" id="endereco" value="<?= $endereco;?>" <?=($errors['endereco'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                 <label for="numero" accesskey="1">Número:</label>
                            </td>
                            <td align="left" valign="middle">
                                 <label for="complemento" accesskey="2">Complemento:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <input name="numero" type="text" id="numero" value="<?= $numero;?>" <?=($errors['numero'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                            <td align="left" valign="middle">
                                 <input name="complemento" type="text" id="complemento" value="<?= $complemento;?>" <?=($errors['complemento'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                 <label for="bairro" accesskey="1">Bairro:</label>
                            </td>
                            <td align="left" valign="middle">
                                 <label for="cep" accesskey="2">Cep:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <input name="bairro" type="text" id="bairro" value="<?= $bairro;?>" <?=($errors['bairro'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                            <td align="left" valign="middle">
                                 <input name="cep" type="text" id="cep" value="<?= $cep;?>" <?=($errors['cep'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                 <label for="estado" accesskey="1">UF:</label>
                            </td>
                            <td align="left" valign="middle">
                                 <label for="cidade" accesskey="2">Cidade:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <select name="estado" id="estado" onChange="carrega_cidades(this.value,'');" <?=($errors['estado'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> >
                                <option value="">---</option>
                                    <?
                                    $servicoDAO = new ServicoDAO();
                                    $lista = $servicoDAO->listaEstados();
                                    $p_valor = '';
                                    foreach ($lista as $l){
                                        $p_valor .= '<option value="'.$l->estado.'"';
                                        if($estado==$l->estado) $p_valor .= 'selected="selected"'; 
                                        $p_valor .= '>'.$l->estado.'</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                                </select>
                            </td>
                            <td align="left" valign="middle">
                                 <input name="cidade" type="text" id="cidade" value="<?= $cidade;?>" <?=($errors['cidade'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                <label for="campo1" accesskey="4">Seu espaço para observações:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" colspan="2">
                                <textarea name="observacao" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?=($errors['observacao'])?'style="border: 1px solid #FF0000; width: 100%; height: 80px;"':''; ?> ><?= $observacao;?></textarea>
                                <span id="spcontando1" style="font-size: 12px;">Ainda não temos nada digitado..</span><br />
                                <span id="sprestante1" style="font-size: 12px;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="middle" colspan="4">
                                <input name="submit1" type="submit" value=" " title="Clique aqui para fazer o cadastro" class="bt_enviar" />
                            </td>
                        </tr>
                    </table>
                </form>
                <?
                }
                if($done){
                    echo '<img src="'.URL_IMAGES.'pages/mensagem-enviada-com-sucesso.png" alt="mensagem enviada com sucesso" title="Mensagem enviada com sucesso!" />';
                    echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE.'">';
                }
                ?>
            </div>
            <div class="box_c">
                <h3 style="color: #202A72;">SAIBA MAIS SOBRE:</h3>
                <div class="faixa_h"></div>
                <div class="icones_box">
                    <a href="<?= URL_SITE;?>sobre-a-franquia-da-cartorio-postal/" title="Sobre a Franquia mais procurada do Brasil">
                        <img src="<?= URL_IMAGES;?>pages/franquia-mais-procurada-do-brasil.png" alt="franquia mais procurada do brasil" title="Franquia mais procurada do Brasil" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>porque-ser-um-franqueado-da-cartorio-postal/" title="Porque ser um franqueado da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/porque-ser-um-franqueado-cartorio-postal.png" alt="porque ser um franqueado da cartorio postal" title="Porque ser um franqueado da Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>vantagens-da-franquia-da-cartorio-postal/" title="Vantagens da franquia da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/vantagens-da-franquia-cartorio-postal.png" alt="vantagens da franquia da cartorio postal" title="Vantagens da franquia da Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box">
                    <a href="<?= URL_SITE;?>pre-cadastro-da-franquia-cartorio-postal/" title="Pré cadastro da franquia Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/pre-cadastro-da-franquia-cartorio-postal.png" alt="pre cadastro da franquia cartorio postal" title="Pré cadastro da franquia Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal/" title="Conheça as unidades da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/conheca-as-unidades-da-cartorio-postal.png" alt="conheca as unidades da cartorio postal" title="Conheça as unidades da Cartório Postal" />
                    </a>
                </div>
                <div class="icones_box" style="margin-left: 6px;">
                    <a href="<?= URL_SITE;?>galeria-de-fotos-da-cartorio-postal/" title="Galeria de fotos da Cartório Postal">
                        <img src="<?= URL_IMAGES;?>pages/galeria-de-fotos-da-cartorio-postal.png" alt="galeria de fotos da cartorio postal" title="Galeria de fotos da Cartório Postal" />
                    </a>
                </div>
            </div>
        </div>
        <div class="box_g">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div class="box_i">
                            <h2 style="color: #202A72;">PRINCIPAIS SERVIÇOS:</h2>
                            <div class="faixa_h"></div>
                            <ul class="marcador_servicos">
                                <?= PRINCIPAIS_SERVICOS;?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" height="205">
                        <img src="<?= URL_IMAGES;?>pages/cartorio-postal-excelencia-em-franchising-2012.png" alt="cartorio postal excelencia em franchising-2012" title="Cartório Postal - Excelência em Franchising 2012" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="box_i" style="margin-top: 20px;">
            <h4 style="color: #202A72;">OFERECEMOS TAMBÉM:</h4>
            <div class="faixa_h"></div>
            <ul class="marcador_servicos">
               <?= OFERECEMOS_TAMBEM;?>
            </ul>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>
