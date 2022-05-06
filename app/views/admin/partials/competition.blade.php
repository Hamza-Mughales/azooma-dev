@extends('admin.index')
@section('content')

<div class="overflow row">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn pull-right" data-bs-toggle="collapse" data-bs-target="#filter-main">  <i data-feather="filter"></i> </button>
    </div>
</div>

<?php
    $countries = Config::get('settings.countries');
?>


<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincompetitions'); }}" method="get" >
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
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('admincompetitions/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
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
                    if (count($lists) > 0) {
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                    if ($list->status == 0) {
                        echo 'class="line-through"';
                    }
                            ?> >
                                <td><?php echo stripslashes($list->title); ?></td>
                                <td>
                                    <?php
                                    echo "Pend: " . MCompetition::getTotalParticipants($list->id, 0);
                                    echo '<br>';
                                    echo "Atten: " . MCompetition::getTotalParticipants($list->id, 1);
                                    echo '<br>';
                                    echo "Canc: " . MCompetition::getTotalParticipants($list->id, 2);
                                    echo '<br>';
                                    echo "Total: " . $list->participants;
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    if (!empty($list->updatedAt)) {
                                        echo date('d/m/Y', strtotime($list->updatedAt));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->last_Time));
                                    }
                                    ?>
                                </td>                                
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-primary mytooltip" href="{{ route('admincompetitions/participants/',$list->id) }}" title="View All Participants"><i data-feather="info"></i></a>
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincompetitions/form/',$list->id) }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincompetitions/status/',$list->id) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincompetitions/status/',$list->id) }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('admincompetitions/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
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