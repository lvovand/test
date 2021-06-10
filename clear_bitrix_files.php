<?php
/*
 для очистки файлов используем данные 
 - картинки и файлы битрикс сохраняет в папке upload
 - связанные картинки/файлы сохраняются в таблице b_file 
 - связанный файл можно искать через апи битрикса, можно и просто через подключение к таблице,
   в данном примере просто поиск по таблице
*/

//функция для рекурсивного прохода по разделам и получения файлов
//на вход раздел, флаг нужно ли проходить рекурсивно и флаг нужно ли получать папки
//на выходе массив файлов
function get_dir_files( $dir, $recursive = true, $include_folders = false ){
	if(!is_dir($dir) )
		return false;

	$files = array();

	$dir = rtrim( $dir, '/\\' ); // удалим слэш на конце

	foreach( glob( "$dir/{,.}[!.,!..]*", GLOB_BRACE ) as $file ){
		if(is_dir($file)){ // если это каталог, то в зависимости от настроек либо заходим в него, либо пропускаем
			if($include_folders)
				$files[] = $file;
			if( $recursive )
				$files = array_merge( $files, call_user_func( __FUNCTION__, $file, $recursive, $include_folders ) );
		}
		else
			$files[] = $file;
	}

	return $files;
}

//получаем массив файлов
$files = get_dir_files("upload/iblock/",true,true);

//Подключаемся к базе данных с таблицами битрикса
$database_host = "localhost";
$database_username = "user";
$database_password = "password";
$database_name = "bitrix_base";
$DBH = new PDO("mysql:host=" . $database_host . ";dbname=".$database_name, $database_username, $database_password);

foreach($files As $ob_file){
	//получаем информацию о файле
	$path_parts = pathinfo($ob_file);
	
	//ищем в таблице b_file информацию по файлу по оригинальному имени файла
	$sql_alr = "SELECT * FROM `b_file` WHERE `FILE_NAME` = :f_name LIMIT 1";
	$arr_alr = array('f_name' => $path_parts['basename']);
	$res_alr = $DBH->prepare($sql_alr);
	$res_alr->execute($arr_alr);
	$row_alr = $res_alr->fetch();
   //если файл с таким именем не найден, удаляем
	if(!$row_alr){
	 $res_unlink = unlink($ob_file);
	}
}

?>
