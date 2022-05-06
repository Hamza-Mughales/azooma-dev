
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminusers'); ?>">All Sufrati Users</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
         <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" method="post" >
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Full Name</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_FullName)) {
                    echo $user->user_FullName;
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Nick Name</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_NickName)) {
                    echo $user->user_NickName;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Email</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_Email)) {
                    echo $user->user_Email;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Country</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_Country)) {
                    echo $user->user_Country;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">City</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_City)) {
                    echo $user->user_City;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Sex</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_Sex)) {
                    echo $user->user_Sex;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Birthday</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_BirthDate)) {
                    echo $user->user_BirthDate;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Telephone</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_Telephone)) {
                    echo $user->user_Telephone;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Mobile</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_Mobile)) {
                    echo $user->user_Mobile;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Nationality</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_nationality)) {
                    echo $user->user_nationality;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Occupation</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_occupation)) {
                    echo $user->user_occupation;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Maritial Status</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->user_maritial)) {
                    echo $user->user_maritial;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">Profile Picture</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->image)) {
                    echo $user->image;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="fullname" class="col-md-2 control-label">User Rank</label>
            <div class="col-md-6">
                <?php
                if (isset($user) && !empty($user->userRank)) {
                    echo $user->userRank;
                }else{
                    echo '-';
                }
                ?>
            </div>
        </div>
        
    </form>
        
        
        
        
    </article>
</div>
