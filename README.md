# example php
 <br> include_once "curl.php";
 <br>$site = 'https://my_site.ru'; 
 <br>$c = curl::app($site);
 <br>$c->follow(true);
 <br>$c->add_header("Content-Type: application/json");
 <br>$a_link = "/api/v1.0/";   
 <br>  
 <br>$arr = array("var" => $value);
 <br>$arr_json = json_encode($arr);
 <br>
 <br>$c->post($arr_json); 
 <br>$data_response = $c->request($a_link);
 <br>var_dump($data_response);
