<?php

namespace So\LogboardBundle\Callback;


class dateFormatter
{
    public static function standardFormat($data)
    {
        //yyyy-mm-dd
        $date = explode("-",$data["key"]);

        $data["key"] = date("D, j-M-Y", mktime(0, 0, 0, $date[1], $date[2], $date[0]));

        return $data;
    }
}
