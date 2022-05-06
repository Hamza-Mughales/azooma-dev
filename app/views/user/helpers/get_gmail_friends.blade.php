<div class="spacing-container"></div>
<ul class="nav nav-tabs" role="tablist">
    <li class="active">
        <a href="#google-sufrati-tab" data-bs-toggle="tab">
            <b><?php echo Lang::get('messages.google_friends_sufrati').' ('.count($sufratiusers).')';?></b>
        </a>
    </li>
    <li>
        <a href="#google-friends-tab" data-bs-toggle="tab">
            <b><?php echo Lang::get('messages.google_not_in_sufrati').' ('.$invitedtotal.')';?></b>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="google-sufrati-tab">
        <div class="spacing-container"></div>
        <?php 
        $friends=array(
            'userfollowers'=>$sufratiusers,
            'lang'=>$lang,
        );
        ?>
        @include('user.helpers.follower_following',$friends)
    </div>
    <div class="tab-pane" id="google-friends-tab">
        <div class="spacing-container"></div>
        <div>
            <button class="btn btn-lg btn-block btn-success" id="invite-all-gmail">
                <?php echo Lang::get('messages.invite_all_friends',array('count'=>$invitedtotal)); ?>
            </button>
        </div>
        <div class="spacing-container"></div>
        <?php 
        $friends=array(
            'contacts'=>$invited,
            'lang'=>Config::get('app.locale'),
        );
        ?>
        @include('user.helpers.invites_list',$friends)
        <?php if($invitedtotal>count($invited)){ ?>
        <div id="invite-morebtn-cnt">
            <div class="spacing-container">
            </div>
            <button id="load-more-invites" data-loaded="<?php echo count($invited);?>" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button" ><?php echo Lang::get('messages.load_more');?></button>
        </div>
        <?php } ?>
    </div>
</div>