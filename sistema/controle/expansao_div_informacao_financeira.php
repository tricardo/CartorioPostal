				<div>
					<p>&nbsp;- INFORMA��ES FINANCEIRAS</p>
					<label style="margin-left:10px;"><strong>Tem Capital Imediato Dispon�vel para Investir?</strong></label>
					<label style="margin-left:40px;"><strong>Valor Dispon�vel:</strong></label><br />
					<input style="margin-left:10px;" id="capital1" name="capital" type="radio" value="Sim" <?=($c->capital=='Sim')?'checked':'';?> />
					<label style="margin-left:20px;" for="capital1">Sim</label>
					<input style="margin-left:20px;" id="capital2" name="capital" type="radio" value="N�o" <?=($c->capital=='N�o')?'checked':'';?> />
					<label style="margin-left:20px;" for="capital2">N�o</label>
					<input onKeyPress="moeda(this);" type="text" style="width:220px; margin-left:235px;" id="valor_disp" name="valor_disp" class="form_estilo" maxlength="14" value="<?=$c->valor_disp?>" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Informe se Depende de Empr�stimo ou Venda de Bens para Investir em sua Franquia Cart�rio Postal:</strong></label><br />
					<textarea style="width:734px; margin-left:10px;" class="form_estilo" id="emprestimo" name="emprestimo"><?=$c->emprestimo?></textarea>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Informe se o Capital Citado for de Terceiros:</strong></label><br />
					<textarea class="form_estilo" style="width:734px; height:90px; margin-left:10px;" id="capital_terc" name="capital_terc"><?=$c->capital_terc?></textarea>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Quando Pretende dar In�cio ao Neg�cio?</strong></label>
					<label style="margin-left:80px;"><strong>Qual o seu Tempo Dedicado a Franquia?</strong></label><br />
					<select class="form_estilo" style="width:354px; margin-left:10px;" id="inicio_neg" name="inicio_neg">
						<option value="">.:SELECIONE:.</option>
						<option value="Imediato" <? if($c->inicio_neg=='Imediato') echo 'selected'; ?>>Imediato</option>
						<option value="2 meses" <? if($c->inicio_neg=='2 meses') echo 'selected'; ?>>2 meses</option>
						<option value="4 meses" <? if($c->inicio_neg=='4 meses') echo 'selected'; ?>>4 meses</option>
						<option value="6 meses" <? if($c->inicio_neg=='6 meses') echo 'selected'; ?>>6 meses</option>
						<option value="8 meses" <? if($c->inicio_neg=='8 meses') echo 'selected'; ?>>8 meses</option>
						<option value="acima de 8 meses" <? if($c->inicio_neg=='acima de 8 meses') echo 'selected'; ?>>acima de 8 meses</option>
					</select>
					<input style="margin-left:18px;" id="dedicado_franq1" name="dedicado_franq" type="radio" value="Integral" <?=($c->dedicado_franq=='Integral')?'checked':'';?> />
					<label for="dedicado_franq1">Integral</label>
					<input id="dedicado_franq2" name="dedicado_franq" type="radio" value="Parcial" <?=($c->dedicado_franq=='Parcial')?'checked':'';?> />
					<label for="dedicado_franq2">Parcial</label>
					<input id="dedicado_franq3" name="dedicado_franq" type="radio" value="Como Investidor" <?=($c->dedicado_franq=='Como Investidor')?'checked':'';?> />
					<label for="dedicado_franq3">Como Investidor</label>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>A Franquia Ser� a Principal Fonte de Renda?</strong></label>
					<label style="margin-left:50px;"><strong>Pretende Ter S�cios? Especifique.</strong></label><br />
					<input style="margin-left:10px;" id="fonte_renda1" name="fonte_renda" type="radio" value="Sim" <?=($c->fonte_renda=='Sim')?'checked':'';?> />
                    <label for="fonte_renda1">Sim</label>
                    <input id="fonte_renda2" name="fonte_renda" type="radio" value="N�o" <?=($c->fonte_renda=='N�o')?'checked':'';?> />
                    <label for="fonte_renda2">N�o</label>
                    <input id="fonte_renda3" name="fonte_renda" type="radio" value="Temporariamente" <?=($c->fonte_renda=='Temporariamente')?'checked':'';?> />
                    <label for="fonte_renda3">Temporariamente</label>
					<input type="text" style="width:351px; margin-left:136px;" class="form_estilo" id="socios" name="socios" value="<?=$c->socios?>" maxlength="50" />
				</div>