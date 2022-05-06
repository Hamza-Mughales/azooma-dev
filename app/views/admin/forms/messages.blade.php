
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminmessages'); ?>">Welcome Messages </a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminmessages/save'); }}" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="country" class="col-md-2 control-label">Country</label>
                <div class="col-md-6">

                    <select name="country" id="country" class="form-control required" onchange="return checksub(this.value,'');">
                        <option value="">Please select country</option>
                        <?php
                        $countries = Config::get('settings.countries');
                        if (is_array($countries)) {
                            foreach ($countries  as $key => $value) {
                                $selected = "";
                                if (isset($page) && $page->country == $key) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option {{ $selected; }} value="{{ $key }}">
                                    {{ $value }}
                                </option>
                                <?php
                            }
                        }
                        ?>                
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="text_en" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="text_en" class="form-control required" value="{{ isset($page) ? $page->text_en : Input::old('text_en') }}" id="text_en" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="text_ar" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="text_ar" class="form-control required"  value="{{ isset($page) ? $page->text_ar : Input::old('text_ar') }}" id="text_ar" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
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
