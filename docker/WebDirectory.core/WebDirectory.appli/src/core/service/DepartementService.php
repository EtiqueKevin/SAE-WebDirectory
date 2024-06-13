<?php

namespace WebDirectory\appli\core\service;

use WebDirectory\appli\core\domain\entities\Departement;
use WebDirectory\appli\core\domain\entities\Entrees;

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
                    'etage' => $d->etage,
                    'description' => $d->description,
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
        $departement = Departement::find($id);
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

    public function createDepartement(array $args): void{

        if(!isset($args['nom']) || !isset($args['etage']) || !isset($args['description'])){
            throw new OrmException("Les champs nom, etage et description sont obligatoires");
        }

        //sanitize
        if(!filter_var($args['nom'], FILTER_SANITIZE_SPECIAL_CHARS) || !filter_var($args['description'], FILTER_SANITIZE_SPECIAL_CHARS)){
            throw new OrmException("Les champs nom et description sont non valides");
        }

        if (!filter_var($args['etage'], FILTER_VALIDATE_INT)){
            throw new OrmException("Le champ etage doit être un entier");
        }

        //vérfie si le departement existe déjà

        $departement = Departement::where('nom', $args['nom'])->first();

        if($departement != null){
            throw new OrmException("Le departement existe déjà");
        }

        try {
            $departement = new Departement();
            $departement->nom = $args['nom'];
            $departement->etage = $args['etage'];
            $departement->description = $args['description'];
            $departement->save();
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de la création du departement");
        }

    }
}