<?php
require_once( "Sugarcrm.class.php" );

class SugarcrmTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){ }

    public function tearDown(){ }
    public function testAddRelationship(){
        $sc = new Sugarcrm();
        $sc->login();
        $this->assertTrue( $sc -> linkContactToLead(
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
