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
                <a href="{{ route('adminrestgallery/form').'?rest_ID='.$rest->rest_ID; }}" id="add-new-menu" class="btn btn-info btn-sm pull-right">Add new </a>
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
                    if (count($lists) > 0) {
                        $countries = Config::get('settings.countries');
                        foreach ($lists as $image) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo stripslashes(($image->title)) . ' - ' . stripslashes(($image->title_ar)); ?>
                                </td>
                                <td>
                                    <img src="<?php echo Config::get('settings.uploadurl') . 'Gallery/thumb/' . $image->image_full; ?>"/>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($image->user_ID)) {
                                        $user = "";
                                        $user = $MGeneral->getUser($image->user_ID);
                                        if (!empty($user->user_NickName)) {
                                            echo $user->user_NickName;
                                        } else {
                                            echo $user->user_FullName;
                                        }
                                        echo '<br />' . $user->user_Email;
                                    } else {
                                        echo 'Restaurant';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                 
                                        echo date('d/m/Y', strtotime($image->updatedAt));
                                    
                                    ?>
                                </td>            
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminrestgallery/form/',$image->image_ID).'?rest_ID='.$rest->rest_ID; }}" title="Edit Content">
                                        <i data-feather="edit"></i> 
                                    </a>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminrestgallery/delete/',$image->image_ID).'?rest_ID='.$rest->rest_ID; }}" title="Delete">
                                        <i data-feather="trash-2"></i> 
                                    </a>
                                    <?php if ($image->is_featured == 0) { ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="<?php echo route('adminrestgallery/makefeaturedimage/', $image->image_ID) . '?rest_ID=' . $rest->rest_ID; ?>" rel="tooltip" title="Make Profile Photo" >
                                            <i data-feather="star"></i>
                                            Make Profile Photo
                                        </a>
                                    <?php } else { ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="<?php echo route('adminrestgallery/unsetfeaturedimage/', $image->image_ID) . '?rest_ID=' . $rest->rest_ID; ?>" rel="tooltip" title="Profile Photo" onclick="return confirm('Do You Want to Remove Profile Photo?')">
                                            <i class="glyphicon glyphicon-star"></i>
                                            Profile Photo
                                        </a>
                                    <?php } ?>
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
            </table>
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

@endsection