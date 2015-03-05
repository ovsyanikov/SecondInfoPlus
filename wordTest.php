<?php

require_once './word/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

$php_word = new \PhpOffice\PhpWord\PhpWord();
$setcion = $php_word->addSection();

$tableStyle = array(
    'borderColor' => '000000',
    'borderSize' => 6,
    'cellMargin' => 50,
);
$firstRowStyle = array('width' => 'x1000');
$php_word->addTableStyle('myTable', $tableStyle);

$table = $setcion->addTable('myTable');

$first_row = $table->addRow();
$first_row->addCell(2000)->addText('Район – вопрос');
$first_row->addCell(2000)->addText('Кол-во новых постов');
$first_row->addCell(2000)->addText('Из них наших информационных постов (онлайн) – т.е. кол-во информации от бот сети');
$first_row->addCell(2000)->addText('Кол-во действия');

$word_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word,'Word2007');
$word_writer->save("hello world.docx");
