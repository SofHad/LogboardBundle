<?php

namespace So\LogboardBundle\Callback;

/**
* Callback functions take array parameter with:
* key   => The value in brackets specified in the regex
* value => The log
*
* For example
*<code>
* Array
*    (
*      [key]   => Mon Oct 28 13:49:54.154759 2013
*      [value] => [Mon Oct 28 13:49:54.154759 2013] [access_compat:error] [pid 3800:tid 1720] [client 127.0.0.1:51218]
*                  AH01797: client denied by server configuration: C:/xampp/htdocs/LogboardBundle/Project/app/,
*                  referer: http://localhost/LogboardBundle/
*     )
*</code>
*
*/

/**
 * Class StringFormatter
 *
 * @package So\LogboardBundle\Callback
 * @author  Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class StringFormatter implements StringFormatterInterface
{
    /**
     * {@inheritdoc}
     *
     */
    public static function uppercase(Array $data)
    {
        $data["key"] = strtoupper($data["key"]);

        return $data;
    }

    /**
     * {@inheritdoc}
     *
     */
    public static function capitalize(Array $data)
    {
        $data["key"] = ucfirst($data["key"]);

        return $data;
    }
}
