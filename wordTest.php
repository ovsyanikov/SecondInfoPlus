<meta charset="UTF-8">
<?php 



function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

//require_once './word/src/PhpWord/Autoloader.php';
//\PhpOffice\PhpWord\Autoloader::register();
//
//$php_word = new \PhpOffice\PhpWord\PhpWord();
//$setcion = $php_word->addSection();
//
//$tableStyle = array(
//    'borderColor' => '000000',
//    'borderSize' => 6,
//    'cellMargin' => 50,
//);
//
//$php_word->addTableStyle('myTable', $tableStyle);
//
//$table = $setcion->addTable('myTable');
//
//$first_row = $table->addRow();
//$first_row->addCell(2500)->addText('Район – вопрос');
//$first_row->addCell(2500)->addText('Кол-во новых постов');
//$first_row->addCell(2500)->addText('Из них наших информационных постов (онлайн) – т.е. кол-во информации от бот сети');
//$first_row->addCell(2500)->addText('Кол-во действия');
//
//for($i = 0; $i < 4; $i++){
//    $first_row = $table->addRow();
//    for($j = 0; $j < 4; $j++){
//        $first_row->addCell(2500)->addText($j);
//    }//for 
//}
//
//$word_writer = \PhpOffice\PhpWord\IOFactory::createWriter($php_word,'Word2007');
//$word_writer->save("hello world.docx");

$str = "Привет%Дивный!Новый;Мир ура";
//Совет
//Совет
$words = multiexplode(array('%','!',';',' '), $str);

foreach ($words as $key) {
    
    echo "$key <br/>";
    
}//foreach