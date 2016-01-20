<?php
require_once '../Writer.php';

$workbook = new Spreadsheet_Excel_Writer('test.xls');
$worksheet =& $workbook->addWorksheet('My first worksheet');
if (PEAR::isError($worksheet)) {
    die($worksheet->getMessage());
}
$workbook->close();
?> 