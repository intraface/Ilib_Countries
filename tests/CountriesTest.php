<?php

require_once 'PHPUnit/Framework.php';
require_once '../src/Ilib/Countries.php';

class CountriesTest extends PHPUnit_Framework_TestCase 
{
    
    
    function testConstruct() {
        
        $countries = new Ilib_Countries();
        
        $this->assertTrue(is_object($countries));
        
    }
    
    function testgetCountryByName() {
        
        $countries = new Ilib_Countries();
        
        $expected = array(
            'iso3' => 'FRA',
            'region' => 'Western Europe',
            'region_code' => 'WE',
            'part_of' => 'FRA');
        
        $this->assertEquals($expected, $countries->getCountryByName('France'));
        
    }
    
    public function testGetCountriesByRegionName() {
        $countries = new Ilib_Countries();
        
        $result = $countries->getCountriesByRegionName(array('Western Europe', 'Eastern Europe'));
        
        $this->assertEquals(52, count($result));
    }
}
?>
