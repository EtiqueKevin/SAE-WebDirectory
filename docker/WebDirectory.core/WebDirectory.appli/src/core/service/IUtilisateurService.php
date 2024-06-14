<?php

namespace WebDirectory\appli\core\service;

interface IUtilisateurService{

    function checkUser(array $data): bool;
    function checkUserPermission(int $role, int $roleAttendu): bool;
    function addUser(array $data);
    function logout();


}