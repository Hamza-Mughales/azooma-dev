@extends('admin.owner.index')
@section('content')


<ol class="breadcrumb">
    <li><a href="<?= route('ownerhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admincountry'); ?>">Country List</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincountry/save'); }}" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Country Name English</label>
                <div class="col-md-6">
                    <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Country Name English">
                </div>
            </div>
            <div class="form-group row">
                <label for="nameAr" class="col-md-2 control-label">Country Name Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="nameAr" class="form-control required"  value="{{ isset($page) ? $page->nameAr : Input::old('city_Name_ar') }}" id="nameAr" placeholder="Country Name Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row">
                <label for="facebook" class="col-md-2 control-label">Face Book</label>
                <div class="col-md-6">
                    <input type="input" name="facebook" class="form-control "  value="{{ isset($page) ? $page->facebook : Input::old('facebook') }}" id="facebook" placeholder="Face Book">
                </div>
            </div>

            <div class="form-group row">
                <label for="twitter" class="col-md-2 control-label">Twitter</label>
                <div class="col-md-6">
                    <input type="input" name="twitter" class="form-control "  value="{{ isset($page) ? $page->twitter : Input::old('twitter') }}" id="twitter" placeholder="Twitter">
                </div>
            </div>

            <div class="form-group row">
                <label for="instagram" class="col-md-2 control-label">Instagram</label>
                <div class="col-md-6">
                    <input type="input" name="instagram" class="form-control "  value="{{ isset($page) ? $page->instagram : Input::old('instagram') }}" id="instagram" placeholder="instagram">
                </div>
            </div>

            <div class="form-group row">
                <label for="youtube" class="col-md-2 control-label">You Tube</label>
                <div class="col-md-6">
                    <input type="input" name="youtube" class="form-control "  value="{{ isset($page) ? $page->youtube : Input::old('youtube') }}" id="youtube" placeholder="youtube">
                </div>
            </div>

            <div class="form-group row">
                <label for="google" class="col-md-2 control-label">Google</label>
                <div class="col-md-6">
                    <input type="input" name="google" class="form-control "  value="{{ isset($page) ? $page->google : Input::old('google') }}" id="google" placeholder="google">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="email" class="col-md-2 control-label">Email</label>
                <div class="col-md-6">
                    <input type="input" name="email" class="form-control "  value="{{ isset($page) ? $page->email : Input::old('email') }}" id="email" placeholder="email">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="teamemail" class="col-md-2 control-label">Team Email</label>
                <div class="col-md-6">
                    <input type="input" name="teamemail" class="form-control "  value="{{ isset($page) ? $page->teamemail : Input::old('teamemail') }}" id="teamemail" placeholder="teamemail">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="telephone" class="col-md-2 control-label">Tele Phone</label>
                <div class="col-md-6">
                    <input type="input" name="telephone" class="form-control required"  value="{{ isset($page) ? $page->telephone : Input::old('telephone') }}" id="telephone" placeholder="telephone">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="currency" class="col-md-2 control-label">Currency</label>
                <div class="col-md-6">
                    <input type="input" name="currency" class="form-control "  value="{{ isset($page) ? $page->currency : Input::old('currency') }}" id="currency" placeholder="currency">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="currencyAr" class="col-md-2 control-label">Currency Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="currencyAr" class="form-control "  value="{{ isset($page) ? $page->currencyAr : Input::old('currencyAr') }}" id="currencyAr" placeholder="currency Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row">
                <label for="countryflag" class="col-md-2 control-label">Image</label>
                <div class="col-md-6">
                    <input type="file" name="countryflag" id="countryflag" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="countryflag_old" value="<?php echo $page->flag; ?>"/>
                        <?php if ($page->flag != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/flag/<?php echo $page->flag; ?>" />
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label for="address" class="col-md-2 control-label">Address</label>
                <div class="col-md-6">
                    <textarea name="address" id="address" class="form-control" rows="5">{{ isset($page) ? $page->address : Input::old('address') }}</textarea>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="rest_backend" class="col-md-2 control-label">Restaurant Backend URL</label>
                <div class="col-md-6">
                    <input type="input" name="rest_backend" class="form-control"  value="{{ isset($page) ? $page->rest_backend : Input::old('rest_backend') }}" id="rest_backend" placeholder="rest_backend">
                </div>
            </div>
            
            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="id"  value="{{ isset($page) ? $page->id : 0 }}" id="id" >
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>


@endsection