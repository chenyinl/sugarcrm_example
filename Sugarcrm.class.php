<?php
require_once( "sugarcrm.config.php" );

class Sugarcrm{

    /* received from login process, like token */
    private $session_id = false;

    // user id from the search result
    public $lead_id = false;

    public $lead_status = false;

    // keep the user id after add new user. For test only
    public $user_id = false;

    public function getAllLead ()
    {
        if(! $this->session_id) $this->login();
        $get_entry_list_parameters = array(

            //session id
            'session' => $this->session_id,

            //The name of the module from which to retrieve records
            'module_name' => 'Leads',

            //The SQL WHERE clause without the word "where".
            'query' => "",

            //The SQL ORDER BY clause without the phrase "order by".
            'order_by' => "",

            //The record offset from which to start.
            'offset' => '0',

            //Optional. A list of fields to include in the results.
            'select_fields' => array(
                'id',
                'email1',
            ),

         /*
         A list of link names and the fields to be returned for each link name.
         Example: 'link_name_to_fields_array' => array(array('name' => 'email_addresses', 'value' => array('id', 'email_address', 'opt_out', 'primary_address')))
         */
            'link_name_to_fields_array' => array(),

            //The maximum number of results to return.
            'max_results' => 2000,

            //To exclude deleted records
            'deleted' => '0',

            //If only records marked as favorites should be returned.
            'Favorites' => false,
        );

        return $this->call('get_entry_list', $get_entry_list_parameters);
    }
    public function search( $string ){
        if(! $this->session_id) $this->login();
        $search_by_module_parameters = array(
            //Session id
            "session" => $this->session_id,

            //The string to search for.
            'search_string' => $string,

            //The list of modules to query.
            'modules' => array('Leads'),
            //'modules' => 'Leads',

            //The record offset from which to start.
            'offset' => 0,

            //The maximum number of records to return.
            'max_results' => 1,

            //Filters records by the assigned user ID.
            //Leave this empty if no filter should be applied.
            'id' => '',

            //An array of fields to return.
            //If empty the default return fields will be from the active listviewdefs.
            //'select_fields' =>array(),
            
            'select_fields' => array(
            
                'id',
                'status',
                'status_description',
                'package_purchased_c'
            ),

            //If the search is to only search modules participating in the unified search.
            //Unified search is the SugarCRM Global Search alternative to Full-Text Search.
            'unified_search_only' => false,

            //If only records marked as favorites should be returned.
            'favorites' => false
        );

        $search_by_module_result = $this->call('search_by_module', $search_by_module_parameters);
        //var_dump($search_by_module_result);
        //exit();
        $resultArray = $search_by_module_result->entry_list[0]->records;
        //var_dump($resultArray);
        //return;
        if(count($resultArray)!=0){
            //var_dump($resultArray);
            //ob_flush();
            //flush();
            // already registered
            $this->lead_id = $resultArray[0]->id->value;
            $this->lead_status = $resultArray[0]->status->value;
            //$this->lead_package_purchased = $resultArray[0]->package_purchased->value;
            //$this->lead_saffron_id = $resultArray[0]->saffron_id_c->value;
            return true;
        }else{
            return false;
        }
        
    }    

    private function call( $method, $parameters ){
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

        $login_result = $this->call("login", $login_parameters);
        $this->session_id = $login_result->id;
        return true;
    }

    public function addNew( 
        $first_name, 
        $last_name, 
        $lead_source_description, 
        $status_description, 
        $email, 
        $status, 
        $assigned_user_id 
    ){
        if( !$this->session_id ) $this->login();
        $set_entry_parameters = array(
            //session id
            "session" => $this->session_id,

            //The name of the module from which to retrieve records.
            "module_name" => "Leads",

            //Record attributes
            "name_value_list" => array(
                array("name" => "last_name", "value" => $last_name),
                array("name" => "first_name", "value" => $first_name),
                array("name" => "email1", "value" => $email),
                array("name" => "status", "value" => $status),
                array("name" => "status_description", "value" => $status_description),
                array("name" => "lead_source_description", "value" => $lead_source_description),
                array("name" => "assigned_user_id", "value" => $assigned_user_id),
                array("name" => "campaign_id", "value" => CAMPAIGN_ID)
            )
        );

        $set_entry_result = $this->call("set_entry", $set_entry_parameters);
        $this->user_id = $set_entry_result->id;
        return true;
    }

    public function updateLeadStatus( $id, $status, $assigned_user_id )
    {
        //if( !$this->session_id ) $this->login();
        $set_entry_parameters = array(
            //session id
            "session" => $this->session_id,

            //The name of the module from which to retrieve records.
            "module_name" => "Leads",

            //Record attributes
            "name_value_list" => array(
                array("name" => "id", "value" => $id),
                array("name" => "assigned_user_id", "value" => $assigned_user_id),
                array("name" => "status", "value" => $status),
            )
        );

        $set_entry_result = $this->call("set_entry", $set_entry_parameters);
        return true;
    }
    public function updatePackagePurachsed( $id, $plan )
    {
        $set_entry_parameters = array(
            //session id
            "session" => $this->session_id,

            //The name of the module from which to retrieve records.
            "module_name" => "Leads",

            //Record attributes
            "name_value_list" => array(
                array("name" => "id", "value" => $id),
                array("name" => "package_purchased_c", "value" => $plan)
            )
        );

        $set_entry_result = $this->call("set_entry", $set_entry_parameters);
        var_dump($set_entry_result);
        return true;
    }
    public function searchById( $id )
    {
        $get_entries_parameters = array(
             //session id
             'session' => $this->session_id,
             //The name of the module from which to retrieve records
             'module_name' => 'Leads',
             //An array of record IDs
             'ids' => array(
                 $id,
             ),
             //The list of fields to be returned in the results
             'select_fields' => array(
                'id',
                'package_purchased_c'
                //'name',
                //'billing_address_state',
                //'billing_address_country'
             ),
             //A list of link names and the fields to be returned for each link name
             'link_name_to_fields_array' => array(
                  array(
                       'name' => 'email_addresses',
                       'value' => array(
                            'email_address',
                            'opt_out',
                            'primary_address'
                       ),
                  ),
             ),
            //Flag the record as a recently viewed item
            'track_view' => false,
        );
        $set_entry_result = $this->call("get_entries", $get_entries_parameters);
        var_dump($set_entry_result);
        return true;
    }
    
    public function createNewOpportunity( 
        $name, 
        $description, 
        $amount
    ){
        if( !$this->session_id ) $this->login();
        $set_entry_parameters = array(
            //session id
            "session" => $this->session_id,

            //The name of the module from which to retrieve records.
            "module_name" => "Opportunities",

            //Record attributes
            "name_value_list" => array(
                array("name" => "name", "value" => $name),
                array("name" => "description", "value" => $description),
                array("name" => "amount", "value" => $amount)
            )
        );

        $set_entry_result = $this->call("set_entry", $set_entry_parameters);
        $id = $set_entry_result->id;
        var_dump( $id );
        return true;
    }
    
    public function linkContactToLead(
        $module_id, //contact id
        //$linked_field_name, //linked field name
        $related_id
    ){
        $set_relationship_parameters = array(
            //session id
            "session" => $this->session_id,
            //The name of the module.
            "module_name" => 'Opportunities',
            //The ID of the specified module bean.
            "module_id" => $module_id,
            //The relationship name of the linked field from which to relate records.
            "link_field_name" => 'leads',
            //The list of record ids to relate
            "related_ids" => array(
                $related_id
            ),
            //Sets the value for relationship based fields
            "name_value_list" => array(
                array(
                    //"name" => "contact_role",
                    //"value" => "Other"
                ),
            ),
            //Whether or not to delete the relationship. 0:create, 1:delete
            "delete"=> 0,
        );
        $set_relationship_result = 
            $this->call( "set_relationship", $set_relationship_parameters );
        if($set_relationship_result->created == 1) return true;
        if($set_relationship_result->failed == 1) return false;
    }
}
