<?$e = $dt->Lazer(); $arr = array(); $i = 0;?>
<div>
	<p>&nbsp;- LAZER</p>
	<div style="margin-left:10px;">
	<?foreach($e as $lz => $l){
		$arr[$i] = array(
			'id_lazer'=>$l->id_lazer,
			'lazer'=>$l->lazer
		); $i++;
	}
	if($submit1){
		$rel_lazer = $c->lazer;
	} else {
		$i = 1; $rel_lazer = array();
		$e = $dt->relFichaLazer($id);
		foreach($e as $lz => $l){ $rel_lazer[$i] = $l->id_lazer; $i++; }
	}
	$k = 0;
	for($i = 0; $i < count($arr); $i++){
		for($j = 1; $j <= 3; $j++){
			if($k < count($arr)){
				echo '<label style="width:25px;"><input ';
				echo 'style="display:inline-block; padding:0; margin:0" class="form_estilo" ';
				echo 'value="'.$arr[$k]['id_lazer'].'" ';
				echo 'name="lazer[]" id="lazer'.$k.'" type="checkbox" ';
				if($rel_lazer){
					if(strlen(array_search($arr[$k]['id_lazer'], $rel_lazer)) > 0){
						echo 'checked="checked" ';
					}
				}
				echo '/></label>'. "\n";
				echo '<label style="width:220px;" for="lazer'.$k.'">'.$arr[$k]['lazer'] .'</label>'. "\n";
				$k++;
			}
	}}?>
	</div>
	<label style="width:758px;">&nbsp;</label>
</div>		