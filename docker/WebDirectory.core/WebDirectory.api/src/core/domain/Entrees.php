<?php

namespace webdirectory\api\core\domain;


class Entrees extends \Illuminate\Database\Eloquent\Model{

    protected $table="entrees";
    protected $primaryKey="id";


    public function entrees2departement(){
        return $this->belongsToMany('webdirectory\api\core\domain\Departement','entrees2departement', 'id_entrees', 'id_departement');
    }
}