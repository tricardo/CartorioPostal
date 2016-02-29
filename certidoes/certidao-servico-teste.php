<form name="form" action="" method="post" enctype="multipart/form-data">
						<table width="100%" border="0" cellspacing="1" cellpadding="3">
							<tr>
								<td align="left" valign="middle">
									<label for="nome" accesskey="1">Nome</label>
								</td>
								<td align="left" valign="middle">
									<label for="email" accesskey="2">E-mail</label>
								</td>
							</tr>
							<tr>
								<td>
									<input name="nome" type="text" value="<?= $nome;?>" id="nome" <?=($errors['nome'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="background: #F8F8F8; border: 1px solid #254061; width: 100%; height: 20px;" />
								</td>
								<td>
									<input name="email" type="text" value="<?= $email;?>" id="email" <?=($errors['email'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="background: #F8F8F8; border: 1px solid #254061; width: 100%; height: 20px;" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle">
									<label for="tel_cont" accesskey="3">Telefone de contato</label>
								</td>
								<td align="left" valign="middle">
									<label for="tel_cel" accesskey="4">Celular</label>
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle">
									<input name="tel_cont" type="text" value="<?= $tel_cont;?>" id="tel_cont" <?=($errors['tel_cont'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="background: #F8F8F8; border: 1px solid #254061; width: 100%; height: 20px;" />
								</td>
								<td align="right" valign="middle">
									<input name="tel_cel" type="text" value="<?= $tel_cel;?>" id="tel_cel" onKeyUp="masc_numeros(this,'(##) ####-####');" <?=($errors['tel_cel'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="background: #F8F8F8; border: 1px solid #254061; width: 100%; height: 20px;" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle" colspan="2">
									<label for="assunto" accesskey="5">Assunto</label>
								</td>
							</tr>
							 <tr>
								<td align="left" valign="middle" colspan="2">
									<input name="assunto" type="text" value="<?= $assunto;?>" id="assunto" <?=($errors['assunto'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> style="background: #F8F8F8; border: 1px solid #254061; width: 100%; height: 20px;" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle" colspan="2">
									<label for="mensagem" accesskey="6">Mensagem</label>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<textarea name="mensagem" id="mensagem" cols="" rows="" <?=($errors['mensagem'])?'style="border: 1px solid #FF0000; width: 460px; height: 100px;"':''; ?> style="background: #F8F8F8; border: 1px solid #254061; width: 460px; height: 100px; font: 15px Calibri;" ><?= $mensagem;?></textarea>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right" valign="middle">
									<input name="submit1" type="submit" value=" " title="Clique aqui para enviar sua mensagem." class="bt-enviar" />
								</td>
							</tr>
						</table>
					</form>