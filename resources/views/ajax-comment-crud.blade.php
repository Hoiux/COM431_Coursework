@extends('base')
@section('main')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 card-header text-center font-weight-bold">
                <h2>Comment Bank</h2>
            </div>
            <div id="message"></div>

            <!--
                <section>
                    <span class="a">
                        <nav>
                            <ul>
                                <li><a href="#">Display Comment Bank</a></li>
                                <li><a href="#">Modify Comment Bank</a></li>
                                <li><a href="#">Display Unverified Comments</a></li>
                                <li><a href="#">Show All Comments</a></li>
                            </ul>
                        </nav>
                    </span>
                </section>
                -->


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
            <textarea id="messageList" rows="10" cols="100">Selection</textarea> <button type="button" id="copy">Copy</button>
        </div>
    </div>

    <div class="col-md-12 mt-1 mb-2">
        <button type="button" id="addNewComment" class="btn btn-success">Add New Comment</button>
        <button type="button" id="editComment" class="btn btn-success">Edit Comment</button>
        <button type="button" id="deleteComment" class="btn btn-success">Delete Comment</button>
        <button onclick="location.href='{{ url('admin-funcs') }}'">Admin Functions</button>
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
