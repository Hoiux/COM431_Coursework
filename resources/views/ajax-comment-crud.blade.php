@extends('base')
@section('main')
    <!-- admin password form -->
    <div class="container mt-2" id="password-field">
        <h3>Administrator Password</h3>
        <form action="javascript:void(0)" id="tryAdminForm" name="tryAdminForm" class="form-horizontal" method="POST">
            <input type="text" class="form-control" id="admin_password" name="admin_password" placeholder="Admin Password"
                value="" maxlength="128" required="">
            <button type="submit" class="btn btn-primary" id="btn-sendAdminPassword"
                value="sendAdminPassword">Submit</button>
            <button type="button" class="btn btn-primary" id="btn-cancelAdminPassword">Cancel</button>
        </form>
        <div id="login-messages"></div>
    </div>

    <div class="container mt-2" id="comment-bank">
        <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h1>Comment Bank</h1>
            </div>
            <div id="message"></div>

            <div class="col-md-12">
                <table id="Table1" class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">#</th>
                            <th scope="col">Comment Text</th>
                            <th scope="col">Code</th>
                            <th scope="col">Feedback</th>
                            <th scope="col">Category</th>
                            <th scope="col">Author</th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Javascript renders the table body. Look in resources/js/app.js. -->
                    </tbody>

                </table>

                <input id="btnGet" type="button" value="Get Selected Comment(s)" />
                <div class="d-flex justify-content-center">
                    @if (isset($comments))
                        {!! $comments->links('pagination::bootstrap-4') !!}
                    @endif
                </div>
            </div>
        </div>

        <div>
            <textarea id="messageList" rows="10" cols="100">Selection</textarea>
        </div>

        <div class="col-md-12 mt-1 mb-2" id="comment-buttons">
            <button type="button" id="copy" class="button2">Copy</button>
            <button type="button" id="addNewComment" class="btn btn-success">Add New Comment</button>
            <button type="button" id="editComment" class="btn btn-success">Edit Comment</button>
            <button type="button" id="deleteComment" class="btn btn-success">Delete Comment</button>
            <button type="button" id="adminLogin" class="btn btn-success">Login as Admin</button>
        </div>
    </div>


    <!-- boostrap model -->
    <div class="modal fade" id="ajax-comment-model" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ajaxCommentModel"></h4>
                </div>

                <div class="modal-body">
                    <ul id="msgList"></ul>
                    <form action="javascript:void(0)" id="addEditCommentForm" name="addEditCommentForm"
                        class="form-horizontal" method="POST">
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Comment</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="comment" name="comment" rows="4" cols="10"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Code</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="code" name="code"
                                    placeholder="Enter comment code (AB## or IM##)" value="" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Author Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="author_name" name="author_name"
                                    placeholder="Enter Your Name" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="author_email" name="author_email"
                                    placeholder="Your email address" value="" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Feedback Type</label>
                            <div class="col-sm-12">
                                <label class="container">Positive
                                    <input type="checkbox" id="feedback" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Negative
                                    <input type="checkbox" checked="unchecked">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Comment Type</label>
                            <div class="col-sm-12">
                                <label class="container">Intro Material
                                    <input type="checkbox" id="type" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Abstracts
                                    <input type="checkbox" checked="unchecked">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-add" value="addNewComment">Save</button>
                            <button type="submit" class="btn btn-primary" id="btn-save" value="UpdateComment">Save
                                changes</button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
