@extends('backend.master')

@section('title', 'User')
@section('content')
	<section>
		<div class="row">
		<div class="col-md-12">
		<h2>User List</h2>
		<table id="user-table" class="table table-striped table-bordered table-hover">
		    <thead>
		        <tr>
		        	<th>#</th>
		            <th>Name</th>
		            <th>Email</th>
		            <th>Status</th>
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
        $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('admin/user/data') }}',
            columns: [
            	{data: 'id', name: 'id'},
	            {data: 'first_name', name: 'first_name'},
	            {data: 'email', name: 'email'},
	            {data: 'is_admin', name: 'is_admin'},
	            {data: 'action', name: 'action', orderable: false, searchable: false}
        	]
        });
    });

</script>
@endsection