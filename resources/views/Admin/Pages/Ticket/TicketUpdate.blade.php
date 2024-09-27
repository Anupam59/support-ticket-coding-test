@extends('Admin.Layout.AdminLayout')
@section('title', 'Ticket Update')
@section('AdminContent')
    <?php
    $user = auth()->user();
    ?>
    <div class="content-wrapper" style="min-height: 1604.08px;" data-select2-id="31">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ticket Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/') }}/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ticket Update</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header">

                        <a class="btn btn-danger btn-sm add_btn" href="{{ url('/admin/') }}/ticket-list">
                            All Data
                        </a>


                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-default-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h5 class="text-bold">Title</h5>
                                    <p>{{ $Ticket->ticket_title }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h5 class="text-bold">Description</h5>
                                    <p>{!! $Ticket->ticket_description !!}</p>
                                </div>
                            </div>

                            @if($user->role == 1)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        @if($Ticket->status == 2)
                                            <button class="btn btn-primary">Already done</button>
                                        @else
                                            <button id="TicketDoneBtn" data-id="{{ $Ticket->ticket_id }}" class="btn btn-primary">Please done now</button>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Comment Write</h1>
                    </div>
                </div>

                <div class="card card-default">
                    <div class="card-body">
                        <form action="{{ url('admin/comment-entry') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="comment_text" placeholder="....Comment Write...."></textarea>
                                    <input type="hidden" class="form-control" name="ticket_id" value="{{ $Ticket->ticket_id }}">
                                    <button type="submit" class="btn btn-primary mt-2">Send</button>
                                </div>
                            </div>
                        </form>

                        @if(!$Comment->isEmpty())
                            <div class="card card-default p-3">
                                @foreach($Comment as $key=>$CommentItem)
                                    <div class="card card-default p-3">
                                        <h6 class="text-bold">{{ $CommentItem->creator_by }}</h6>
                                        <p>{{ $CommentItem->comment_text }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="DoneTicketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('admin/ticket-done')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-3 text-center">
                        <h5 class="mt-4">Do you want to Closes the ticket?</h5>
                        <input id="TicketDoneId" type="hidden" name="ticket_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                        <button  id="TaskDeleteConfirmBtn" type="submit" class="btn  btn-sm  btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('AdminScript')
    <script>
        $('#ticket_status').select2();
        $('#ticket_description').summernote({
            placeholder: 'News Description',
            height: 120,
        });

        $('#TicketDoneBtn').click(function(){
            var id= $(this).data('id');
            $('#TicketDoneId').val(id);
            $('#DoneTicketModal').modal('show');
        })



        @if(Session::has('success_message'))
            toastr.options ={"closeButton" : true,"progressBar" : true}
            toastr.success("{{ session('success_message') }}");
        @endif
            @if(Session::has('error_message'))
            toastr.options ={"closeButton" : true,"progressBar" : true}
            toastr.error("{{ session('error_message') }}");
        @endif

    </script>
@endsection
