@extends('admin.index')
@section('content')
    

<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('admins'); ?>">Administrators</a></li>  
    <li class="active">{{ $title }}</li>
</ol>

<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminpages/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="panel-heading">
                <?php if (count($lists) > 0) { ?> Results {{ $lists->getFrom() }} to {{ $lists->getTo() }} out of <span class="label label-info">{{ $lists->getTotal() }}</span> <?php
                } else {
                    echo 'No Result Found';
                }
                ?>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            ?>
                            <th >{{ $value }}</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lists) > 0) {
                        foreach ($lists as $list) {
                            ?>
                            <tr>            
                                <td><?php echo stripslashes($list->user); ?></td>            
                                <td><?php echo stripslashes($list->message); ?></td>            
                                <td><?php echo date('d/m/Y', strtotime($list->date_time)); ?></td>            
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