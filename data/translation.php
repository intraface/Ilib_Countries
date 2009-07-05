<?php

require_once 'Ilib/ClassLoader.php';

$da_countries = array('Albania' => 'Albanien', 'Andorra' => 'Andorra', 'Australia' => 'Australien',
            'Austria' => 'Østrig', 'Bahrain' => 'Bahrain', 'Belarus' => 'Hviderusland',
            'Belgium' => 'Belgien', 'Bermuda' => 'Bermuda', 'Bosnia and Herzegovina' => 'Bosnien og Herzegovina',
            'Brazil' => 'Brasilien', 'Bulgaria' => 'Bulgarien',
            'Canada' => 'Canada', 'Canary Islands' => 'de Kanariske Øer',
            'China' => 'Kina', 'Corsica' => 'Korsika',
            'Croatia' => 'Kroatien', 'Cyprus' => 'Cypern',
            'Czech Republic' => 'Tjekkiet', 'Denmark' => 'Danmark',
            'Estonia' => 'Estland', 'Finland'  => 'Finland',
            'France' => 'Frankrig', 'Germany' => 'Tyskland',
            'Gibraltar' => 'Gibraltar', 'Greece' => 'Grækkenland', 'Greenland' => 'Grønland',
            'Hong Kong' => 'Hong Kong', 'Holland'  => 'Holland',
            'Hungary' => 'Ungarn', 'Iceland' => 'Island',
            'India' => 'Indien', 'Ireland'  => 'Irland',
            'Israel' => 'Israel', 'Italy' => 'Italien',
            'Japan' => 'Japan', 'Jordan' => 'Jordan',
            'Kuwait' => 'Kuwait', 'Latvia' => 'Letland',
            'Lebanon' => 'Libanon', 'Liechtenstein' => 'Liechtenstein', 'Lithuania' => 'Litauen',
            'Luxembourg' => 'Luxemborg', 'Macedonia' => 'Makedonien', 'Malta' => 'Malta',
            'Mexico' => 'Mexico', 'Moldova' => 'Moldova', 'Monaco' => 'Monaco',
            'Netherlands' => 'Holland', 'New Zealand'  => 'New Zealand',
            'Norway' => 'Norge', 'Poland' => 'Polen', 'Romania' => 'Romanien',
            'Russia' => 'Rusland', 'Portugal' => 'Portugal', 'Qatar' => 'Qatar',
            'San Marino' => 'San Marino', 'Saudi Arabia' => 'Saudi Arabien',
            'Serbia and Montenegro' => 'Serbien og Montenegro', 'Singapore' => 'Singapore', 'Slovakia' => 'Slovakiet',
            'Slovenia' => 'Slovenien', 'South Korea'  => 'Syd Korea',
            'Spain' => 'Spanien', 'Sweden' => 'Sverige', 'Switzerland' => 'Schweiz',
            'Taiwan' => 'Taiwan', 'Turkey' => 'Tyrkiet', 'Ukraine' => 'Ukraine',
            'United Kingdom' => 'Storbritannien', 'United Arab Emirates'  => 'Forenede Arabiske Emirater',
            'United States of America' => 'USA'
        );

$xml = '';
require_once '../src/Ilib/Countries.php';
$countries = new Ilib_Countries();        

foreach($countries->getAll() AS $country) {
    
    
    $xml .= "      <string key=\"".$country."\">\n" .
        "        <tr lang=\"da\">".((isset($da_countries[$country])) ? $da_countries[$country] : '') ."</tr>\n" .
        "      </string>\n";
}

// echo $xml;

file_put_contents('translations.xml', $xml);

// $serializer = &new XML_Serializer();
// $serializer->serialize($converted_result);

// echo $serializer->getSerializedData();
// file_put_contents('countries1.xml', $serializer->getSerializedData());
// print_r($result);


?>