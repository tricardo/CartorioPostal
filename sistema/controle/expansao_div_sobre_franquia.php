				<div>
					<p>&nbsp;- SOBRE A FRANQUIA CARTÓRIO POSTAL</p>
					<label style="margin-left:10px; width:738px;"><strong>Enumere o que você considera importante na franquia Cartório Postal, sendo que o número 1 é o mais importante:</strong></label>
					<label style="width:758px;">&nbsp;</label>
					<?php $e = $dt->EnumPergunta(); $i = 0;
					foreach($e as $j => $ep){
						$id_pergunta[$i] = $ep->id_enum_perg;
						$pergunta[$i]    = $ep->pergunta;
						$i++;
					}
					for($i = 0; $i < count($id_pergunta); $i++){
						if($submit1){
							$valor = valida($_POST['pergunta'.$i]);
						}else{$e = $dt->buscaRelEnumPergunta($id, $id_pergunta[$i]); $valor = $e->valor;}?>
						<input type="hidden" value="<?=$id_pergunta[$i]?>" name="id_pergunta<?=$i?>" id="id_pergunta<?=$i?>" />
						<input onKeyUp="masc_numeros(this,'#');" name="pergunta<?=$i?>" id="pergunta<?=$i?>" value="<?=$valor?>" type="text" class="form_estilo" maxlength="1" style="text-align:center; width:50px; margin-left:10px;" />
						<label><?=$pergunta[$i]?></label>
						<br />		
					<? } ?>
					<input type="hidden" value="<?=$i?>" name="id_pergunta_total" id="id_pergunta_total" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px; width:738px;"><strong>Como Conheceu as Franquias Cartório Postal:</strong></label>
					<textarea class="form_estilo" style="width:734px; height:90px; margin-left:10px;" id="conheceu_cp" name="conheceu_cp"><?=$c->conheceu_cp?></textarea>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="width:200px; margin-left:10px;"><strong>Já Esteve em uma de Nossas Unidades?</strong></label>
					<label style="margin-left:66px;"><strong><br />&nbsp;Qual?</strong></label>
					<label style="width:300px; margin-left:127px;"><strong>Deseja Receber Comunicados de Outras Empresas da Rede?</strong></label><br />
					<input style="margin-left:10px;" id="unidades1" name="unidades" type="radio" value="Sim" <?=($c->unidades=='Sim')?'checked':'';?> />
                    <label for="unidades1">Sim</label>
                    <input id="unidades2" name="unidades" type="radio" value="Não" <?=($c->unidades=='Não')?'checked':'';?> />
                    <label for="unidades2">Não</label>
					<input type="text" style="width:150px; margin-left:175px;" class="form_estilo" id="unidades_valor" name="unidades_valor" maxlength="25" value="<?=$c->unidades_valor?>" />
					<input style="margin-left:15px;" id="comunicados1" name="comunicados" type="radio" value="Sim" <?=($c->comunicados=='Sim')?'checked':'';?> />
					<label for="comunicados1">Sim</label>
					<input id="comunicados2" name="comunicados" type="radio" value="Não" <?=($c->comunicados=='Não')?'checked':'';?> />
					<label for="comunicados2">Não</label>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px; width:738px;"><strong>Porque o Interesse em ser um Franqueado?</strong></label>
					<textarea class="form_estilo" style="width:734px; height:90px; margin-left:10px;" id="interesse" name="interesse"><?=$c->interesse?></textarea>
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px; width:738px;"><strong>Selecione o Estado e a Cidade de Interesse: <span>*</span></strong></label>
					<select style="width:84px; margin-left:10px;" class="form_estilo" name="estado_interesse" id="estado_interesse">
						<option value="<?= $estado_interesse ?>">UF</option>
						<?$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
						while($res = mysql_fetch_array($sql)){
							echo '<option value="'.$res['estado'].'"';
							if($c->estado_interesse==$res['estado']) echo 'selected="selected"'; 
							echo '>'.$res['estado'].'</option>';
						}
					?></select>
					<input type="text" style="width:634px; margin-left:10px;" class="form_estilo" id="cidade_interesse" name="cidade_interesse" value="<?=$c->cidade_interesse?>" maxlength="120" />
					
					<label style="width:758px;">&nbsp;</label>
					<label style="margin-left:10px; width:738px;"><strong>Seu Espaço Para Observações:</strong></label><br />
					<textarea class="form_estilo" style="width:734px; height:90px; margin-left:10px;" id="observacao" name="observacao"><?=$c->observacao?></textarea>
					
					<label style="width:758px;">&nbsp;</label>
				</div>