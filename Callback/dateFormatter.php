<?php

namespace So\LogboardBundle\Callback;

/**
 * Callback functions takes array parameter with:
 * key   => The value in brackets specified in the regex
 * value => the log
 *
 * Array
 *    (
 *      key] => Mon Oct 28 13:49:54.154759 2013
 *      [value] => [Mon Oct 28 13:49:54.154759 2013] [access_compat:error] [pid 3800:tid 1720] [client 127.0.0.1:51218] AH01797: client denied by server configuration: C:/xampp/htdocs/BeautyLogBundle/Project/app/, referer: http://localhost/BeautyLogBundle/
 *     )
 *
 * Date formatter
 *
 */
class dateFormatter
{
    public static function standardFormat(Array $data)
    {
        //yyyy-mm-dd
        $date = explode("-", $data["key"]);

        $data["key"] = date("D, j-M-Y", mktime(0, 0, 0, $date[1], $date[2], $date[0]));

        return $data;
    }

    public static function apacheFormat(Array $data)
    {

        $parts = preg_split('/\s+/', $data["key"]);

        $data["key"] = sprintf('%s, %s-%s-%s', $parts[0], $parts[2], $parts[1], $parts[4]);

        return $data;
    }
}
