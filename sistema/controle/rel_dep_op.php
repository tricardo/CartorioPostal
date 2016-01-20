<?
require('header.php');
require('../includes/dias_uteis.php');
?>
<div id="topo">
<?
$permissao = verifica_permissao('Rel_n_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$usuarioDAO = new UsuarioDAO();

$busca_data_f_co = date('Y/m/d');
$busca_data_i_co = date('Y/m/d');
?>
    <h1 class="tit"><img src="../images/tit/tit_rel.png" alt="Título" /> Relatório Operacional</h1>
    <hr class="tit"/><br />
</div>
<div id="meio">
    <form name="buscador" action="gera_operacional_conc.php" target="_blank" method="post" ENCTYPE="multipart/form-data">
		<div style="float:left">
			<img src="../images/lupa.png" alt="busca" />
        </div>
        <div style="width:400px; float:left;">
            <strong>Conc. Oper.: </strong>
            <input type="text" name="busca_data_i_co" value="<? if($busca_data_i_co <> '') echo invert($busca_data_i_co,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />
            <strong>e </strong>
            <input type="text" name="busca_data_f_co"  value="<?  if($busca_data_f_co <> '') echo invert($busca_data_f_co,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />
            (máximo de 31 dias)
			<?
			if($controle_id_empresa=='1'){
				?>
				<br/></br><strong>Cliente: </strong>
				<select name="id_conveniado" style="width:200px;" class="form_estilo">
                <option value="">Todos</option>
				<option value="635">HSBC (Processos Judiciais)</option>
				<option value="-635">Exceto HSBC</option>
				</select>				
			<?
			}
			?>
			<?php if(in_array(9,explode(',',$controle_id_departamento_s))
					|| in_array(3,explode(',',$controle_id_departamento_s))
					|| in_array(5,explode(',',$controle_id_departamento_s))
					|| in_array(8,explode(',',$controle_id_departamento_s))
					|| in_array(6,explode(',',$controle_id_departamento_s))){
			 $usuarios = $usuarioDAO->listarPorDepartamentoEmpresa($controle_id_empresa,array(3,4,5,8,9,15))	?>
				<br/><strong>Usuário: </strong>
				<select name="id_usuario" style="width:200px;" class="form_estilo">
                <option value="">Todos</option>
				<?php foreach($usuarios as $u){ ?>
					<option value="<?php echo $u->id_usuario ?>"><?php echo $u->nome?></option>
				<?php } ?>
				</select>
			<?php } ?>
			<input type="submit" name="submit" class="button_busca" value=" Buscar " /><br><br>
        </div>
	</form><br />
	<br />
</div>
<?php 
	require('footer.php');
?>