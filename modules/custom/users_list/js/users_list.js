(function ($, Drupal) {
    'use strict';

    Drupal.behaviors.usersListSearch = {
        attach: function (context, settings) {
            console.log("users_list.js cargado correctamente con paginación AJAX.");

            function loadUsers(page = 1) {
                const name = $('#search-name', context).val()?.trim() || "";
                const surname1 = $('#search-surname1').val().trim();
                const surname2 = $('#search-surname2').val().trim();
                const email = $('#search-email', context).val()?.trim() || "";

                console.log("Buscando usuarios con:", name, surname1, surname2, email, "Página:", page);

                $.ajax({
                    url: "/custom/users-list/search/ajax",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ name, surname1, surname2, email, page }),
                    success: function (response) {
                        console.log("Respuesta AJAX recibida:", response);

                        if (!response.usuarios || response.usuarios.length === 0) {
                            $('#users-container', context).html('<p>No hay usuarios disponibles.</p>');
                            $('#pagination-container', context).html(''); 
                            return;
                        }

                        let userList = '<table border="1" style="width:100%; text-align:left;">';
                        userList += '<tr><th>Nombre de Usuario</th><th>Apellido 1</th><th>Apellido 2</th><th>Correo Electrónico</th></tr>';
                        response.usuarios.forEach(user => {
                            userList += `<tr>
                                <td>${user.name}</td>
                                <td>${user.surname1}</td>
                                <td>${user.surname2}</td>
                                <td>${user.email}</td>
                            </tr>`;
                        });
                        userList += '</table>';


                        let pagination = '';
                        if (response.total && response.per_page) {
                            const totalPages = Math.ceil(response.total / response.per_page);
                            for (let i = 1; i <= totalPages; i++) {
                                pagination += `<button class="pagination-btn" data-page="${i}">${i}</button> `;
                            }
                        }
                        $('#pagination-container', context).html(pagination);
                    },
                    error: function (xhr) {
                        console.error("Error en la petición AJAX:", xhr);
                        $('#users-container', context).html('<p>Error al cargar los usuarios.</p>');
                    }
                });
            }


            $('#users-search-form', context).once('users-list-search').submit(function (event) {
                event.preventDefault();
                console.log("Evento submit ejecutado correctamente.");
                loadUsers(1); 
                return false;
            });


            $(document, context).once('users-list-pagination').on('click', '.pagination-btn', function () {
                let page = $(this).data('page');
                console.log("Cargando página:", page);
                loadUsers(page);
            });


            loadUsers();
        }
    };
})(jQuery, Drupal);
