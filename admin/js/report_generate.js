$(document).ready(function () {
    $('#role').on('change', function () {
        let role = $(this).val();
        $('#email').html('<option value="">Loading...</option>');
        if (role) {
            $.post('get_emails_by_role.php', { role }, function (data) {
                let options = '<option value="">-- Select Email --</option>';
                data.forEach(d => options += `<option value="${d.email}">${d.email}</option>`);
                $('#email').html(options);
            }, 'json');
        }
    });

    $('#email').on('change', function () {
        let role = $('#role').val();
        let email = $(this).val();
        if (email) {
            $.post('get_user_info.php', { role, email }, function (data) {
                $('#user-details').html(
                    `<p><strong>Name:</strong> ${data.name}</p>
                     <p><strong>Department:</strong> ${data.department}</p>
                     <p><strong>Semester:</strong> ${data.semester}</p>
                     <p><strong>Section:</strong> ${data.section}</p>`
                );
            }, 'json');
        }
    });

    $('#generate-report-btn').on('click', function () {
        let role = $('#role').val();
        let email = $('#email').val();
        if (role && email) {
            $.post('generate_report_logic.php', { role, email }, function (data) {
                $('#report-output').html(data);
            });
        }
    });
});
