<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<div id="rodape">
	<div style="background-color:<?=$_SESSION['backGroundColor1']?>" class="backCor3"></div>
    <div style="background-color:<?=$_SESSION['backGroundColor2']?>" id="rodape_conteudo">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="29%" rowspan="2" align="left" valign="middle" class="style1">
				<div style="margin-left:10px; color:<?=$_SESSION['color']?>">
                <!--
                <span style="font-size:14px;">DESENVOLVIDO POR</span><br />
            	<span style="font-size:10px;">CANAL DOS PROFISSIONAIS</span>-->
                <img src="images/softfox.png" /></div></td>
            <td width="44%" rowspan="2" align="left" valign="middle" class="style1"><div align="center" style="font-size:20px;">Post Office</div></td>
            <td align="right"><img src="images/marca_cartorio_postal.png" style="margin-right:10px; margin-top:5px;" alt="Cartório Postal" /></td>
          </tr>
          <tr>
            <td align="right" width="27%">
            	<div style="font-size:8px; margin-top:2px; font-weight:bold; color:<?=$_SESSION['backGroundColor1']?>; width:170px; text-align:center; margin-right:2px;">
                EMPRESA PRIVADA DE SERVIÇOS DE<br />
				INTERMEDIAÇÃO CARTORÁRIA</div>            </td>
          </tr>
        </table>
  </div>
</div>
<div class="box_ativa round" id="box_news" style="width:350px; height:200px; border:5px solid <?=$_SESSION['backGroundColor1']?>; position:fixed; top:28%; left:20%; background-color:white;">
	<?
	$cor = '#FF0000';
    if($_SESSION['backGroundColor1'] != '#FFF' || $_SESSION['backGroundColor1'] != '#FFFFFF'){
		$cor = $_SESSION['backGroundColor1'];
	}?>
    <div class="ba_tit" style="background-color:<?=$_SESSION['backGroundColor2']?>">
        <span style="float: right; cursor: pointer; color:<?=$cor?>; font-weight:bold;" onclick="$('#box_news').hide();" class="hb_tit">X</span>
        <span class="hb_tit" style="font-weight:bold; color:<?=$cor?>;">ERRO!</span></div>
        <div class="ba_box" style="color:#CC0000; margin:10px; text-align:left; font-weight:bold;" id="erro"></div>
        <div onclick="$('#box_news').hide();" style="cursor:pointer; margin-left:20px; width:30px; text-align:center; background-color:<?=$_SESSION['backGroundColor2']?>; border:solid 2px <?=$_SESSION['backGroundColor1']?>"><p style="margin-top:5px; margin-bottom:5px; font-weight:bold; color:<?=$_SESSION['backGroundColor1']?>;">Ok!</p></div>
</div>
</body>
</html>