$(document).ready(function () {
    $.ajaxSetup({
        beforeSend: function (xhr, settings) {
            if (settings.type == 'POST' || settings.type == 'PUT' || settings.type == 'DELETE') {
                xhr.setRequestHeader("X-CSRF-TOKEN", $('[name="csrf_token"]').attr('content'));
            }
        }
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_url').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function () {
        $('#image_hidden').val('');
        readURL(this);
    });
    $("#btn-back").click(function () {
        window.history.back();
    });
    $('section').on('click', '#btn-delete', function (event) {
        var response = confirm($(this).data('alert'));
        if (response) {
            var arr = [];
            $("input[type='checkbox']:checked").each(function () {
                arr.push($(this).val())
            });

            if (arr.length == 0) {
                alert($(this).data('check'));
                return false;
            }
            $.ajax({
                type: 'DELETE',
                url: $(this).data('url'),
                dataType: 'json',
                data: {
                    ids: arr
                },
                success: function (data, status) {
                    window.location.replace($('#btn-delete').data('manage'));
                }
            });
        }
    });
    $('section').on('click', '#btn-create', function (event) {
        window.location.replace($(this).data('url'));
    });
    $('section').on('click', '.select-all', function (event) {
        $("input[type='checkbox']").prop('checked', !$("input[type='checkbox']").prop('checked'));
    });
    $('section').on('click', '#btn-update-task', function (event) {
        var arr = [];
        $("input[type='checkbox']:checked").each(function () {
            arr.push($(this).val())
        });
        if (arr.length == 0) {
            alert($(this).data('check'));
            return false;
        }
        $.ajax({
            type: 'put',
            url: $(this).data('url'),
            data: {
                ids: arr
            },
            success: function (data, status) {
                location.reload(true);
            }
        });
    });
    $('.new-option').on('click', function (event) {
        parent = $(this).prev();
        newOption = parent.find('.col-md-10').clone();
        parent = parent.prev().find('.col-md-10');
        no = parent.find('.task-name').last().attr('id').split('-')[1];
        no = parseInt(no) + 1;
        newOption.find('.task-name').attr({name: 'name-' + no, id: 'name-' + no});
        newOption.find('.task-description').attr({name: 'description-' + no, id: 'description-' + no});
        newOption.find('.task-remove').attr({id: 'remove-' + no});
        parent.append(newOption.children());
        event.preventDefault();
    });
    $("#option-wrap").on('click', '.task-remove', function (event) {
        event.preventDefault();
        no = $(this).attr('id').split('-')[1];
        $("#name-" + no).remove();
        $("#description-" + no).remove();
        $("#remove-" + no).remove();
    });
    $('#create-subject').submit(function (event) {
        subparent = $(this).find('#option-wrap');
        no = subparent.find('.task-name').last().attr('id').split('-')[1];
        $("#option-count").val(parseInt(no));
    });
    $('section').on('click', '#btn-addTrainee', function (event) {
        var arr = [];
        $("input[type='checkbox']:checked").each(function () {
            arr.push($(this).val())
        });
        if (arr.length == 0) {
            alert($(this).data('check'));
            return false;
        }
        $.ajax({
            type: 'POST',
            url: $('#btn-addTrainee').data('url'),
            data: {
                ids: arr
            },
            success: function (data, status) {
                window.location.replace($('#btn-addTrainee').data('redirect'));
            }
        });
    });
    $('section').on('click', '#btn-destroy', function (event) {
        $.ajax({
            type: 'DELETE',
            url: $(this).data('url'),
            success: function (data, status) {
                window.location.replace($('#btn-destroy').data('redirect'));
            }
        });
    });
});
