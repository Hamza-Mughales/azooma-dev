
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminmenurequest'); ?>">All Menu Requests</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>     
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form">
            <div class="form-group row">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-2">Name</th>
                            <th class="col-md-2">Email</th>
                            <th class="col-md-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($lists) > 0) {
                            foreach ($lists as $list) {
                                ?>
                                <tr>
                                    <td><?php echo $list->name; ?></td>
                                    <td><?php echo $list->email; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($list->createdAt)); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </form>
    </article>
</div>

