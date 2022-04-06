require('./bootstrap');

$(document).ready(function ($) {

    $('#password-field').hide();
    $('#ajax-comment-model').hide();
    $('#comment-bank').show();

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

                $('tbody').html("");
                $.each(res.comments, function (key, item) {

                    var feedback = (item.feedback) ? 'Positive' : 'Negative';

                    $('tbody').append('<tr>\
        <td><input type="checkbox" name="selected" id="selected' + item.id + '" value="' + item.selected + '"/></td>\
        <td>' + item.id + '</td>\
        <td>' + item.text + '</td>\
        <td>' + item.code + '</td>\
        <td>' + feedback + '</td>\
        <td>' + item.type + '</td>\
        <td>' + item.author_name + '</td>\
        <td>' + item.author_email + '</td>\
        </tr>');
                });
            },
            complete: function () {
                isChecked();
            }
        });
    }

    $('#adminLogin').click(function (evt) {
        evt.preventDefault();

        $('#comment-bank').hide();
        $('#ajax-comment-model').hide();
        $('#admin_password').val('');
        $('#password-field').show();
    });

    $('body').on('click', '#btn-cancelAdminPassword', function (evt) {
        evt.preventDefault();

        $('#password-field').hide();
        $('#comment-bank').show();
        $('#ajax-comment-model').hide();
    });

    $('#addNewComment').click(function (evt) {
        evt.preventDefault();

        $('#addEditCommentForm').trigger("reset");
        $('#ajaxCommentModel').html("Add New Comment");
        $('#btn-add').show();
        $('#btn-save').hide();
        $('#addEditCommentForm').show();
        $('#ajax-comment-model').show();

    });

    $('#editComment').click(function (evt) {
        evt.preventDefault();
        var id = -1;

        $("#Table1 input[type=checkbox]:checked").each(function () {
            // choose bottom-most selected comment
            var row = $(this).closest("tr")[0];
            id = row.cells[1].innerHTML;
        });

        if (id == -1) {
            return;
        }

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
                $('#addEditCommentForm').show();
                $('#ajax-comment-model').show();

                if (res.status == 404) {
                    $('#msgList').html("");
                    $('#msgList').addClass('alert alert-danger');
                    $('#msgList').text(res.message);

                } else {

                    // console.log(res.book.xxx);
                    $('#comment').val(res.comment.text);
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

    $('body').on('click', '#btn-sendAdminPassword', function (evt) {
        evt.preventDefault();

        var admin_password = $("#admin_password").val();

        $.ajax({
            type: "POST",
            url: "check-password",

            data: {
                password: admin_password,
            },

            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res.status == 400) {
                    $('#login-messages').text(res.message);
                } else {
                    fetchComments();
                    $('#password-field').hide();
                    $('#comment-bank').show();
                    $('#ajax-comment-model').hide();
                    $('#btn-save').html('Approve Comment');
                }
            },
        });
    });

    $('#deleteComment').click(function (evt) {
        evt.preventDefault();
        var id = -1;

        $("#Table1 input[type=checkbox]:checked").each(function () {
            // choose bottom-most selected comment
            var row = $(this).closest("tr")[0];
            id = row.cells[1].innerHTML;
        });

        if (id == -1) {
            return;
        }

        // ajax
        $.ajax({
            type: "DELETE",
            url: "delete-comment/" + id,
            dataType: 'json',
            success: function (res) {

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
    });

    $('body').on('click', '#btn-add', function (event) {
        event.preventDefault();

        var comment = $("#comment").val();
        var code = $("#code").val();
        var feedback = ($("#feedback").val() == 'checked') ? 1 : 0;
        var type = ($("#type").val() == 'checked') ? "INTRO" : "ABSTRACT";
        var author_name = $("#author_name").val();
        var author_email = $("#author_email").val();
        $("#btn-add").html('Please Wait...');
        $("#btn-add").attr("disabled", true);

        // ajax
        $.ajax({
            type: "POST",
            url: "save-comment",

            data: {
                text: comment,
                code: code,
                feedback: feedback,
                type: type,
                author_name: author_name,
                author_email: author_email,
                pending_approval: 1,
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
                $('#ajaxCommentModel').hide();
                $('#addEditCommentForm').trigger("reset");
                $('#addEditCommentForm').hide();
                $('#ajax-comment-model').modal('hide');
                $('#message').fadeOut(4000);
            }
        });
    });

    $('body').on('click', '#btn-save', function (event) {
        event.preventDefault();
        var id = $("#id").val();
        var comment = $("#comment").val();
        var code = $("#code").val();
        var feedback = ($("#feedback").val() == 'checked') ? 1 : 0;
        var type = ($("#type").val() == 'checked') ? "INTRO" : "ABSTRACT";
        var author_name = $("#author_name").val();
        var author_email = $("#author_email").val();

        $("#btn-save").html('Please Wait...');
        $("#btn-save").attr("disabled", true);

        // ajax
        $.ajax({
            type: "PUT",
            url: "update-comment/" + id,
            data: {
                text: comment,
                code: code,
                feedback: feedback,
                type: type,
                author_name: author_name,
                author_email: author_email,
                pending_approval: 0
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
                $('#ajaxCommentModel').hide();
                $('#addEditCommentForm').trigger("reset");
                $('#addEditCommentForm').hide();
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

            message += row.cells[2].innerHTML;
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
