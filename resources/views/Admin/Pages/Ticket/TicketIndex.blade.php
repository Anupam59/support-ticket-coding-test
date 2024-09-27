@extends('Admin.Layout.AdminLayout')
@section('title', 'Ticket')
@section('AdminContent')
    <?php
    date_default_timezone_set("Asia/Dhaka");
    ?>
    <div class="content-wrapper" style="min-height: 1604.08px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ticket</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/') }}/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ticket</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

        @if(!$Ticket->isEmpty())

                <div class="card pt-2">
                    <form action="{{ url('admin/ticket-list') }}" method="get" class="formDiv">
                        <div class="row gy-4 justify-content-center">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" id="ticket_status" name="status">
                                        <option value="" selected="selected">Select One</option>
                                        <option value="1" @if(request()->query('status') == "1") {{ 'selected' }} @endif>Pending</option>
                                        <option value="2" @if(request()->query('status') == "2") {{ 'selected' }} @endif>Progress</option>
                                        <option value="3" @if(request()->query('status') == "3") {{ 'selected' }} @endif>Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="invisible d-block">Search</label>
                                <input style="width: 70px" class="btn btn-default" id="resetID" value="Reset">
                                <input class="btn btn-default" type="submit" value="Search">
                            </div>
                        </div>
                    </form>
                </div>

            <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-danger btn-sm add_btn" href="{{ url('/admin/') }}/ticket-create">
                            Add <i class="fas fa-plus"></i>
                        </a>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 1%">
                                    SL
                                </th>
                                <th style="width: 40%">
                                    Title
                                </th>
                                <th style="width: 15%" class="text-center">
                                    Creator
                                </th>
                                <th style="width: 20%" class="text-center">
                                    Date
                                </th>
                                <th style="width: 9%" class="text-center">
                                    Status
                                </th>
                                <th style="width: 10%" class="text-center">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($Ticket as $key=>$TicketItem)

                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <a>{{ $TicketItem->ticket_title }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a>{{ $TicketItem->creator_by }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a>{{ date('d M Y h:i a', strtotime($TicketItem->created_date)) }}</a>
                                    </td>
                                    <td class="project-state">
                                        @if($TicketItem->status == 1)
                                            <span class="badge badge-primary">Pending</span>
                                        @elseif($TicketItem->status == 2)
                                            <span class="badge badge-success">Closes</span>
                                        @endif
                                    </td>
                                    <td class="project-actions text-center">
                                        <a class="btn btn-primary btn-sm" href="{{ url('/admin/') }}/ticket-edit/{{ $TicketItem->ticket_id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm ticketDeleteBtn" data-id="{{ $TicketItem->ticket_id }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="row">
                    <div class="col d-flex align-items-center justify-content-center">
                        {{ $Ticket->onEachSide(3)->links('Admin.Common.Paginate') }}
                    </div>
                </div>

            @else
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-danger btn-sm add_btn" href="{{ url('/admin/') }}/ticket-create">
                            Add <i class="fas fa-plus"></i>
                        </a>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @include('Admin.Common.DataNotFound')
            @endif

        </section>
        <!-- /.content -->
    </div>




    <div class="modal fade" id="deleteTicketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('admin/ticket-delete')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-3 text-center">
                        <h5 class="mt-4">Do You Want To Delete?</h5>
                        <input id="TicketDeleteId" type="hidden" name="ticket_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
                        <button  id="TicketDeleteConfirmBtn" type="submit" class="btn  btn-sm  btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('AdminScript')
    <script>

        $('#resetID').click(function(){
            $('#ticket_status').val('');
        });


        $('.ticketDeleteBtn').click(function(){
            var id= $(this).data('id');
            $('#TicketDeleteId').val(id);
            $('#deleteTicketModal').modal('show');
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
