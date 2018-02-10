@extends('backend.master')

@section('title', 'Menu')
@section('content')
	<section>
		<div class="row">
		<div class="col-md-12">
		<h2>Menu List</h2>
		<a href="{{ url('admin/menu/add') }}" class="btn btn-primary">Add Menu</a>
		<table id="product-table" class="table table-striped table-bordered table-hover">
		    <thead>
		        <tr>
		        	<th>#</th>
		            <th>Title</th>
		            <th>Path</th>
		            <th>Parent</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		</table>
		</div>
		</div>
	</section>
@endsection

@section('js')
<script type="text/javascript">
	$(function() {
        $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('admin/menu/data') }}',
            columns: [
            	{data: 'id', name: 'id'},
	            {data: 'title', name: 'title'},
	            {data: 'path', name: 'path'},
	            {data: 'parent', name: 'parent'},
	            {data: 'action', name: 'action', orderable: false, searchable: false}
        	]
        });
    });

</script>
@endsection