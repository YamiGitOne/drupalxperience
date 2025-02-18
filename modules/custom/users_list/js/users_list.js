(function ($, Drupal) {
    Drupal.behaviors.usersList = {
        attach: function (context, settings) {
            console.log("users_list.js se ha cargado correctamente.");

            let currentPage = 1;
            const usersPerPage = 5;

            async function fetchUsers(page = 1) {
                try {
                    console.log(`Fetching users for page ${page}...`);

                    let response = await fetch("/admin/users-list/ajax", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ page: page })
                    });

                    console.log("Response received:", response);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    let data = await response.json();
                    console.log("✅ Data received:", data);

                    if (!data.usuarios || data.usuarios.length === 0) {
                        $('#users-container').html('<p>No hay usuarios disponibles.</p>');
                        return;
                    }

                    let start = (page - 1) * usersPerPage;
                    let end = start + usersPerPage;
                    let usersToShow = data.usuarios.slice(start, end);

                    let userList = '<ul>';
                    usersToShow.forEach(user => {
                        userList += `<li>${user.name} ${user.surname1} ${user.surname2} - ${user.email}</li>`;
                    });
                    userList += '</ul>';

                    $('#users-container').html(userList);
                    $('#page-info').text(`Página ${page}`);
                    currentPage = page;

                } catch (error) {
                    console.error("Error al obtener usuarios:", error);
                    $('#users-container').html('<p>Error al cargar los usuarios.</p>');
                }
            }

            $(document).ready(function () {
                fetchUsers();

                $('#prev-page').click(function () {
                    if (currentPage > 1) {
                        fetchUsers(currentPage - 1);
                    }
                });

                $('#next-page').click(function () {
                    fetchUsers(currentPage + 1);
                });

                $('#users-search-form').submit(function (event) {
                    event.preventDefault();
                    fetchUsers(1);
                });
            });
        }
    };
})(jQuery, Drupal);
