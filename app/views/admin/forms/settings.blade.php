
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>    
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminsettings/save'); }}" method="post" >

            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Site Name</label>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control required" id="name" placeholder="Site Name" value="{{ isset($settings) ? $settings->name : Input::old('name') }}" >
                </div>
            </div>
            <div class="form-group row">
                <label for="nameAr" class="col-md-2 control-label">Site Name Arabic</label>
                <div class="col-md-6">
                    <input type="text" name="nameAr" class="form-control required" id="nameAr" placeholder="Site Name Arabic" value="{{ isset($settings) ? $settings->nameAr : Input::old('nameAr') }}" dir="rtl">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="countryname" class="col-md-2 control-label">Country Name</label>
                <div class="col-md-6">
                    <input type="text" name="countryname" class="form-control required" id="countryname" placeholder="Country Name" value="{{ isset($settings) ? $settings->countryname : Input::old('countryname') }}" >
                </div>
            </div>
            <div class="form-group row">
                <label for="countrynameAr" class="col-md-2 control-label">Country Name Arabic</label>
                <div class="col-md-6">
                    <input type="text" name="countrynameAr" class="form-control required" id="countrynameAr" placeholder="Country Name Arabic" value="{{ isset($settings) ? $settings->countrynameAr : Input::old('countrynameAr') }}" dir="rtl">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="currency" class="col-md-2 control-label">Currency</label>
                <div class="col-md-6">
                    <input type="text" name="currency" class="form-control required" id="currency" placeholder="Currency" value="{{ isset($settings) ? $settings->currency : Input::old('currency') }}" >
                </div>
            </div>
            <div class="form-group row">
                <label for="currencyAr" class="col-md-2 control-label">Currency Arabic</label>
                <div class="col-md-6">
                    <input type="text" name="currencyAr" class="form-control required" id="currencyAr" placeholder="Currency Arabic" value="{{ isset($settings) ? $settings->currencyAr : Input::old('currencyAr') }}" dir="rtl">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="keywords" class="col-md-2 control-label">keywords</label>
                <div class="col-md-6">
                    <input type="text" name="keywords" class="form-control required" id="keywords" placeholder="keywords" value="{{ isset($settings) ? $settings->keywords : Input::old('keywords') }}" >
                </div>
            </div>
            <div class="form-group row">
                <label for="keywordsAr" class="col-md-2 control-label">keywords Arabic</label>
                <div class="col-md-6">
                    <input type="text" name="keywordsAr" class="form-control required" id="keywordsAr" placeholder="keywords Arabic" value="{{ isset($settings) ? $settings->keywordsAr : Input::old('keywordsAr') }}" dir="rtl">
                </div>
            </div>
            
            

            <div class="form-group row">
                <label for="email" class="col-md-2 control-label">Site Email</label>
                <div class="col-md-6">
                    <input type="text" name="email" class="form-control required" id="email" placeholder="Site Email" value="{{ isset($settings) ? $settings->email : Input::old('email') }}" >
                </div>
            </div>
            <div class="form-group row">
                <label for="twitter" class="col-md-2 control-label">Twitter Profile</label>
                <div class="col-md-6">
                    <input type="text" name="twitter" class="form-control required" id="twitter" placeholder="Twitter Profile" value="{{ isset($settings) ? $settings->twitter : Input::old('twiter') }}" >
                </div>
            </div>

            <div class="form-group row">
                <label for="facebook" class="col-md-2 control-label">Facebook Profile</label>
                <div class="col-md-6">
                    <input type="text" name="facebook" class="form-control required" id="facebook" placeholder="FaceBook Profile" value="{{ isset($settings) ? $settings->facebook : Input::old('facebook') }}" >
                </div>
            </div>

            <div class="form-group row">
                <label for="linkedin" class="col-md-2 control-label">LinkedIn Profile</label>
                <div class="col-md-6">
                    <input type="text" name="linkedin" class="form-control required" id="linkedin" placeholder="LinkedIn Profile" value="{{ isset($settings) ? $settings->linkedin : Input::old('linkedin') }}" >
                </div>
            </div>

            <div class="form-group row">
                <label for="youtube" class="col-md-2 control-label">Youtube Channel</label>
                <div class="col-md-6">
                    <input type="text" name="youtube" class="form-control required" id="youtube" placeholder="Youtube Cannel" value="{{ isset($settings) ? $settings->youtube : Input::old('youtube') }}" >
                </div>
            </div>
            
            <div class="form-group row">
                <label for="instagram" class="col-md-2 control-label">Instagram Link</label>
                <div class="col-md-6">
                    <input type="text" name="instagram" class="form-control required" id="instagram" placeholder="instagram Link" value="{{ isset($settings) ? $settings->instagram : Input::old('instagram') }}" >
                </div>
            </div>

            <div class="form-group row">
                <label for="tel" class="col-md-2 control-label">Telephone</label>
                <div class="col-md-6">
                    <input type="text" name="tel" class="form-control required" id="tel" placeholder="Telephone" value="{{ isset($settings) ? $settings->tel : Input::old('tel') }}" >
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="col-md-2 control-label">Mobile</label>
                <div class="col-md-6">
                    <input type="text" name="mobile" class="form-control required" id="mobile" placeholder="Mobile" value="{{ isset($settings) ? $settings->mobile : Input::old('mobile') }}" >
                </div>
            </div>
            
            <div class="form-group row">
                <label for="fax" class="col-md-2 control-label">FAX</label>
                <div class="col-md-6">
                    <input type="text" name="fax" class="form-control required" id="fax" placeholder="FAX" value="{{ isset($settings) ? $settings->fax : Input::old('fax') }}" >
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-md-2 control-label">Site Address</label>
                <div class="col-md-6">
                    <textarea name="address" class="form-control " id="address">{{ isset($settings) ? $settings->address : Input::old('address') }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="addressAr" class="col-md-2 control-label">Site Address</label>
                <div class="col-md-6">
                    <textarea dir="rtl" name="addressAr" class="form-control required" id="addressAr">{{ isset($settings) ? $settings->addressAr : Input::old('addressAr') }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($settings)) {
                        ?>
                        <input type="hidden" name="id"  value="{{ isset($settings) ? $settings->id : 0 }}" id="id" >
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>

