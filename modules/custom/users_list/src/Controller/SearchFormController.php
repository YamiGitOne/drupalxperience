<?php

namespace Drupal\users_list\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchFormController extends ControllerBase {


  public function searchPage() {
    return [
      '#theme' => 'users_list_search', 
      '#attached' => [
        'library' => [
          'users_list/users_list_js',
        ],
      ],
    ];
  }

  public function searchUsers(Request $request) {
    $data = json_decode($request->getContent(), true);
    $search_term = $data['query'] ?? '';

    $users = [
      ['id' => 1, 'name' => 'Juan Pérez', 'email' => 'juan@example.com'],
      ['id' => 2, 'name' => 'María Gómez', 'email' => 'maria@example.com'],
    ];

    $results = array_filter($users, function ($user) use ($search_term) {
      return stripos($user['name'], $search_term) !== false;
    });

    return new JsonResponse(['usuarios' => array_values($results)]);
  }
}
