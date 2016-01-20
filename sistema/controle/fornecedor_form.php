<?php
$bancoDAO = new BancoDAO();
$bancos = $bancoDAO->listar(); 

$regimeDAO = new RegimeDAO();
$regimes = $regimeDAO->listar();

if(count($errors)>0){?>
<div class="erro"><?php echo $error; ?></div>
<?php
}
?>
<div style="position: relative; width: 800px; margin: auto;" id="container-hotsite">
		<ul>
			<li><a href="#aba0" onclick="eraseCookie('aba');">Dados do fornecedor</a></li>
			<?php if($id!=''){?>
				<li><a href="#aba1" onclick="eraseCookie('aba'); createCookie('aba','aba1','1','1');">Anexos</a></li>
			<?php } ?>
		</ul>
		<div id="aba0" class="tabs-container" style="position: relative; width: 800px; margin: auto;">
			<table border="0">
				<tr>
					<td valign="top" align="center">
					<form enctype="multipart/form-data" action="" method="post" name="fornecedor_form">
					<table width="650" class="tabela">
						<tr>
							<td colspan="4" class="tabela_tit">Dados do Fornecedor</td>
						</tr>
						<tr>
							<td width="100">
							<div align="right"><strong>Razão Social:</strong></div>
							</td>
							<td colspan="3">
								<input type="text" name="razao" value="<?=$f->razao ?>"
								 style="width:514px"
								 class="form_estilo <?=(isset($errors['razao']))?'form_estilo_erro':''; ?>" />
								 <font color="#FF0000">*</font>
							</td>
						</tr>
						<tr>
							<td width="100">
							<div align="right"><strong>Fantasia:</strong></div>
							</td>
							<td colspan="3"><input type="text" name="fantasia" value="<?=$f->fantasia ?>"
								style="width:514px"
								class="form_estilo  <?=(isset($errors['fantasia']))?'form_estilo_erro':''; ?>" />
								 <font color="#FF0000">*</font>
								
								</td>
						</tr>
						<tr>
							<td width="100">
							<div align="right"><strong>CNPJ: </strong></div>
							</td>
							<td width="200"><input type="text" name="cnpj" value="<?=$f->cnpj ?>"
								style="width: 150px"
								onKeyUp="masc_numeros(this,'##.###.###/####-##');"
								class="form_estilo <?=(isset($errors['cnpj']))?'form_estilo_erro':''; ?>" /></td>
							<td width="108">
							<div align="right"><strong>I.E.:</strong></div>
							</td>
							<td><input type="text" name="ie" value="<?=$f->ie ?>"
								style="width:150px"
								onKeyUp="masc_numeros(this,'###.###.###.###');"
								class="form_estilo  <?=(isset($errors['ie']))?'form_estilo_erro':''; ?>" /></td>
						</tr>
						
						<tr>
							<td>
							<div align="right"><strong>Regime:</strong></div>
							</td>
							<td><select name="id_regime" style="width: 150px"
								class="form_estilo  <?=(isset($errors['fax']))?'form_estilo_erro':''; ?>">
								<option></option>
								<?php foreach($regimes as $regime){ ?>
								<option value="<?=$regime->id_regime;?>"
								<?=($f->id_regime == $regime->id_regime)?'selected="selected"':''?>><?=$regime->nome; ?></option>
								<?php }?>
								</select>
								</td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Fax:</strong></div>
							</td>
							<td><input type="text" name="fax" value="<?=$f->fax ?>"
								style="width: 150px"
								class="form_estilo  <?=(isset($errors['fax']))?'form_estilo_erro':''; ?>"
								onKeyUp="masc_numeros(this,'(##) ####-####');" /></td>
						</tr>
			
						<tr>
							<td colspan="4" class="tabela_tit">Endereço</td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>CEP: </strong></div>
							</td>
							<td colspan="3"><input type="text" name="cep" style="width: 150px"
								value="<?=$f->cep ?>"
								class="form_estilo <?=(isset($errors['cep']))?'form_estilo_erro':''; ?>"
								onKeyUp="masc_numeros(this,'#####-###');" />
							<input type="button" name="consultar2" value="Consultar"
								class="button_busca"
								onclick="carrega_endedeco(cep.value, 'fornecedor_form');" />
							</td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Endere&ccedil;o: </strong></div>
							</td>
							<td colspan="3">
								<input type="text" name="endereco" value="<?=$f->endereco ?>" style="width: 387px"
								class="form_estilo <?=(isset($errors['endereco']))?'form_estilo_erro':''; ?>" />
							<strong>N&deg;</strong> <input
								type="text" name="numero" style="width: 95px"
								value="<?=$f->numero ?>"
								class="form_estilo  <?=(isset($errors['numero']))?'form_estilo_erro':''; ?>" />
							</td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Complemento: </strong></div>
							</td>
							<td><input type="text" name="complemento" style="width: 200px"
								value="<?=$f->complemento ?>" class="form_estilo" /></td>
							<td>
							<div align="right"><strong>Bairro:</strong></div>
							</td>
							<td><input type="text" name="bairro" style="width: 150px"
								value="<?=$f->bairro ?>"
								class="form_estilo  <?=(isset($errors['bairro']))?'form_estilo_erro':''; ?>" /></td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Cidade: </strong></div>
							</td>
							<td><input type="text" name="cidade" style="width: 200px"
								value="<?=$f->cidade ?>"
								class="form_estilo  <?=(isset($errors['cidade']))?'form_estilo_erro':''; ?>" />
							</td>
							<td>
							<div align="right"><strong>Estado:</strong></div>
							</td>
							<td><input type="text" name="estado" style="width: 150px"
								value="<?=$f->estado ?>"
								class="form_estilo  <?=(isset($errors['estado']))?'form_estilo_erro':''; ?>"
								maxlength="2" /></td>
						</tr>
						<tr>
							<td colspan="4" class="tabela_tit">Dados Bancários</td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Banco: </strong></div>
							</td>
							<td colspan="3"><select name="id_banco"
								class="form_estilo  <?=(isset($errors['id_banco']))?'form_estilo_erro':''; ?>">
								<option></option>
								<?php foreach($bancos as $banco){ ?>
								<option value="<?=$banco->id_banco;?>"
								<?=($f->id_banco==$banco->id_banco)?'selected="selected"':''?>><?=$banco->banco; ?></option>
								<?php }?>
							</select></td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Agência:</strong></div>
							</td>
							<td><input type="text" name="agencia" style="width: 150px"
								value="<?=$f->agencia ?>"
								class="form_estilo  <?=(isset($errors['agencia']))?'form_estilo_erro':''; ?>"
								maxlength="15" /></td>
							<td>
							<div align="right"><strong>Conta:</strong></div>
							</td>
							<td><input type="text" name="conta" style="width: 150px"
								value="<?=$f->conta ?>"
								class="form_estilo  <?=(isset($errors['conta']))?'form_estilo_erro':''; ?>"
								maxlength="15" /></td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Favorecido:</strong></div>
							</td>
							<td><input type="text" name="favorecido" style="width: 150px"
								value="<?=$f->favorecido ?>"
								class="form_estilo  <?=(isset($errors['favorecido']))?'form_estilo_erro':''; ?>"
								maxlength="45" /></td>
						</tr>
			
						<tr>
							<td colspan="4" class="tabela_tit">Contatos</td>
						</tr>
						<tr>
							<td align="right"><strong>Contato:</strong></td>
							<td><input type="text" name="contato1" style="width: 150px"
								value="<?=$f->contato1 ?>"
								class="form_estilo  <?=(isset($errors['contato1']))?'form_estilo_erro':''; ?>"
								maxlength="45" /></td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Tel / Ramal: </strong></div>
							</td>
							<td width="248">
								<input type="text" name="tel1" value="<?=$f->tel1 ?>"
								style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
								class="form_estilo <?=(isset($errors['tel1']))?'form_estilo_erro':''; ?>" />
								 - <input type="text" name="ramal1"
								value="<?=$f->ramal1 ?>" style="width: 50px"
								onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
							<td>
							<div align="right"><strong>Email: </strong></div>
							</td>
							<td><input type="text" name="email1" value="<?=$f->email1 ?>"
								style="width: 150px"
								class="form_estilo  <?=(isset($errors['email1']))?'form_estilo_erro':''; ?>" /></td>
						</tr>
			
						<tr>
							<td align="right"><strong>Contato:</strong></td>
							<td><input type="text" name="contato2" style="width: 150px"
								value="<?=$f->contato2 ?>" class="form_estilo" maxlength="45" /></td>
						</tr>
						<tr>
							<td>
							<div align="right"><strong>Tel / Ramal: </strong></div>
							</td>
							<td width="248"><input type="text" name="tel2" value="<?=$f->tel2 ?>"
								style="width: 150px" onKeyUp="masc_numeros(this,'(##) ####-####');"
								class="form_estilo <?=(isset($errors['tel2']))?'form_estilo_erro':''; ?>" />
							<font color="#FF0000">&nbsp;</font> - <input type="text" name="ramal2"
								value="<?=$f->ramal2 ?>" style="width: 50px"
								onkeyup="masc_numeros(this,'####');" class="form_estilo" /></td>
							<td>
							<div align="right"><strong>Email: </strong></div>
							</td>
							<td><input type="text" name="email2" value="<?=$f->email2 ?>"
								style="width: 150px" class="form_estilo" /></td>
						</tr>
			
						<tr>
							<td colspan="4" class="tabela_tit">Serviços</td>
						</tr>
						<tr>
							<td align="right"><strong>Descritivo de Produtos / Serviços:</strong></td>
							<td colspan="3"><textarea name="descProduto" class="form_estilo" style="width:470px; height:100px"><?=$f->descProduto?></textarea></td>
						</tr>
						<tr>
							<td align="right"><strong>Crédito para Compra:</strong></td>
							<td colspan="3"><input type="text" class="form_estilo"
								value="<?=$f->creditoCompra?>" name="creditoCompra" />
						
						</tr>
						<tr>
							<td colspan="4" align="center"><input type="submit" name="submit"
								value="Enviar" class="button_busca" />&nbsp; <input type="submit"
								name="cancelar" value="Cancelar"
								onclick="document.fornecedor_form.action='fornecedor.php'"
								class="button_busca" /></td>
						</tr>
					</table>
							<div id="resgata_endereco"></div>
					</form>
					</td>
				</tr>
			</table>
		</div>
		<?php if($id!=''){?>
		<div id="aba1" class="tabs-container" style="position: relative; width: 800px; margin: auto;">
			<table border="0">
				<tr>
					<td valign="top" align="center">
					<form enctype="multipart/form-data" action="#aba1" method="post" name="fornecedor_anexo">
					<input name="id_fornecedor" value="<?php echo $f->id_fornecedor?>" type="hidden"/>
					<table width="650" class="tabela">
						<tr>
							<td colspan="4" class="tabela_tit">Anexos</td>
						</tr>
						<tr>
							<td align="right"><strong>Anexo:</strong></td>
							<td><input type="text" name="descricao" style="width: 150px" value="<?=$a->descricao ?>" class="form_estilo" maxlength="45" /><font color='#ff0000'>*</font></td>
						</tr>
						<tr>
							<td align="right"><strong>Arquivo:</strong></td>
							<td><input type="file" name="anexo" style="width: 150px" class="form_estilo" maxlength="45" /></td>
						</tr>
						<tr>
							<td colspan="4" align="center">
								<input type="submit" name="submit_anexo" value="Enviar" class="button_busca" />&nbsp;
							</td>
						</tr>
					</table>
					</form>
					<table width="650" class="tabela">
					<tr>
						<td colspan="4" class="tabela_tit">Anexos</td>
					</tr>
					<?php 
					$anexos = $fornecedorDAO->buscaAnexosForn($id,$controle_id_empresa);
					foreach($anexos as $anexo){?>
						<tr>
							<td><?php echo $anexo->descricao?></td>
							<td><a href="../anexos_fornecedor/<?php echo $anexo->anexo?>" target="_blank">
								<img border="0" title="Anexo" src="../images/botao_print.png" >
								</a>
							</td>
							<td>
								<a href="<?php echo $anexo->id_fornecedor_anexo ?>" class="ex">excluir</a>
							</td>
						</tr>
					<?php }?>
					</table>
					</td>
				</tr>
			</table>
		</div>
		<?php } ?>
</div>

<script>
$(document).ready(function() {
	$(".ex").click(function(){
		if(confirm("Apagar o anexo?")){
			var id_fornecedor_anexo = $(this).attr('href');
			$.ajax({url: "fornecedor_rem_anexo.php?id_fornecedor_anexo="+id_fornecedor_anexo});
			$(this).parent().parent().remove();
		}
		return false;
	});
});

</script>


