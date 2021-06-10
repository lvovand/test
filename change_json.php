<?php

 //читаем файл и конвертируем json в массив
 $arr_file = file("chart.json");
 $json = $arr_file[0];
 $arr = json_decode($json, true); 
 $number = 100; // число для сравнения
 $flag_podmen = false; //флаг о том была ли уже подмена   
 
 //echo "<pre>";
 //print_r($arr);
 //echo "<pre>";
 if(!is_array($arr)){
	echo "error";
	exit;	 
 }
 for($i=0; $i<count($arr);  $i++){
 	 if($flag_podmen){
	  break;	//если подмена уже была, выходим		
	 }
    if(is_array($arr[$i]) && count($arr[$i]) > 1){
     for($j=1; $j < count($arr[$i]); $j++){
       if($arr[$i][$j] == $number){
       	$arr[$i][$j] = "null";
       	$flag_podmen = true; //меняем флаг что была подмена
       }else{
			if($flag_podmen){
				break; //если подмена уже была, выходим	
			}		       
       }     
     } 
    }
 }
// echo "<pre>";
 //print_r($arr);
 //echo "<pre>";
 //конвертируем массив в json и сохраняем файл
 $json_new = json_encode($arr);
 file_put_contents("chart_result.json", $json_new);
?>
