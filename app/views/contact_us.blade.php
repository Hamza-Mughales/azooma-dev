<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
      

            {{-- Breadcrumb Section Start --}}
    <section class="Breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <ul class="breadcrumb-nav">
                        <li>
                            <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                                <?php echo Lang::get('messages.azooma'); ?></a>
                        </li>
                        <li class="active">
                            <?php echo Lang::get('messages.contact_us');?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="breadcrumb-social">
                        <div class="social">
                            <a href="https://twitter.com/share"><i class="fa fa-twitter"></i> Tweet</a>
                        </div>
                        <div class="social">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo Request::url();?>"><i
                                    class="fa fa-facebook"></i> Share</a>
                            {{-- <div class="fb-share-button" data-layout="button_count" data-href="<?php echo Request::url();?>"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        {{-- Breadcrumb Section End --}}
        {{-- contact Us Section Start --}}
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt-6">
                        <?php if(Session::has('success')){ ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo Session::get('success');?>
                            </div>
                            <?php }
                            if(isset($errors)){
                                    if(!$errors->isEmpty()){
                                        ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <?php echo $errors->first();?>
                                        </div>
                                        <?php
                                    }    
                                }
                            ?>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-6">
                        <h2>
                            <?php echo Lang::get('messages.our_office_address');?>
                        </h2>
                        <?php
                        if(count($countries)>0){
                            foreach ($countries as $country) {
                                ?>
                                <div class="country-block">
                                <h3 class="mainColor">
                                    <?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr); ?>
                                </h3>
                                <p>
                                    <?php echo stripcslashes($country->address);?>
                                </p>
                                <p>
                                    <?php echo stripcslashes($country->telephone);?>
                                </p>
                            </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-6">
                        <h2>
                            <?php echo Lang::get('messages.write_to_us');?>
                        </h2>
                        <form  role="form" action="" method="post" class="contact-form" id="contact-us-form" enctype="multipart/form-data">
                            <div class="form-group row">
                                <input type="text" class="form-control input-lg required" id="contactname" name="contactname" placeholder="<?php echo Lang::get('messages.name');?>"/>
                            </div>
                            <div class="form-group ">
                                <input type="email" class="form-control input-lg required" id="contactemail" name="contactemail" placeholder="<?php echo Lang::get('messages.email');?>"/>
                            </div>
                            <div class="form-group row">
                                    <input type="text" class="form-control input-lg" id="contactphone" name="contactphone" placeholder="<?php echo Lang::get('messages.mobile').' / '.Lang::get('messages.telephone');?>"/>
                            </div>
                            <div class="form-group row">
                                <select name="enquiry_type" id="enquiry_type" class="form-control input-lg required">
                                    <option value=""><?php echo Lang::get('messages.enquiry_type');?></option>
                                    <option value="Advertising"><?php echo Lang::get('messages.advertising');?></option>
                                    <option value="Bug Reporting"><?php echo Lang::get('messages.bug_report');?></option>
                                    <option value="Job Seeker"><?php echo Lang::get('messages.seeking_job');?></option>
                                    <option value="To Promote My Restaurant"><?php echo Lang::get('messages.promote_restaurant');?></option>
                                    <option value="Ideas to Improve Azooma.co"><?php echo Lang::get('messages.ideas_improve_sufrati');?></option>
                                    <option value="Out of Date Business Listing"><?php echo Lang::get('messages.out_of_date');?></option>
                                    <option value="Make a Complaint"><?php echo Lang::get('messages.make_complaint');?></option>
                                    <option value="Other"><?php echo Lang::get('messages.other');?></option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <textarea placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.message');?>" class="form-control input-lg required" rows="5" name="contactmessage" id="contactmessage"></textarea>
                            </div>
                            <div class="form-group row">
                                <button class="btn btn-camera btn-lg big-main-btn" type="submit"><?php echo Lang::get('messages.submit');?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        {{-- contact Us Section End --}}
    @include('inc.footer')
    <script type="text/javascript">
        require(['bootstrap-multiselect','add-restaurant'],function(){});
    </script>
</body>
</html>