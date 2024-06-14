<?php

namespace WebDirectory\appli\core\service;

use Illuminate\Container\Util;
use WebDirectory\appli\core\domain\entities\Utilisateur;

class UtilisateurService implements IUtilisateurService{

    function checkUser(array $data): array
    {
        $email = $data['email'];
        $password = $data['password'];

        if (empty($email) || empty($password)){
            return ['reussite'=>false];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new OrmException("login must be an email");
        }

        $user = Utilisateur::where('email', $email)->first();
        if ($user == null){
            return ['reussite'=>false];
        }

        if(!password_verify($password, $user->password)){
            return ['reussite'=>false];
        }else{
            return  ['email' => $user->email, 'role' => $user->role, 'id' => $user->id, 'reussite'=>true];

        }
    }

    function addUser(array $data){

        if (empty($data['email'])){
            throw new OrmException("login is required");
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            throw new OrmException("login must be an email");
        }

        if (empty($data['password'])){
            throw new OrmException("password is required");
        }

        if (empty($data['password2'])){
            throw new OrmException("password confirmation is required");
        }

        if ($data['password'] != $data['password2']){
            throw new OrmException("passwords do not match");
        }

        if (strlen($data['password']) < 8){
            throw new OrmException("password must be at least 8 characters");
        }

        if(!preg_match('/[A-Z]/', $data['password'])){
            throw new OrmException("password must contain at least one uppercase letter");
        }

        if(!preg_match('/[a-z]/', $data['password'])){
            throw new OrmException("password must contain at least one lowercase letter");
        }

        if(!preg_match('/[0-9]/', $data['password'])){
            throw new OrmException("password must contain at least one number");
        }

        if(!preg_match('/[^a-zA-Z0-9]/', $data['password'])){
            throw new OrmException("password must contain at least one special character");
        }

        if(Utilisateur::where('email', $data['email'])->first() != null){
            throw new OrmException("login already exists");
        }

        $user = new Utilisateur();
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->role = 1;
        $user->save();
    }

    function checkUserPermission(int $role, int $roleAttendu): bool{
        if (!isset($role)){
            return false;
        }

        if ($role >= $roleAttendu){
            return true;
        }else{
            return false;
        }
    }

    function logout(){
        unset($_SESSION['user']);
    }
}