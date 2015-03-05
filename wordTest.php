<?php

require_once './word/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

$php_word = new \PhpOffice\PhpWord\PhpWord();
$setcion = $php_word->addSection();

$tableStyle = array(
    'borderColor' => '006699',
    'borderSize' => 6,
    'cellMargin' => 50
);



$php_word->addTableStyle('myTable', $tableStyle);

$table = $setcion->addTable('myTable');
$table->addRow()->addCell()->addText('Hello');

$word_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word,'Word2007');
$word_writer->save("hello wordl.docx");
