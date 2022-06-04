@extends('admin.owner.index')
@section('content')


<div class="overflow">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="<?= route('ownerhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
</div>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('admins/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="table-responsive">
            <table id="data-table-one" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Description') {
                                ?>
                                <th class="col-md-4">{{ $value }}</th>
                                <?php
                            } else {
                                ?>
                                <th class="col-md-2">{{ $value }}</th>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    if (count($lists) > 0) {
                        $countries = Config::get('settings.countries');
                        foreach ($lists as $list) {
                            if ($list->user == "admin") {
                                continue;
                            }
                            ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?php echo stripslashes($list->fullname); ?></td>
                                <td><?php echo stripslashes($list->user); ?></td>     
                                <td><?php echo stripslashes($list->email); ?></td>     
                                <td>
                                    <?php
                                    if ($list->country != 0) {
                                        echo $countries[$list->country];
                                    } else {
                                        echo 'All';
                                    }
                                    ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($list->lastlogin)); ?></td>            
                                <td class="Azooma-action">
                                    <a class="btn btn-xs btn-info m-1" href="{{ route('admins/form/',$list->id) }}" title="Edit {{ $title }}"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->id != 1) {
                                        
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info m-1" href="{{ route('admins/status/',$list->id) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info m-1" href="{{ route('admins/status/',$list->id) }}" title="Deactivate "><i data-feather="plus-circle"></i></a>
                                        <?php
                                    } ?>
                                    <a  class="btn btn-xs btn-danger m-1 cofirm-delete-button" href="#" link="{{ route('admins/delete/',$list->id) }}" title="Delete "><i data-feather="trash-2"></i></a>              

                                    <?php   }?>
                                    
                                        <a class="btn btn-xs btn-info m-1" href="{{ route('admins/password/',$list->id) }}" title="Change Password"><i data-feather="lock"></i></a>
<!--                                         <a class="btn btn-xs btn-info m-1" href="{{ route('admins/permissions/',$list->id) }}" title="Update Permissions "><i data-feather="sliders"></i></a>
 -->                                

                                    <a class="btn btn-xs btn-info m-1" href="{{ route('admins/activity/',$list->id) }}" title="View All activities of {{ $list->fullname }}"><i data-feather="eye"></i></a>



                                </td>
                            </tr>
                            <?php
                        }
                    }
                        ?>
                      
                </tbody>
            </table>
            </div>
    
        </div>
    </article>
</div>

@endsection