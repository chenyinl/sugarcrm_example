<?php
define("USERNAME","XXXX");
define("PASSWORD","XXXX");
define("URL","http://XXXX/service/v4_1/rest.php");
echo "Processing Region\n";
$limit=600;
$row=0;
$sugar = new crm();
$sugar->login();

if (($handle = fopen("nonGB.csv", "r")) !== FALSE ) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE &&
    $row < $limit
    ) {
        $num = count($data);
        //echo "$num fields in line $row:\n";
        $row++;
            echo $data[0]." - ".$data[1]." - ".$data[2]."\n";
            $sugar->update($data[0], $data[2]);
            echo "\n";
    }
    fclose($handle);
}


class crm
{
	private $session_id;
	public $tid; //thunderbirds id
	private function call( $method, $parameters )
    {
        ob_start();
        $curl_request = curl_init();
        curl_setopt($curl_request, CURLOPT_URL, URL);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);
        $jsonEncodedData = json_encode($parameters);
        $post = array(
             "method" => $method,
             "input_type" => "JSON",
             "response_type" => "JSON",
             "rest_data" => $jsonEncodedData
        );
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl_request);
        curl_close($curl_request);
        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();
        return $response;
    }

	public function login()
    {
        $login_parameters = array(
            "user_auth" => array(
                "user_name" => USERNAME,
                "password" => md5( PASSWORD ),
                "version" => "1"
            ),
            "application_name" => "RestTest",
            "name_value_list" => array()
        );
        $result = $this->call("login", $login_parameters);
        if( !isset( $result->id )){
            die( $result->name.": ".$result->description."\n" );
            return false;
        }
        $this->session_id = $result->id;
        return true;
    }
    public function update( $id,  $country_code)
    {
        if( !$this->session_id ) $this->login();
        $set_entry_parameters = array(
            //session id
            "session" => $this->session_id,
            //The name of the module from which to retrieve records.
            "module_name" => "Accounts",
            //Record attributes
            "name_value_list" => array(
				array("name" => "id", "value"=>$id),
                //array("name" => "thunderbirds_user_id_c", "value" => $tbid),
                array("name" => "country_code_c", "value" => $country_code),
            )
        );
        $set_entry_result = $this->call("set_entry", $set_entry_parameters);
        return true;
    }
	public function searchById( $id )
    {
        $get_entries_parameters = array(
             //session id
             'session' => $this->session_id,
             //The name of the module from which to retrieve records
             'module_name' => 'Accounts',
             //An array of record IDs
             'ids' => array(
                 $id,
                
             ),
             //The list of fields to be returned in the results
             'selececho $set_entry_result->entry_list[0]->name_value_list->id->value;t_fields' => array(
                'id',
                'thunderbirds_user_id_c',
                'country_code_c'
             ),
             //A list of link names and the fields to be returned for each link name
             'link_name_to_fields_array' => array(),

            //Flag the record as a recently viewed item
            'track_view' => false,
        );
        $set_entry_result = $this->call("get_entries", $get_entries_parameters);
        //var_dump($set_entry_result->entry_list[0]);
        $r=$set_entry_result->entry_list[0];
        if(!isset($r->name_value_list->id->value)){
			echo "Deleted\n";
			return true;
		}
		echo $r->name_value_list->id->value;
		
        
        echo " - ";
        if(isset($r->name_value_list->thunderbirds_user_id_c->value) ||
			$r->name_value_list->thunderbirds_user_id_c->value==""
        ){

			echo $r->name_value_list->thunderbirds_user_id_c->value;
			$this->tid=$r->name_value_list->thunderbirds_user_id_c->value;
		}else{
			echo "NOID";
			$this->tid=false;
			return false;
			
		}
        echo " - ";
        if(!isset($r->name_value_list->country_code_c->value) ||
			$r->name_value_list->country_code_c->value==""
        ){
			echo "NOC";
			return false;
		}else{
			echo $r->name_value_list->country_code_c->value;
		}
        echo "\n";
        return true;
    }
}
