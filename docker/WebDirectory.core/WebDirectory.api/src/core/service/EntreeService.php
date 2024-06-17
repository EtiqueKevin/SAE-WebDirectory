<?php

namespace webdirectory\api\core\service;

use webdirectory\api\core\domain\Departement;
use webdirectory\api\core\domain\Entrees;

class EntreeService implements IEntreeService{

    public function getEntrees(string $sort): array
    {
        $sort = $sort === 'nom-desc' ? 'desc' : 'asc';
        $entrees = Entrees::all();
        $tab = [];
        foreach ($entrees as $e) {
            if ($e['publie'] == 1) {
                $dep = $e->entrees2departement()->get();
                $depTab = [];
                foreach ($dep as $d) {
                    $depTab[] = [
                        'departement' => [
                            'id' => $d->id,
                            'nom' => $d->nom,
                        ],
                        'links' => [
                            'self' => ['href' => '/api/services/' . $d->id . '/entrees']
                        ],
                    ];
                }
                $tab[] = [
                    'entree' => [
                        'nom' => $e->nom,
                        'prenom' => $e->prenom,
                        'departements' => $depTab,

                    ],
                    'links' => [
                        'self' => ['href' => '/api/entrees/' . $e->id]
                    ],
                ];
            }
        }
        if ($sort === "asc"){
            usort($tab, function($a, $b){
                return $a['entree']['nom'] . $a['entree']['prenom'] <=> $b['entree']['nom'] . $b['entree']['prenom'];
            });
        } else {
            usort($tab, function($a, $b){
                return $b['entree']['nom'] . $b['entree']['prenom'] <=> $a['entree']['nom'] . $a['entree']['prenom'];
            });
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
        $dep = $entree->entrees2departement()->get();
        $depTab = [];
        foreach ($dep as $d){
            $depTab[] = [
                'departement' => [
                    'id' => $d->id,
                    'nom' => $d->nom,
                ],
                'links' => [
                    'self' => ['href' => '/api/services/'.$d->id.'/entrees']
                ],
            ];
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
                'adresse' => $entree->adresse,
                'publie' => $entree->publie,
                'created_at' => $entree->created_at,
                'updated_at' => $entree->updated_at,
                'departements' => $depTab
            ],
            'links' => [
                'image' => ['href' => $entree->image],
            ],
        ];
    }

    /**
     * @throws OrmException
     */
    public function getEntreesByService(int $id, string $sort): array
    {
        $sort = $sort === 'nom-desc' ? 'desc' : 'asc';
        $departement = Departement::find($id);
        if ($departement == null){
            throw new OrmException("Departement non trouvé");
        }
        $entrees = $departement->entrees2departement()->get();
        $tab = [];
        foreach ($entrees as $e) {
            if ($e['publie'] == 1) {
                $dep = $e->entrees2departement()->get();
                $depTab = [];
                foreach ($dep as $d) {
                    $depTab[] = [
                        'departement' => [
                            'id' => $d->id,
                            'nom' => $d->nom,
                        ],
                        'links' => [
                            'self' => ['href' => '/api/services/' . $d->id . '/entrees']
                        ],
                    ];
                }
                $tab[] = [
                    'entree' => [
                        'id' => $e->id,
                        'nom' => $e->nom,
                        'prenom' => $e->prenom,
                        'num_bureau' => $e->nbureau,
                        'tel_mobile' => $e->tel_mobile,
                        'tel_fixe' => $e->tel_fixe,
                        'email' => $e->email,
                        'adresse' => $e->adresse,
                        'publie' => $e->publie,
                        'created_at' => $e->created_at,
                        'updated_at' => $e->updated_at,
                        'departements' => $depTab
                    ],
                    'links' => [
                        'self' => ['href' => '/api/entrees/' . $e->id],
                        'image' => ['href' => $e->image],
                    ],
                ];
            }
        }
        if ($sort === "asc"){
            usort($tab, function($a, $b){
                return $a['entree']['nom'] . $a['entree']['prenom'] <=> $b['entree']['nom'] . $b['entree']['prenom'];
            });
        } else {
            usort($tab, function($a, $b){
                return $b['entree']['nom'] . $b['entree']['prenom'] <=> $a['entree']['nom'] . $a['entree']['prenom'];
            });
        }
        return [
            'type' => 'collection',
            'count' => count($tab),
            'entrees' => $tab
        ];
    }

    public function getEntreesBySearch(string $search, string $sort): array
    {
        $search = '%'.$search.'%';
        $sort = $sort === 'nom-desc' ? 'desc' : 'asc';
        $entrees = Entrees::where('nom', 'like', $search)->orWhere('prenom', 'like', $search)->get();
        $tab = [];
        foreach ($entrees as $e) {
            if ($e['publie'] === 1) {
                $dep = $e->entrees2departement()->get();
                $depTab = [];
                foreach ($dep as $d) {
                    $depTab[] = [
                        'departement' => [
                            'id' => $d->id,
                            'nom' => $d->nom,
                        ],
                        'links' => [
                            'self' => ['href' => '/api/services/' . $d->id . '/entrees']
                        ],
                    ];
                }
                $tab[] = [
                    'entree' => [
                        'id' => $e->id,
                        'nom' => $e->nom,
                        'prenom' => $e->prenom,
                        'num_bureau' => $e->nbureau,
                        'tel_mobile' => $e->tel_mobile,
                        'tel_fixe' => $e->tel_fixe,
                        'email' => $e->email,
                        'adresse' => $e->adresse,
                        'publie' => $e->publie,
                        'created_at' => $e->created_at,
                        'updated_at' => $e->updated_at,
                        'departements' => $depTab
                    ],
                    'links' => [
                        'self' => ['href' => '/api/entrees/' . $e->id],
                        'image' => ['href' => $e->image],
                    ],
                ];
            }
        }
        if ($sort === "asc"){
            usort($tab, function($a, $b){
                return $a['entree']['nom'] . $a['entree']['prenom'] <=> $b['entree']['nom'] . $b['entree']['prenom'];
            });
        } else {
            usort($tab, function($a, $b){
                return $b['entree']['nom'] . $b['entree']['prenom'] <=> $a['entree']['nom'] . $a['entree']['prenom'];
            });
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
    public function getEntreesSorted(string $sort): array
    {
        $sort = $sort === 'nom-desc' ? 'desc' : 'asc';
        $entrees = Entrees::all();
        $tab = [];
        foreach ($entrees as $e) {
            if ($e['publie'] === 1) {
                $dep = $e->entrees2departement()->get();
                $depTab = [];
                foreach ($dep as $d) {
                    $depTab[] = [
                        'departement' => [
                            'id' => $d->id,
                            'nom' => $d->nom,
                        ],
                        'links' => [
                            'self' => ['href' => '/api/services/' . $d->id . '/entrees']
                        ],
                    ];
                }
                $tab[] = [
                    'entree' => [
                        'id' => $e->id,
                        'nom' => $e->nom,
                        'prenom' => $e->prenom,
                        'num_bureau' => $e->nbureau,
                        'tel_mobile' => $e->tel_mobile,
                        'tel_fixe' => $e->tel_fixe,
                        'email' => $e->email,
                        'adresse' => $e->adresse,
                        'publie' => $e->publie,
                        'created_at' => $e->created_at,
                        'updated_at' => $e->updated_at,
                        'departements' => $depTab
                    ],
                    'links' => [
                        'self' => ['href' => '/api/entrees/' . $e->id],
                        'image' => ['href' => $e->image],
                    ],
                ];
            }
        }
        if ($sort === "asc"){
            usort($tab, function($a, $b){
                return $a['entree']['nom'] . $a['entree']['prenom'] <=> $b['entree']['nom'] . $b['entree']['prenom'];
            });
        } else {
            usort($tab, function($a, $b){
                return $b['entree']['nom'] . $b['entree']['prenom'] <=> $a['entree']['nom'] . $a['entree']['prenom'];
            });
        }
        return [
            'type' => 'collection',
            'count' => count($tab),
            'entrees' => $tab
        ];
    }

    public function getEntreesByDepartementAndSearchSorted(int $id, string $search, string $sort): array
    {
        $departement = Departement::find($id);
        if ($departement == null){
            throw new OrmException("Departement non trouvé");
        }
        $search = '%'.$search.'%';
        $sort = $sort === 'nom-desc' ? 'desc' : 'asc';
        $entrees = $departement->entrees2departement()
            ->where('nom', 'like', $search)
            ->orWhere('prenom', 'like', $search)
            ->get();
        $tab = [];
        foreach ($entrees as $e) {
            if ($e['publie'] === 1) {
                $dep = $e->entrees2departement()->get();
                $depTab = [];
                foreach ($dep as $d) {
                    $depTab[] = [
                        'departement' => [
                            'id' => $d->id,
                            'nom' => $d->nom,
                        ],
                        'links' => [
                            'self' => ['href' => '/api/services/' . $d->id . '/entrees']
                        ],
                    ];
                }
                $tab[] = [
                    'entree' => [
                        'id' => $e->id,
                        'nom' => $e->nom,
                        'prenom' => $e->prenom,
                        'num_bureau' => $e->nbureau,
                        'tel_mobile' => $e->tel_mobile,
                        'tel_fixe' => $e->tel_fixe,
                        'email' => $e->email,
                        'adresse' => $e->adresse,
                        'publie' => $e->publie,
                        'created_at' => $e->created_at,
                        'updated_at' => $e->updated_at,
                        'departements' => $depTab
                    ],
                    'links' => [
                        'self' => ['href' => '/api/entrees/' . $e->id],
                        'image' => ['href' => $e->image],
                    ],
                ];
            }
        }
        if ($sort === "asc"){
            usort($tab, function($a, $b){
                return $a['entree']['nom'] . $a['entree']['prenom'] <=> $b['entree']['nom'] . $b['entree']['prenom'];
            });
        } else {
            usort($tab, function($a, $b){
                return $b['entree']['nom'] . $b['entree']['prenom'] <=> $a['entree']['nom'] . $a['entree']['prenom'];
            });
        }
        return [
            'type' => 'collection',
            'count' => count($tab),
            'entrees' => $tab
        ];
    }

}