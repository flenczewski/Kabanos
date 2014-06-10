/**
 * Kabanos
 * 
 * Funkcjonalność
 * ~~~~~~~~~~~~~~
 *  
 *  a. zliczanie ilości requestów w funckji czasu (1h, 24h)
 *  b. automatycznie blokowanie (na określony czas) po przekroczeniu granicznych wartośći
 *  c. próba identyfikacji użytkownika (anonimowego) 
 *  
 * Konfiguracja
 * ~~~~~~~~~~~~
 * 
 * $type = array('limit' => array(10 => 5, 60 => 10, 3600 => 20) );
 *      $type - typ obiektu
 *      limit 
 *          10 sek - 5 req
 *          60 sek - 10 req
 *          3600 sek - 20 req
 * 
 * 
 * @author  Fabian Lenczewski <fabian.lenczewski@gmail.com>
 * @since   2014-06-10
 */
class Kabanos
{
    const KEY_PREFIX  = 'banos';

    // pobranie konfiguracji bazy danych
    private static function _getDb()
    {
    }   

    // próba identyfikacji użytkownika
    private static function _getFingerprint()
    {
    }
    
    // pobranie limitów    
    // public static function getConfig()
    // {
    // }
    
    
    // weryfikacja + większenie licznika
    public static function check($user = null, $type = null, $config = null)
    {
    }

    
}
