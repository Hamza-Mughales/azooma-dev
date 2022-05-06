@extends('admin.index')
@section('content')
    
<div class="overflow">
    <ol class="breadcrumb">
        <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
        <li class="active">{{ $title }}</li>
    </ol>
</div>


<?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
?>

<div class="well-white">
    <article>
        <div class="control-group">
            <div  id="rating-desc"> <b>Overall User Rating:</b> <span id="rating-total"> <b>
                        <?php printf("%.1f", $rating['total']); ?>
                    </b> 
                    <span> out of 10</span> 
                </span> 
            </div>
            <div class="spacing spacer"></div>
            <div id="rating-results">
                <div class="rest-profile-chart"> <span class="rating-value-text"> Food : </span>
                    <div class="poll-result-chart">
                        <div class="poll-results" id="food-value"></div>
                    </div>
                    <span class="user-rate-total" > <?php echo round($rating['food']); ?> </span> </div>
                <div class="rest-profile-chart"> <span class="rating-value-text"> Service : </span>
                    <div class="poll-result-chart">
                        <div class="poll-results" id="service-value"></div>
                    </div>
                    <span class="user-rate-total"> <?php echo round($rating['service']); ?> </span> </div>
                <div class="rest-profile-chart"> <span class="rating-value-text"> Atmosphere : </span>
                    <div class="poll-result-chart">
                        <div class="poll-results" id="atmosphere-value"></div>
                    </div>
                    <span class="user-rate-total"> <?php echo round($rating['atmosphere']); ?> </span> </div>
                <div class="rest-profile-chart"> <span class="rating-value-text"> Value : </span>
                    <div class="poll-result-chart">
                        <div class="poll-results" id="value-value"></div>
                    </div>
                    <span class="user-rate-total"> <?php echo round($rating['value']); ?> </span> </div>
                <div class="rest-profile-chart"> <span class="rating-value-text"> Variety : </span>
                    <div class="poll-result-chart">
                        <div class="poll-results" id="variety-value"></div>
                    </div>
                    <span class="user-rate-total"> <?php echo round($rating['variety']); ?> </span> </div>
                <div class="rest-profile-chart"> <span class="rating-value-text"> Presentation : </span>
                    <div class="poll-result-chart">
                        <div class="poll-results" id="presentation-value"></div>
                    </div>
                    <span class="user-rate-total"> <?php echo round($rating['presentation']); ?> </span> </div>
                <div class="spacing"></div>
            </div>
        </div>
        <div class="spacing spacer"></div>
        <div class="spacing spacer"></div>
        <div class="control-group">
            <?php
            if (is_array($lists) && count($lists) > 0) {
                ?>
                <div  id="rating-desc"> 
                    <b>Overall User Comments:</b> 
                    <span id="rating-total"> 
                        <b>
                            <?php echo $overallcomments; ?>
                        </b> 

                    </span> 
                </div>
                <div class="spacing spacer"></div>
                <div class="overflow">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-2">User Name</th>
                                <th class="col-md-2">Date</th>
                                <th class="col-md-6">Comment</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($lists as $list) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    $user = "";
                                    $user = $MGeneral->getUser($list->user_ID);
                                    if (!empty($user->user_NickName)) {
                                        echo $user->user_NickName;
                                    } else {
                                        echo $user->user_FullName;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y',strtotime($list->review_Date)); ?>
                                </td>
                                <td>
                                    <?php echo stripslashes($list->review_Msg); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </article>

</div>
<script>

    $(document).ready(function() {
        $("#food-value").animate({'width': '<?php echo round(($rating['food']) * 10); ?>%'}, 3000);
        $("#service-value").animate({'width': '<?php echo round(($rating['service']) * 10); ?>%'}, 3000);
        $("#atmosphere-value").animate({'width': '<?php echo round(($rating['atmosphere']) * 10); ?>%'}, 3000);
        $("#value-value").animate({'width': '<?php echo round(($rating['value']) * 10); ?>%'}, 3000);
        $("#variety-value").animate({'width': '<?php echo round(($rating['variety']) * 10); ?>%'}, 3000);
        $("#presentation-value").animate({'width': '<?php echo round(($rating['presentation']) * 10); ?>%'}, 3000);
    });
</script>

@endsection