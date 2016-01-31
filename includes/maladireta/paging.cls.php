<?php 

/*--------------------------------------------------+
|													 |
| Copyright © 2008 http://www.yadog.net/      |
| All Rights Reserved.								 |
| Email: adm@yadog.net                    |
|                                                    |
+---------------------------------------------------*/



?><?php
/*

 "paging.cls.php" this file is a class used to disaply result in different pages in case of there we have results that we ca't include in one page
  All rights reserved and all the rights of the file and script goes to Jacob Baby[jacobbbc@yahoo.co.in] only.
  
  Created on:13/05/2006
  Modified on:13/05/2006
  
*/


/*

Funtion HELP

 */

class paging
{
	 
	function page($total,$perpage,$pagenumber="",$linkformat="",$linkstyle="")
	{	
 		
		$out="";
		if($total>$perpage){
		
		if($linkformat==""){
		$linkformat=$_SERVER['PHP_SELF']; $linkformat.="?";}
		else{
		if(substr_count($linkformat,"?")>0) $linkformat.="&"; else $linkformat.="?";}
		
		if($pagenumber=="")
		 if(isset($_REQUEST['page']))
		  $pagenumber=$_REQUEST['page'];
		 else
		 $pagenumber=1;
		 $lastpage=$total/$perpage;
		 if($total%pagecount!=0)
		 $lastpage+=1;
		 if($linkstyle!="") $linkstyle="class=\"".$linkstyle."\"";
		// echo $pagenumber;
		 if($pagenumber>=2)
		 $out.="<a href=\"$linkformat"."page=".($pagenumber-1)."\" $linkstyle >"."&lt;&lt; Previous"."</a>&nbsp;&nbsp;";

		for($i=0;$i<($total/$perpage);$i++){
		if($pagenumber==($i+1))
		$out.=($i+1)."&nbsp;&nbsp;";
		else
		 $out.="<a href=\"$linkformat"."page=".($i+1)."\"$linkstyle  >".($i+1)."</a>&nbsp;&nbsp;";
		}
		if(($total%pagecount)!=0){
		if($pagenumber==($i+1))
		$out.=($i+1)."&nbsp;&nbsp;";
		else
		$out.="<a href=\"$linkformat"."page=".($i+1)."\">".($i+1)." $linkstyle  </a>&nbsp;&nbsp;";
		}
	 if($pagenumber<$lastpage)
	 $out.="<a href=\"$linkformat"."page=".($pagenumber+1)."\" $linkstyle >"."Next &gt;&gt;"."</a> ";
	  }
		 return $out;

	}
}
?>
