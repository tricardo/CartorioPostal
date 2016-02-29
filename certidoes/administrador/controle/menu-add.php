<div id="menu_add">
	<ul>
		<?if($pg=='administrador'){?>
			<?
			$permissao = verifica_permissao('cadastro_usuarios',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="usuario-add.php" title="Clique aqui" class="link_main_menu">Usuário</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('cadastro_permissao',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="permissao-add.php" title="Clique aqui" class="link_main_menu">Permissão</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('cadastro_keyword',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="meta-tag-add.php" title="Clique aqui" class="link_main_menu">Palavra chave</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='news'){?>
			<?
			$permissao = verifica_permissao('cadastro_news',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="news-add.php" title="Clique aqui" class="link_main_menu">Notícias</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='treinadores'){?>
			<?
			$permissao = verifica_permissao('cadastro_treinadores',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="treinadores-add.php" title="Clique aqui" class="link_main_menu">Treinadores</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='rh'){?>
			<?
			$permissao = verifica_permissao('cadastro_area_pretendida',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="area-pretendida-add.php" title="Clique aqui" class="link_main_menu">Departamento</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='galeria_videos'){?>
			<?
			$permissao = verifica_permissao('cadastro_categoria_videos',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="categoria-video-add.php" title="Clique aqui" class="link_main_menu">Categoria</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('cadastro_videos',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="video-add.php" title="Clique aqui" class="link_main_menu">Vídeo</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='galeria_imagens'){?>
			<?
			$permissao = verifica_permissao('cadastro_categoria_imagens',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="categoria-imagem-add.php" title="Clique aqui" class="link_main_menu">Categoria</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('cadastro_imagens',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="imagem-add.php" title="Clique aqui" class="link_main_menu">Imagem</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='hotsite'){?>
			<?
			$permissao = verifica_permissao('cadastro_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="produtos-add.php" title="Clique aqui" class="link_main_menu">Produtos</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('cadastro_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="parcerias-add.php" title="Clique aqui" class="link_main_menu">Parcerias</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('cadastro_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="banners-add.php" title="Clique aqui" class="link_main_menu">Banners</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('cadastro_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="analytics-add.php" title="Clique aqui" class="link_main_menu">Analytics</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
</div>