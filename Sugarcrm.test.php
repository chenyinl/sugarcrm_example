<?php
require_once( "Sugarcrm.class.php" );
require_once( "sugarcrm.config.php" );

class SugarcrmTest extends PHPUnit_Framework_TestCase
{
    protected $sc;
    protected function setUp()
    {
        $this->sc = new Sugarcrm( URL, USERNAME, PASSWORD );
        
    }

    public function tearDown()
    {
        //unset( $this->sc );
    }

    public function testLogin()
    {
        $badSc = new Sugarcrm( URL, "aaa", "bbb" );
        $this->assertFalse( $badSc->login());
        // print put the error message
        echo "Error Message: ".$badSc->error_message."\n";

        // correct login 
        $this->assertTrue( $this->sc-> login());
    }

    public function testGet_user_id()
    {
        $this->sc->login();
        $this->sc->get_user_id();
        //$this->assertTrue( $this->sc->get_user_id()); 
        echo "User Id: ".$this->sc->user_id."\n";
    }

    public function testAdd_new_lead(){
        $this->sc->add_new_lead( 
            "steve", //$first_name, 
            "smith", //$last_name, 
            "lead source form newspapaer", //$lead_source_description, 
            "status unknown", //$status_description, 
            "steveSmith".rand(111, 999)."@one-k.com", //$email, 
            "new", //$status, 
            $this->sc->user_id, //$assigned_user_id
            CAMPAIGN_ID
        );
    }

    /*
    public function testAddRelationship(){

        $this->sc->assertTrue( $sc -> linkContactToLead(
            "b9894f1a-4301-22d7-59d6-53da9deda499", //$module_id, opportunity id
            //"a5bb595d-838f-2dac-e068-53ce4b9aff47"//$related_ids, lead id
            "5b036ef1-d30a-5d3f-de25-53cdb0990390"
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
