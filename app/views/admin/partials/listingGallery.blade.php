<div class="overflow">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li><a href="<?= route('adminlisting'); ?>">Business Listings</a></li>
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn pull-right" data-bs-toggle="collapse" data-bs-target="#filter-main">  <i data-feather="filter"></i> </button>
    </div>
</div>


<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminlistinggallery/',$List_ID); }}" method="get" >
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" >
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-lg-2 col-md-6">
                <button type="submit" class="btn btn-primary-gradien">Filter</button>          
            </div>
        </div>
    </form>
</div>


<div class="well-white">

    <?php
    include(app_path() . '/views/admin/common/listingheader.blade.php');
    ?>
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminlistinggallery/form').'?List_ID='.$List_ID; }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="panel-heading">
                <?php
                if (count($lists) > 0) {
                    ?> 
                    Results {{ $lists->getFrom() }} to {{ $lists->getTo() }} out of 
                    <span class="label label-info">{{ $lists->getTotal() }}</span> 
                    <?php
                } else {
                    echo 'No Result Found';
                }
                ?>        
            </div>
            <table class="table table-hover">
                <?php if (count($lists) > 0) { ?>
                    <thead>
                        <tr>
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
                <?php } ?>
                <tbody>
                    <?php
                    if (count($lists) > 0) {
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                    if ($list->status == 0) {
                        echo 'class="line-through"';
                    }
                            ?>>
                                <td><?php echo stripslashes($list->name); ?></td>
                                <td><?php echo stripslashes($list->nameAr); ?></td>                                
                                <td><?php
                        if ($list->updatedAt == "") {
                            echo date('d/m/Y', strtotime($list->createdAt));
                        } else {
                            echo date('d/m/Y', strtotime($list->updatedAt));
                        }
                            ?></td>
                                <td><?php echo date('d/m/Y', strtotime($list->createdAt)); ?></td>
                                <td class="Azooma-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminlistinggallery/photos/',$list->id).'?List_ID='.$list->List_ID }}" title="View All Photos"><i data-feather="eye"></i></a>
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminlistinggallery/form/',$list->id).'?List_ID='.$list->List_ID }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminlistinggallery/status/',$list->id) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminlistinggallery/status/',$list->id) }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminlistinggallery/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } 
                    ?>
                </tbody>
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
