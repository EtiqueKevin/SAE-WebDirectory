<?php

namespace WebDirectory\appli\infrastructure;


use Illuminate\Database\Capsule\Manager as DB;

class Eloquent {

    public static function init($conf){

        $conf = parse_ini_file($conf);

        $db = new DB();
        $db->addConnection($conf);
        $db->setAsGlobal();
        $db->bootEloquent();

    }

}