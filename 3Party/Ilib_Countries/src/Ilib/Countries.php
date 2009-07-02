<?php

class Ilib_Countries
{
    
    /**
     * 
     * @var array with countries
     */
    private $countries;
    
    public function __construct($encoding = 'UTF-8')
    {
        $file = dirname(__FILE__).'/Countries/countries.xml';
        $contents = file_get_contents($file);
        
        //$reader = new XMLReader;
        // $reader->open($file, 'utf-8');
        
        
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
    
    public function getCountryByName($name) 
    {
        if(isset($this->countries[$name])) {
            return $this->countries[$name];
        }
        return false;
    }
    
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
                $result[$country] = $country;
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
    
    
    function getReduced($translation = NULL)
    {
        $countries = array('Albania', 'Andorra', 'Australia', 'Austria', 'Bahrain', 'Belarus', 'Belgium', 'Bermuda', 'Bosnia and Herzegovina', 'Brazil', 
            'Bulgaria', 'Canada', 'Canary Islands', 'China', 'Corsica', 'Croatia', 'Cyprus', 
            'Czech Republic', 'Denmark', 'Estonia', 'Finland', 'France', 'Germany', 'Gibraltar', 
            'Greece', 'Greenland', 'Hong Kong', 'Holland', 'Hungary', 'Iceland', 'India', 'Ireland', 'Israel', 
            'Italy', 'Japan', 'Jordan', 'Kuwait', 'Latvia', 'Lebanon', 'Lithuania', 'Liechtenstein', 'Luxembourg', 
            'Macedonia', 'Malta', 'Mexico', 'Moldova', 'Monaco', 'Netherlands', 'New Zealand', 'Norway', 'Poland', 
            'Portugal', 'Qatar', 'Romania', 'Russia', 'San Marino', 'Saudi Arabia', 'Serbia and Montenegro', 'Singapore', 'Slovakia', 
            'Slovenia', 'South Korea', 'Spain', 'Sweden', 'Switzerland', 'Taiwan', 'Turkey', 'Ukraine',
            'United Kingdom', 'United Arab Emirates', 'United States of America');
        
        $countries_with_key = array();
        foreach($countries AS $country) {
            if($translation != NULL) {
                $countries_with_key[$country] = $translation->get($country);
            } else {
                $countries_with_key[$country] = $country;
            }
        }
        
        asort($countries_with_key);
        
        return $countries_with_key;
    }
}

?>


