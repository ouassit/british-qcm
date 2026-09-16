$(function () {
    var $panel = $('.import-panel');
    var $source = $('#source-center');
    var $destination = $('#destination-center');
    var $tests = $('#source-tests');
    var $import = $('#import-tests');
    var csrf = $('meta[name="csrf-token"]').attr('content');

    function alert(message, type) {
        $('#test-import-alert').removeClass('alert-success alert-danger').addClass(type === 'success' ? 'alert-success' : 'alert-danger').text(message).show();
    }
    function selectedTests() { return $('.js-import-test:checked').map(function () { return this.value; }).get(); }
    function refreshImportButton() { $import.prop('disabled', !($source.val() && $destination.val() && $source.val() !== $destination.val() && selectedTests().length)); }
    function setProgress(percent, label) {
        $('#import-progress-wrap').removeClass('d-none');
        $('#import-progress').css('width', percent + '%').attr('aria-valuenow', percent);
        $('#import-progress-value').text(percent + '%');
        $('#import-progress-label').text(label);
    }
    function renderTests($container, tests, emptyMessage, selectable) {
        if (!tests.length) { $container.text(emptyMessage).addClass('text-muted'); return; }
        $container.removeClass('text-muted').empty();
        $.each(tests, function (_, test) {
            var $item = selectable
                ? $('<label class="import-test-item"><input type="checkbox" class="js-import-test" value="' + test.id + '"> <strong></strong> <small></small></label>')
                : $('<div class="import-test-item"><strong></strong> <small></small></div>');
            $item.find('strong').text(test.name);
            $item.find('small').text(test.questions_count + ' questions' + (test.duration ? ' · ' + test.duration + ' min' : ''));
            $item.appendTo($container);
        });
    }

    $source.on('change', function () {
        var id = $source.val();
        $tests.html(id ? 'Loading tests…' : 'Choose a source center to view its tests.').addClass('text-muted');
        $('#select-all-tests').prop('disabled', true).text('Select all');
        refreshImportButton();
        if (!id) return;
        $.getJSON($panel.data('tests-url').replace('__CENTER__', id)).done(function (tests) {
            renderTests($tests, tests, 'This center has no tests.', true);
            $('#select-all-tests').prop('disabled', !tests.length);
        }).fail(function () { $tests.text('Unable to load tests.'); alert('Unable to load source tests.', 'danger'); });
    });

    $destination.on('change', function () {
        var id = $destination.val();
        var $destinationTests = $('#destination-tests');
        $destinationTests.html(id ? 'Loading existing tests…' : 'Choose a destination center to view its existing tests.').addClass('text-muted');
        refreshImportButton();
        if (!id) return;
        $.getJSON($panel.data('tests-url').replace('__CENTER__', id)).done(function (tests) {
            renderTests($destinationTests, tests, 'This center has no tests yet.', false);
        }).fail(function () {
            $destinationTests.text('Unable to load existing tests.');
            alert('Unable to load destination tests.', 'danger');
        });
    });
    $tests.on('change', '.js-import-test', refreshImportButton);
    $('#select-all-tests').on('click', function () {
        var check = $('.js-import-test:not(:checked)').length > 0;
        $('.js-import-test').prop('checked', check);
        $(this).text(check ? 'Clear selection' : 'Select all');
        refreshImportButton();
    });

    $import.on('click', function () {
        var ids = selectedTests();
        if (!ids.length || $source.val() === $destination.val()) { alert('Choose different centers and at least one test.', 'danger'); return; }
        $import.prop('disabled', true); $('select, .js-import-test, #select-all-tests').prop('disabled', true);
        var completed = 0, questions = 0, choices = 0;
        function next() {
            if (completed === ids.length) {
                setProgress(100, 'Import complete');
                alert(completed + ' test(s) imported: ' + questions + ' questions and ' + choices + ' answers.', 'success');
                $('.js-import-test').prop('checked', false); $('select, .js-import-test, #select-all-tests').prop('disabled', false); refreshImportButton();
                window.setTimeout(function () { $('#import-progress-wrap').addClass('d-none'); }, 1200);
                return;
            }
            setProgress(Math.round((completed / ids.length) * 100), 'Importing test ' + (completed + 1) + ' of ' + ids.length + '…');
            $.ajax({ url: $panel.data('import-url'), method: 'POST', headers: {'X-CSRF-TOKEN': csrf}, data: {source_center_id: $source.val(), destination_center_id: $destination.val(), test_id: ids[completed]} })
                .done(function (data) { completed++; questions += data.questions; choices += data.choices; next(); })
                .fail(function (xhr) { var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Import stopped. No further tests were imported.'; alert(message, 'danger'); $('select, .js-import-test, #select-all-tests').prop('disabled', false); refreshImportButton(); });
        }
        next();
    });
});
