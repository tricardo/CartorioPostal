<div id="menu_add">
	<ul>
		<?if($pg=='administrador'){?>
			<?
			$permissao = verifica_permissao('lista_usuario',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="usuario-list.php" title="Clique aqui" class="link_main_menu">Usuário</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_permissao',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="permissao-list.php" title="Clique aqui" class="link_main_menu">Permissão</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_keyword',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="meta-tag-list.php" title="Clique aqui" class="link_main_menu">Palavra chave</a></li>
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
			$permissao = verifica_permissao('lista_news',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="news-list.php" title="Clique aqui" class="link_main_menu">Notícias</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_comentario',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="comentario-news-list.php" title="Clique aqui" class="link_main_menu">Comentários</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='depoimento'){?>
			<?
			$permissao = verifica_permissao('lista_depoimento',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="depoimento-list.php" title="Clique aqui" class="link_main_menu">Depoimentos</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
	<ul>
		<?if($pg=='unidades'){?>
			<?
			$permissao = verifica_permissao('lista_unidades',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="unidades-list.php" title="Clique aqui" class="link_main_menu">Unidades</a></li>
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
			$permissao = verifica_permissao('lista_treinadores',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="treinadores-list.php" title="Clique aqui" class="link_main_menu">Treinadores</a></li>
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
			$permissao = verifica_permissao('lista_area_pretendida',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="area-pretendida-list.php" title="Clique aqui" class="link_main_menu">Departamento</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_candidatos',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="candidatos-list.php" title="Clique aqui" class="link_main_menu">Candidatos</a></li>
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
			$permissao = verifica_permissao('lista_categoria_videos',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="categoria-video-list.php" title="Clique aqui" class="link_main_menu">Categoria</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_videos',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="video-list.php" title="Clique aqui" class="link_main_menu">Vídeo</a></li>
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
			$permissao = verifica_permissao('lista_categoria_imagens',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="categoria-imagem-list.php" title="Clique aqui" class="link_main_menu">Categoria</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_imagens',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="imagem-list.php" title="Clique aqui" class="link_main_menu">Imagem</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_fachada',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="fachada-list.php" title="Clique aqui" class="link_main_menu">Fachada</a></li>
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
			$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="produtos-list.php" title="Clique aqui" class="link_main_menu">Produtos</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="parcerias-list.php" title="Clique aqui" class="link_main_menu">Parcerias</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="banners-list.php" title="Clique aqui" class="link_main_menu">Banners</a></li>
			<?
			}
			?>
			<?
			$permissao = verifica_permissao('lista_hotsite',$controle_permissao_p,$controle_permissao_s);
			if($permissao == 'TRUE'){
			?>
				<li><a href="analytics-list.php" title="Clique aqui" class="link_main_menu">Analytics</a></li>
			<?
			}
			?>
			<li></li><li></li><li></li><li></li><li></li><li></li>
		<?
		}
		?>
	</ul>
</div>