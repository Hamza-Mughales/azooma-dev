<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('menus'); ?>"><?=lang('menu_management')?></a> <span class="divider">/</span>
        </li>
        <?php
        if (isset($menu)) {
        ?>
            <li class="active"><?=lang('menu_type')?> </li>
        <?php }
        if (isset($category)) {
        ?>
            <li class="active"><?=lang('menu_category')?></li>
        <?php }
        if (isset($item)) {
        ?>
            <li class="active"><?=lang('menu_item')?> </li>
        <?php } ?>

    </ul>
</div>
<?php
echo message_box('error');
echo message_box('success');
?>
<section class="card">

    <div class="card-body">
            <h4 class="mb-4">
                    <?php echo $pagetitle; ?> 
            </h4>
            <div id="results">
        
                <?php
                if (isset($menu)) {
                ?>
                    <form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('menus/save/menu'); ?>">
                     

                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="cat_name"><?=lang('m_type_name')?></label>
                                <div class="col-md-9">
                                    <input type="text" name="menu_name" class="form-control" required id="menu_name" placeholder="<?=lang('m_type_name')?>" <?php echo isset($menucat) ? 'value="' . (htmlspecialchars($menucat['menu_name'])) . '"' : ""; ?> />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="cat_name_ar"><?=lang('m_type_name_ar')?></label>
                                <div class="col-md-9">
                                    <input type="text" name="menu_name_ar" id="menu_name_ar" class="form-control" required placeholder="<?=lang('m_type_name_ar')?>" <?php echo isset($menucat) ? 'value="' . (htmlspecialchars($menucat['menu_name_ar'])) . '"' : ""; ?> />
                                </div>
                            </div>
                            <div class="form-group row text-end">
                                <div class="col-md-12">
                                    <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID']; ?>" />
                                    <?php if (isset($menucat)) {
                                    ?>
                                        <input type="hidden" name="menu_id" value="<?php echo $menucat['menu_id']; ?>" />
                                    <?php
                                    }
                                    ?>
                                    <input type="submit" name="submit" value="<?=lang('save')?>" class="btn btn-primary" />
                                    <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                                else echo base_url('menus'); ?>" class="btn" title="btn btn-light"><?=lang('cancel')?></a>
                                </div>
                            </div>
                       
                    </form>
                <?php
                }
                if (isset($category)) {
                ?>
                    <form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('menus/save/menucategory'); ?>">
                        <fieldset>
                            <legend><?php echo $pagetitle; ?></legend>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="cat_name_ar"><?=lang('menu_type')?></label>
                                <div class="col-md-9">
                                    <select id="menu_id" name="menu_id" class="form-control" required>
                                        <option value=""><?=lang('please_select')?></option>
                                        <?php
                                        $i = 0;
                                        foreach ($menuList as $list) {
                                            $i++;
                                        ?>
                                            <option value="<?php echo $list['menu_id']; ?>" <?php if (isset($menucat)) {
                                                                                                if ($list['menu_id'] == $menucat['menu_id']) {
                                                                                                    echo "selected";
                                                                                                }
                                                                                            } elseif (isset($_GET['menu_id'])) {
                                                                                                if ($_GET['menu_id'] == $list['menu_id']) {
                                                                                                    echo "selected";
                                                                                                }
                                                                                            } ?>><?php echo $list['menu_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="cat_name"><?=lang('menu_cat_name')?></label>
                                <div class="col-md-9">
                                    <input type="text" name="cat_name" class="form-control" required id="cat_name" placeholder="<?=lang('menu_cat_name')?>" <?php echo isset($menucat) ? 'value="' . (htmlspecialchars($menucat['cat_name'])) . '"' : ""; ?> />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="cat_name_ar"><?=lang('menu_cat_name_ar')?></label>
                                <div class="col-md-9">
                                    <input type="text" name="cat_name_ar" id="cat_name_ar" class="form-control" required placeholder="<?=lang('menu_cat_name_ar')?>" <?php echo isset($menucat) ? 'value="' . (htmlspecialchars($menucat['cat_name_ar'])) . '"' : ""; ?> />
                                </div>
                            </div>

                            <div class="form-group row text-end">
                                <div class="col-md-12">
                                    <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID']; ?>" />
                                    <?php if (isset($menucat)) {
                                    ?>
                                        <input type="hidden" name="cat_id" value="<?php echo $menucat['cat_id']; ?>" />
                                    <?php
                                    }
                                    ?>
                                    <input type="submit" name="submit" value="<?=lang('save')?>" class="btn btn-primary" />
                                    <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                                else echo base_url('menus'); ?>" class="btn" title="Cancel Changes"><?=lang('cancel')?></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                <?php
                }
                if (isset($item)) {
                ?>
                    <form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('menus/save/menuitem'); ?>" enctype="multipart/form-data">
                        <fieldset>
                            <legend><?php echo $pagetitle; ?></legend>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="menu_item"><?=lang('menu_item_name')?></label>
                                <div class="col-md-9">
                                    <input type="text" name="menu_item" id="menu_item" class="form-control" required placeholder="<?=lang('menu_item_name')?>" <?php echo isset($menuitem) ? 'value="' . (htmlspecialchars($menuitem['menu_item'])) . '"' : ""; ?> />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="menu_item_ar"><?=lang('menu_item_name_ar')?></label>
                                <div class="col-md-9">
                                    <input type="text" name="menu_item_ar" dir="rtl" id="menu_item_ar" class="form-control" required placeholder="<?=lang('menu_item_name_ar')?>" <?php echo isset($menuitem) ? 'value="' . (htmlspecialchars($menuitem['menu_item_ar'])) . '"' : ""; ?> />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="rest_Description" class="col-md-3 control-label"><?=lang('menu_item_desc')?></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" placeholder="<?=lang('menu_item_desc')?>" rows="5" id="menuItemDescription" name="menuItem_Description"><?php if (isset($menuitem) && ($menuitem['description'] != "")) echo stripcslashes($menuitem['description']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rest_Description_Ar" class="col-md-3 control-label"><?=lang('menu_item_desc_ar')?></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" placeholder="<?=lang('menu_item_desc_ar')?>" dir="rtl" rows="5" id="menuItem_Description_Ar" name="menuItem_Description_Ar"><?php if (isset($menuitem) && ($menuitem['descriptionAr'] != "")) echo stripcslashes($menuitem['descriptionAr']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="price"><?=lang('Price')?></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" name="price" id="price" placeholder="<?=lang('Price')?>" <?php echo isset($menuitem) ? 'value="' . $menuitem['price'] . '"' : ""; ?> />
                                </div>
                            </div>
                            <?php if ($permissions['accountType'] != 0) { ?>
                                <div class="form-group row">
                                    <label for="rest_Logo" class="col-md-3 control-label"><?=lang('image')?><br /><span class="small-font"><?=lang('img_size')?>: (200*200)</span></label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="file" id="menuItem_image" name="menuItem_image">
                                        <?php
                                        if (isset($menuitem)) {
                                            if (!empty($menuitem['image'])) {
                                        ?>
                                                <img src="<?php echo $this->config->item('sa_url') . 'images/menuItem/thumb/' . $menuitem['image']; ?>">
                                                <input type="hidden" value="<?php echo $menuitem['image']; ?>" name="rest_Logo_old">
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group row text-end">
                                <div class="col-md-12">
                                    <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID']; ?>" />
                                    <input type="hidden" name="cat_id" value="<?php echo $cat['cat_id']; ?>" />
                                    <input type="hidden" name="menu_id" value="<?php echo $cat['menu_id']; ?>" />
                                    <?php if (isset($menuitem)) {
                                    ?>
                                        <input type="hidden" name="id" value="<?php echo $menuitem['id']; ?>" />
                                    <?php
                                    }
                                    ?>
                                    <input type="submit" name="submit" value="<?=lang('save')?>" class="btn btn-primary" />
                                    <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                                else echo base_url('menus'); ?>" class="btn" title="Cancel Changes"><?=lang('cancel')?></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                <?php
                }
                ?>
                <script type="text/javascript">
                    $("#menuForm").validate();
                </script>

            </div>
     

    </div>
</section>