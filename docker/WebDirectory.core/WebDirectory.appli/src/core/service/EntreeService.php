<?php

namespace WebDirectory\appli\core\service;

use WebDirectory\appli\core\domain\entities\Departement;
use WebDirectory\appli\core\domain\entities\Entrees;

class   EntreeService implements IEntreeService{

    public function getEntrees(): array
    {
        $entrees = Entrees::all();
        $tab = [];
        foreach ($entrees as $e){

            //récupération des departements de l'entree
            $departement = $e->entrees2departement()->first();

            $tab[] = [
                'entree' => [
                    'id' => $e->id,
                    'nom' => $e->nom,
                    'prenom' => $e->prenom,
                    'num_bureau' => $e->nbureau,
                    'tel_mobile' => $e->tel_mobile,
                    'tel_fixe' => $e->tel_fixe,
                    'email' => $e->email,
                    'created_at' => $e->created_at,
                    'updated_at' => $e->updated_at,
                    'departement' => $departement->nom,
                ],
                'links' => [
                    'self' => ['href' => '/entrees/'.$e->id]
                ],
            ];
        }
        return [
            'type' => 'collection',
            'count' => count($tab),
            'entrees' => $tab
        ];
    }

    /**
     * @throws OrmException
     */
    public function getEntreeById(int $id): array
    {
        $entree = Entrees::find($id);
        if ($entree == null){
            throw new OrmException("Entree non trouvée");
        }
        return [
            'type' => 'resource',
            'entree' => [
                'id' => $entree->id,
                'nom' => $entree->nom,
                'prenom' => $entree->prenom,
                'num_bureau' => $entree->nbureau,
                'tel_mobile' => $entree->tel_mobile,
                'tel_fixe' => $entree->tel_fixe,
                'email' => $entree->email,
                'created_at' => $entree->created_at,
                'updated_at' => $entree->updated_at,
            ],
        ];
    }

    /**
     * @throws OrmException
     */
    public function getEntreesByService(int $id): array
    {
        $departement = Departement::find($id);
        if ($departement == null){
            throw new OrmException("Departement non trouvé");
        }
        $entrees = $departement->entrees2departement()->get();

        $tab = [];
        foreach ($entrees as $e){
            $tab[] = [
                'entree' => [
                    'id' => $e->id,
                    'nom' => $e->nom,
                    'prenom' => $e->prenom,
                    'num_bureau' => $e->nbureau,
                    'tel_mobile' => $e->tel_mobile,
                    'tel_fixe' => $e->tel_fixe,
                    'email' => $e->email,
                    'created_at' => $e->created_at,
                    'updated_at' => $e->updated_at,
                    'departement' => $departement->nom,
                ],
                'links' => [
                    'self' => ['href' => '/entrees/'.$e->id]
                ],
            ];
        }
        return [
            'type' => 'collection',
            'count' => count($tab),
            'entrees' => $tab
        ];
    }

    public function createEntree(array $data){

        // Vérification si les données sont existantes
        if(!isset($data['nom']) || !isset($data['prenom']) || !isset($data['nbBureau']) || !isset($data['tel_mobile']) || !isset($data['tel_fixe']) || !isset($data['email']) || !isset($data['departement_id'])){
            throw new OrmException("Données manquantes");
        }

        // Vérification si les données sont valides
        if(!filter_var($data['nom'], FILTER_SANITIZE_SPECIAL_CHARS)){
            throw new OrmException("Nom non valide");
        }

        if(!filter_var($data['prenom'], FILTER_SANITIZE_SPECIAL_CHARS)){
            throw new OrmException("Prenom non valide");
        }

        if(!filter_var($data['nbBureau'], FILTER_SANITIZE_NUMBER_INT)){
            throw new OrmException("Numéro de bureau non valide");
        }

        if(!filter_var($data['tel_mobile'], FILTER_SANITIZE_SPECIAL_CHARS)){
            throw new OrmException("Numéro de téléphone mobile non valide");
        }

        if (!filter_var($data['tel_fixe'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            throw new OrmException("Numéro de téléphone fixe non valide");
        }

        if (!filter_var($data['email'], FILTER_SANITIZE_EMAIL)) {
            throw new OrmException("Email non valide");
        }

        if (!filter_var($data['departement_id'], FILTER_SANITIZE_NUMBER_INT)) {
            throw new OrmException("Id departement non valide");
        }

        //vérification que l'utilisateur n'existe pas déjà
        $entree = Entrees::where('email', $data['email'])->first();

        if ($entree != null) {
            throw new OrmException("L'utilisateur existe déjà");
        }

        // Création de l'entree
        try {
            $entree = new Entrees();
            $entree->nom = $data['nom'];
            $entree->prenom = $data['prenom'];
            $entree->nbureau = $data['nbBureau'];
            $entree->tel_mobile = $data['tel_mobile'];
            $entree->tel_fixe = $data['tel_fixe'];
            $entree->email = $data['email'];
            $entree->save();
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de la création de l'entree");
        }


        // Ajout de l'entree au departement
        try {
            $entree->entrees2departement()->attach($data['departement_id']);
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de l'ajout de l'entree au departement");
        }
    }
}