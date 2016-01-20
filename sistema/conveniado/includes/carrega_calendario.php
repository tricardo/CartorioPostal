<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../../includes/funcoes.php" );
require( "../../includes/global.inc.php" );
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
$diasemana = date("w", mktime(0,0,0,$month,1,$year) );
?>
<table border="0" cellspacing="0" cellpadding="0" style="font-size:10px; font-family:Verdana; text-align:center; background-color:#FFFFFF;">
  <tr>
    <td height="25" colspan="8" style="text-align:right"><a href="#" onclick="javascript:document.getElementById('calendario').style.display='none';" style="color:#4070D0; font-size:10px;">fechar X</a>&nbsp;</td>
  </tr>
  <tr style="font-weight:bold; background-color:#6098F0; color:#FFFFFF">
    <td height="25"><?
    if($year >= 2009){ 
		$m = 1;
		if($month > 1){
			$m = $month - 1;
		}	
		echo '<img src="images/seta1.png" style="cursor:pointer; height:12px" onclick="TrocaDataCalendario(1, \''.$cp.'\', '.$m.', '.$year.')" />';
	}
    ?></td>
    <td colspan="6" style="font-weight:bold"><select class="style4" style="width:80px;" id="_calendario_mes" onchange="TrocaDataCalendario(1, '<?=$cp?>', this.value, <?=$year?>)">
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
        </select> <select class="style4" id="_calendario_ano" style="width:50px; margin-left:10px;" onchange="TrocaDataCalendario(2, '<?=$cp?>', this.value, <?=$month?>)">
            <? for($i = 2009; $i <= (date('Y')+1); $i++){?>
                <option value="<?=$i?>" <? if($i == $year){?> selected="selected" <? }?>><?=$i?></option>
            <? }?>
        </select></td>
    <td><?
    if($year >= (date('Y')-1)) 
		$m = 12;
		if($month < 12){
			$m = $month + 1;
		}	
		echo '<img src="images/seta2.png" style="cursor:pointer; height:12px" onclick="TrocaDataCalendario(1, \''.$cp.'\', '.$m.', '.$year.')" />';
    ?></td>
  </tr>
  <tr style="font-weight:bold;">
    <td class="style11 style12" style="border-right:2px solid #4070D0">&nbsp;</td>
    <td width="25" bgcolor="#E2E2E2" class="style11 style12" style="border-left:none;">D</td>
    <td width="25" class="style11 style12" style="border-left:none;">S</td>
    <td width="25" class="style11 style12" style="border-left:none;">T</td>
    <td width="25" class="style11 style12" style="border-left:none;">Q</td>
    <td width="25" class="style11 style12" style="border-left:none;">Q</td>
    <td width="25" class="style11 style12" style="border-left:none;">S</td>
    <td width="25" bgcolor="#E2E2E2" class="style11 style12" style="border-left:none;">S</td>
  </tr>
  <?
  $mes = (int)$mes;
  switch($mes){
  	case 2:
		$max = 28;
		if(($ano%4) == 0){
			$max = 29;
		}
		break;
	case 1: 
	case 3: 
	case 5:  
	case 7: 
	case 8: 
	case 10: 
	case 12:
		$max = 31;
		break;
	default:
		$max = 30;
  }
  $j = 0; 
  $k = 0;
  $cor2 = '#6699CC';  
  for($i = 1; $i < 7; $i++){
  	if($j <= $max){
		echo '<tr>' . " \n";
		
		$year_week = (int) date('W', mktime(0,0,0,$month,($j+2),$year));
		
		$s = (int)$year_week;
		if($year_week < 10){
			$s = '0'.$year_week;
		}
		
		echo '<td bgcolor="#6098F0" class="style3" style="border-left:solid 1px #6699CC; border-right:solid 2px #4070D0">'.$s.'</td>' . " \n";
		$year_week++;
		
		$cor = '#E2E2E2';
		$prt = ($j + 1);
		if($diasemana == $k && $j < $max){
			if($day == ($j+1) && $month == date('n') && $year == date('Y')){ 
				$prt = '<span style="font-weight:bold">'.($j+1) .'</span>' . " \n";
				$cor = $cor2;
			}
			echo '<td bgcolor="'.$cor.'" class="style5" ';
			echo 'onmouseover="this.style.backgroundColor=\'#FFCC00\'" onmouseout="this.style.backgroundColor=\''.$cor.'\'"';
			echo 'onclick="CarregaCalendario(\''.$cp.'\','.($j+1).','.$year.','.$month.');" style="cursor:pointer;" ';
			echo '>'.$prt.'</td>' . " \n";
			$j++;
		} else { $k++; echo '<td bgcolor="'.$cor.'" class="style3">&nbsp;</td>' . " \n"; }
		
		for($w = 1; $w < 6; $w++){
			$cor = '#FFF';
			$prt = ($j + 1);
			if($diasemana == $k && $j < $max){
				if($day == ($j+1) && $month == date('n') && $year == date('Y')){ 
					$prt = '<span style="font-weight:bold">'.($j+1) .'</span>' . " \n";
					$cor = $cor2;
				}
				echo '<td bgcolor="'.$cor.'" class="style3" ';
				echo 'onmouseover="this.style.backgroundColor=\'#FFCC00\'" onmouseout="this.style.backgroundColor=\''.$cor.'\'"';
				echo 'onclick="CarregaCalendario(\''.$cp.'\','.($j+1).','.$year.','.$month.');" ';
				if($w == 1){
					echo 'style="cursor:pointer; border-left:none;" ';			
				} else {
					echo 'style="cursor:pointer;" ';			
				}
				echo '>'.$prt.'</td>';
				$j++;
			} else { $k++; echo '<td bgcolor="'.$cor.'" class="style3">&nbsp;</td>' . " \n"; }
		}
		
		$cor = '#E2E2E2';
		$prt = ($j + 1);
		if($diasemana == $k && $j < $max){
			if($day == ($j+1) && $month == date('n') && $year == date('Y')){ 
				$prt = '<span style="font-weight:bold">'.($j+1) .'</span>' . " \n";
				$cor = $cor2;
			}
			echo '<td bgcolor="'.$cor.'" class="style5" ';
			echo 'onmouseover="this.style.backgroundColor=\'#FFCC00\'" onmouseout="this.style.backgroundColor=\''.$cor.'\'"';
			echo 'onclick="CarregaCalendario(\''.$cp.'\','.($j+1).','.$year.','.$month.');" style="cursor:pointer" ';
			echo '>'.$prt.'</td>' . " \n";
			$j++;
		} else { $k++; echo '<td bgcolor="'.$cor.'" class="style3">&nbsp;</td>' . " \n"; }
		echo ' </tr>' . " \n";
		
		if($j == $max){
			$i = 7;
		}
  	}
  }?>
</table>


