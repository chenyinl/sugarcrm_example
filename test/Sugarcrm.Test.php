<?php
//require_once( dirname(__FILE__)."/sugarcrm.config.php" );
//define( "URL", "http://54.214.51.240/scrm/service/v4_1/rest.php" );
//define( "USERNAME" , "admin" );
//define( "PASSWORD", "1kagency" );
//define( "CAMPAIGN_ID", "e32ed053-2293-a5ae-2405-53c5d29ca4b3");

define( "URL", "http://54.186.249.180/service/v4_1/rest.php" );
define( "USERNAME" , "admin" );
define( "PASSWORD", "0nek@q3ncy" );
define( "CAMPAIGN_ID", "");
class SugarcrmTest extends PHPUnit_Framework_TestCase
{
    protected $sc;
    protected $oppo_id;
    protected $lead_id;
    protected function setUp()
    {
        $this->sc = new Sugarcrm( URL, USERNAME, PASSWORD );
    }

    public function tearDown()
    {
        //unset( $this->sc );
    }

    /**
     * @covers login
     * @covers call
     */
    public function testLogin()
    {
        $badSc = new Sugarcrm( URL, "aaa", "bbb" );
        $this->assertFalse( $badSc->login());
        // print put the error message
        //echo "Error Message: ".$badSc->error_message."\n";

        // correct login 
        $this->assertTrue( $this->sc-> login());
    }
    /**
     * @depends testLogin
     * @covers get_user_id
     */

    public function testGet_user_id()
    {
        $this->sc->login();
        $this->sc->get_user_id();
        $this->assertTrue( $this->sc->get_user_id());
        // id could be 1 (admin) or a 8-4-4-4-8 string;
        $this->assertNotEmpty( $this->sc->user_id );
    }
    /*
    public function testAdd_new_lead(){

        $this->sc->add_new_lead( 
            "steveoo3", //$first_name, 
            "smithoo3", //$last_name, 
            "lead source form newspapaer", //$lead_source_description, 
            "status unknown", //$status_description, 
            "steveSmith".rand(111, 999)."@one-k.com", //$email, 
            "0", //email opt out
            "new", //$status, 
            $this->sc->user_id, //$assigned_user_id
            CAMPAIGN_ID
        );
        
        $this->lead_id = $this->sc->lead_id;
    }

    public function testAdd_new_opportunity(){
        $this->sc->add_new_opportunity( 
            "steveSmithOpportunity".rand(11,99), //$first_name, 
            "This is a testing opportunity",
            rand(1000, 9999)
        );
        
        $this->oppo_id = $this->sc->opportunity_id;
    }


    
    public function testAddRelationship(){
        $this->sc->add_new_lead( 
            "stevex", //$first_name, 
            "smitxh", //$last_name, 
            "lead source form newspapaer", //$lead_source_description, 
            "status unknown", //$status_description, 
            "steveSmith".rand(111, 999)."@one-k.com", //$email, 
            "0",
            "new", //$status, 
            $this->sc->user_id, //$assigned_user_id
            CAMPAIGN_ID
        );
         
        $this->sc->add_new_opportunity( 
            "steveSmithOpportunity".rand(11,99), //$first_name, 
            "This is a testing opportunity",
            rand(1000, 9999)
        );

        //echo "lead id: ".$this->sc->lead_id."\n";
        //echo "opport id: ".$this->sc->opportunity_id."\n";
        
        $this->assertTrue( $this->sc -> linkContactToLead(
            $this->sc->opportunity_id, //$module_id, opportunity id
            $this->sc->lead_id //$related_ids, lead id
        ));
    }
    /*
    public function testAddNewOpportunity()
    {
        $sc = new Sugarcrm();
        $sc->login();
        $this->assertTrue( $sc -> createNewOpportunity(
            "UnitTestOpportunity222", 
            "UnitUnitTestOpportunity Description 222",
            "200"
        ));
        //$this->assertEquals( 36, strlen($loginObj->user_id));
 
    }    */
    
/*
    public function testSearchById()
    {
        $sc = new Sugarcrm();
        $sc->login();
        //$sc->searchById( "3e89a65c-7b23-9ac6-549e-53cee90472bd" );
        $sc->searchById( "xxxxxx" );
    }

    public function testPackageUpdate()
    {
        $sc = new Sugarcrm();
        $sc->login();
        //$sc->search( "clin@one-k.com" );
        //var_dump($sc->lead_id);
        $r = $sc->updatePackagePurachsed( "xxxxxx", 2 );
        //var_dump( $r );

       
    }

*/


    /*
    public function testGetAllLead()
    {
        $sc = new Sugarcrm();
        $sc -> login();
        $sc->search( "clin@one-k.com" );
        //var_dump($sc -> getAllLead());
    }*/

    /*
    public function testLoginWorks()
    {
        $loginObj = new Sugarcrm();
        $loginObj -> login();
        $this->assertTrue($loginObj -> login());
    }
    public function testSearchTrue()
    {
        $loginObj = new Sugarcrm();
        $this->assertTrue($loginObj -> search("knichols@scs.k12.va.us"));
    }*/
    /*
    public function testSearchFalse()
    {
        $loginObj = new Sugarcrm();
        $this->assertFalse($loginObj -> search("clin321furhkfgikdenghctgsjdl@one-k.com"));
    }

    public function testAddNewAndUpdate()
    {
        $loginObj = new Sugarcrm();
        $this->assertTrue( $loginObj -> addNew(
            "UnitTest", 
            "UnitTest",
            "UTM_code",
            "2",
            "unittest@one-k.com", 
            "Assigned",
            NEWSLETTER_ID
        ));
        $this->assertEquals( 36, strlen($loginObj->user_id));
        $this->assertTrue( $loginObj -> updateLeadStatus( 
            $loginObj->user_id, 
            "In Process", 
            SUBSCRIBER_ID 
        ));
    }*/
}
