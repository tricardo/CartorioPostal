<?php
require("includes/verifica_logado_controle.inc.php");

$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao_admin = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
$errors=0;
$campos='';
$msgbox='';
$show_msgbox = 1; 

