<?php

namespace Drupal\users_list\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UsersListController extends ControllerBase {

    public function listPage() {
        return [
            '#theme' => 'users_list',
            '#usuarios' => [
                ["name" => "Ejemplo", "surname1" => "Uno", "surname2" => "Dos", "email" => "ejemplo@yopmail.com"]
            ],
            '#attached' => [
                'library' => ['users-list/ajax'],
            ],
        ];
    }

    public function ajaxList(Request $request) {
        // Simulación de API datos de prueba
        $usuarios_json = '{
            "usuarios": [
                {"id": 1, "email": "admin@yopmail.com", "name": "Admin", "surname1": "Uno", "surname2": "Uno"},
                {"id": 2, "email": "user2@yopmail.com", "name": "User2", "surname1": "Tres", "surname2": "Dos"},
                {"id": 3, "email": "user3@yopmail.com", "name": "User3", "surname1": "Cinco", "surname2": "Tres"},
                {"id": 4, "email": "user4@yopmail.com", "name": "User4", "surname1": "Siete", "surname2": "Cuatro"},
                {"id": 5, "email": "user5@yopmail.com", "name": "User5", "surname1": "Nueve", "surname2": "Cinco"},
                {"id": 1, "email": "admin@yopmail.com", "name": "Admin", "surname1": "Uno", "surname2": "Seis"},
                {"id": 2, "email": "user2@yopmail.com", "name": "User2", "surname1": "Tres", "surname2": "Siete"},
                {"id": 3, "email": "user3@yopmail.com", "name": "User3", "surname1": "Cinco", "surname2": "Ocho"},
                {"id": 4, "email": "user4@yopmail.com", "name": "User4", "surname1": "Siete", "surname2": "Nueve"},
                {"id": 5, "email": "user5@yopmail.com", "name": "User5", "surname1": "Nueve", "surname2": "Diez"}
            ]
        }';
        return new JsonResponse(json_decode($usuarios_json, true));
    }
}
