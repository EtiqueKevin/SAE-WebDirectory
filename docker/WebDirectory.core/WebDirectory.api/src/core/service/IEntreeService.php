<?php

namespace webdirectory\api\core\service;

interface IEntreeService{

    public function getEntrees(string $sort): array;

    public function getEntreeById(int $id): array;

    public function getEntreesByService(int $id, string $sort): array;

    public function getEntreesBySearch(string $search, string $sort): array;

    public function getEntreesSorted(string $sort): array;

    public function getEntreesByDepartementAndSearchSorted(int $id, string $search, string $sort): array;

}