@extends('backend.master')

@section('title', 'Add Menu')
@section('content')
	<section class="content-header">
      <h1>Menu Add</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Add Product</li>
      </ol>
    </section>
	<section class="content">
		<div class="row">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		<form method="post" action="#">
		<div class="col-md-6">
		     <div class="form-group ">
		      <label class="control-label requiredField" for="name">
		       Name Menu
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <input class="form-control" id="name" name="name" type="text"/>
		     </div>
		     <div class="form-group ">
		      <label class="control-label requiredField" for="description">
		       Description
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <textarea class="form-control" cols="40" id="description" name="description" rows="10"></textarea>
		     </div>
		     <div class="form-group ">
		      <label class="control-label requiredField" for="active">
		       Active
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <select class="select form-control" id="active" name="active">
		       <option value="1">
		        Ya
		       </option>
		       <option value="0">
		        Tidak
		       </option>
		      </select>
		     </div>
		</div>
		<div class="col-md-6">
		     <div class="form-group ">
		      <label class="control-label requiredField" for="parent">
		       Parent
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <select class="select form-control" id="parent" name="parent">
		      </select>
		     </div>
		     <div class="form-group ">
		      <label class="control-label requiredField" for="path">
		       Url/Path
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		     <input class="form-control" id="path" name="path" type="text"/>

		     </div>
		     <div class="form-group">
		      <div>
		       <button class="btn btn-primary " name="submit" type="submit">
		        Submit
		       </button>
		      </div>
		     </div>
		     {{ csrf_field() }}
		</div>
		</form>
		</div>
	</section>
@endsection

@section('js')
<script type="text/javascript">
	$('#parent').select2({
  		ajax: {
			    url: '{{ url('admin/menu/data') }}',
			    dataType: 'json',
			    processResults: function (data) {
      				  return {
				    results: data.items
				  };
				}
			  }
});
</script>
@endsection
