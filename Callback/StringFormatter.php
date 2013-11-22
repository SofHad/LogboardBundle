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
 * String formatter
 *
 */
class StringFormatter
{
    public static function uppercase(Array $data)
    {
        $data["key"] = strtoupper($data["key"]);

        return $data;
    }

    public static function capitalize(Array $data)
    {
        $data["key"] = ucfirst ($data["key"]);

        return $data;
    }
}
