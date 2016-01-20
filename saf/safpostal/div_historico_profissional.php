				<div>
					<p>&nbsp;- HISTÓRICO PROFISSIONAL</p>
					<label style="margin-left:10px;"><strong>Empresa: <span>*</span></strong></label>
					<label style="margin-left:295px;"><strong>Cargo Atual: <span>*</span></strong></label><br />
					<input name="empresa_t" type="text" class="form_estilo" id="empresa_t" style="width:358px; margin-left:10px;" value="<?=$c->empresa_t?>" maxlength="25" />
					<input name="cargo" type="text" class="form_estilo" id="cargo" style="width:358px; margin-left:9px;" value="<?=$c->cargo?>" maxlength="25" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Faça um Breve Relato Sobre seu Histórico: <span>*</span></strong></label>
					<textarea id="historico" name="historico" class="form_estilo" style="width:732px; height:90px; margin-left:10px;"><?=$c->historico?></textarea>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Período: <span>*</span></strong></label>
					<label style="margin-left:172px;"><strong>Funcionários:</strong></label>
					<label style="margin-left:143px;"><strong>Faturamento:</strong></label><br />
					<select style="width:234px; margin-left:10px;" class="form_estilo" name="periodo" id="periodo">
						<option value="">.:SELECIONE:.</option>
						<option value="6 meses a 1 ano" <? if($c->periodo=='6 meses a 1 ano') echo 'selected'; ?>>6 meses a 1 ano</option>
						<option value="1 ano a 5 anos" <? if($c->periodo=='1 ano a 5 anos') echo 'selected'; ?>>1 ano a 5 anos</option>
						<option value="5 anos a 10 anos" <? if($c->periodo=='5 anos a 10 anos') echo 'selected'; ?>>5 anos a 10 anos</option>
						<option value="acima de 10 anos" <? if($c->periodo=='acima de 10 anos') echo 'selected'; ?>>acima de 10 anos</option>
					</select>
					<select style="width:234px; margin-left:10px;" class="form_estilo" name="funcionarios" id="funcionarios">
						<option value="">.:SELECIONE:.</option>
						<option value="1 a 5" <? if($c->funcionarios=='1 a 5') echo 'selected'; ?>>1 a 5</option>
						<option value="de 5 a 10" <? if($c->funcionarios=='de 5 a 10') echo 'selected'; ?>>de 5 a 10</option>
						<option value="de 10 a 50" <? if($c->funcionarios=='de 10 a 50') echo 'selected'; ?>>de 10 a 50</option>
						<option value="de 50 a 100" <? if($c->funcionarios=='de 50 a 100') echo 'selected'; ?>>de 50 a 100</option>
						<option value="acima de 100" <? if($c->funcionarios=='acima de 100') echo 'selected'; ?>>acima de 100</option>
					</select>
					<select style="width:234px; margin-left:10px;" class="form_estilo" name="faturamento" id="faturamento">
						<option value="">.:SELECIONE:.</option>
						<option value="Até R$ 50 mil" <? if($c->faturamento=='Até R$ 50 mil') echo 'selected'; ?>>Até R$ 50 mil</option>
						<option value="R$ 50 a R$ 100 mil" <? if($c->faturamento=='R$ 50 a R$ 100 mil') echo 'selected'; ?>>R$ 50 a R$ 100 mil</option>
						<option value="R$ 100 a R$ 300 mil" <? if($c->faturamento=='R$ 100 a R$ 300 mil') echo 'selected'; ?>>R$ 100 a R$ 300 mil</option>
						<option value="R$ 300 a R$ 500 mil" <? if($c->faturamento=='R$ 300 a R$ 500 mil') echo 'selected'; ?>>R$ 300 a R$ 500 mil</option>
						<option value="Acima de R$ 500 mil" <? if($c->faturamento=='Acima de R$ 500 mil') echo 'selected'; ?>>Acima de R$ 500 mil</option>
					</select>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Contato: <span>*</span></strong></label>
					<label style="margin-left:169px;"><strong>Ramo de Atuação:</strong></label>
					<label style="margin-left:120px;"><strong>Nome da Empresa:</strong></label><br />
					<input name="contato" type="text" class="form_estilo" id="contato" style="width:232px; margin-left:10px;" value="<?=$c->contato?>" maxlength="50" />
					<input id="ramo_at" maxlength="40" name="ramo_at" value="<?=$c->ramo_at?>" type="text" style="width:232px; margin-left:10px;" class="form_estilo" />
					<input name="empresa_p" type="text" class="form_estilo" id="empresa_p" style="width:232px; margin-left:10px;" value="<?=$c->empresa_p?>" maxlength="50" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Cursos: <span>*</span></strong></label>
					<label style="margin-left:303px;"><strong>Grau de Escolaridade:</strong></label><br />
					<input type="text" style="width:358px; margin-left:10px;" class="form_estilo" maxlength="50" id="cursos" name="cursos" value="<?=$c->cursos?>" />
					<select style="width:358px; margin-left:9px;" class="form_estilo" id="escolaridade" name="escolaridade">
						<option value="">.:SELECIONE:.</option>
						<option value="Ensino fundamental: Incompleto" <? if($c->escolaridade=='Ensino fundamental: Incompleto') echo 'selected'; ?>>Ensino fundamental: Incompleto</option>
						<option value="Ensino fundamental: Completo" <? if($c->escolaridade=='Ensino fundamental: Completo') echo 'selected'; ?>>Ensino fundamental: Completo</option>
						<option value="">----------------------------------------------------------</option>
						<option value="Ensino médio: Incompleto" <? if($c->escolaridade=='Ensino médio: Incompleto') echo 'selected'; ?>>Ensino médio: Incompleto</option>
						<option value="Ensino médio: Completo" <? if($c->escolaridade=='Ensino médio: Completo') echo 'selected'; ?>>Ensino médio: Completo</option>
						<option value="">----------------------------------------------------------</option>
						<option value="Ensino superior: Incompleto" <? if($c->escolaridade=='Ensino superior: Incompleto') echo 'selected'; ?>>Ensino superior: Incompleto</option>
						<option value="Ensino superior: Completo" <? if($c->escolaridade=='Ensino superior: Completo') echo 'selected'; ?>>Ensino superior: Completo</option>
						<option value="">----------------------------------------------------------</option>
						<option value="Pós graduação" <? if($c->escolaridade=='Pós graduação') echo 'selected'; ?>>Pós graduação</option>
						<option value="Mestrado" <? if($c->escolaridade=='Mestrado') echo 'selected'; ?>>Mestrado</option>
						<option value="Doutorado" <? if($c->escolaridade=='Doutorado') echo 'selected'; ?>>Doutorado</option>
						<option value="MBA" <? if($c->escolaridade=='MBA') echo 'selected'; ?>>MBA</option>
					</select>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px;"><strong>Qual Faculdade:</strong></label>
					<label style="margin-left:165px;"><strong>Ano de Conclusão:</strong></label>
					<label style="margin-left:20px;"><strong>Tem ou Teve Negócio Próprio?</strong></label><br />
					<input name="faculdade" type="text" class="form_estilo" id="faculdade" style="width:279px; margin-left:10px;" value="<?=$c->faculdade?>" maxlength="45" />
					<input name="conclusao" type="text" class="form_estilo" id="conclusao" style="width:134px" value="<?=$c->conclusao?>" maxlength="7" />
					<input style="margin-left:20px;" id="negocios1" name="negocios" type="radio" value="Sim" <?=($c->negocios=='Sim')?'checked':'';?> />
                    <label style="margin-left:20px;" for="negocios1">Sim</label>
                    <input style="margin-left:20px;" id="negocios2" name="negocios" type="radio" value="Não" <?=($c->negocios=='Não')?'checked':'';?> />
                    <label style="margin-left:20px;" for="negocios2">Não</label>
				</div>