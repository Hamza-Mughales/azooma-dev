@extends('admin.index')
@section('content')
    
<div class="overflow row">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>

</div>


<?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
?>




<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }} 
                <a href="{{ route('adminrestaurants/branches/imageform')."?br_id=".$br_id."&rest_ID=".$rest->rest_ID; }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="table-responsive">
            <table id="data-table-one" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Restaurant') {
                                ?>
                                <th class="col-md-2">{{ $value }}</th>
                                <?php
                            } else {
                                ?>
                                <th class="col-md-1">{{ $value }}</th>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody >
                    <?php
                    if (count($lists) > 0) {
                        $countries = Config::get('settings.countries');
                        $MGeneral = new MGeneral();
                        foreach ($lists as $list) {
                            ?>
                            <tr class="<?php
                            if ($list->status == 0) {
                                echo ' line-through';
                            }
                            ?>" >
                                <td>
                                    <?php
                                    echo stripslashes($list->title) . ' - ' . stripslashes($list->title_ar);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo stripslashes($rest->rest_Name) . '-' . $branch->br_loc;
                                    ?>
                                </td>
                                <td>
                                    <?php if ($list->image_full != "") { ?>
                                        <img src="<?php echo Config::get('settings.uploadurl'); ?>/Gallery/thumb/<?php echo $list->image_full; ?>" width="100"/>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list->updatedAt == "") {
                                        echo date('d/m/Y', strtotime($list->enter_time));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->updatedAt));
                                    }
                                    ?>
                                </td>            
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestaurants/branches/imageform/',$list->image_ID)."?br_id=".$br_id."&rest_ID=".$rest->rest_ID; }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-danger mytooltip m-1" href="{{ route('adminrestaurants/branches/imagestatus/',$list->image_ID)."?br_id=".$br_id."&rest_ID=".$rest->rest_ID; }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestaurants/branches/imagestatus/',$list->image_ID)."?br_id=".$br_id."&rest_ID=".$rest->rest_ID; }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a  class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-btn" href="#" link="{{ route('adminrestaurants/branches/imagedelete/',$list->image_ID)."?br_id=".$br_id."&rest_ID=".$rest->rest_ID; }}" title="Delete"><i data-feather="trash-2"></i></a>

                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="100%">No record found.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <?php
            if (count($lists) > 0) {
                $get = array();
                if (count($_GET) > 0) {
                    foreach ($_GET as $key => $val) {
                        if ($key == "page") {
                            continue;
                        } else {
                            $get[$key] = $val;
                        }
                    }
                }
                if (count($get) > 0) {
                    echo $lists->appends($get)->links();
                } else {
                    echo $lists->links();
                }
            }
            ?>
        </div>
    </article>
</div>
<script>
$(document).ready(function(){
  
  $("body").on("click",".cofirm-delete-btn",function() {
      const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
              confirmButton: 'btn-primary p-0 mx-2',
              cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
      })
      var  url = $(this).attr('link');
      swalWithBootstrapButtons.fire({
          title: '<?= __('You really want to delete?') ?>',
          text: "<?= __("You can't undo it.") ?>",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: ' <a class="btn btn-primary text-white" href="' + url + '"><?= __('Yes') ?>!</a> ',
          cancelButtonText: ' <?= __('Cancel') ?>',
          reverseButtons: true
      }).then((result) => {
          if (result.value != true)
              (
                  result.dismiss === Swal.DismissReason.cancel
              )
      });
  });

});
</script>
@endsection