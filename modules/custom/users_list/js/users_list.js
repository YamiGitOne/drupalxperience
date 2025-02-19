(function ($, Drupal) {
    Drupal.behaviors.usersListSearch = {
        attach: function (context, settings) {
            console.log("users_list.js cargado correctamente.");

            function loadUsers(page = 1) {
                const name = $('#search-name').val().trim();
                const email = $('#search-email').val().trim();

                console.log("Buscando usuarios con:", name, email, "Página:", page); 

                $.ajax({
                    url: "/users-list/search/ajax",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ name, email, page }),
                    success: function (response) {
                        console.log("Respuesta recibida:", response); 

                        if (!response.usuarios.length) {
                            $('#users-container').html('<p>No hay usuarios disponibles.</p>');
                            return;
                        }

                        let userList = '<ul>';
                        response.usuarios.forEach(user => {
                            userList += `<li>${user.name} ${user.surname1} ${user.surname2} - ${user.email}</li>`;
                        });
                        userList += '</ul>';

                        $('#users-container').html(userList);

                        let pagination = '';
                        for (let i = 1; i <= Math.ceil(response.total / response.per_page); i++) {
                            pagination += `<button class="pagination-btn" data-page="${i}">${i}</button> `;
                        }
                        $('#pagination-container').html(pagination);
                    },
                    error: function (xhr) {
                        console.error("Error en la petición AJAX:", xhr);
                        $('#users-container').html('<p>Error al cargar los usuarios.</p>');
                    }
                });
            }

            $('#users-search-form', context).submit(function (event) {
                event.preventDefault();
                loadUsers();
            });

            $(document).on('click', '.pagination-btn', function () {
                let page = $(this).data('page');
                loadUsers(page);
            });

            loadUsers(); 
        }
    };
})(jQuery, Drupal);
