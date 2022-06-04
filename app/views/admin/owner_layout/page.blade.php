<section class="page-content span11">
    <ul class="breadcrumb">
        <li>
            <a href="{{ URL::to('admin/home') }}">Dashboard</a> <span class="divider">/</span>
        </li>
        <?php 
        if(isset($backname)){
            ?>
            <li>
            <a href="{{ URL::to('admin/'.$backurl) }}">{{ $backname }}</a> <span class="divider">/</span>
            </li>
            <?php
        }
        ?>
        <li>{{ $title }}</li>
    </ul>
    <div>
        <h1 class="inline-block">{{ $pagetitle }}</h1>
        <?php 
        if(!isset($nonew)){
            ?>
            <a title="Add New {{ $title }}" class="right-float btn btn-primary" href="{{ URL::to('admin/'.$add_link) }}">Add New {{ $title }}</a>
            <?php 
        } 
        if(isset($download)){
            ?>
            <a title="Download Participants" class="right-float btn btn-info" href="{{ URL::to('admin/'.$download) }}">Download Participants</a>
            <?php 
        }
        ?>
        </div>
        <?php
        $error = Session::get('error');
        if (isset($error) && !empty($error)) {
            echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $error . '</strong></div>';
        }
        $message = Session::get('message');
        if (isset($message) && !empty($message)) {
            echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>' . $message . '</strong></div>';
        }
        ?>
        <article class="spacer accordion-group">
            <h2 data-bs-target="#results" class="accordion-heading " data-bs-toggle="collapse">
                <a href="javascript:void(0);" class="accordion-toggle">
                    Total Results (<?php echo count($lists); ?>) <i class="icon icon-chevron-down icon-dashboard-widget"></i>
                </a>
            </h2>
            <div id="results" class="collapse in accordion-inner">
                <?php
                if (count($lists) > 0) {
                    ?>
                    <table id="table-results-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <?php
                                if (isset($headings)) {
                                    foreach ($headings as $key => $val) {
                                        echo '<th>' . $val . '</th>';
                                    }
                                }
                                ?>
                            </tr></thead>
                            <tbody>                        
                                <?php echo render('admin::partials.' . $partials_name, array('lists' => $lists,'action'=>$action)); ?>
                            </tbody>
                        </table>
                        <?php
                //$menu_list->links();
                    }
                    ?>
                </div>
            </article>
        </section>