<div>
	<p>&nbsp;- REFERENCIAS BANCÁRIAS</p>
	<label style="margin-left:10px;"><strong>Banco:</strong></label>
	<label style="margin-left:210px;"><strong>Cartão de Crédito:</strong></label>
	<label style="margin-left:40px;"><strong>Vencimento:</strong></label>
	<label style="margin-left:60px;"><strong>Limite:</strong></label><br />
	<input type="text" style="width:244px; margin-left:10px;" class="form_estilo" maxlength="60" id="banco" name="banco" value="<?=$c->banco?>" />
	<input type="text" style="width:164px; margin-left:10px;" class="form_estilo" maxlength="40" id="cartao_credito" name="cartao_credito" value="<?=$c->cartao_credito?>" />
	<input type="text" maxlength="7" style="width:134px; margin-left:10px;" class="form_estilo" id="vencimento" name="vencimento" value="<?=$c->vencimento?>" />
	<input type="text" style="width:134px; margin-left:10px;" class="form_estilo" id="limite" name="limite" value="<?=$c->limite?>" maxlength="14" />
	
	<label style="width:758px;">&nbsp;</label>
	<label style="margin-left:10px;"><strong>Telefone:</strong></label>
	<label style="margin-left:47px;"><strong>Nome do Gerente:</strong></label>
	<label style="margin-left:245px;"><strong>Agência e Conta:</strong></label><br />
	<input type="text" style="width:104px; margin-left:10px;" maxlength="14" class="form_estilo" id="telefone_banco" name="telefone_banco" value="<?=$c->telefone_banco?>" />
	<input type="text" style="width:354px; margin-left:10px;" class="form_estilo" id="nome_gerente" name="nome_gerente" value="<?=$c->nome_gerente?>" maxlength="50" />
	<input type="text" style="width:234px; margin-left:10px;" class="form_estilo" maxlength="25" id="agencia_conta" name="agencia_conta" value="<?=$c->agencia_conta?>" />
</div>