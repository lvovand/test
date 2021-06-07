# example
 $site = 'https://my_site.ru'; 
   $c = curl::app($site);
   $c->follow(true);
   $c->add_header("Content-Type: application/json");
   $a_link = "/api/v1.0/";   
   
   $arr = array("var" => $value);
   $arr_json = json_encode($arr);
   
   $c->post($arr_json); 
   $data_response = $c->request($a_link);
   var_dump($data_response);
