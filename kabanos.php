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
    const KEY_PREFIX  = 'ban';

    // redis connection
    private static function _getDb()
    {
        $config['host']      = 'localhost';
        $config['port']      = 6379;
        $config['database']  = 0;

        return Redis::getInstance($config);
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
     * @param string $type   - label of object type limit (eg. "add-post", "get-userInfo" etc)
     * @param array  $config - eg. array(60 => 5, 300 => 10) // seconds => limitCount  
     * @param string $user   - id, name or something else eg, hash
     *
     * @return true
     */
    public static function check($type, $config = null, $user = null)
    {
        if( !$user ) {
            $user = self::_getUserFingerprint();
        }

        $uid = substr((uniqid()), -8);
        foreach($config as $second => $limit) {

            $keyPattern = self::KEY_PREFIX .':'. $type .':'. $user .':'. $second ;

            // add data to redis
            $res = self::_getDb()->multi(Redis::PIPELINE)
                                ->set($keyPattern .':'. $uniqId, 1)  // add key to db
                                ->setTimeout($keyPattern .':'. $uniqId, $second) // set TTL
                                ->keys($keyPattern .':*') // get key list matching to pattern
                                ->exec();

            // limit verify
            $count = isset($res[2]) ? count($res[2]) : count(self::_getDb()->keys($keyPattern .':*'));

            if($count > $limit) {
                // limit was exceeded
                $error[] = $second .':'. $limit .':'. $count;
            }
        }

        return true;
    }

    
}
