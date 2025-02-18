<?php

namespace Drupal\users_list\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchFormController extends ControllerBase {

    /**
     * Muestra la página con el formulario de búsqueda.
     */
    public function searchPage() {
        return [
            '#theme' => 'users_list_search', // ← Nombre del template Twig
            '#attached' => [
                'library' => ['users_list/ajax'],
            ],
        ];
    }

    /**
     * Endpoint para la búsqueda de usuarios con AJAX.
     */
    public function searchUsers(Request $request) {
        $data = json_decode($request->getContent(), true);

        // Simulación de API - Lista de usuarios
        $usuarios_json = '{
            "usuarios": [
                {"id": 1, "email": "admin@yopmail.com", "name": "Admin", "surname1": "Uno", "surname2": "Uno"},
                {"id": 2, "email": "user2@yopmail.com", "name": "User2", "surname1": "Tres", "surname2": "Dos"},
                {"id": 3, "email": "user3@yopmail.com", "name": "User3", "surname1": "Cinco", "surname2": "Tres"},
                {"id": 4, "email": "user4@yopmail.com", "name": "User4", "surname1": "Siete", "surname2": "Cuatro"},
                {"id": 5, "email": "user5@yopmail.com", "name": "User5", "surname1": "Nueve", "surname2": "Cinco"}
            ]
        }';
        $usuarios = json_decode($usuarios_json, true)['usuarios'];

        // Filtrar usuarios según los datos del formulario
        if (!empty($data['name'])) {
            $usuarios = array_filter($usuarios, function($user) use ($data) {
                return stripos($user['name'], $data['name']) !== false;
            });
        }
        if (!empty($data['email'])) {
            $usuarios = array_filter($usuarios, function($user) use ($data) {
                return stripos($user['email'], $data['email']) !== false;
            });
        }

        return new JsonResponse(['usuarios' => array_values($usuarios)]);
    }
}
