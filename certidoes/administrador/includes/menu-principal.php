<ul id="navigation-1">
	<li><a href="#" title="Menu cadastro"><img src="../images/paginas/bt-cadastro.jpg" alt="bt-cadastro" /></a>
		<ul class="navigation-2">
			<?
			$permissao = verifica_permissao('diretor',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="usuario-add.php" title="Clique aqui">Administrador</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('news',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="news-add.php" title="Clique aqui">Notícias</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('treinadores',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="treinadores-add.php" title="Cadastro de imagens">Treinadores</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('rh',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="area-pretendida-add.php" title="Clique aqui">Oportunidades</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('galeria_imagens',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="categoria-imagem-add.php" title="Clique aqui">Imagens</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('galeria_videos',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="categoria-video-add.php" title="Clique aqui">Vídeo</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="produtos-add.php" title="Clique aqui">Hotsite</a></li>
			<?
			}
			?>
		</ul>
	</li>
	<li><a href="#" title="Menu consulta"><img src="../images/paginas/bt-consulta.jpg" alt="bt-consulta" /></a>
		<ul class="navigation-2">
			<?
			$permissao = verifica_permissao('diretor',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="usuario-list.php" title="Clique aqui">Administrador</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('news',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="news-list.php" title="Clique aqui">Notícias</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('depoimento',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="depoimento-list.php" title="Clique aqui">Depoimentos</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('unidades',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="unidades-list.php" title="Cadastro de unidades">Unidades</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('treinadores',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="treinadores-list.php" title="Cadastro de treinadores">Treinadores</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('rh',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="area-pretendida-list.php" title="Clique aqui">Oportunidades</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('galeria_imagens',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="categoria-imagem-list.php" title="Clique aqui">Imagens</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('galeria_videos',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="categoria-video-list.php" title="Clique aqui">Vídeo</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
			<li><a href="produtos-list.php" title="Clique aqui">Hotsite</a></li>
			<?
			}
			?>
		</ul>
	</li>
	<li><a href="#" title="Alteração do seus dados"><img src="../images/paginas/bt-meus-dados.jpg" alt="bt-meus-dados" /></a>
		<ul class="navigation-2">
			<li><a href="alterar-senha.php" title="Clique aqui">Alterar senha</a></li>
		</ul>
	</li>
	<li><a href="#" title="Entre em contato conosco"><img src="../images/paginas/bt-suporte.jpg" alt="bt-suporte" /></a>
		<ul class="navigation-2">
			<li><a href="suporte.php" title="Clique aqui">Suporte</a></li>
		</ul>
	</li>
	<li><a href="sair.php" title="Sair do sistema"><img src="../images/paginas/bt-sair.jpg" alt="bt-sair" /></a></li>
</ul>