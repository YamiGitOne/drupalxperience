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
                {"id": 2, "email": "user2@yopmail.com", "name": "User2", "surname1": "Tres", "surname2": "Cuatro"}
            ]
        }';
        $usuarios = json_decode($usuarios_json, true);
        return new JsonResponse($usuarios);
    }
}
