<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('menus'); ?>"><?=lang('menu_management')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('pdf_menus')?> </li>

    </ul>
</div>
<?php
echo message_box('error');
echo message_box('success');
?>
<section class="card">

    <div class="card-body">
            <h4>
            
                    <?php echo $pagetitle; ?> 
            
            </h4>
            <div id="results">
        
                <form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('menus/savepdf'); ?>" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="menu"><?=lang('pdf_menu_english')?><br><span class="small-text" style="font-size:12px;">(1MB)</span></label>
                            <div class="col-md-12">
                                <input class="form-control" type="file" name="menu" id="menu" />
                                <?php
                                if (isset($menu)) {
                                ?>
                                    <input type="hidden" name="menu_old" value="<?php echo $menu['menu']; ?>" />
                                    <a target="_blank" href="http://uploads.azooma.co/images/menuItem/<?php echo $menu['menu']; ?>" title="Download">View Menu</a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="menu_ar"><?=lang('pdf_menu_ar')?><br><span class="small-text" style="font-size:12px;">(1MB)</span></label>
                            <div class="col-md-12">
                                <input class="form-control" type="file" name="menu_ar" id="menu_ar" />
                                <?php
                                if (isset($menu)) {
                                ?>
                                    <input type="hidden" name="menu_ar_old" value="<?php echo $menu['menu_ar']; ?>" />
                                    <a target="_blank" href="http://uploads.azooma.co/images/menuItem/<?php echo $menu['menu_ar']; ?>" title="Download">View Menu</a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="title"><?=lang('title')?></label>
                            <div class="col-md-12">
                                <input type="text" name="title" class="form-control" required id="title" placeholder="<?=lang('title')?>" <?php echo isset($menu) ? 'value="' . (htmlspecialchars($menu['title'])) . '"' : ""; ?> />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="title_ar"><?=lang('title_ar')?></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" required name="title_ar" id="title_ar" placeholder="<?=lang('title_ar')?>" <?php echo isset($menu) ? 'value="' . (htmlspecialchars($menu['title_ar'])) . '"' : ""; ?> />
                            </div>
                        </div>

                        <div class="form-group row text-end">
                            <div class="col-md-12">
                                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID']; ?>" />
                                <input type="hidden" name="rest_Name" value="<?php echo $rest['rest_Name']; ?>" />
                                <?php if (isset($menu)) {
                                ?>
                                    <input type="hidden" name="id" value="<?php echo $menu['id']; ?>" />
                                    <input type="hidden" name="pagenumber" value="<?php echo $menu['pagenumber']; ?>" />
                                    <input type="hidden" name="pagenumberAr" value="<?php echo $menu['pagenumberAr']; ?>" />
                                <?php
                                }
                                ?>
                                <input type="submit" name="submit" value="<?=lang('save')?>" class="btn btn-primary" />
                                <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                            else echo base_url('hungryn137/menu'); ?>" class="btn" title="btn btn-light Changes"><?=lang('cancel')?></a>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <script type="text/javascript">
                    $("#menuForm").validate();
                </script>

            </div>
        </article>

    </div>
</section>