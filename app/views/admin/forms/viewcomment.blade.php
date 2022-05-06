
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admincomments'); ?>">All Comments</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincomments/save'); }}" method="post" >
            <div class="form-group row">
                <label class="col-md-2 control-label">Comment From</label>
                <div class="col-md-6">
                    <?php
                    echo $user->user_FullName;
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label">Date</label>
                <div class="col-md-6">
                    <?php
                    echo date('d/m/Y', strtotime($comment->review_Date));
                    echo ' &nbsp; ';
                    echo date('h:i:s', strtotime($comment->review_Date));
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="review_Msg" class="col-md-2 control-label">Description</label>
                <div class="col-md-6">
                    <textarea name="review_Msg" id="review_Msg" class="form-control" rows="5">{{ isset($comment) ? $comment->review_Msg : Input::old('review_Msg') }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="review_Status" value="1"  {{ isset($comment) ? ($comment->review_Status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($comment)) {
                        ?>
                        <input type="hidden" name="review_ID"  value="{{ isset($comment) ? $comment->review_ID : 0 }}" id="review_ID" >
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>

