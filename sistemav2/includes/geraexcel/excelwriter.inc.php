<?php

     /*
     ###############################################
     ####                                       ####
     ####    Author : Harish Chauhan            ####
     ####    Date   : 31 Dec,2004               ####
     ####    Updated:                           ####
     ####                                       ####
     ###############################################

     */


     /*
     * Class is used for save the data into microsoft excel format.
     * It takes data into array or you can write data column vise.
     */


Class ExcelWriter{

   var $fp=null;
    var $error;
    var $state="CLOSED";
    var $newRow=false;

    /*
    * @Params : $file  : file name of excel file to be created.
    * @Return : On Success Valid File Pointer to file
    *             On Failure return false
    */
    function ExcelWriter($file="",$bsc="CELLPAR"){
        return $this->open($file);
    }

    /*
    * @Params : $file  : file name of excel file to be created.
    *                if you are using file name with directory i.e. test/myFile.xls
    *                then the directory must be existed on the system and have permissioned properly
    *                to write the file.
    * @Return : On Success Valid File Pointer to file
    *                On Failure return false
    */
    function open($file){
        if($this->state!="CLOSED"){
            $this->error="Error : Outro arquivo está aberto .Feche-o para salvar o arquivo";
            return false;
        }

        if(!empty($file)){
           $this->fp=@fopen($file,"w+");
        }else{
           $this->error="Usage : New ExcelWriter('fileName')";
            return false;
        }

      if($this->fp==false){
         $this->error="Error: Unable to open/create File.You may not have permmsion to write the file.";
            return false;
      }
        $this->state="OPENED";
        fwrite($this->fp,$this->GetHeader());
        return $this->fp;
   }

    function close(){
       if($this->state!="OPENED"){
          $this->error="Error : Please open the file.";
            return false;
       }
        if($this->newRow){
           fwrite($this->fp,"</tr>");
            $this->newRow=false;
        }
        fwrite($this->fp,$this->GetFooter());
        fclose($this->fp);
        $this->state="CLOSED";
        return;
    }



		/* @Params : Void
        *  @return : Void
        * This function write the header of Excel file.
        */
   function GetHeader(){
        $header = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 11">
<link rel=File-List href="exporta_1(6)_arquivos/filelist.xml">
<link rel=Edit-Time-Data href="exporta_1(6)_arquivos/editdata.mso">
<link rel=OLE-Object-Data href="exporta_1(6)_arquivos/oledata.mso">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:LastAuthor>admin</o:LastAuthor>
  <o:LastSaved>2009-12-24T22:55:05Z</o:LastSaved>
  <o:Version>11.9999</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:DownloadComponents/>
  <o:LocationOfComponents HRef="file:///C:\Users\admin\AppData\Local\Temp\RarSFX0\"/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<style>
<!--table
	{mso-displayed-decimal-separator:"\,";
	mso-displayed-thousand-separator:"\.";}
@page
	{margin:1.0in .75in 1.0in .75in;
	mso-header-margin:.5in;
	mso-footer-margin:.5in;}
tr
	{mso-height-source:auto;}
col
	{mso-width-source:auto;}
br
	{mso-data-placement:same-cell;}
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	border:none;
	mso-protection:locked visible;
	mso-style-name:Normal;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
.xl24
	{mso-style-parent:style0;
	font-family:"Arial Unicode MS";
	mso-generic-font-family:auto;
	mso-font-charset:0;}

.xl25
	{mso-style-parent:style0;
	font-family:"Arial Unicode MS";
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:0;}
	
.xl26
	{mso-style-parent:style0;
	font-family:"Arial Unicode MS";
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:"Short Date";}

-->
</style>
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>NOME_PLANILHA</x:Name>
    <x:WorksheetOptions>
     <x:Print>
      <x:ValidPrinterInfo/>
      <x:PaperSizeIndex>9</x:PaperSizeIndex>
      <x:HorizontalResolution>600</x:HorizontalResolution>
      <x:VerticalResolution>0</x:VerticalResolution>
     </x:Print>
     <x:Selected/>
     <x:Panes>
      <x:Pane>
       <x:Number>3</x:Number>
       <x:ActiveRow>1</x:ActiveRow>
       <x:ActiveCol>6</x:ActiveCol>
      </x:Pane>
     </x:Panes>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>9240</x:WindowHeight>
  <x:WindowWidth>10005</x:WindowWidth>
  <x:WindowTopX>120</x:WindowTopX>
  <x:WindowTopY>135</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->
</head>

<body link=blue vlink=purple>

<table x:str border=0 cellpadding=0 cellspacing=0 width=1031 style=\'border-collapse:
 collapse;table-layout:fixed;width:773pt\'>';
            return $header;
   }

    function GetFooter(){
       return "</table></body></html>";
    }

    /*
    * @Params : $line_arr: An valid array
    * @Return : Void
    */

    function writeLine($line_arr){
       if($this->state!="OPENED"){
          $this->error="Error : Please open the file.";
            return false;
       }
        if(!is_array($line_arr)){
           $this->error="Error : Argument is not valid. Supply an valid Array.";
            return false;
        }
        fwrite($this->fp,"<tr>");

        foreach($line_arr as $col){
			
			if(is_numeric(str_replace(',','.',$col))==1) {
				if(strlen($col)>11) $tipo = ' class=xl25 align=right x:num="'.str_replace(',','.',$col).'"';
				else $tipo = ' class=xl24 align=right x:num="'.str_replace(',','.',$col).'"';
			} else {
				if($data=ValidaData($col)==1){
					$tipo = ' class=xl26 ';
				}else{
					$tipo = ' class=xl24 ';
				}
			}	
			fwrite($this->fp,"<td ".$tipo.">".$col."</td>");
        }
		fwrite($this->fp,"</tr>");
    }

    /*
    * @Params : Void
    * @Return : Void
    */
    function writeRow(){
      if($this->state!="OPENED"){
          $this->error="Error : Please open the file.";
            return false;
       }
       if($this->newRow==false){
         fwrite($this->fp,"<tr>");
       }else{
           fwrite($this->fp,"</tr><tr>");
            $this->newRow=true;
        }
   }

    /*
    * @Params : $value : Coloumn Value
    * @Return : Void
    */
    function writeCol($value){
       if($this->state!="OPENED"){
          $this->error="Error : Please open the file.";
            return false;
       }
	   fwrite($this->fp,"<td class=xl24 width=64>".$value."</td>");
    }
}

?>