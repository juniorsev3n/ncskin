@extends('backend.master')

@section('title', 'Product')
@section('content')
	<section class="content-header">
      <h1>
        Product List
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Product</li>
      </ol>
    </section>
	<section class="content">
		<div class="row">
		<hr>
		<a href="{{ url('admin/product/add') }}" class="btn btn-md btn-primary">Add Product</a>
		<hr>
		<div class="col-md-12">
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
		</table>
		</div>
		</div>
	</section>

<div class="modal fade" id="ProductViewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check-square"></i> <span class="title-modal"></span></h4>
            </div>
            <div class="modal-body">
                <div class="box-body row">
                    <div class="col-md-12">
                        <div class="box box-solid bg-aqua">
                            <div class="box-footer text-black">
                                <div class="modal-body">
                                <div class="content-detail">
                                <h3>Name Product : <span class="name-content"></span></h3>
                                    <span class="content-modal"></span>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-flat btn-primary" data-dismiss="modal"><i class="fa fa-check-square-o"></i> Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="ProductEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check-square"></i> <span class="title-modal"></span></h4>
            </div>
            <div class="modal-body">
                <div class="box-body row">
                    <div class="col-md-12">
                        <div class="box box-solid bg-aqua">
                            <div class="box-footer text-black">
                                <div class="modal-body">
                                <div class="content-detail">
                                <h3><Name Product : <input type="text" name="name" class="name-content"></h3>
                                    <span class="content-modal"></span>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-flat btn-primary" data-dismiss="modal"><i class="fa fa-check-square-o"></i> Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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
	            {data: 'images', name: 'images', 'render': function(val, _, obj) {
                    return '<img src="' + val + '" width="100px" height="120px">';
                }
        },
	            {data: 'price', name: 'price'},
	            {data: 'stock', name: 'stock'},
	            {data: 'action', name: 'action', orderable: false, searchable: false}
        	]
        });
    
	
    });
    function view(id) {
        if (id) {
            $.ajax({
            type: 'GET',
                    url: '{{ url('admin/product/show') }}'+'/'+id,
                    dataType: 'json',
                    success: function(data) {
                    $('.loader-page').fadeOut();
                        if (data) {
                            $('#ProductViewModal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            $('#myModalLabel').html(data.name);
                            $('.title-modal').html(data.name);
                            $('.name-content').html(data.name);
                            $('.images-modal').html(data.images);
                            $('.created-date-modal').html(data.created_at);
                            $('.content-modal').html(data.description);
                        }
                    }
            });
            return false;
        }
    }
    function edit(id) {
        if (id) {
            $.ajax({
            type: 'GET',
                    url: '{{ url('admin/product/show') }}'+'/'+id,
                    dataType: 'json',
                    success: function(data) {
                    $('.loader-page').fadeOut();
                        if (data) {
                            $('#ProductEditModal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            $('#myModalLabel').html(data.name);
                            $('.title-modal').html(data.name);
                            $('.name-content').val(data.name);
                            $('.images-modal').html(data.images);
                            $('.created-date-modal').html(data.created_at);
                            $('.content-modal').html(data.description);
                        }
                    }
            });
            return false;
        }
    }
</script>
@endsection