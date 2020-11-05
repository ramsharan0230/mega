@extends('admin.layouts.app')
@section('page_title', 'All exhibitors')

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
    <h1 class="page-title">Exhibitors</h1>
    @include('admin.layouts._partials.messages.info')

</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All exhibitors</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('exhibitor.create')}}">Add exhibitor</a>
            </div>
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Exhibitor's name</th>
                        <th>Exhibitor's email</th>
                        <th>Category</th>
                        <th>Interested Countries</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>

                    @if($users->count())
                    @foreach($users as $key => $data)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email ?? ''}}</td>
                        <td>{{$data->exhibitor->category->title ?? ''}}</td>
                        <td>
                            <ul>
                                @foreach($data->exhibitor->countries as $country)
                                <li>{{$country->title}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$data->publish == 1 ? 'Published' : 'Not Published'}}</td>
                        <td>
                            <a href="{{route('exhibitor.edit', $data->id)}}" class="btn btn-success btn-sm"><i
                                    class="fa fa-edit"></i></a>

                            <a href="{{route('exhibitor.edit_info', $data->id)}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-edit"></i> Infos</a>

                            <form class="mt-2" action="{{route('exhibitor.destroy', $data->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" type="submit" name="button"
                                    style="border-radius:50%"
                                    onclick="return confirm('Are you sure you want to delete this exhibitor?')"><i
                                        class="fa fa-trash"></i></button>
                            </form>


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