<?php
$largura=20;
$altura=3000;
$excelgrava = isset($excelgrava) ? $excelgrava : '';

    $workbook = & new Spreadsheet_Excel_Writer();

    //seta o nome do arquivo e coloca send para ir para download
	if($excelgrava=='')  $workbook->send($arquivo); else $workbook->Spreadsheet_Excel_Writer($arquivo);

    //estilos
    $stylebg = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1
            ));

    $styletitulo = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1
            ));

    $styletitulo2 = & $workbook->addFormat(array(
                'Size' => 14, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1
            ));

    $styletitulo3 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'silver', 'Align' => 'left', 'Bold' => 1,
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black'
            ));

    $styletitulo4 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1
            ));
			
    $styleleft = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 0,
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black'
            ));

    $stylecenter = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 0,
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1 , 'BorderColor' => 'black'
            ));

    $styleright = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'right',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 0,
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1 , 'BorderColor' => 'black'
            ));

    $styleright2 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'right',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 0
            ));
    
    $stylereal = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'right',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black', 'NumFormat' => '_*R$ #,##0.00'
            ));

    $style4 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1,
                'Top' => 2, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black'
            ));


    $style6 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1,
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black'
            ));

    $style7 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black', 'NumFormat' => '_*R$ #,##0.00'
            ));

    $style8 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Width' => 14,
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 2, 'BorderColor' => 'black'
            ));

    $style9 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'right',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 1, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black', 'NumFormat' => '_*R$ #,##0.00'
            ));

    $style10 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'right',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 1, 'Bottom' => 1, 'Left' => 2, 'Right' => 1, 'BorderColor' => 'black', 'NumFormat' => '_*R$ #,##0.00'
            ));

    $style11 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'right',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 2, 'Bottom' => 1, 'Left' => 1, 'Right' => 1, 'BorderColor' => 'black', 'NumFormat' => '_*R$ #,##0.00'
            ));

    $style12 = & $workbook->addFormat(array(
                'Size' => 8, 'FgColor' => 'red', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri'
            ));

    $style13 = & $workbook->addFormat(array(
                'Size' => 8, 'FgColor' => 'red', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Bottom' => 2, 'BorderColor' => 'black'
            ));

    $style14 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1,
                'Left' => 2, 'BorderColor' => 'black'
            ));

    $style15 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1,
                'Left' => 2, 'BorderColor' => 'black'
            ));

    $style16 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1,
                'Left' => 2, 'Right' => 2, 'BorderColor' => 'black'
            ));

    $style17 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Left' => 2, 'Right' => 2, 'Top' => 2, 'Bottom' => 1, 'BorderColor' => 'black'
            ));

    $style18 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Left' => 2, 'Right' => 2, 'Bottom' => 1, 'BorderColor' => 'black'
            ));

    $style19 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Left' => 2, 'Right' => 2, 'Bottom' => 2, 'BorderColor' => 'black'
            ));

    $style20 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 1, 'Left' => 1, 'Right' => 1, 'Bottom' => 1, 'BorderColor' => 'black',
                'NumFormat' => '_*R$ #,##0.00'
            ));

    $style21 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 2, 'Left' => 1, 'Right' => 1, 'Bottom' => 1, 'BorderColor' => 'black',
                'NumFormat' => '_*R$ #,##0.00'
            ));

    $style22 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 2, 'Left' => 1, 'Right' => 1, 'Bottom' => 1, 'BorderColor' => 'black',
                'NumFormat' => '_*R$ #,##0.00'
            ));

    $style23 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 2, 'BorderColor' => 'black'
            ));

    $style24 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 2, 'Left' => 1, 'BorderColor' => 'black'
            ));

    $style25 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 1, 'Left' => 1, 'Right' => 2, 'Bottom' => 1, 'BorderColor' => 'black',
                'NumFormat' => '_*R$ #,##0.00'
            ));

    $style26 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 2, 'Left' => 1, 'Right' => 2, 'Bottom' => 1, 'BorderColor' => 'black',
                'NumFormat' => '_*R$ #,##0.00'
            ));

    $style27 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'center',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri',
                'Top' => 1, 'Left' => 1, 'Right' => 1, 'Bottom' => 1, 'BorderColor' => 'black',
                'NumFormat' => '_*R$ #,##0.00'
            ));

    $style28 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1
            ));

    $style29 = & $workbook->addFormat(array(
                'Size' => 11, 'FgColor' => 'black', 'BgColor' => 'white', 'Align' => 'left',
                'vAlign' => 'vcenter', 'FontFamily' => 'Calibri', 'Bold' => 1,
                'Top' => 1, 'Left' => 1, 'Right' => 1, 'Bottom' => 1
            ));


    
?>