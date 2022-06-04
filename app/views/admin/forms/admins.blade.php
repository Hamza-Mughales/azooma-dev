@extends('admin.owner.index')
@section('content')

<ol class="breadcrumb">
    <li><a href="<?= route('ownerhome'); ?>">Dashboard</a></li>
    <li><a href="<?= route('admins'); ?>">Administrators</a></li>
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>
        <fieldset>
            <legend>{{ $pagetitle }}</legend>
        </fieldset>
        <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admins/save'); }}" method="post">
            <div class="form-group row">
                <label for="fullname" class="col-md-2 control-label">Full Name</label>
                <div class="col-md-6">
                    <input type="input" name="fullname" class="form-control required" value="{{ isset($admin) ? $admin->fullname : Input::old('fullname') }}" id="fullname" placeholder="Full Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="user" class="col-md-2 control-label">User Name</label>
                <div class="col-md-6">
                    <input type="input" name="user" minlength="5" class="form-control required" value="{{ isset($admin) ? $admin->user : Input::old('user') }}" id="user" placeholder="User Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-2 control-label">Email Address</label>
                <div class="col-md-6">
                    <input type="email" name="email" class="form-control required email" value="{{ isset($admin) ? $admin->email : Input::old('email') }}" id="email" placeholder="Email Address">
                </div>
            </div>
            <?php if (!isset($admin)) { ?>
                <div class="form-group row">
                    <label for="pass" class="col-md-2 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" minlength="5" name="pass" class="form-control required" id="pass" placeholder="Password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="passconf" class="col-md-2 control-label">Confirm Password</label>
                    <div class="col-md-6">
                        <input type="password" minlength="5" name="passconf" class="form-control required" equalto="#pass" id="passconf" placeholder="Confirm Password">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group row">
                <label for="admin" class="col-md-2 control-label">User Role</label>
                <div class="col-md-6">
                    <select name="admin" id="user-role" class="form-control user-role required">
                        <option value="">Select User Role</option>
                        <option value="1" <?php if ((isset($admin)) && ($admin->admin == 1)) {
                                                echo 'selected="selected"';
                                            } ?>>Owner</option>
                        <option value="2" <?php if ((isset($admin)) && ($admin->admin == 2)) {
                                                echo 'selected="selected"';
                                            } ?>>Country Admin</option>

                    </select>
                </div>
            </div>
            <div id="select-country">
                <div class="form-group row">
                    <label for="admin" class="col-md-2 control-label">Country</label>
                    <div class="col-md-6">
                        <select name="country" id="admin" class="form-control">
                            <?php
                            foreach ($countries as $c) {

                            ?>
                                <option value="<?= $c->id ?>"><?= $c->name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox" name="status" value="1" {{ isset($admin) ? ($admin->status==1) ? 'checked': '' : 'checked' }}>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($admin)) {
                    ?>
                        <input type="hidden" name="id" value="{{ isset($admin) ? $admin->id : 0 }}" id="id">
                    <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>

<script>
    $(document).ready(function() {
        var admin = "<?= isset($admin) && $admin->admin == 1 ? "1" : "0" ?>";
        if (admin == 1) {
            $("#select-country").hide();
        }
        else{
            $("#select-country").show();

        }
        $("#user-role").change(function(){
            var admin=$(this).val();
            if (admin == 1) {
            $("#select-country").hide();
        }
        else{
            $("#select-country").show();

        }
        });
    });
</script>
@endsection