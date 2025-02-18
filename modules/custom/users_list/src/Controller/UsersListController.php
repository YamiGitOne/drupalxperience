<?php

namespace Drupal\users_list\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UsersListController extends ControllerBase {

    public function listPage() {
        return [
            '#theme' => 'users_list',
            '#attached' => [
                'library' => ['users_list/ajax'],
            ],
        ];
    }

    public function ajaxList(Request $request) {
        // Simulación de API
        $usuarios_json = '{
            "usuarios": [
                {"id": 1, "email": "admin@yopmail.com", "name": "Admin", "surname1": "Uno", "surname2": "Dos"},
                {"id": 2, "email": "user2@yopmail.com", "name": "User2", "surname1": "Tres", "surname2": "Cuatro"},
                {"id": 3, "email": "user3@yopmail.com", "name": "User3", "surname1": "Cinco", "surname2": "Seis"},
                {"id": 4, "email": "user4@yopmail.com", "name": "User4", "surname1": "Siete", "surname2": "Ocho"},
                {"id": 5, "email": "user5@yopmail.com", "name": "User5", "surname1": "Nueve", "surname2": "Diez"}
            ]
        }';
        $usuarios = json_decode($usuarios_json, true);
        return new JsonResponse($usuarios);
    }
}
