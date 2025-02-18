<?php

namespace Drupal\users_list\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchFormController extends ControllerBase {

  
  public function searchPage() {
    return [
      '#markup' => '<h2>Buscar Usuarios</h2><p>Aquí irá el formulario de búsqueda.</p>',
    ];
  }


  public function searchUsers(Request $request) {
    $search_term = $request->request->get('query');
    
    // Simulación de usuarios encontrados (normalmente iría una consulta a la base de datos).
    $users = [
      ['id' => 1, 'name' => 'Juan Pérez'],
      ['id' => 2, 'name' => 'María Gómez'],
    ];
    

    $results = array_filter($users, function ($user) use ($search_term) {
      return stripos($user['name'], $search_term) !== false;
    });

    return new JsonResponse(array_values($results));
  }
}
