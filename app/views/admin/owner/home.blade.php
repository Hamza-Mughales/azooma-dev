@extends('admin.owner.index')
@section('content')



<div class=" mb-2">
  <span class="">You are in <span class="h6 text-start">Owner Dashboard</span></span>
</div>





{{-- Start Section --}}
<div class="row">
  <?php foreach($countries as $c){?>
  
  <div class="col-sm-6 col-lg-3">
    <a  href="<?=route("countrydashboard",$c->id )?>">
      <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
              <i data-feather="user"></i>
            </div>
            <div class="media-body"><span class="m-0">  <?= $c->name ?></span>
           
              <div class="stat"> Dashboard</div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <?php } ?>

  </div>
  @endsection