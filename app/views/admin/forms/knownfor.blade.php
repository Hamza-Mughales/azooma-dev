@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('adminknownfor'); ?>">Known For List</a></li>  
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
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminknownfor/save'); }}" method="post" enctype="multipart/form-data">
      <div class="form-group row">
        <label for="bestfor_Name" class="col-md-2 control-label">Title English</label>
        <div class="col-md-6">
          <input type="input" name="bestfor_Name" class="form-control required" value="{{ isset($page) ? $page->bestfor_Name : Input::old('bestfor_Name') }}" id="bestfor_Name" placeholder="Title English">
        </div>
      </div>
      <div class="form-group row">
        <label for="bestfor_Name_ar" class="col-md-2 control-label">Title Arabic</label>
        <div class="col-md-6">
          <input type="input" name="bestfor_Name_ar" class="form-control required"  value="{{ isset($page) ? $page->bestfor_Name_ar : Input::old('bestfor_Name_ar') }}" id="bestfor_Name_ar" placeholder="Title Arabic" dir="rtl">
        </div>
      </div>
        
        <div class="form-group row">
                <label for="rest_ID" class="col-md-2 control-label">Restaurant</label>
                <div class="col-md-6">

                    <select name="rest_ID[]" id="rest_ID" class="form-control chzn-select" multiple="" placeholder="Please select Restaurant">                        
                        <?php
                        $selected_ids = array();
                        if (isset($page) && $page->rest_ID != "") {
                            $arest_IDs = $page->rest_ID;
                            $selected_ids = explode(",", $arest_IDs);
                        }
                        if (is_array($restaurants)) {
                            foreach ($restaurants as $restaurant) {
                                $selected = "";
                                if (in_array($restaurant->rest_ID, $selected_ids)) {
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?php echo $restaurant->rest_ID; ?>" <?php echo $selected; ?>><?php echo $restaurant->rest_Name; ?></option>
                                <?php
                            }
                        }
                        ?>                
                    </select>
                </div>
            </div>

      <div class="form-group row">
        <label for="best_for_desc" class="col-md-2 control-label">Description English</label>
        <div class="col-md-6">
          <textarea name="best_for_desc" id="best_for_desc" class="form-control" rows="5">{{ isset($page) ? $page->best_for_desc : Input::old('best_for_desc') }}</textarea>
        </div>
      </div>
      <div class="form-group row">
        <label for="best_for_desc_ar" class="col-md-2 control-label">Description Arabic</label>
        <div class="col-md-6">
          <textarea name="best_for_desc_ar" id="best_for_desc_ar" class="form-control" rows="5">{{ isset($page) ? $page->best_for_desc_ar : Input::old('best_for_desc_ar') }}</textarea>
        </div>
      </div>    

      <div class="form-group row">
        <label for="bestfor_Status" class="col-md-2 control-label">Publish</label>
        <div class="col-md-6">
          <div class="btn-group">
            <input type="checkbox"  name="bestfor_Status" value="1"  {{ isset($page) ? ($page->bestfor_Status==1) ? 'checked': '' : 'checked' }} >            
          </div>
        </div>
      </div>  

      <?php
      if(isset($page)){
        ?>
        <div class="panel">
          <div data-bs-toggle="collapse" data-bs-target="#filter-main" class="panel-heading anchor">
            All Restaurants which Serve {{ $page->bestfor_Name }}
          </div>

          <div id="filter-main" data-bs-toggle="collapse" class="collapse ">
            <div class="form-group row"></div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="col-md-1">Sr#</th>
                  <th class="col-md-2">Restaurant Name</th>
                  <th class="col-md-2">Restaurant Name Arabic</th>
                  <th class="col-md-2">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $rest_IDs="";
                if(isset($page)){
                  $rest_IDs = explode(',', $page->rest_ID);
                }
                if($restaurantsbestfor){
                  $i=1;
                  foreach ($restaurantsbestfor as $key => $value) {
                    ?>
                    <tr>
                      <td>{{$i}}</td> 
                      <td> <?php echo stripslashes($value->rest_Name); ?> </td>
                      <td> <?php echo $value->rest_Name_Ar; ?> </td>
                      <td id="td-<?php echo $value->rest_ID; ?>"> 
                        <?php if (isset($page)) {
                          if (!in_array($value->rest_ID, $rest_IDs)) {
                            ?>
                            <a id="fav-<?php echo $value->rest_ID; ?>" class="Azooma-backend-actions" href="javascript:void(0);" onclick="return addToFavorite('<?php echo $value->rest_ID; ?>','<?php echo $page->bestfor_ID; ?>');" rel="tooltip" data-original-title="Add to List"> <i class="icon icon-exclamation-sign"></i> 
                              <i class="glyphicon glyphicon-check"></i>   Add to List 
                            </a>
                            <?php
                          }else{
                            echo "<i class='glyphicon glyphicon-bookmark'></i>  Added in List ";
                          }
                        }
                        ?>
                      </td> 
                    </tr>
                    <?php
                    $i++;
                  }
                }
                ?>                
              </tbody>
            </table>
          </div>    
        </div>
        <?php
      }
      ?>
      <div class="form-group row"></div>



      <div class="form-group row">
        <div class="offset-lg-2 col-md-6">
          <button type="submit" class="btn btn-primary-gradien">Save Now</button>
          <?php
          if(isset($page)){
            ?>
            <input type="hidden" name="bestfor_ID"  value="{{ isset($page) ? $page->bestfor_ID : 0 }}" id="id" >
            <?php
          }
          ?>
        </div>
      </div>
    </form>
  </article>
</div>



<script type="text/javascript">


  function addToFavorite(rest_ID,bestfor_ID){       
    $.get(adminbase+"/adminknownfor/addToFavorite/?rest_ID="+rest_ID+"&bestfor_ID="+bestfor_ID,function(data){      
      $('#td-'+rest_ID).html('Added in List');        
      $('#fav-'+rest_ID).css('display','none');    
    });

  }
</script>

@endsection