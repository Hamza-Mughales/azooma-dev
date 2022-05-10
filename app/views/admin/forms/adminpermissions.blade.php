@extends('admin.index')
@section('content')

<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>
  <li><a href="<?= route('admins'); ?>">Administrators</a></li>
  <li class="active">{{ $title }}</li>
</ol>
<?php
$message = Session::get('message');

?>

<div class="well-white container">
  <article>
    <fieldset>
      <legend>{{ $pagetitle }}</legend>
    </fieldset>
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admins/savePermissions'); }}" method="post">

      <table class="table table-hover">
        <thead>
          <tr>
            <th class="col-md-4">Permissions</th>
            <th class="col-md-2">Add</th>
            <th class="col-md-2">Edit</th>
            <th class="col-md-2">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $MAdmins = new Admin();
          $userpermissions = explode(',', $admin->permissions);
          if (count($permissions) > 0) {
            foreach ($permissions as $val) {
          ?>
              <tr>
                <?php
                $info = $MAdmins->getPermissionSectionInfo($val->id);
                ?>
                <td><label for=""><?php echo $val->section; ?></label></td>
                <?php
                if (count($info) > 0) {
                  if (count($info) == 0) {
                    echo "<td colspan='3'>&nbsp;</td>";
                  } elseif (count($info) == 1) {
                    echo "<td>&nbsp;</td>";
                  } elseif (count($info) == 2) {
                    echo "<td>&nbsp;</td>";
                  }

                  foreach ($info as $arr) {
                    $addpos = $editpos = $deletepos = false;
                    $addpos = strpos($arr->permissionText, 'add ');
                    $editpos = strpos($arr->permissionText, 'edit ');
                    $deletepos = strpos($arr->permissionText, 'delete ');

                    if ($addpos !== false) {
                ?>
                      <td>
                        <div class="form-checkbox">
                          <input type="checkbox" name="permissions[]" value="<?php echo $arr->id; ?>" <?php if (isset($userpermissions) && in_array($arr->id, $userpermissions)) echo 'checked="checked"'; ?> <?php if (isset($entry) && in_array($arr->id, $entry)) echo 'checked="checked"'; ?> />

                          <label class="form-check-label">
                            <?php echo $arr->permissionText; ?>
                          </label>
                        </div>
                      </td>
                    <?php
                    }

                    if ($editpos !== false) {
                    ?>
                      <td>
                        <div class="form-checkbox">

                          <input type="checkbox" name="permissions[]" value="<?php echo $arr->id; ?>" <?php if (isset($userpermissions) && in_array($arr->id, $userpermissions)) echo 'checked="checked"'; ?> <?php if (isset($entry) && in_array($arr->id, $entry)) echo 'checked="checked"'; ?> />
                          <label class="form-check-label">
                            <?php echo $arr->permissionText; ?>
                          </label>
                        </div>

                      </td>
                    <?php
                    }

                    if ($deletepos !== false) {
                    ?>
                      <td>
                        <div class="form-checkbox">

                            <input type="checkbox" name="permissions[]" value="<?php echo $arr->id; ?>" <?php if (isset($userpermissions) && in_array($arr->id, $userpermissions)) echo 'checked="checked"'; ?> <?php if (isset($entry) && in_array($arr->id, $entry)) echo 'checked="checked"'; ?> />
                            <label class="form-check-label">
                            <?php echo $arr->permissionText; ?>
                          </label>
                        </div>

                      </td>
                <?php
                    }
                  }
                }
                ?>
              </tr>
          <?php
            }
          }
          ?>

        </tbody>
      </table>
      <hr>
      <div class="form-group row">
        <div class=" col-md-6">
          <button type="submit" class="btn btn-primary-gradien">Save Now</button>
          <?php
          if (isset($admin)) {
          ?>
            <input type="hidden" name="id" value="{{ isset($admin) ? $admin->id : 0 }}" id="id">
          <?php
          }
          ?>
          <a href="<?php echo route('admins'); ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
        </div>
      </div>

    </form>
  </article>
</div>


@endsection