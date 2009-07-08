<?php
/**
 * Class which returns all countries in the world
 * 
 * Source: http://www.addressdoctor.com/en/countries_data/countries.asp
 * 
 * @package Ilib_Countries
 * @author sune
 *
 */

/** 
 * Class which returns all countries in the world
 * 
 * Source: http://www.addressdoctor.com/en/countries_data/countries.asp
 * 
 * @package Ilib_Countries
 * @author sune
 *
 */
class Ilib_Countries
{
    
    /**
     * 
     * @var array with countries
     */
    private $countries;
    
    /**
     * 
     * @var oject translation
     */
    private $translation;
    
    /**
     * Constructor
     * 
     * @param string $encoding either utf-8 or iso-8859-1
     * @param object $translation
     * @return void
     */
    public function __construct($encoding = 'UTF-8', $translation = NULL)
    {
        $this->translation = $translation;
        
        $contents = file_get_contents($this->getFilePath());
        $parser = xml_parser_create('utf-8');
        if(!$parser) throw new Exception('Unable to load xml parser');

        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, $encoding);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $values);
        xml_parser_free($parser);
        if (!$values) return array(); 
        
        
        for($i = 0, $max = count($values); $i < $max; $i++) {
            if($values[$i]['tag'] == 'country' && $values[$i]['type'] == 'open') {
                $country = $values[$i]['attributes']['name'];
                $attribute = array();
                $i++;
                while(in_array($values[$i]['tag'], array('iso3', 'region', 'region_code', 'part_of'))) {
                    $attribute[$values[$i]['tag']] = (isset($values[$i]['value'])) ? $values[$i]['value'] : '';
                    $i++;
                }
                $this->countries[$country] = $attribute;
            }
        }
    }
    
    /**
     * Returns a country by name of if
     * @param string $name
     * @return array containing information about the country
     */
    public function getCountryByName($name) 
    {
        if(isset($this->countries[$name])) {
            return $this->countries[$name];
        }
        return false;
    }
    
    /**
     * Returns all countries 
     * 
     * @return array with countries
     */
    public function getAll()
    {
        
        $result = array();
        
        foreach($this->countries AS $country => $attribute) {
            $result[$country] = $this->translate($country);
        }
        
        asort($result);
        return $result;
    }
    
    /**
     * Returns countries by region
     * 
     * @param mixed $region either string or array containing name of region or regions
     * @return array with countries
     */
    public function getCountriesByRegionName($region)
    {
        if(is_string($region)) {
            $region = array($region);
        }
        if(!is_array($region)) {
            throw new Exception('First parameter should either be string or array');
        }
        
        $invalid = array_diff($region, $this->getRegions());
        if(count($invalid) > 0) {
            throw new Exception('The following regions are invalid: '.implode(', ', $invalid));
        }
        
        $result = array();
        
        foreach($this->countries AS $country => $attribute) {
            if(in_array($attribute['region'], $region, false)) {
                $result[$country] = $this->translate($country);
            }
        }
        
        asort($result);
        return $result;
    }
    
    /**
     * Returns possible regions
     * @TODO: Should be set in xml file instead of here.
     * 
     * @return array with regions
     */
    public function getRegions()
    {
        return array(
            'WA' => 'West Asia',
            'WE' => 'Western Europe',
            'EE' => 'Eastern Europe',
            'AF' => 'Africa',
            'OZ' => 'Oceania',
            'CA' => 'Central America',
            'AR' => 'Arctic Region',
            'SA' => 'South America',
            'ME' => 'Middle East',
            'EA' => 'East Asia',
            'NA' => 'North America'
        );
    }
    
    /**
     * Function to get file path of xml translations file
     * 
     * @return string path
     */
    private function getFilePath()
    {
        $path = dirname(__FILE__) . "/Countries/countries.xml";
        if(file_exists($path)) {
            return $path;
        }
        
        $path = '@data_dir@/Ilib_Countries/Ilib/Countries/countries.xml';
        if(file_exists($path)) {
            return $path;
        }
        
        throw new Exception('Unable to locate data file');
    }
    
    /**
     * Private method for translating countries
     * 
     * @param string $phrase
     * @return string phrase translated
     */
    private function translate($phrase)
    {
        if(isset($this->translation) && $this->translation != NULL) {
            if(is_array($this->translation) && is_callable($this->translation)) {
                return call_user_func($this->translation, $phrase);
            } elseif(is_object($this->translation) && is_callable(array($this->translation, 'get'))) {
                return $this->translation->get($phrase);
            }
            
            throw new Exception('Invalid translator argument');
        }
        
        return $phrase;
    }

}
