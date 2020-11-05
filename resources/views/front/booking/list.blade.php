@extends('front.exhibitor.exhibitorMaster')
@section('page_title', 'All bookings')

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
    <h1 class="page-title">Bookings</h1>
    @include('admin.layouts._partials.messages.info')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All bookings</div>
            <form method="post" action="{{route('front.studentExport')}}" enctype="multipart/form-data">
                @csrf
                <input name="user_id" type="hidden" value="{{auth()->user()->id}}">
                <button class="btn btn-primary btn-sm mt-3"><i class="fa fa-edit"></i> Export Students
                </button>
            </form>
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Exhibitor Name</th>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Booked Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>

                    @if($details->count())
                    @foreach($details as $key => $data)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->exhibitor->title ?? ''}}</td>
                        <td>{{$data->user->name ?? ''}}</td>
                        <td>{{$data->date}}</td>
                        <td>{{$data->datetime->time ?? ''}}</td>
                        <td>{{$data->isBooked == 1 ? 'Booked' : 'Not Booked'}}</td>
                        <td>
                            <a href="{{route('front.booking.edit', $data->id)}}" class="btn btn-success btn-sm mb-2"><i
                                    class="fa fa-edit"></i>
                            </a>

                            @if($data->isBooked == 0)
                            <form method="post" action="{{route('front.booking.update', $data->id)}}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <input name="isBooked" type="hidden" value="1">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Confirm Booking
                                </button>
                            </form>
                            @endif

                        </td>
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