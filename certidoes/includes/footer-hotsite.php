<?
if($id_afiliado != ""){
	$empresaDAO = new EmpresaDAO();
	$fr = $empresaDAO->listaEmpresaAfiliado($id_afiliado);
}
?>
<div id="area-footer">
	<div class="box-02">
		<div class="nav">
			<div class="nav-02">
				<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
					<tr>
						<td align="left" valign="top" colspan="2"><strong style="font-weight: bold; color: #202A72; text-transform: uppercase;"><?= $fr->fantasia;?></strong></td>
						<td align="left" valign="top"><strong style="font-size: 15px; color: #202A72;">CENTRAL DE ATENDIMENTO</strong></td>
					</tr>
					<tr>
						<td colspan="2" rowspan="4" align="left" valign="middle">
							<? if($fr->imagem==""){?>
							<img src="<?= URL_UPLOAD;?>franquia.jpg" width="300" height="210"/>
							<? }else{ ?>
							<img src="<?= URL_UPLOAD;?><?= $fr->imagem ?>" title="<?= $fr->fantasia ?>" width="300" height="210" />
							<?}?>
						</td>
						<td height="30" align="left" valign="middle">
							<?
							if($fr->tel)
								echo '<strong style="font-size: 15px; color: #333333;">'.$fr->tel.'</strong>' .' / '. '<strong style="font-size: 15px; color: #333333;">'.$fr->cel.'</strong>';
							else
							   echo '<strong style="font-size: 15px; color: #333333;">(11) 3103.0800</strong>';
							?>
						</td>
					</tr>
					<tr>
						<td height="20" align="left" valign="middle"><div class="linha-dash"></div></td>
					</tr>
					<tr>
						<td height="30" align="left" valign="middle">
							<?
							if($fr->tel)
								echo '<a href="mailto:'.str_replace('diretoria','contato',$fr->email).'" title="Clique para enviar um e-mail para a Cartório Postal '.$fr->fantasia.'" class="link_contato">'.str_replace('diretoria','contato',$fr->email).'</a>';
							else
								echo '<a href="mailto:contato@cartoriopostal.com.br" title="Clique para enviar um e-mail para a Cartório Postal" class="link_contato">contato@cartoriopostal.com.br</a>';
							?>
						</td>
					</tr>
					<tr>
						<td height="30" align="left" valign="middle" style="font: 15px Arial;">
							<span style="font: bold 15px Arial; color: #333333;">Endereço:</span> <?= $fr->endereco ?>, <?= $fr->numero?><br />
							<span style="font: bold 15px Arial; color: #333333;">Complemento:</span> <?= $fr->complemento?><br />
							<span style="font: bold 15px Arial; color: #333333;">Bairro:</span> <?= $fr->bairro?><br />
							<span style="font: bold 15px Arial; color: #333333;">Cidade:</span> <?= $fr->cidade?><br />
							<span style="font: bold 15px Arial; color: #333333;">Estado:</span> <?= $fr->estado?><br />
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>