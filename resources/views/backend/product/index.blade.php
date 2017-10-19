@extends('backend.master')

@section('title', 'Product')
@section('content')
	<section>
		<div class="row">
		<div class="col-md-12">
		<h2>Product List</h2>
		<table id="product-table" class="table table-striped table-bordered table-hover">
		    <thead>
		        <tr>
		        	<th>#</th>
		            <th>Name</th>
		            <th>Images</th>
		            <th>Price</th>
		            <th>Stock</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		        	<td></td>
		        	<td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		            <td></td>
		        </tr>
		    </tbody>
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
            ajax: '{{ url('admin/product/data') }}',
            columns: [
            	{data: 'id', name: 'id'},
	            {data: 'name', name: 'name'},
	            {data: 'images', name: 'images'},
	            {data: 'price', name: 'price'},
	            {data: 'stock', name: 'stock'},
	            {data: 'action', name: 'action', orderable: false, searchable: false}
        	]
        });
    });

</script>
@endsection