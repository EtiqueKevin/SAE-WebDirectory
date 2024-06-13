<?php

namespace WebDirectory\appli\core\domain\entities;


class Entrees extends \Illuminate\Database\Eloquent\Model{

    protected $table="entrees";
    protected $primaryKey="id";


    public function entrees2departement(){
        return $this->belongsToMany('WebDirectory\appli\core\domain\entities\Departement','entrees2departement', 'id_entrees', 'id_departement');
    }
}