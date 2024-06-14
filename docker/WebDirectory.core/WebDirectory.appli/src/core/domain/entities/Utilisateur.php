<?php

namespace WebDirectory\appli\core\domain\entities;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model{
        protected $table="utilisateur";
        protected $primaryKey="id";

        public $timestamps = false;
        
}