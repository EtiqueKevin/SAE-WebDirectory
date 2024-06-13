<?php

namespace webdirectory\api\core\service;

interface IDepartementService{

    public function getDepartement():array;

    public function getDepartementById(string $id):array;
}