@extends('admin.owner.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('ownerhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('admins'); ?>">Administrators</a></li>  
  <li class="active">{{ $title }}</li>
</ol>
<?php
$message = Session::get('message');

?>

<div class="well-white">
  <article>    
    <fieldset>
      <legend>{{ $pagetitle }}</legend>        
    </fieldset>
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admins/savePassword'); }}" method="post" >
     
      <div class="form-group row">
        <label for="pass" class="col-md-2 control-label">Password</label>
        <div class="col-md-6">
          <input type="password" minlength="5" name="pass" class="form-control required"  id="pass" placeholder="Password" >
        </div>
      </div>
      <div class="form-group row">
        <label for="passconf" class="col-md-2 control-label">Confirm Password</label>
        <div class="col-md-6">
          <input type="password" minlength="5" name="passconf" class="form-control required" equalto="#pass" id="passconf" placeholder="Confirm Password" >
        </div>
      </div> 
  

      <div class="form-group row">
        <div class="offset-lg-2 col-md-6">
          <button type="submit" class="btn btn-primary-gradien">Save Now</button>
          <?php
          if(isset($admin)){
            ?>
            <input type="hidden" name="id"  value="{{ isset($admin) ? $admin->id : 0 }}" id="id" >
            <?php
          }
          ?>
        </div>
      </div>
    </form>
  </article>
</div>


@endsection