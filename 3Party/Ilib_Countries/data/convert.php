<?php

require_once 'Ilib/ClassLoader.php';

$parser = Ilib_FileImport::createParser('CSV');

$parser->assignFieldNames(array('country', 'iso3', 'region', 'region_code', 'part_of'));
$result = $parser->parse('countries.csv', 1);

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$xml .= "\n<!DOCTYPE Countries [\n" .
    "<!ELEMENT countries (country*)>\n" .
    "<!ELEMENT country (iso3,region,region_code,part_of)>\n" .
    "<!ATTLIST country name CDATA #REQUIRED>\n" .
    "<!ELEMENT iso3 (#PCDATA)>\n" .
    "<!ELEMENT region (#PCDATA)>\n" .
    "<!ELEMENT region_code (#PCDATA)>\n" .
    "<!ELEMENT part_of (#PCDATA)>\n" .
    "]>\n";

$xml .= "<countries>\n";

foreach($result AS $country) {
    $xml .= "  <country name=\"".utf8_encode($country['country'])."\">\n" .
        "    <iso3>".$country['iso3']."</iso3>\n" .
        "    <region>".$country['region']."</region>\n" .
        "    <region_code>".$country['region_code']."</region_code>\n" .
        "    <part_of>".$country['part_of']."</part_of>\n".
        "  </country>\n";
}

$xml .= "</countries>";

// echo $xml;

file_put_contents('countries.xml', $xml);

// $serializer = &new XML_Serializer();
// $serializer->serialize($converted_result);

// echo $serializer->getSerializedData();
// file_put_contents('countries1.xml', $serializer->getSerializedData());
// print_r($result);


?>