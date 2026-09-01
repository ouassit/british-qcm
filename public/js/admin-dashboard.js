$(document).ready(function () {
    function showAdminAlert(message, type) {
        var $alert = $('#admin-dashboard-alert');
        $alert
            .removeClass('alert-success alert-danger')
            .addClass(type === 'success' ? 'alert-success' : 'alert-danger')
            .text(message)
            .fadeIn(120);

        window.setTimeout(function () {
            $alert.fadeOut(160);
        }, 3000);
    }

    function updateExpiration($row, response) {
        var daysText = response.days_left < 0
            ? Math.abs(response.days_left) + ' days late'
            : response.days_left + ' days left';

        $row.find('.js-expire-date').text(response.expire_date);
        $row.find('.js-days-left').text(daysText);
        $row.find('.js-renew-date').val(response.expire_date);
        $row.find('.js-expire-status')
            .removeClass('badge-finished badge-progress badge-waiting badge-expired')
            .addClass(response.status_class)
            .text(response.status_label);
    }

    function renewCenter($control, data) {
        var $row = $control.closest('tr');

        $.ajax({
            url: $control.data('url'),
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                updateExpiration($row, response);
                showAdminAlert('Center renewed successfully.', 'success');
            },
            error: function () {
                showAdminAlert('Unable to renew this center.', 'danger');
            }
        });
    }

    function updatePassword($control) {
        var $row = $control.closest('tr');
        var $input = $row.find('.js-center-password');
        var password = $input.val();

        if (!password || password.length < 6) {
            showAdminAlert('Password must contain at least 6 characters.', 'danger');
            $input.focus();
            return;
        }

        $.ajax({
            url: $control.data('url'),
            method: 'POST',
            data: {
                password: password
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $input.val('');
                showAdminAlert('Center password updated successfully.', 'success');
            },
            error: function () {
                showAdminAlert('Unable to update this password.', 'danger');
            }
        });
    }

    $('.js-renew-center').on('click', function () {
        renewCenter($(this), {
            months: $(this).data('months')
        });
    });

    $('.js-renew-date').on('change', function () {
        renewCenter($(this), {
            expire_date: $(this).val()
        });
    });

    $('.js-update-password').on('click', function () {
        updatePassword($(this));
    });
});
