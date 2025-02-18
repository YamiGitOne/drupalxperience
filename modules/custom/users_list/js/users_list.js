(function ($, Drupal) {
    Drupal.behaviors.usersListSearch = {
        attach: function (context, settings) {
            console.log("users_list.js cargado correctamente.");

            $('#users-search-form').submit(async function (event) {
                event.preventDefault();

                const name = $('#search-name').val();
                const email = $('#search-email').val();

                try {
                    let response = await fetch("/admin/users-list/search/ajax", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ name, email })
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    let data = await response.json();
                    console.log("Usuarios recibidos:", data);

                    if (!data.usuarios || data.usuarios.length === 0) {
                        $('#users-container').html('<p>No hay usuarios disponibles.</p>');
                        return;
                    }

                    let userList = '<ul>';
                    data.usuarios.forEach(user => {
                        userList += `<li>${user.name} ${user.surname1} ${user.surname2} - ${user.email}</li>`;
                    });
                    userList += '</ul>';

                    $('#users-container').html(userList);

                } catch (error) {
                    console.error("Error al obtener usuarios:", error);
                    $('#users-container').html('<p>Error al cargar los usuarios.</p>');
                }
            });
        }
    };
})(jQuery, Drupal);
