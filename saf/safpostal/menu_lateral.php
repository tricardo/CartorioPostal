<table border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
<tr>
<td>
<table width="150" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<!--<tr>
<td bgcolor="#95D8FF" height="25" align="left" valign="middle"><strong>Ranking</strong></td>
</tr>
<tr>
<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="ranking.php">&bull; Ranking das Franquias</a><br /></td>
</tr>//-->
<tr>
<td bgcolor="#95D8FF" height="25" align="left" valign="middle"><strong>Central de Ajuda</strong></td>
</tr>
<tr>
<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="index.php">&bull; Página inicial</a><br /></td>
</tr>
<!--<tr>
<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="helpdesk_at_list.php">&bull; Suporte Online</a></td>
</tr>//-->
	<?
	$permissao = verifica_permissao('CHAT',$safpostal_departamento_saf);
	if($safpostal_id_empresa=="1" and $permissao=='TRUE'){?>
	 <!--<tr><tr>
	<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="skype.php">&bull; Skype</a></td>
	</tr>//-->
    <? } else {?>
    <!--<tr>
	<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="skype.php">&bull; Skype</a></td>
	</tr>//-->
    <? } ?>
    <tr>
	<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="convencao2011.php">&bull; Convenção 2011</a></td>
	</tr>
	<tr>
	<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="net-exchange.php">&bull; Net Exchange</a></td>
	</tr>
	<tr>
	<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="midia-sociais.php">&bull; Mídia Social</a></td>
	</tr>
	<tr>
	<td height="25" align="left" valign="middle" bgcolor="#FFFFFF"><a title="Clique aqui" href="galeria-de-fotos.php">&bull; Galeria de Fotos</a></td>
	</tr>
		<? 
	$permissao = verifica_permissao('USUARIOS',$safpostal_departamento_saf);
	if($safpostal_id_empresa=="1" and $permissao=='TRUE'){?>
<tr>
<td bgcolor="#95D8FF" height="25" align="left" valign="middle"><strong>Administrador</strong></td>
</tr>
	<tr>
	<td height="25" align="left" valign="middle"><a title="Clique aqui" href="usuarios.php">&bull; Usuário</a></td>
	</tr>
	<?
	}
	?>
	
	
<tr>
<td bgcolor="#95D8FF" height="25" align="left" valign="middle"><strong>Treinamentos</strong></td>
</tr>
<tr>
	<td height="25" align="left" valign="middle"><a title="Clique aqui" href="modulos.php">&bull; Módulos</a></td>
	</tr>
<? 
	$permissao = verifica_permissao('PARCERIAS',$safpostal_departamento_saf);
	if($safpostal_id_empresa=="1" and $permissao=='TRUE'){?>
	<tr>
	<td height="25" align="left" valign="middle"><a title="Clique aqui" href="parcerias.php">&bull; Parcerias</a></td>
	</tr>
	<?
	}
	?>
	
<tr>
<td bgcolor="#95D8FF" height="25" align="left" valign="middle"><strong>Fórum</strong></td>
</tr>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="forum_list.php">&bull; Lista de tópicos</a></td>
</tr>
	<tr>
    <td height="25" align="left" valign="middle"><a title="Clique aqui" href="forum.php">&bull; Adicionar Tópico</a></td>
    </tr>
	<? 
	$permissao = verifica_permissao('FORUM',$safpostal_departamento_saf);
	if($safpostal_id_empresa=="1" and $permissao=='TRUE'){?>
    <tr>
    <td height="25" align="left" valign="middle"><a title="Clique aqui" href="forum_list.php?lista=pendentes">&bull; Tópicos Pendentes</a></td>
    </tr>
    <? } ?>
<tr>
<td bgcolor="#95D8FF" height="25" align="left" valign="middle"><strong>Área de Downloads</strong></td>
</tr>
	<? 
	$permissao = verifica_permissao('FTP',$safpostal_departamento_saf);
	if($safpostal_id_empresa=="1" and $permissao=='TRUE'){?>
    <tr>
    <td height="25" align="left" valign="middle"><a title="Clique aqui" href="ftp_upload.php">&bull; Upload</a></td>
    </tr>
    <? } ?>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="ftp_list.php">&bull; Lista de Downloads</a></td>
</tr>
<tr>
<td bgcolor="#95D8FF" height="25" align="left" valign="middle"><strong>Informativos</strong></td>
</tr>
	<? 
	$permissao = verifica_permissao('COMUNICADO',$safpostal_departamento_saf);
	if($safpostal_id_empresa=="1" and $permissao=='TRUE' or $safpostal_id_empresa=="1" and ($safpostal_id_usuario=="338" or $safpostal_id_usuario=="272")){?>
	<tr>
	<td height="25" align="left" valign="middle"><a title="Clique aqui" href="comunicado.php">&bull; Comunicado externo</a></td>
	</tr>
	<?
	}
	?>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="lista_comunicado_franquia.php">&bull; Comunicados Enviados</a></td>
</tr>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="treino_video.php">&bull; Vídeo de Treinamento</a></td>
</tr>
<?
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
	if($safpostal_id_empresa=="1" and $permissao=='TRUE'){?>
<tr>
<td height="25" align="left" valign="middle" bgcolor="#95D8FF"><strong>Expansão</strong></td>
</tr>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="novos-interessados.php">&bull; Novos Interessados</a></td>
</tr>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="direcionamento.php">&bull; Direcionamento</a></td>
</tr>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="interessados.php">&bull; Interessados</a></td>
</tr>
<? } ?>
<tr>
<td height="25" align="left" valign="middle" bgcolor="#95D8FF"><strong>Rede de Franqueados</strong></td>
</tr>
<tr>
<td height="25" align="left" valign="middle"><a title="Clique aqui" href="rede_franqueada.php">&bull; Lista</a></td>
</tr>
</table>
</td>
</tr>
</table>