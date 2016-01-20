<fieldset class="semborda" >
	<legend><b >Endere&ccedil;os </b></legend>
	<table cellspacing="0" cellpadding="0"	border="0" >
		<tr>
                    <td height="20" width="100" class="menu" id="td_opcao1" onClick="AlternarAbas('td_opcao1','div_opcao1')">Domic&iacute;lio</td>
                    <td height="20" width="100" class="menu1" id="td_opcao2" onClick="AlternarAbas('td_opcao2','div_opcao2')"> Cobran&ccedil;a</td>
                    <td height="20" width="100" class="menu2" id="td_opcao3" onClick="AlternarAbas('td_opcao3','div_opcao3')"> Entrega</td>
                    <td height="20" width="100" class="menu3" id="td_opcao4" onClick="AlternarAbas('td_opcao4','div_opcao4')"> Faturamento</td>
		</tr>
		<tr>
		<td class="tb-conteudo" colspan="4">
			<? $tipos = array(1=>'D',2=>'C',3=>'E',4=>'F'); ?>
			<? foreach($tipos as $i=>$tipo){ ?>
			<div id="div_opcao<?=$i?>" class="conteudo" style="display: none">
            
				<label for="cep">CEP:</label>
                                <input  id="cep" type="text" name="cep[<?=$tipo?>]" value="<?=$pessoa->getEndereco($tipo)->cep ?>" onkeyup="cepMasc(this);" onblur="buscaCep(this.value, 'endereco');" maxlength="9" align="right"/><br />
               
				<label for="end">Endere&ccedil;o:</label>
					<input  class="strUpper"  id="end" type="text" name="endereco[<?=$tipo?>]" value="<?=$pessoa->getEndereco($tipo)->endereco ?>" id="endereco" size="50"/>
				<label for="nro">No.:</label> <input  id="nro" type="text" name="numero[<?=$tipo?>]" value="<?=$pessoa->getEndereco($tipo)->numero ?>" size="4" align="right"/>
                                <br/>
				<label for="compl">Compl.:</label>
				<input  class="strUpper"  id="compl" type="text" name="compl[<?=$tipo?>]" value="<?=$pessoa->getEndereco($tipo)->compl ?>" size="10"/><br />
				<label for="bairro">Bairro:</label>
				<input  class="strUpper"  id="bairro" type="text" value="<?=$pessoa->getEndereco($tipo)->bairro ?>" name="bairro[<?=$tipo?>]" size="50"/>
				<br/>
				<label for="uf">UF:</label> 
				<select id="uf" name="uf[<?=$tipo?>]" id="uf" size="1">
					<option value="SP" <?=($pessoa->getEndereco($tipo)->uf=='SP') ?'selected="selected"':''?>>SP</option>
					<option value="AC" <?=($pessoa->getEndereco($tipo)->uf=='AC') ?'selected="selected"':''?>>AC</option>
					<option value="AL" <?=($pessoa->getEndereco($tipo)->uf=='AL') ?'selected="selected"':''?>>AL</option>
					<option value="AM" <?=($pessoa->getEndereco($tipo)->uf=='AM') ?'selected="selected"':''?>>AM</option>
					<option value="AP" <?=($pessoa->getEndereco($tipo)->uf=='AP') ?'selected="selected"':''?>>AP</option>
					<option value="BA" <?=($pessoa->getEndereco($tipo)->uf=='BA') ?'selected="selected"':''?>>BA</option>
					<option value="DF" <?=($pessoa->getEndereco($tipo)->uf=='DF') ?'selected="selected"':''?>>DF</option>
					<option value="ES" <?=($pessoa->getEndereco($tipo)->uf=='ES') ?'selected="selected"':''?>>SP</option>
					<option value="GO" <?=($pessoa->getEndereco($tipo)->uf=='GO') ?'selected="selected"':''?>>GO</option>
					<option value="MA" <?=($pessoa->getEndereco($tipo)->uf=='MA') ?'selected="selected"':''?>>MA</option>
					<option value="MG" <?=($pessoa->getEndereco($tipo)->uf=='MG') ?'selected="selected"':''?>>MG</option>
					<option value="MS" <?=($pessoa->getEndereco($tipo)->uf=='MS') ?'selected="selected"':''?>>MS</option>
					<option value="MT" <?=($pessoa->getEndereco($tipo)->uf=='MT') ?'selected="selected"':''?>>MT</option>
					<option value="PA" <?=($pessoa->getEndereco($tipo)->uf=='PA') ?'selected="selected"':''?>>PA</option>
					<option value="PB" <?=($pessoa->getEndereco($tipo)->uf=='PB') ?'selected="selected"':''?>>PB</option>
					<option value="PI" <?=($pessoa->getEndereco($tipo)->uf=='PI') ?'selected="selected"':''?>>PI</option>
					<option value="PR" <?=($pessoa->getEndereco($tipo)->uf=='PR') ?'selected="selected"':''?>>PR</option>
					<option value="RJ" <?=($pessoa->getEndereco($tipo)->uf=='RJ') ?'selected="selected"':''?>>RJ</option>
					<option value="RN" <?=($pessoa->getEndereco($tipo)->uf=='RN') ?'selected="selected"':''?>>RN</option>
					<option value="RO" <?=($pessoa->getEndereco($tipo)->uf=='RO') ?'selected="selected"':''?>>RO</option>
					<option value="RR" <?=($pessoa->getEndereco($tipo)->uf=='RR') ?'selected="selected"':''?>>RR</option>
					<option value="RS" <?=($pessoa->getEndereco($tipo)->uf=='RS') ?'selected="selected"':''?>>RS</option>
					<option value="SC" <?=($pessoa->getEndereco($tipo)->uf=='SC') ?'selected="selected"':''?>>SC</option>
					<option value="SE" <?=($pessoa->getEndereco($tipo)->uf=='SE') ?'selected="selected"':''?>>SE</option>
					<option value="TO" <?=($pessoa->getEndereco($tipo)->uf=='TO') ?'selected="selected"':''?>>TO</option>
				</select>                                                               
				<label for="cidade">Cidade:</label>
				<input  class="strUpper"  id="cidade" type="text" value="<?=$pessoa->getEndereco($tipo)->cidade ?>" name="cidade[<?=$tipo?>]"/>
			</div>
			<? } ?>
		</td>
		</tr>
	</table>
</fieldset>    