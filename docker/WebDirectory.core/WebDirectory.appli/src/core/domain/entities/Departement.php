<?php

namespace WebDirectory\appli\core\domain\entities;

class Departement extends \Illuminate\Database\Eloquent\Model{

    protected $table = "departement";
    protected $primaryKey = "id";
    public $timestamps=false;

    public function entrees2departement(){
        return $this->belongsToMany('WebDirectory\appli\core\domain\entities\Entrees', 'entrees2departement', 'id_entrees', 'id_departement');
    }

}

