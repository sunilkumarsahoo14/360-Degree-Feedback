$(document).ready(function () {
    $('#role').on('change', function () {
        const selectedRole = $(this).val();
        if (selectedRole !== '') {
            $.ajax({
                url: 'get_emails_by_role.php',
                type: 'POST',
                data: { role: selectedRole },
                dataType: 'json',
                success: function (emails) {
                    const emailDropdown = $('#email');
                    emailDropdown.empty().append('<option value="">-- Select Email --</option>');
                    $.each(emails, function (index, email) {
                        emailDropdown.append('<option value="' + email + '">' + email + '</option>');
                    });
                },
                error: function () {
                    alert('Error fetching emails.');
                }
            });
        } else {
            $('#email').empty().append('<option value="">-- Select Email --</option>');
        }
    });
});
