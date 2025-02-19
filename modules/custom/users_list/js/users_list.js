(function ($, Drupal) {
    'use strict';

    Drupal.behaviors.usersListSearch = {
        attach: function (context, settings) {
            console.log("users_list.js cargado correctamente con paginación AJAX.");

            function loadUsers(page = 1) {
                const name = $('#search-name', context).val()?.trim() || "";
                const email = $('#search-email', context).val()?.trim() || "";

                console.log("Buscando usuarios con:", name, email, "Página:", page);

                $.ajax({
                    url: "/custom/users-list/search/ajax",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ name, email, page }),
                    success: function (response) {
                        console.log("Respuesta AJAX recibida:", response);

                        if (!response.usuarios || response.usuarios.length === 0) {
                            $('#users-container', context).html('<p>No hay usuarios disponibles.</p>');
                            $('#pagination-container', context).html(''); 
                            return;
                        }

                        let userList = '<ul>';
                        response.usuarios.forEach(user => {
                            userList += `<li>${user.name} ${user.surname1} ${user.surname2} - ${user.email}</li>`;
                        });
                        userList += '</ul>';

                        $('#users-container', context).html(userList);


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
