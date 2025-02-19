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
    $name = isset($data['name']) ? trim($data['name']) : '';
    $email = isset($data['email']) ? trim($data['email']) : '';
    $page = isset($data['page']) ? (int)$data['page'] : 1;
    $perPage = 5;

    \Drupal::logger('users_list')->notice('🔎 Buscando: name = @name, email = @email, page = @page', [
      '@name' => $name,
      '@email' => $email,
      '@page' => $page
    ]);

     // Simulación de usuarios
     $all_users = [];
     for ($i = 1; $i <= 20; $i++) {
       $all_users[] = [
         'id' => $i,
         'name' => "Usuario $i",
         'surname1' => "Apellido1_$i",
         'surname2' => "Apellido2_$i",
         'email' => "usuario$i@yopmail.com",
       ];
     }

     $filtered_users = array_filter($all_users, function ($user) use ($name, $email) {
        return (stripos($user['name'], $name) !== false || empty($name)) &&
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
