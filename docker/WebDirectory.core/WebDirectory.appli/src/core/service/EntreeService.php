<?php

namespace WebDirectory\appli\core\service;

use mPDF;
use WebDirectory\appli\core\domain\entities\Departement;
use WebDirectory\appli\core\domain\entities\Entrees;

class   EntreeService implements IEntreeService{

    public function getEntrees(): array
    {
        $entrees = Entrees::all();
        $tab = [];
        foreach ($entrees as $e){

            $departement = $e->entrees2departement()->get();
            $tabDepartement = [];
            foreach ($departement as $d){
                $tabDepartement[] = [
                    'id' => $d->id,
                    'nom' => $d->nom,
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
                    'created_at' => $e->created_at,
                    'updated_at' => $e->updated_at,
                    'departements' => $tabDepartement,
                    'publie' => $e->publie,
                    'adresse' => $e->adresse,
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

        $departement = $entree->entrees2departement()->get();
        $tabDepartement = [];
        foreach ($departement as $d){
            $tabDepartement[] = [
                'id' => $d->id,
                'nom' => $d->nom,
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
                'created_at' => $entree->created_at,
                'updated_at' => $entree->updated_at,
                'publie' => $entree->publie,
                'departements' => $tabDepartement,
                'adresse' => $entree->adresse,
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

            $departement = $e->entrees2departement()->get();

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
                    'departements' => $departement,
                    'publie' => $e->publie,
                    'adresse' => $e->adresse,
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
        if(!isset($data['nom']) || !isset($data['prenom']) || !isset($data['nbBureau']) || !isset($data['tel_mobile']) || !isset($data['tel_fixe']) || !isset($data['email']) || !isset($data['departements'])){
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

        if (!filter_var($data['adresse'], FILTER_SANITIZE_SPECIAL_CHARS)) {
            throw new OrmException("Adresse non valide");
        }

        //vérification que l'utilisateur n'existe pas déjà
        $entree = Entrees::where('email', $data['email'])->first();

        if ($entree != null) {
            throw new OrmException("L'utilisateur existe déjà");
        }

        $fileNameNew = null;

        if (!isset($_FILES['image'])  || $_FILES['image']['size'] == 0 || $_FILES['image']['type'] == "") {
            //echo 'No files uploaded';
        }else {
            $file = $_FILES['image'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            $allowed = array('image/jpg', 'image/jpeg', 'image/png');

            if(in_array($fileType, $allowed)){

                //générer un nom unique pour l'image
                $fileNameNew = uniqid('', true).".".explode("/",$fileType)[1];
                $fileDestination = './img/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            }else{
                throw new OrmException("type de d'image non valide");
            }

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
            $entree->image = $fileNameNew;
            $entree->adresse = $data['adresse'];
            $entree->save();
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de la création de l'entree");
        }

        // Ajout de l'entree au departement
        try {
            $tabDepartement = $data['departements'];
            foreach ($tabDepartement as $d){
                $entree->entrees2departement()->attach($d);
            }
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de l'ajout de l'entree au departement");
        }
    }

    public function publicationEntre(array $data){

        $entree = Entrees::find($data['id']);

        if ($entree == null) {
            throw new OrmException("L'entree n'existe pas");
        }

        // Publication de l'entree
        try {
            $entree->publie = $entree->publie == 1 ? 0 : 1;
            $entree->save();
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de la publication de l'entree");
        }
    }

    public function updateEntree(array $data){

        // Vérification si les données sont existantes
        if(!isset($data['id']) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['nbBureau']) || !isset($data['tel_mobile']) || !isset($data['tel_fixe']) || !isset($data['email']) || !isset($data['departements'])){
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

        $ad = $data['adresse'];

        if($data['adresse'] != null || $data['adresse'] != ""){
            if (!filter_var($data['adresse'], FILTER_SANITIZE_SPECIAL_CHARS)) {
                throw new OrmException("Adresse non valide");
            }
        }else{
            $ad = "";
        }


        //vérification que l'utilisateur n'existe pas déjà
        $entree = Entrees::where('email', $data['email'])->first();

        if ($entree != null && $entree->id != $data['id']) {
            throw new OrmException("L'utilisateur existe déjà");
        }

        $fileNameNew = null;

        if (!isset($_FILES['image'])  || $_FILES['image']['size'] == 0 || $_FILES['image']['type'] == "") {
            //echo 'No files uploaded';
        }else {
            $file = $_FILES['image'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            $allowed = array('image/jpg', 'image/jpeg', 'image/png');

            if (in_array($fileType, $allowed)) {

                //générer un nom unique pour l'image
                $fileNameNew = uniqid('', true) . "." . explode("/", $fileType)[1];
                $fileDestination = './img/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            } else {
                throw new OrmException("type de d'image non valide");
            }

        }

        // Mise à jour de l'entree
        try {
            $entree = Entrees::find($data['id']);
            $entree->nom = $data['nom'];
            $entree->prenom = $data['prenom'];
            $entree->nbureau = $data['nbBureau'];
            $entree->tel_mobile = $data['tel_mobile'];
            $entree->tel_fixe = $data['tel_fixe'];
            $entree->email = $data['email'];
            $entree->adresse = $data['adresse'];
            $entree->image = $fileNameNew;
            $entree->save();
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de la mise à jour de l'entree");
        }

        // Suppression des departements de l'entree
        try {
            $entree->entrees2departement()->detach();
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de la suppression des departements de l'entree");
        }

        // Ajout de l'entree au departement
        try {
            $tabDepartement = $data['departements'];
            foreach ($tabDepartement as $d){
                $entree->entrees2departement()->attach($d);
            }
        }catch (\Exception $e){
            throw new OrmException("Erreur lors de l'ajout de l'entree au departement");
        }

    }

    public function deleteEntree(array $data){

            $entree = Entrees::find($data['id']);

            if ($entree == null) {
                throw new OrmException("L'entree n'existe pas");
            }

            // Suppression de l'entree
            try {
                $entree->delete();
            }catch (\Exception $e){
                throw new OrmException("Erreur lors de la suppression de l'entree");
            }

    }

    public function exportCSV(){

//prends toutes les entrées, et renvoie un fichier CSV  et le fichier est téléchargé
        $entrees = Entrees::all();
        $file = fopen("entrees.csv", "w");
        fputcsv($file, ['id', 'nom', 'prenom', 'num_bureau', 'tel_mobile', 'tel_fixe', 'email', 'created_at', 'updated_at', 'publie', 'adresse']);
        foreach ($entrees as $e){
            fputcsv($file, [$e->id, $e->nom, $e->prenom, $e->nbureau, $e->tel_mobile, $e->tel_fixe, $e->email, $e->created_at, $e->updated_at, $e->publie, $e->adresse]);
        }
        fclose($file);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="entrees.csv"');
        readfile("entrees.csv");
        exit();
    }

    public function exportPDF(){
        // Create a new instance of the TCPDF class
        $pdf = new \TCPDF();

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Entrees Export');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // Set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Add a page
        $pdf->AddPage();

        // Fetch all entries
        $entrees = Entrees::all();

        // Start the HTML string
        $html = '<table><tr><th>ID</th><th>Nom</th><th>Prenom</th><th>Num Bureau</th><th>Tel Mobile</th><th>Tel Fixe</th><th>Email</th><th>Created At</th><th>Updated At</th><th>Publie</th><th>Adresse</th></tr>';

        // Loop through all entries and add them to the HTML string
        foreach ($entrees as $e){
            $html .= '<tr><td>'.$e->id.'</td><td>'.$e->nom.'</td><td>'.$e->prenom.'</td><td>'.$e->nbureau.'</td><td>'.$e->tel_mobile.'</td><td>'.$e->tel_fixe.'</td><td>'.$e->email.'</td><td>'.$e->created_at.'</td><td>'.$e->updated_at.'</td><td>'.$e->publie.'</td><td>'.$e->adresse.'</td></tr>';
        }

        // End the HTML string
        $html .= '</table>';

        // Write the HTML string to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output the PDF as a downloadable file
        $pdf->Output('entrees.pdf', 'D');
    }
}