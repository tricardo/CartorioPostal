<?
$fat_pedido = $_SESSION['fat_pedido'];

$im="";
$cont=0;
unset($p_id_pedido_item);
if($fat_pedido){
	foreach ($fat_pedido as $l) {
		if($cont>0) $im.=',';
		$im .= "'".$l->id_pedido_item."'";
		$p_id_pedido_item[] = $l->id_pedido_item;
		$cont++;
	}
}

if($im<>''){
	$empresaDAO = new EmpresaDAO();
	$emp = $empresaDAO->selectPorId($controle_id_empresa);
	
	$lista = $financeiroDAO->listaPedidoIn2($im,$controle_id_empresa);
	$p_valor = '';
	if($lista[0]->id_pedido_item<>''){
		$id_fatura = $financeiroDAO->inserirFatura($controle_id_empresa,$controle_id_usuario,$_SESSION['fat_acao'],$_SESSION['fat_fatura']->retem_imposto);
		$cont=0;
		foreach($lista as $l){
			$busca_item = array_search($l->id_pedido_item, $p_id_pedido_item);
			#valor
			switch($_SESSION['fat_acao']){
				case 1:
					$valor = (float)($fat_pedido[$busca_item]->valor)+(float)($fat_pedido[$busca_item]->custa); 
					$custas = 0;
					break;
				case 2:
					$valor = (float)($fat_pedido[$busca_item]->valor)-(float)($fat_pedido[$busca_item]->custa);
					$custas = (float)($fat_pedido[$busca_item]->custa);
					break;
				case 4:
					$valor = (float)($fat_pedido[$busca_item]->valor);
					$custas = (float)($fat_pedido[$busca_item]->custa);
					break;
				default:
					$valor = $fat_pedido[$busca_item]->valor;
					$custas = 0;
			}
			
			$valor_t= (float)($valor_t)+(float)($valor);
			$valor_rec = (float)($valor_rec)+(float)($l->valor_rec);
			$valor_nota=(float)($valor_nota)+(float)($valor);
			$financeiroDAO->atualizaFaturaPedidoItem($l->id_pedido_item,$id_fatura,$fat_pedido[$busca_item]->valor,$fat_pedido[$busca_item]->custa);
			$p_valor .= '<div class="sucesso">Pedido #'.$l->id_pedido.'/'.$l->ordem.': Fatura gerada com sucesso.</div>';
			$cont++;
		}
	}

	if($_SESSION['fat_fatura']->boleto==0){
		$_SESSION['fat_fatura']->ocorrencia=1;
		if($_SESSION['fat_fatura']->retem_imposto<>''){
			$valor_t = (float)($valor_t)-(float)($valor_nota)/100*(float)($_SESSION['fat_fatura']->retem_imposto);
		}
		$valor_t=(float)($valor_t)+(float)($custas)-(float)($valor_rec);

		$_SESSION['fat_fatura']->valor=$valor_t;
		$_SESSION['fat_fatura']->vencimento=invert($_SESSION['fat_fatura']->vencimento,'-','SQL');
		$_SESSION['fat_fatura']->id_fatura=$id_fatura;
		if($valor_t>0)	$contaDAO->inserirBoletoBrad($_SESSION['fat_fatura'],$controle_id_empresa,$controle_id_usuario);
		else $p_valor .= '<div class="erro"><b>O boleto não foi gerado:</b> O valor do boleto não pode ser inferior a 0</div>';
	}
}	
echo '<br>';
unset( $_SESSION['fat_fatura'] );
unset( $_SESSION['fat_pedido'] );
unset( $_SESSION['fat_cpf'] );
unset( $_SESSION['fat_acao'] );
?>