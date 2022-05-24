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
$countries = Config::get('settings.countries');
?>





<div class="well-white">
    <article>
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminsubscriptions/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>
        </fieldset>

        <div class="panel">
            <div class="panel-heading">

            </div>
            <form onsubmit="return check();" name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminsubscriptions/compare'); }}" method="post">
                <div class="table-responsive">
                    <table id="data-table-one" class="table table-striped">
                        <thead>
                            <tr>
                                <?php
                                foreach ($headings as $key => $value) {
                                ?>
                                    <th class="col-md-2">{{ $value }}</th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($lists) > 0) {
                                $counter = 1;
                                foreach ($lists as $list) {
                            ?>
                                    <tr>
                                        <td> <a href="Javascript:void(0);" title="Compare Package">
                                                <input id="checkbox-<?php echo $counter; ?>" class="compare" type="checkbox" name="compare[]" style="margin: 0px;" value="<?php echo $list->id; ?>" />
                                            </a></td>
                                        <td><?php echo stripslashes($list->accountName); ?></td>
                                        <td>
                                            <?php
                                            if ($list->country != 0) {
                                                echo $countries[$list->country];
                                            } else {
                                                echo 'Unknow';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($list->date_upd)) {
                                                echo date('d/m/Y', strtotime($list->date_add));
                                            } else {
                                                echo date('d/m/Y', strtotime($list->date_upd));
                                            }
                                            ?>
                                        </td>
                                        <td class="Azooma-action">

                                            <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminsubscriptions/form/',$list->id) }}" title="Edit Content"><i data-feather="edit"></i></a>
                                            <a  class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-button" href="#" link="{{ route('adminsubscriptions/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    $counter++;
                                }
                                ?>

                            <?php
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
                    <div class="mx-1 my-2">
                        <button type="submit" class="btn btn-group-sm btn-info mytooltip" href="" title="Compare Package"><i class="fa  fa-large"></i> Compare</button>

                    </div>
                </div>
            </form>


        </div>
    </article>
</div>
<script type="text/javascript">
    function check() {
        var numberOfChBox = $('.compare').length;
        var counter = 0;
        for (i = 1; i <= numberOfChBox; i++) {
            if ($('#checkbox-' + i).is(':checked')) {
                counter++;
            }
        }
        if (counter == 2) {
            return true;
        } else if (counter == 1 || counter > 2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select 2 packages to compare',
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select  packages to compare',
            })
        }
        return false;
    }
</script>

@endsection