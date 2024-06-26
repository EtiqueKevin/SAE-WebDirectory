<?php

namespace WebDirectory\appli\core\service;

interface IDepartementService{

    public function getDepartement():array;

    public function getDepartementById(string $id):array;

    public function createDepartement(array $args):void;

    public function updateDepartement(array $args):void;

    public function deleteDepartement(string $id):void;
}