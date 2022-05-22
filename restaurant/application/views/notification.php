<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">
<?php
    echo message_box('error');
    echo message_box('success');
    // var_dump(count($notifications));
    // exit;
?>
<section class="card">
    <div class="card-body">
        <div id="results">
            <?php
            if (count($notifications) > 0) {
            ?>
            <div class="table-responsive">

                <table class="table table-bordered table-striped sufrati-backend-table text-center" id="basic-1">
                    <thead>
                        <th class="span4">
                            #
                        </th>
                        <th class="span4 w-75">
                            Detail
                        </th>
                        <!-- <th class="span4">
                            Status
                        </th> -->
                        <th class="span4 w-25">
                            Date
                        </th>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($notifications as $notif) {
                        ?>
                            <tr>
                                <td>
                                    <?php
                                        echo ($notif->id);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo ($notif->detail);
                                    ?>
                                </td>
                                <!-- <td>
                                    <?php 
                                     //   echo ($notif->status);
                                    ?>
                                </td> -->
                                <td>
                                    <?php 
                                        echo ($notif->createdAt);
                                    ?>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
                } else {
                    echo '<h4>There are no notification yet! </h4>';
                }
            ?>
        </div>
    </div>
</section>
<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>

