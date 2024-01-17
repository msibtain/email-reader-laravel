@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    

                    <div class="row">
                        <div class="col-md-8"><h3>{{ __('Link Detail') . ' - ' . $email->links }}</h3></div>
                        <div class="col-md-4 text-right">
                            
                        </div>
                    </div>

                    
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif



                    <div class="table-responsive-sm">
                    <table id="datatable" class="table" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <td>From Name</td>
                                <td>From Email</td>
                                <td>From Host</td>
                                <td>Subject</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                    </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<style>
label {
    display: inline-flex !important;
}
#datatable_length {
	margin-bottom: 10px;
}
.custom-select {
	margin: 0 8px;
}

#datatable_filter input[type="search"] {
	margin-left: 8px;
}

@media only screen and (min-width: 600px) {
#datatable_filter {
	text-align: right;
}    
.pagination {
	float: right;
}
}
</style>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    $(document).ready(function() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/links/detail/'.$id) }}",
                type: "POST",
                data: function (data) {
                    data.search = $('input[type="search"]').val();
                }
            },
            order: ['1', 'DESC'],
            pageLength: 10,
            searching: true,
            aoColumns: [
                {
                    data: 'from_name',
                },
                {
                    data: 'from_email',
                },
                {
                    data: 'from_host',
                },
                {
                    data: 'subject',
                },
                {
                    data: 'created_at',
                }
            ]
        });
    });

    
</script>
@endsection
