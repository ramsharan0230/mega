@extends('admin.layouts.app')
@section('page_title', 'All visitors')

@push('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />

<style media="screen">
    .adjust-delete-button {
        margin-top: -28px;
        margin-left: 37px;
    }
</style>
@endpush
@section('content')

<div class="page-heading">
    @include('admin.layouts._partials.messages.info')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All visitors</div>
            <form method="post" action="{{route('exportVisitors')}}" enctype="multipart/form-data">
                @csrf
                <button class="btn btn-primary btn-sm mt-3"><i class="fa fa-edit"></i> Export Visitors
                </button>
            </form>
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Student Name</th>
                        <th>Student Email</th>
                        <th>Student Phone</th>
                        <th>Exhibitor Name</th>
                        <th>Visited Date</th>
                    </tr>
                </thead>
                <tbody>

                    @if($details->count())
                    @foreach($details as $key => $data)

                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->user_name}}</td>
                        <td>{{$data->user_email}}</td>
                        <td>{{$data->user_phone}}</td>
                        <td>{{$data->exhibitor_name}}</td>
                        <td>{{\Carbon\Carbon::parse($data->create_at)->format('Y, M d')}}</td>

                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any data yet.
                        </td>
                    </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
@push('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,

        });
    })
</script>
@endpush

{{-- <td><a href="/images/main/{{$data->image}}" target="_blank"><img style="height:120px; width: 120px;"
    src="{{$data->image ? asset('/images/thumbnail/' . $data->image) : '/assets/admin/images/image.jpg' }}"></a>
</td> --}}

{{-- <form class="adjust-delete-button" action="{{route('category.destroy', $data->id)}}"
method="post">
@csrf
@method('delete')
<button class="btn btn-danger btn-sm" type="submit" name="button" style="border-radius:50%"
    onclick="return confirm('Are you sure you want to delete this category?')"><i class="fa fa-trash"></i></button>
</form> --}}