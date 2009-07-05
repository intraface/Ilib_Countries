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
        $path = dirname(__FILE__) . "/i18n.xml";
        if(file_exists($path)) {
            return $path;
        }
        
        $path = '@data_dir@/Ilib_Countries/Ilib/Countries/i18n.xml';
        if(file_exists($path)) {
            return $path;
        }
        
        throw new Exception('Unable to locate data file');
    }
}