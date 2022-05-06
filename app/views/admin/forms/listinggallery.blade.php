<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminlisting'); ?>">Business Listings</a></li>
    <li class="active">{{ $title }}</li>
</ol>



<div class="well-white">
    <?php
    include(app_path() . '/views/admin/common/listingheader.blade.php');
    ?>
    <article>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminlistinggallery/save'); }}" method="post" enctype="multipart/form-data">
            <legend>General Information</legend>
            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Name English</label>
                <div class="col-md-6">
                    <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Name English">
                </div>
            </div>
            <div class="form-group row">
                <label for="nameAr" class="col-md-2 control-label">Name Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="nameAr" class="form-control required"  value="{{ isset($page) ? $page->nameAr : Input::old('name') }}" id="nameAr" placeholder="Name Arabic" dir="rtl">
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
                <label class="col-md-2 control-label"></label>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($mainPage)) {
                        ?>
                        <input type="hidden" name="List_ID"  value="{{ isset($mainPage) ? $mainPage->List_ID : 0 }}" id="List_ID" >
                        <?php
                    }
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



