@extends('Admin.Layout.AdminLayout')
@section('title', 'Ticket Create')
@section('AdminContent')
    <div class="content-wrapper" style="min-height: 1604.08px;" data-select2-id="31">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Ticket Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/') }}/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ticket Create</li>
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
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success_message'))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success_message') }}
                            </div>
                        @elseif (session('error_message'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error_message') }}
                            </div>
                        @else

                        @endif
                        <form action="{{ url('admin/ticket-entry') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" value="{{ old('ticket_title') }}" name="ticket_title" placeholder="Title">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" id="ticket_description" name="ticket_description" placeholder="Description ...">{{ old('ticket_description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('AdminScript')
    <script>

        $('#ticket_description').summernote({
            placeholder: 'News Description',
            height: 120,
        });

    </script>
@endsection
