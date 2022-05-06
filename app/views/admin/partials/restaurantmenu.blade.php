@extends('admin.index')
@section('content')
    
<div class="overflow">
    <div class="col-md-11 zero-padding">
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
                <a href="javascript:void(0)" onclick="return abc();" id="add-new-menu" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
        <div class="table-responsive">
            <table id="data-table-one" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Location') {
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
                <tbody>
                    <?php
                    $newURL = "/adminrestmenu/form/" . $rest->rest_ID;
                    if ($menuAction == "category") {
                        $newURL.='?menu_id=' . $menu_id . '&cat_id=0';
                    } elseif ($menuAction !== "menu") {
                        $newURL.='?cat_id=0&menu_id=' . $cat->menu_id . '&cat=' . $cat->cat_id;
                    }
                    if (count($lists) > 0) {
                        $countries = Config::get('settings.countries');
                        $MGeneral = new MGeneral();
                        if ($menuAction == "menu") {
                            foreach ($lists as $list) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo stripslashes($list->menu_name);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo stripslashes($list->menu_name_ar);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($list->updatedAt == "") {
                                            echo date('d/m/Y', strtotime($list->createdAt));
                                        } else {
                                            echo date('d/m/Y', strtotime($list->updatedAt));
                                        }
                                        ?>
                                    </td>            
                                    <td class="sufrati-action">
                                        <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestmenu/',$rest->rest_ID).'?menu_id='.$list->menu_id }}" title="View Categories ">
                                            <i data-feather="file-plus"></i> Categories
                                        </a>
                                        <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestmenu/form/',$rest->rest_ID).'?menu_id='.$list->menu_id }}" title="Edit Content">
                                            <i data-feather="edit"></i> 
                                        </a>
                                        <a  class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-btn" href="#" link="{{ route('adminrestmenu/delete/',$rest->rest_ID).'?menu_id='.$list->menu_id }}" title="Delete">
                                            <i data-feather="trash-2"></i> 
                                        </a>

                                    </td>
                                </tr>
                                <?php
                            }
                        } elseif ($menuAction == "category") {
                            foreach ($lists as $list) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo stripslashes($list->cat_name);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo stripslashes($list->cat_name_ar);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($list->updatedAt == "") {
                                            echo date('d/m/Y', strtotime($list->createdAt));
                                        } else {
                                            echo date('d/m/Y', strtotime($list->updatedAt));
                                        }
                                        ?>
                                    </td>            
                                    <td>
                                        <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestmenu/',$rest->rest_ID).'?menu_id='.$list->menu_id.'&cat_id='.$list->cat_id.'&item='.$list->cat_id }}" title="View Categories ">
                                            <i data-feather="file-plus"></i> Items
                                        </a>


                                        <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestmenu/form/',$rest->rest_ID).'?menu_id='.$list->menu_id.'&cat_id='.$list->cat_id.'&item='.$list->cat_id }}" title="Edit Content">
                                            <i class="glyphicon glyphicon-arrow-up"></i> 
                                        </a>


                                        <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestmenu/form/',$rest->rest_ID).'?menu_id='.$list->menu_id.'&cat_id='.$list->cat_id.'&item='.$list->cat_id }}" title="Edit Content">
                                            <i data-feather="edit"></i> 
                                        </a>
                                        <a  class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-btn" href="#" link="{{ route('adminrestmenu/delete/',$rest->rest_ID).'?menu_id='.$list->menu_id.'&cat_id='.$list->cat_id; }}" title="Delete">
                                            <i data-feather="trash-2"></i> 
                                        </a>

                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            foreach ($lists as $list) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo stripslashes($list->menu_item);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo stripslashes($list->menu_item_ar);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($list->updatedAt == "") {
                                            echo date('d/m/Y', strtotime($list->createdAt));
                                        } else {
                                            echo date('d/m/Y', strtotime($list->updatedAt));
                                        }
                                        ?>
                                    </td>            
                                    <td>
                                        <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestmenu/form/',$rest->rest_ID).'?menu_id='.$cat->menu_id.'&cat='.$list->cat_id.'&item='.$list->id; }}" title="Edit Content">
                                            <i data-feather="edit"></i> 
                                        </a>
                                        <a  class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-btn" href="#" link="{{ route('adminrestmenu/delete/',$rest->rest_ID).'?menu_id='.$cat->menu_id.'&cat='.$list->cat_id.'&item='.$list->id; }}" title="Delete">
                                            <i data-feather="trash-2"></i> 
                                        </a>

                                    </td>
                                </tr>
                                <?php
                            }
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
<script type="text/javascript">
    function abc() {
        window.location.href = adminbase + '<?php echo $newURL; ?>';
    }
</script>
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
