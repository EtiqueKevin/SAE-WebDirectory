<?php

namespace WebDirectory\appli\core\service;

use WebDirectory\appli\core\domain\entities\Departement;

class DepartementService implements IDepartementService{

    public function getDepartement(): array
    {
        $departements = Departement::all();
        $tab = [];
        foreach ($departements as $d){
            $tab[] = [
                'departement' => [
                    'id' => $d->id,
                    'nom' => $d->nom,
                ],
            ];
        }
        return [
            'type' => 'collection',
            'count' => count($tab),
            'departements' => $tab
        ];

    }

    /**
     * @throws OrmException
     */
    public function getDepartementById(string $id): array
    {
        $departement = Entrees::find($id);
        if(!$departement){
            throw new OrmException("Le departement n'existe pas");
        }
        return [
            'type' => 'resource',
            'departement' => [
                'id' => $departement->id,
                'nom' => $departement->nom,
            ],
        ];
    }
}