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
          'users_list/users_list_styles', 
          'users_list/users_list_js',
        ],
      ],
    ];
  }

  public function searchUsers(Request $request) {
    $data = json_decode($request->getContent(), true);
    $name = isset($data['name']) ? trim($data['name']) : '';
    $email = isset($data['email']) ? trim($data['email']) : '';
    $page = isset($data['page']) ? (int)$data['page'] : 1;
    $perPage = 5;

    \Drupal::logger('users_list')->notice('Buscando: name = @name, surname1 = @surname1, surname2 = @surname2, email = @email, page = @page', [
      '@name' => $name,
      '@surname1' => $surname1,
      '@surname2' => $surname2,
      '@email' => $email,
      '@page' => $page
    ]);

     // Listas de nombres y apellidos simulados
    $names = ["Juan", "María", "Carlos", "Ana", "Luis", "Elena", "Pedro", "Lucía", "Miguel", "Sofía"];
    $surnames = ["García", "Fernández", "Martínez", "López", "González", "Rodríguez", "Pérez", "Sánchez", "Ramírez", "Torres"];

    // Simulación de usuarios
    $all_users = [];
    for ($i = 1; $i <= 50; $i++) {
      $randomName = $names[array_rand($names)];
      $randomSurname1 = $surnames[array_rand($surnames)];
      $randomSurname2 = $surnames[array_rand($surnames)];

      $all_users[] = [
        'id' => $i,
        'name' => $randomName,
        'surname1' => $randomSurname1,
        'surname2' => $randomSurname2,
        'email' => strtolower($randomName) . strtolower($randomSurname1) . "@yopmail.com",
      ];
    }

     $filtered_users = array_filter($all_users, function ($user) use ($name, $email) {
        return (stripos($user['name'], $name) !== false || empty($name)) &&
               (stripos($user['surname1'], $surname1) !== false || empty($surname1)) &&
               (stripos($user['surname2'], $surname2) !== false || empty($surname2)) &&
               (stripos($user['email'], $email) !== false || empty($email));
      });

        $total_users = count($filtered_users);
        $start = ($page - 1) * $perPage;
        $users_paginated = array_slice($filtered_users, $start, $perPage);

        return new JsonResponse([
            'usuarios' => array_values($users_paginated),
            'total' => $total_users,
            'per_page' => $perPage,
            'current_page' => $page,
          ]);
        }
      }
