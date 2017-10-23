@extends('backend.master')

@section('title', 'Product')
@section('content')
	<section class="content-header">
      <h1>
        Product Add
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Add Product</li>
      </ol>
    </section>
	<section class="content">
		<div class="row">
		<div class="col-md-6">
			<form method="post">
		     <div class="form-group ">
		      <label class="control-label requiredField" for="name">
		       Name Product
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
		     <div class="form-group ">
		      <label class="control-label requiredField" for="is_homepage">
		       Homepage
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <select class="select form-control" id="is_homepage" name="is_homepage">
		       <option value="1">
		        Ya
		       </option>
		       <option value="0">
		        Tidak
		       </option>
		      </select>
		     </div>
		     <div class="form-group ">
		      <label class="control-label requiredField" for="is_homepage">
		       Category
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <select class="category form-control">
				<option value="ivaynberg/select2" selected="selected">ivaynberg/select2</option>
				</select>

		     </div>
		     <div class="form-group">
		      <div>
		       <button class="btn btn-primary " name="submit" type="submit">
		        Submit
		       </button>
		      </div>
		     </div>
		    </form>
		</div>
		<div class="col-md-6">
			<form method="post">
		     <div class="form-group ">
		      <label class="control-label requiredField" for="name">
		       Images
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <input class="form-control" id="name" name="name" type="text"/>
		     </div>
		     <div class="form-group ">
		      <label class="control-label requiredField" for="description">
		       Optional
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <textarea class="form-control" cols="40" id="description" name="description" rows="10"></textarea>
		     </div>
		     <div class="form-group ">
		      <label class="control-label requiredField" for="active">
		       Price
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
		     <div class="form-group ">
		      <label class="control-label requiredField" for="is_homepage">
		       Discount
		       <span class="asteriskField">
		        *
		       </span>
		      </label>
		      <select class="select form-control" id="is_homepage" name="is_homepage">
		       <option value="1">
		        Ya
		       </option>
		       <option value="0">
		        Tidak
		       </option>
		      </select>
		     </div>
		     <div class="form-group">
		      <div>
		       <button class="btn btn-primary " name="submit" type="submit">
		        Submit
		       </button>
		      </div>
		     </div>
		    </form>
		</div>
		</div>
	</section>
@endsection

@section('js')
<script type="text/javascript">

  var $ajax = $(".category");

  $ajax.select2({
    ajax: {
      url: "https://api.github.com/search/repositories",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page
        };
      },
      processResults: function (data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;

        return {
          results: data.items,
          pagination: {
            more: (params.page * 30) < data.total_count
          }
        };
      },
      cache: true
    },
    minimumInputLength: 1,
    templateResult: function (repo) {
      if (repo.loading) return repo.text;

      var markup = '<div class="clearfix">' +
        '<div class="col-sm-1">' +
          '<img src="' + repo.owner.avatar_url + '" style="max-width: 100%" />' +
        '</div>' +
        '<div clas="col-sm-10">' +
          '<div class="clearfix">' +
            '<div class="col-sm-6">' + repo.full_name + '</div>' +
            '<div class="col-sm-3"><i class="fa fa-code-fork"></i> ' + repo.forks_count + '</div>' +
            '<div class="col-sm-2"><i class="fa fa-star"></i> ' + repo.stargazers_count + '</div>' +
          '</div>';

      if (repo.description) {
         markup += '<div>' + repo.description + '</div>';
      }

      markup += '</div></div>';

      return markup;
    },
    templateSelection: function (repo) {
      return repo.full_name || repo.text;
    }
  });

  
</script>
@endsection