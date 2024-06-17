<?php

namespace webdirectory\api\core\service;

use webdirectory\api\core\domain\Departement;

class DepartementService implements IDepartementService{

    public function getDepartement(string $sort): array
    {
        $sort = $sort === 'nom-desc' ? 'desc' : 'asc';
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
        if($sort === 'asc'){
            usort($tab, function($a, $b){
                return $a['departement']['nom'] <=> $b['departement']['nom'];
            });
        }else{
            usort($tab, function($a, $b){
                return $b['departement']['nom'] <=> $a['departement']['nom'];
            });
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
        $departement = Departement::find($id);
        if(!$departement){
            throw new OrmException("Le departement n'existe pas");
        }
        return [
            'type' => 'resource',
            'departement' => [
                'id' => $departement->id,
                'nom' => $departement->nom,
                'etage' => $departement->etage,
                'description' => $departement->description,
            ],
        ];
    }
}