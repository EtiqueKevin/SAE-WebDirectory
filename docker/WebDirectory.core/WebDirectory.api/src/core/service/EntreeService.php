<?php

namespace webdirectory\api\core\service;

use webdirectory\api\core\domain\Departement;
use webdirectory\api\core\domain\Entrees;

class EntreeService implements IEntreeService{

    public function getEntrees(): array
    {
        $entrees = Entrees::all();
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

    public function getEntreesBySearch(string $search): array
    {
        $search = '%'.$search.'%';
        $entrees = Entrees::where('nom', 'like', $search)->get();
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
    public function getEntreesSorted(string $sort = "nom-asc"): array
    {
        if ($sort === 'nom-asc' || $sort === 'nom-desc') {
            $sort = explode('-', $sort);
        $entrees = Entrees::orderBy('nom', $sort[1])->get();
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
        } else {
            throw new OrmException("Tri non supporté");
        }
    }

    public function getEntreesByDepartementAndSearchSorted(int $id, string $search, string $sort): array
    {
        $departement = Departement::find($id);
        if ($departement == null){
            throw new OrmException("Departement non trouvé");
        }
        $search = '%'.$search.'%';
        if ($sort === 'nom-asc' || $sort === 'nom-desc') {
            $sort = explode('-', $sort);
            $sort = $sort[1];
        } else {
            $sort = "asc";
        }
        $entrees = $departement->entrees2departement()->where('nom', 'like', $search)->orderBy('nom', $sort)->get();
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

}