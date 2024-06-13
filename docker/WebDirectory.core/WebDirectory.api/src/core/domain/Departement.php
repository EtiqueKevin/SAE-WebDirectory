<?php

namespace webdirectory\api\core\domain;

class Departement extends \Illuminate\Database\Eloquent\Model{

    protected $table = "departement";
    protected $primaryKey = "id";
    public $timestamps=false;

    public function entrees2departement(){
        return $this->belongsToMany('webdirectory\api\core\domain\Entrees', 'entrees2departement', 'id_departement', 'id_entrees');
    }

}

