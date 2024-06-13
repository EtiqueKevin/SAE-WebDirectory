<?php

namespace webdirectory\api\core\service;

interface IEntreeService{

    public function getEntrees(): array;

    public function getEntreeById(int $id): array;

    public function getEntreesByService(int $id): array;

}