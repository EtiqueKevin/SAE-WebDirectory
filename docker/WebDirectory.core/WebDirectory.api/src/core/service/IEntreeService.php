<?php

namespace webdirectory\api\core\service;

interface IEntreeService{

    public function getEntrees(): array;

    public function getEntreeById(int $id): array;

    public function getEntreesByService(int $id): array;

    public function getEntreesBySearch(string $search): array;

    public function getEntreesSorted(string $sort): array;

    public function getEntreesByDepartementAndSearchSorted(int $id, string $search, string $sort): array;

}