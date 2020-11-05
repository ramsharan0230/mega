@extends('admin.layouts.app')
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
    <h1 class="page-title">Pages</h1>
    <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All News</li>
    </ol> -->
    @include('admin.layouts._partials.messages.info')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Pages</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('pages.create')}}">Add Pages</a>
            </div>
        </div>


        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-bordered table-hover" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Description</th>
                        {{-- <th>Image</th> --}}
                        <th>Published</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>

                    @if($details->count())
                    @foreach($details as $key => $data)

                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{$data->slug}}</td>
                        <td>{!! str_limit($data->description, 200) !!}</td>

                        {{-- <td><a href="/images/main/{{$data->image}}" target="_blank"><img
                            style="height:90px; width: 90px;"
                            src="{{$data->image ? asset('/images/main/' . $data->image) : '/assets/admin/images/image.jpg' }}"></a>
                        </td> --}}

                        <td>{{$data->published == 1 ? 'Published' : 'Not Published'}}</td>

                        <td>
                            <a href="{{route('pages.edit', $data->id)}}" class="btn btn-success btn-sm"><i
                                    class="fa fa-edit"></i></a>

                            @if(!in_array($data->slug, $readonlyslug))
                            <form class="adjust-delete-button" action="{{route('pages.destroy', $data->id)}}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" type="submit" name="button"
                                    style="border-radius:50%"
                                    onclick="return confirm('Are you sure you want to delete this?')"><i
                                        class="fa fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any Pages yet.
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