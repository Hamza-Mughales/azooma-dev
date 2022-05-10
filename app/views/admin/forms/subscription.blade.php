@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminsubscriptions'); ?>">Subscriptions</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminsubscriptions/save'); }}" method="post" >
            <div class="form-group row">
                <label for="title" class="col-md-2 control-label">Subscription Title </label>
                <div class="col-md-6">
                    <input type="text" name="accountName" class="form-control" value="{{ isset($page) ? $page->accountName : Input::old('accountName') }}" id="accountName" placeholder="Subscription Title" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="country" class="col-md-2 control-label">Country</label>
                <div class="col-md-6">
                    <?php
                    $country = Session::get('admincountry');
                    if (empty($country)) {
                        $country = 1;
                    }
                    $countries = Config::get('settings.countries');
                    if (is_array($countries)) {
                        foreach ($countries as $key => $value) {
                            $selected = "";
                            if (isset($page) && $page->country == $key) {
                                $countryName = $value;
                            } elseif ($country == $key) {
                                $countryName = $value;
                            }
                        }
                    }
                    ?>
                    <input type="input" name="abc" class="form-control" value="{{ $countryName }}"  disabled="disabled">
                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-md-2 control-label">Price </label>
                <div class="col-md-6">
                    <input type="number" name="price" class="form-control" value="{{ isset($page) ? $page->price : Input::old('price') }}" id="price" placeholder="Subscription Price" required>
                </div>
            </div>
            <br />
            <legend>Subscription Features</legend>
            <?php
            if (isset($page) && !empty($page->sub_detail)) {
                $permissions = explode(",", $page->sub_detail);
            }
            ?>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(1, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="1" />
                    <label class="form-check-label" for="bestfor_Name">Profile Page</label>

            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(2, $permissions)) echo "checked='checked'"; ?>   name="features[]"  value="2" />
                    <label class="form-check-label" for="bestfor_Name">Branch Management</label>

            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(3, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="3" />
                    <label class="form-check-label" for="bestfor_Name">Sample Menu</label>

            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(4, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="4" />
                    <label class="form-check-label" for="bestfor_Name">Full Menu + PDF</label>

            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(6, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="6" />
                    <label class="form-check-label" for="bestfor_Name">Photo Gallery - 3 Photos</label>

            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(7, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="7" />
                    <label class="form-check-label" for="bestfor_Name">Photo Gallery - 6 Photos</label>
            </div>
            <div class="form-check">
                
                    <input type="checkbox" <?php if (isset($permissions) and in_array(8, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="8" />
                    <label class="form-check-label" for="bestfor_Name">Photo Gallery - 12 Photos</label>

            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(9, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="9" />
                    <label class="form-check-label" for="bestfor_Name">Photo Gallery - 20 Photos</label>
            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(16, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="16" />
                    <label class="form-check-label" for="bestfor_Name">News Feed</label>

               
            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(10, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="10" />
                    <label class="form-check-label" for="bestfor_Name">Special Offer - 1 Offer</label>

            </div>
            <div class="form-check">
                
                    <input type="checkbox" <?php if (isset($permissions) and in_array(11, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="11" />
                    <label class="form-check-label" for="bestfor_Name">Special Offer - 3 offers</label>
            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(14, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="14" />
                    <label class="form-check-label" for="bestfor_Name">Comment Response</label>
            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(17, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="17" />
                    <label class="form-check-label" for="bestfor_Name">Fan Club</label>

            </div>
            <div class="form-check">
                     <input type="checkbox" <?php if (isset($permissions) and in_array(15, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="15" />
                     <label class="form-check-label" for="bestfor_Name">Video Gallery</label>
            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(13, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="13" />
                    <label class="form-check-label" for="bestfor_Name">Poll</label>
            </div>
            <div class="form-check">
                    <input type="checkbox" <?php if (isset($permissions) and in_array(12, $permissions)) echo "checked='checked'"; ?> name="features[]"  value="12" />
                    <label class="form-check-label" for="bestfor_Name">Booking</label>
            </div>

            <div class="form-group row my-2">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="id"  value="{{ isset($page) ? $page->id : 0 }}" id="id" >
                        <?php
                    }
                    ?>
                    <a href="<?php
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        echo $_SERVER['HTTP_REFERER'];
                    } else {
                        echo route('adminsubscriptions');
                    }
                    ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                </div>
            </div>
        </form>
    </article>
</div>


@endsection