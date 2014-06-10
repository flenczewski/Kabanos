/**
 * Kabanos
 * Antyflood protection (request limiter for selected time intervals) eg. 100req/60s and 200req/5m and 500req/1h
 * 
 * Functionality
 * ~~~~~~~~~~~~~
 *  
 *  # hit counting in sample time (eg. 10s, 1h, 24h)
 *  # info about exceeded the limits
 *  # try to identify the user (anonymous)
 *  
 *
 * Config
 * ~~~~~~
 * 
 * $type = array('limit' => array(60 => 100, 300 => 200, 3600 => 500) );
 *      $type - object type
 *      limit 
 *          100req / 60s
 *          200req / 5m (300s)
 *          500req / 1h (3600s)
 * 
 * 
 * @author  Fabian Lenczewski <fabian.lenczewski@gmail.com>
 * @since   2014-06-10
 */
class Kabanos
{
    const KEY_PREFIX  = 'banos';

    // redis connection
    private static function _getDb()
    {
    }   

    /**
     * Trying to identify the user (anonymous)
     *
     * @return string 
     */
    private static function _getUserFingerprint()
    {
        return md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    }

    
    /**
     * verification and inc counter
     *
     * @return true
     */
    public static function check($user = null, $type = null, $config = null)
    {
        if( !$user ) {
            $user = self::_getUserFingerprint();
        }

        return true;
    }

    
}
