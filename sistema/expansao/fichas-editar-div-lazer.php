<table style="width:100%;border:none">
<? $dt = $expansao->lazer(); $i = 0;
foreach($dt as $lz => $l){
		$arr[$i] = array(
		'id_lazer'=>$l->id_lazer,
		'lazer'=>$l->lazer
	); $i++;
}

if($c->acao_btn == 'cadastro'){
	$rel_lazer = $c->lazer;
} else {
	$i = 1; $rel_lazer = array();
	$e = $expansao->relFichaLazer($c->id_ficha);
	foreach($e as $lz => $l){ $rel_lazer[$i] = $l->id_lazer; $i++; }
}

$k = 0;
for($i = 0; $i < count($arr); $i++){
	echo "\t\t<tr>\n";
	for($j = 1; $j <= 3; $j++){
		if($k < count($arr)){
			echo "\t\t\t<td style=\"width:20px\">";
			echo '<input ';
			echo 'style="padding:0; margin:0" class="form_estilo" ';
			echo 'value="'.$arr[$k]['id_lazer'].'" ';
			echo 'name="lazer[]" id="lazer'.$k.'" type="checkbox" ';
			if($rel_lazer){
				if(strlen(array_search($arr[$k]['id_lazer'], $rel_lazer)) > 0){
					echo 'checked="checked" ';
				}
			}
			echo '/></td>'. "\n";
			echo '<td>'.$arr[$k]['lazer'] .'</td>'. "\n";
			$k++;
		} else {
			echo "\t\t\t<td></td><td></td>";
		}
	}
	echo "\t\t</tr>\n";
}
?>
</table>