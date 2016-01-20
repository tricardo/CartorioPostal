<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_safpostal.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','cp');
pt_register('GET','ano');
pt_register('GET','mes');

$year      = date('Y');
if($ano){
	$year = $ano;
}
$month     = date('n');
if($mes){
	$month = $mes;
}
$day       = date('j');
$year_week = date('W', mktime(0,0,0,$month,1,$year));
$week      = date('w');

$diasemana = date("w", mktime(0,0,0,$month,1,$year) );
?>
<table border="0" cellspacing="0" cellpadding="0" style="font-size:10px; font-family:Verdana; text-align:center; background-color:#FFFFFF;">
  <tr>
    <td height="25" colspan="8" style="text-align:right"><a href="#" onclick="javascript:document.getElementById('calendario').style.display='none';" style="color:#0071B6">fechar X</a>&nbsp;</td>
  </tr>
  <tr style="font-weight:bold; background-color:#0071B6; color:#FFFFFF">
    <td height="25"><?
    if($year >= (date('Y')-1)){ 
		$m = 1;
		if($month > 1){
			$m = $month - 1;
		}	
		echo '<strong><a href="#" onclick="TrocaDataCalendario(1, \''.$cp.'\', '.$m.', '.$year.')"><<</strong>';
	}
    ?></td>
    <td colspan="6"style="font-weight:bold"><select class="style4" style="width:80px;" id="_calendario_mes" onchange="TrocaDataCalendario(1, '<?=$cp?>', this.value, <?=$year?>)">
		<option value="1" <? if($month == 1){?> selected="selected"<? }?>>Janeiro</option>
        <option value="2" <? if($month == 2){?> selected="selected"<? }?>>Fevereiro</option>
        <option value="3" <? if($month == 3){?> selected="selected"<? }?>>Março</option>
        <option value="4" <? if($month == 4){?> selected="selected"<? }?>>Abril</option>
        <option value="5" <? if($month == 5){?> selected="selected"<? }?>>Maio</option>
        <option value="6" <? if($month == 6){?> selected="selected"<? }?>>Junho</option>
        <option value="7" <? if($month == 7){?> selected="selected"<? }?>>Julho</option>
        <option value="8" <? if($month == 8){?> selected="selected"<? }?>>Agosto</option>
        <option value="9" <? if($month == 9){?> selected="selected"<? }?>>Setembro</option>
        <option value="10" <? if($month == 10){?> selected="selected"<? }?>>Outubro</option>
        <option value="11" <? if($month == 11){?> selected="selected"<? }?>>Novembro</option>
        <option value="12" <? if($month == 12){?> selected="selected"<? }?>>Dezembro</option>
        </select> / <select class="style4" id="_calendario_ano" style="width:50px;" onchange="TrocaDataCalendario(2, '<?=$cp?>', this.value, <?=$month?>)">
            <? for($i = (date('Y') - 1); $i <= (date('Y')+1); $i++){?>
                <option value="<?=$i?>" <? if($i == $year){?> selected="selected" <? }?>><?=$i?></option>
            <? }?>
        </select></td>
    <td><?
    if($year >= (date('Y')-1)) 
		$m = 12;
		if($month < 12){
			$m = $month + 1;
		}	
		echo '<strong><a href="#" onclick="TrocaDataCalendario(1, \''.$cp.'\', '.$m.', '.$year.')">>></strong>';
    ?></td>
  </tr>
  <tr style="font-weight:bold;">
    <td class="style1 style2"></td>
    <td bgcolor="#CCCCCC" class="style1 style2" style="border-left:none;">D</td>
    <td class="style1 style2" style="border-left:none;">S</td>
    <td class="style1 style2" style="border-left:none;">T</td>
    <td class="style1 style2" style="border-left:none;">Q</td>
    <td class="style1 style2" style="border-left:none;">Q</td>
    <td class="style1 style2" style="border-left:none;">S</td>
    <td bgcolor="#CCCCCC" class="style1 style2" style="border-left:none;">S</td>
  </tr>
  <?
  switch($mes){
  	case 2:
		$max = 28;
		if(($ano%4) == 0){
			$max = 29;
		}
		break;
	case 1 || 3 || 5 || 7 || 8 || 10 || 12:
		$max = 31;
		break;
	default:
		$max = 30;
  }
  
  $j = 0; 
  $k = 0;
  $cor2 = '#999';  
  for($i = 1; $i < 7; $i++){
  	if($j <= $max){
		echo '<tr>';
		echo '<td bgcolor="#0071B6" class="style3" style="border-left:solid 1px #999">'.$year_week.'</td>';
		$year_week++;
		
		$cor = '#CCC';
		$prt = ($j + 1);
		if($diasemana == $k && $j < $max){
			if($day == ($j+1) && $month == date('n') && $year == date('Y')){ 
				$prt = '<span style="font-weight:bold">'.($j+1) .'</span>';
				$cor = $cor2;
			}
			echo '<td bgcolor="'.$cor.'" class="style3" ';
			echo 'onmouseover="this.style.backgroundColor=\'#FFCC66\'" onmouseout="this.style.backgroundColor=\''.$cor.'\'"';
			echo 'onclick="CarregaCalendario(\''.$cp.'\','.($j+1).','.$year.','.$month.');" style="cursor:pointer" ';
			echo '>'.$prt.'</td>';
			$j++;
		} else { $k++; echo '<td bgcolor="'.$cor.'" class="style3">&nbsp;</td>'; }
		
		for($w = 1; $w < 6; $w++){
			$cor = '#FFF';
			$prt = ($j + 1);
			if($diasemana == $k && $j < $max){
				if($day == ($j+1) && $month == date('n') && $year == date('Y')){ 
					$prt = '<span style="font-weight:bold">'.($j+1) .'</span>';
					$cor = $cor2;
				}
				echo '<td bgcolor="'.$cor.'" class="style3" ';
				echo 'onmouseover="this.style.backgroundColor=\'#FFCC66\'" onmouseout="this.style.backgroundColor=\''.$cor.'\'"';
				echo 'onclick="CarregaCalendario(\''.$cp.'\','.($j+1).','.$year.','.$month.');" style="cursor:pointer" ';
				echo '>'.$prt.'</td>';
				$j++;
			} else { $k++; echo '<td bgcolor="'.$cor.'" class="style3">&nbsp;</td>'; }
		}
		
		$cor = '#CCC';
		$prt = ($j + 1);
		if($diasemana == $k && $j < $max){
			if($day == ($j+1) && $month == date('n') && $year == date('Y')){ 
				$prt = '<span style="font-weight:bold">'.($j+1) .'</span>';
				$cor = $cor2;
			}
			echo '<td bgcolor="'.$cor.'" class="style3" ';
			echo 'onmouseover="this.style.backgroundColor=\'#FFCC66\'" onmouseout="this.style.backgroundColor=\''.$cor.'\'"';
			echo 'onclick="CarregaCalendario(\''.$cp.'\','.($j+1).','.$year.','.$month.');" style="cursor:pointer" ';
			echo '>'.$prt.'</td>';
			$j++;
		} else { $k++; echo '<td bgcolor="'.$cor.'" class="style3">&nbsp;</td>'; }
		echo ' </tr>';
		
		if($j == $max){
			$i = 7;
		}
  	}
  }?>
</table>


