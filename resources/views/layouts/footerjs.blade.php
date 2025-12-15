<!-- Required Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ URL::asset('build/js/plugins/dataTables.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/jszip.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/popper.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('build/js/fonts/custom-font.js') }}"></script>
<script src="{{ URL::asset('build/js/pcoded.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins/feather.min.js') }}"></script>

<script>
    function handleDelete(url, data) {
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>' +
                '<div class="mt-4 pt-2 fs-15 mx-5">' +
                '<h4>Are you Sure ?</h4>' +
                '<p class="text-muted mx-4 mb-0">Are you Sure You want to Delete this Record ?</p>' +
                '</div>' +
                '</div>',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-primary w-xs me-2 mb-1',
            confirmButtonText: 'Yes, Delete It!',
            cancelButtonClass: 'btn btn-danger w-xs mb-1',
            buttonsStyling: false,
            showCloseButton: true
        }).then(function(confirm) {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>' +
                                '<div class="mt-4 pt-2 fs-15">' +
                                '<h4>Successfully Deleted !</h4>' +
                                '<p class="text-muted mx-4 mb-0"></p>' + '</div>' +
                                '</div>',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonClass: 'btn btn-primary w-xs mb-1',
                            cancelButtonText: 'OK',
                            buttonsStyling: false,
                            showCloseButton: true
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 500) {
                            var errorMessage = xhr.responseJSON
                                .message; // Assuming the server sends an error message in the response
                            Swal.fire({
                                html: '<div class="mt-3">' +
                                    '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                                    'trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px">' +
                                    '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' +
                                    '<h4>' +
                                    errorMessage + ' !</h4>' + '</div>' + '</div>',
                                showCancelButton: true,
                                showConfirmButton: false,
                                cancelButtonClass: 'btn btn-primary',
                                cancelButtonText: 'Dismiss',
                                buttonsStyling: false,
                                showCloseButton: true
                            }).then(() => {
                                // location.reload();
                            });
                        }
                    },
                });
            }
        });
    }

    function resetFormAndErrors(modalId, saveBtnId) {
        $('#submitForm')[0].reset();
        $('#submitForm').find('.is-invalid').removeClass('is-invalid');
        $('#submitForm').find('.invalid-feedback').remove();
        $(saveBtnId).removeClass('btn-success').text('Add');
        $(modalId).modal('hide');
        $(modalId).modal('show');
        $('.modal-title').removeClass('modelTitle');
    }

    $(document).on('click', '.add-new', function(e) {

        let modal = $('#varyingcontentModalLabel');
        let currentText = modal.text();

        if (currentText.includes('Edit')) {
            modal.text(currentText.replace('Edit', 'Create'));
        }
        if (currentText.includes('Show')) {
            modal.text(currentText.replace('Show', 'Create'));
        }
        $('#submitForm')[0].reset();
        $('#submitForm').find('.is-invalid').removeClass('is-invalid');
        $('#submitForm').find('.invalid-feedback').remove();
        $('.modal-footer').show();
        resetFormAndErrors('.createModel', '.save-button');
    });

    $('.btn-close, .btnClose').click(function() {
        resetFormAndErrors('.createModel', '.save-button');
    });

    $("#submitFormBtn").click(function() {

        var $btn = $(this);
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        // Clear previous error messages and styling
        // $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Get the native DOM element using document.getElementById
        var formData = new FormData(document.getElementById('submitForm'));

        $.ajax({
            type: 'POST',
            url: $('#submitForm').attr('action'),
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.cashier_closed) {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                            'trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px">' +
                            '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>Well done !</h4>' +
                            '<p class="text-muted mx-4 mb-0">' + response.message +
                            '!</p>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: 'OK',
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then(() => {
                        window.location.href = response.next_path;
                    });
                } else if (response.next) {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                            'trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px">' +
                            '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>Well done !</h4>' +
                            '<p class="text-muted mx-4 mb-0">' + response.message +
                            '!</p>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: 'OK',
                        buttonsStyling: false,
                        showCloseButton: true,
                        footer: '<a href="' + response.next_path + '?' + response
                            .next_param_name + '=' + response.next_param_value + '" ' +
                            response.next_attribute + '="' + response.next_value +
                            '">Next Process - ' + response.next_process_name + '</a>'
                    }).then(() => {
                        location.reload();
                    });

                } else {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                            'trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px">' +
                            '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>Well done !</h4>' +
                            '<p class="text-muted mx-4 mb-0">' + response.message +
                            '!</p>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: 'OK',
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then(() => {
                        location.reload();
                    });
                }

            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false).html(originalText);
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        // Convert validation key (e.g., documents.0.description) to input name (documents[0][description])
                        var inputName = key.replace(/\.(\d+)\./g, '[$1][').replace(/\.(\w+)$/g, '[$1]');
                        var inputField = $('[name="' + inputName + '"]');

                        if (!inputField.length && key.includes('.')) {
                            // Fallback: try top-level name if exact match not found
                            var baseKey = key.split('.')[0];
                            inputField = $('[name="' + baseKey + '"]');
                        }

                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            var container = inputField.closest('.form-group').length ? inputField.closest('.form-group') : inputField.parent();
                            container.append('<div class="invalid-feedback">' + value[0] + '</div>');
                        }
                    });
                }
            } else if (xhr.status === 500) {
                    var errorMessage = xhr.responseJSON
                        .message; // Assuming the server sends an error message in the response
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                            'trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px">' +
                            '</lord-icon>' + '<div class="mt-4 pt-2 fs-15">' + '<h4>' +
                            errorMessage + ' !</h4>' + '</div>' + '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary',
                        cancelButtonText: 'Dismiss',
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then(() => {
                        // location.reload();
                    });
                }
            },
            complete: function() {

            }
        });
    });
</script>

@if (env('APP_DARK_LAYOUT') == 'default')
    <script>
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            dark_layout = 'true';
        } else {
            dark_layout = 'false';
        }
        layout_change_default();
        if (dark_layout == 'true') {
            layout_change('dark');
        } else {
            layout_change('light');
        }
    </script>
@endif

@if (env('APP_DARK_LAYOUT') != 'default')
    @if (env('APP_DARK_LAYOUT') == 'true')
        <script>
            layout_change('dark');
        </script>
    @endif
    @if (env('APP_DARK_LAYOUT') == false)
        <script>
            layout_change('light');
        </script>
    @endif
@endif


@if (env('APP_DARK_NAVBAR') == 'true')
    <script>
        layout_sidebar_change('dark');
    </script>
@endif

@if (env('APP_DARK_NAVBAR') == false)
    <script>
        layout_sidebar_change('light');
    </script>
@endif

@if (env('APP_BOX_CONTAINER') == false)
    <script>
        change_box_container('true');
    </script>
@endif

@if (env('APP_BOX_CONTAINER') == false)
    <script>
        change_box_container('false');
    </script>
@endif

@if (env('APP_CAPTION_SHOW') == 'true')
    <script>
        layout_caption_change('true');
    </script>
@endif

@if (env('APP_CAPTION_SHOW') == false)
    <script>
        layout_caption_change('false');
    </script>
@endif

@if (env('APP_RTL_LAYOUT') == 'true')
    <script>
        layout_rtl_change('true');
    </script>
@endif

@if (env('APP_RTL_LAYOUT') == false)
    <script>
        layout_rtl_change('false');
    </script>
@endif

@if (env('APP_PRESET_THEME') != '')
    <script>
        preset_change("{{ env('APP_PRESET_THEME') }}");
    </script>
@endif
