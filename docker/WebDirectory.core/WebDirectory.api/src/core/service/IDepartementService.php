<?php

namespace webdirectory\api\core\service;

interface IDepartementService{

    public function getDepartement(string $sort, int $page):array;

    public function getDepartementById(string $id):array;
}