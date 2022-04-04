require('./bootstrap');

$(document).ready(function ($) {
    fetchComments(); // Get the table from the dB to start

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function fetchComments() {

        // ajax
        $.ajax({
            type: "GET",
            url: "fetch-comments",
            dataType: 'json',
            success: function (res) {

                // console.log(res);

                $('tbody').html("");
                $.each(res.comments, function (key, item) {

                    $('tbody').append('<tr>\
        <td><input type="checkbox" name="selected" id="selected' + item.id + '" value="' + item.selected + '"/></td>\
        <td>' + item.id + '</td>\
        <td>' + item.text + '</td>\
        <td>' + item.code + '</td>\
        <td>' + item.feedback + '</td>\
        <td>' + item.type + '</td>\
        <td>' + item.author_name + '</td>\
        <td>' + item.author_email + '</td>\
        <td><button type="button" data-id="' + item.id + '" class="btn btn-primary edit btn-sm">Edit</button>\
        <button type="button" data-id="' + item.id + '" class="btn btn-danger delete btn-sm">Delete</button></td>\
        </tr>');
                });
            },

            complete: function () {
                isChecked();
            }
        });

    }

    $('#addNewComment').click(function (evt) {
        evt.preventDefault();

        $('#addEditCommentForm').trigger("reset");
        $('#ajaxCommentModel').html("Add New Comment");
        $('#btn-add').show();
        $('#btn-save').hide();
        $('#ajax-comment-model').modal('show');
    });


    $('body').on('click', '#btn-add', function (event) {
        event.preventDefault();
        var text = $("#text").val();
        var code = $("#code").val();
        var feedback = $("#feedback").val();
        var type = $("#type").val();
        var author_name = $("#author_name").val();
        var author_email = $("#author_email").val();
        $("#btn-add").html('Please Wait...');
        $("#btn-add").attr("disabled", true);

        // ajax
        $.ajax({
            type: "POST",
            url: "save-comment",

            data: {
                text: text,
                code: code,
                feedback: feedback,
                type: type,
                author_name: author_name,
                author_email: author_email,
            },

            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status == 400) {
                    $('#msgList').html("");
                    $('#msgList').addClass('alert alert-danger');
                    $.each(res.errors, function (key, err_value) {
                        $('#msgList').append('<li>' + err_value + '</li>');
                    });

                    $('#btn-save').text('Save changes');
                } else {
                    $('#message').html("");
                    $('#message').addClass('alert alert-success');
                    $('#message').text(res.message);
                    fetchComments();
                }
            },

            complete: function () {
                $("#btn-add").html('Save');
                $("#btn-add").attr("disabled", false);
                $("#btn-add").hide();
                $('#ajax-comment-model').modal('hide');
                $('#message').fadeOut(4000);
            }
        });
    });

    $('body').on('click', '.edit', function (evt) {
        evt.preventDefault();
        var id = $(this).data('id');

        // ajax
        $.ajax({
            type: "GET",
            url: "edit-comment/" + id,
            dataType: 'json',
            success: function (res) {
                console.dir(res);
                $('#ajaxCommentModel').html("Edit Comment");
                $('#btn-add').hide();
                $('#btn-save').show();
                $('#ajax-comment-model').modal('show');

                if (res.status == 404) {
                    $('#msgList').html("");
                    $('#msgList').addClass('alert alert-danger');
                    $('#msgList').text(res.message);

                } else {

                    // console.log(res.book.xxx);
                    $('#text').val(res.comment.text);
                    $('#code').val(res.comment.code);
                    $('#feedback').val(res.comment.feedback);
                    $('#type').val(res.comment.type);
                    $('#author_name').val(res.comment.author_name);
                    $('#author_email').val(res.comment.author_email);
                    $('#id').val(res.comment.id);

                }

            }
        });
    });

    $('body').on('click', '.delete', function (evt) {
        evt.preventDefault();
        if (confirm("Delete Comment?") == true) {
            var id = $(this).data('id');

            // ajax
            $.ajax({
                type: "DELETE",
                url: "delete-comment/" + id,
                dataType: 'json',
                success: function (res) {
                    // console.log(res);
                    if (res.status == 404) {
                        $('#message').addClass('alert alert-danger');
                        $('#message').text(res.message);
                    } else {
                        $('#message').html("");
                        $('#message').addClass('alert alert-success');
                        $('#message').text(res.message);
                    }
                    fetchComments();
                }
            });
        }
    }); 

    $('body').on('click', '#btn-save', function (event) {
        event.preventDefault();
        var id = $("#id").val();
        var text = $("#text").val();
        var code = $("#code").val();
        var feedback = $("#feedback").val();
        var type = $("#type").val();
        var author_name = $("#author_name").val();
        var author_email = $("#author_email").val();

        // alert("id="+id+" title = " + title);
        $("#btn-save").html('Please Wait...');
        $("#btn-save").attr("disabled", true);

        // ajax
        $.ajax({
            type: "PUT",
            url: "update-comment/" + id,
            data: {
                text: text,
                code: code,
                feedback: feedback,
                type: type,
                author_name: author_name,
                author_email: author_email,
            },

            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status == 400) {
                    $('#msgList').html("");
                    $('#msgList').addClass('alert alert-danger');
                    $.each(res.errors, function (key, err_value) {
                        $('#msgList').append('<li>' + err_value + '</li>');
                    });

                    $('#btn-save').text('Save changes');
                } else {
                    $('#message').html("");
                    $('#message').addClass('alert alert-success');
                    $('#message').text(res.message);
                    fetchComments();
                }
            },

            complete: function () {
                $("#btn-save").html('Save changes');
                $("#btn-save").attr("disabled", false);
                $('#ajax-comment-model').modal('hide');
                $('#message').fadeOut(4000);
            }
        });
    });

    $("#btnGet").click(function () {

        var message = "";

        //Loop through all checked CheckBoxes in GridView.

        $("#Table1 input[type=checkbox]:checked").each(function () {
            var row = $(this).closest("tr")[0];

            // message += row.cells[2].innerHTML;
            message += " " + row.cells[3].innerHTML;

            // message += " " + row.cells[4].innerHTML;
            message += "\n-----------------------\n";

        });


        //Display selected Row data in Alert Box.

        $("#messageList").html(message);
        return false;

    });


    $("#copy").click(function () {

        $("#messageList").select();
        document.execCommand("copy");
        alert("Copied On clipboard");

    });



    function isChecked() {

        $("#Table1 input[type=checkbox]").each(function () {
            if ($(this).val() == 1) {
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }

        });
    }

});
