<?php

namespace WebDirectory\appli\core\service;

interface IEntreeService{

    public function getEntrees(): array;

    public function getEntreeById(int $id): array;

    public function getEntreesByService(int $id): array;

    public function createEntree(array $data);

    public function publicationEntre(array $data);

    public function updateEntree(array $data);

    public function deleteEntree(array $data);

    public function exportCSV();

    public function exportPDF();

    public function importCSV();

}