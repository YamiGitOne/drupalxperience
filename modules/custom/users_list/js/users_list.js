(function ($, Drupal) {
    Drupal.behaviors.usersList = {
        attach: function (context, settings) {
            let currentPage = 1;
            const usersPerPage = 5;

            function fetchUsers(page = 1) {
                $.ajax({
                    type: "POST",
                    url: "/admin/users-list/ajax",
                    success: function (response) {
                        let start = (page - 1) * usersPerPage;
                        let end = start + usersPerPage;
                        let usersToShow = response.usuarios.slice(start, end);

                        let userList = '<ul>';
                        usersToShow.forEach(user => {
                            userList += `<li>${user.name} ${user.surname1} ${user.surname2} - ${user.email}</li>`;
                        });
                        userList += '</ul>';

                        $('#users-container').html(userList);
                        $('#page-info').text(`Página ${page}`);
                        currentPage = page;
                    }
                });
            }

            fetchUsers();

            $('#prev-page').click(function () {
                if (currentPage > 1) {
                    fetchUsers(currentPage - 1);
                }
            });

            $('#next-page').click(function () {
                fetchUsers(currentPage + 1);
            });

            $('#user-search-form').submit(function (event) {
                event.preventDefault();
                fetchUsers(1);
            });
        }
    };
})(jQuery, Drupal);
