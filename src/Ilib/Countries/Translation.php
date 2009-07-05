<?php
class Ilib_Countries_Translation
{
    
    /**
     * Returns Translation2 object initialized with countries translations.
     * 
     * return object Translation2
     */
    public static function factory()
    {
        $driver = "XML";
        $options = array(
            "filename"         => Ilib_Countries_Translation::getFilePath(),
            "save_on_shutdown" => true
        );
        $translation = Translation2::factory($driver, $options);
        if (PEAR::isError($translation)) {
            throw new Exception($translation->getMessage());
        }
        
        return $translation;
    }
        
    
    /**
     * Function to get file path of xml translations file
     * 
     * @return string path
     */
    public static function getFilePath()
    {
        return dirname(__FILE__) . "/i18n.xml";
    }
}