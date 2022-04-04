@extends('base')
@section('main')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Comment Bank</h2>
            </div>
            <div id="message"></div>

            <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewComment" class="btn btn-success">Add</button></div>
            <div class="col-md-12">
                <table id="Table1" class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">#</th>
                            <th scope="col">Comment Text</th>
                            <th scope="col">Comment Code</th>
                            <th scope="col">Comment Feedback</th>
                            <th scope="col">Comment Type</th>
                            <th scope="col">Author_Name</th>
                            <th scope="col">Author_Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (isset($comments))
                            @foreach ($comments as $comment)
                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->text }}</td>
                                    <td>{{ $comment->code }}</td>
                                    @if ($comment->feedback == 0)
                                        <td>Negative</td>
                                    @else
                                        <td>Positive</td>
                                    @endif
                                    <td>{{ $comment->type }}</td>
                                    <td>{{ $comment->author_name }}</td>
                                    <td>{{ $comment->email }}</td>
                                    <td>
                            @endforeach
                        @endif
                    </tbody>

                </table>

                <input id="btnGet" type="button" value="Get Selected" />
                <div class="d-flex justify-content-center">
                    @if (isset($comments))
                        {!! $comments->links('pagination::bootstrap-4') !!}
                    @endif
                </div>
            </div>
        </div>

        <div>
            <textarea id="messageList" rows="10" cols="100">Selection</textarea> <button type="button" id="copy">Copy</button>
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
                    <form action="javascript:void(0)" id="addEditCommentForm" name="addEditCommentForm" class="form-horizontal"
                        method="POST">
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Comment</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="comment" name="comment" rows="4" cols="10">Enter Comment Text</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">First Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Enter Your First Name" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Surname</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="surname" name="surname"
                                    placeholder="Enter Your Surname" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="email" name="emal"
                                    placeholder="Enter your email address" value="" required="">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-4 control-label">Feedback Type</label>
                            <div class="col-sm-12">
                                    <label class="container">Positive
                                        <input type="checkbox" checked="checked">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Negative
                                        <input type="checkbox" checked="checked">
                                        <span class="checkmark"></span>
                                    </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Comment Type</label>
                            <div class="col-sm-12">
                                    <label class="container">Intro Material
                                        <input type="checkbox" checked="checked">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Abstracts
                                        <input type="checkbox" checked="checked">
                                        <span class="checkmark"></span>
                                    </label>
                            </div>
                        </div>


                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-add" value="addNewComment">Save </button>
                            <button type="submit" class="btn btn-primary" id="btn-save" value="UpdateComment">Save changes
                            </button>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
