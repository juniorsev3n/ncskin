@extends('layouts.default')
@section('title','Contact')



@section('content')
<div class="container-fluid about-head">
  <div class="container">
    <div class="row">
      <h1>Contact Ventro</h1>
    </div>
  </div>
</div>

<div class="container contact-form">
  <div class="row">
    <div class="col-md-9">
      <form data-ajax-handler="system:onSendMessage">
        <div class="form" id="contact-form">
          <h3>Need to send a message?</h3>
          <div class="form-group">
            <input class="required input-sm form-control" placeholder="Email Address*" value="" name="fields[email]" id="fields_email"/>
            <span class="error"></span><br><br>
    
            <input class="required input-sm form-control" placeholder="Name*" value="" name="fields[name]" id="fields_name" />
            <span class="error"></span><br><br>

            <textarea rows="10" class="required input-sm form-control" placeholder="Message*" value="" name="fields[message]" id="fields_message"></textarea>
            <span class="error"></span>
          </div>
          <input type="hidden" name="redirect" value="{{ url('/') }}"/>
          <input type="submit" class="btn-default btn" value="Submit"/>
          <input type="text" name="hp" value="" style="display: none"/>
        </div>
      </form>
    </div>
    <div class="col-md-3 address">
      <h3>Contact Us here</h3>
      <p><i class="fa fa-envelope"></i> contact@ventro.com</p>
      <p><i class="fa fa-phone"></i> (883)837-8383</p>
      <p><i class="fa fa-clock-o"></i>Monday-Friday 1-9</p>
    </div>
  </div>
</div>
@endsection
