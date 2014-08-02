<?php
require_once( "Sugarcrm.class.php" );
require_once( "sugarcrm.config.php" );

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
