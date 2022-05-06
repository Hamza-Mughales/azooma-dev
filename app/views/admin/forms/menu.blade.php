@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('adminrestaurants'); ?>">All Restaurants</a></li>  
    <li class="active">{{ $title }}</li>
</ol>




<?php
include(app_path() . '/views/admin/common/restaurant.blade.php');
?>

<div class="well-white">
    <article>
        <?php
        if (isset($menu)) {
            ?>
            <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="<?php echo route('adminrestmenu/save'); ?>">
                <fieldset>
                    <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                    <div class="form-group row">
                        <label class="col-md-3 control-label" for="cat_name">Menu Type Name</label>
                        <div class="col-md-6">
                            <input type="text" name="menu_name" class="form-control required" id="menu_name" placeholder="Menu Type Name" <?php echo isset($menucat) ? 'value="' . stripslashes(($menucat->menu_name)) . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label" for="cat_name_ar">Arabic Name </label>
                        <div class="col-md-6">
                            <input type="text" name="menu_name_ar" id="menu_name_ar" dir="rtl" class="form-control required" placeholder="" <?php echo isset($menucat) ? 'value="' . stripslashes(($menucat->menu_name_ar)) . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-md-3 col-md-6">
                            <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>"/>
                            <input type="hidden" name="menuActionSave" value="menu"/>
                            <?php if (isset($menucat)) {
                                ?>
                                <input type="hidden" name="menu_id" value="<?php echo $menucat->menu_id; ?>"/>
                                <?php
                            }
                            ?>
                            <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                            <a href="<?php
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                echo $_SERVER['HTTP_REFERER'];
                            } else {
                                echo route('adminrestmenu/', $rest->rest_ID);
                            }
                            ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                        </div>
                    </div>
                </fieldset>
            </form>
            <?php
        }
        if (isset($category)) {
            ?>
            <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="<?php echo route('adminrestmenu/save'); ?>">
                <fieldset>
                    <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="cat_name_ar">Menu Type</label>
                        <div class="col-md-8">
                            <select id="menu_id" name="menu_id" class="form-control required">
                                <option value="">Please select</option>
                                <?php
                                $i = 0;
                                foreach ($menuList as $list) {
                                    $i++;
                                    ?>
                                    <option value="<?php echo $list->menu_id; ?>" <?php
                                    if (isset($menucat)) {
                                        if ($list->menu_id == $menucat->menu_id) {
                                            echo "selected";
                                        }
                                    } elseif (isset($_GET['menu_id'])) {
                                        if ($_GET['menu_id'] == $list->menu_id) {
                                            echo "selected";
                                        }
                                    }
                                    ?>><?php echo stripslashes(($list->menu_name)); ?></option>
                                            <?php
                                        }
                                        ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="cat_name">Menu Category Name</label>
                        <div class="col-md-8">
                            <input type="text" name="cat_name" class="form-control required" id="cat_name" placeholder="Menu Category Name" <?php echo isset($menucat) ? 'value="' . stripslashes(($menucat->cat_name)) . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="cat_name_ar">Menu Category Name Arabic</label>
                        <div class="col-md-8">
                            <input type="text" name="cat_name_ar" id="cat_name_ar" dir="rtl" class="form-control required" placeholder="Menu Category Name Arabic" <?php echo isset($menucat) ? 'value="' . stripslashes(($menucat->cat_name_ar)) . '"' : ""; ?> />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>"/>
                            <input type="hidden" name="menuActionSave" value="menucategory"/>
                            <?php if (isset($menucat)) {
                                ?>
                                <input type="hidden" name="cat_id" value="<?php echo $menucat->cat_id; ?>"/>
                                <?php
                            }
                            ?>
                            <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                            <a href="<?php
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                echo $_SERVER['HTTP_REFERER'];
                            } else {
                                echo route('adminrestmenu/', $rest->rest_ID);
                            }
                            ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                        </div>
                    </div>
                </fieldset>
            </form>
            <?php
        }
        if (isset($item)) {
            ?>
            <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="<?php echo route('adminrestmenu/save'); ?>" enctype="multipart/form-data">
                <fieldset>
                    <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="menu_item">Menu Item Name</label>
                        <div class="col-md-8">
                            <input type="text" name="menu_item" id="menu_item" class="form-control required" placeholder="Menu Item Name" <?php echo isset($menuitem) ? 'value="' . stripslashes(($menuitem->menu_item)) . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="menu_item_ar"> Arabic Name</label>
                        <div class="col-md-8">
                            <input type="text" name="menu_item_ar" dir="rtl" id="menu_item_ar" class="form-control required" placeholder="Menu Item Name Arabic" <?php echo isset($menuitem) ? 'value="' . stripslashes(($menuitem->menu_item_ar)) . '"' : ""; ?> />
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="rest_Description" class="col-md-2 control-label"> Description/Ingredients</label>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Menu Item Description" rows="5" id="menuItemDescription" name="menuItem_Description"><?php if (isset($menuitem) && ($menuitem->description != "")) echo stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $menuitem->description)); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="rest_Description_Ar" class="col-md-2 control-label">Arabic Description/Ingredients </label>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Menu Item Description Arabic" dir="rtl" rows="5" id="menuItem_Description_Ar" name="menuItem_Description_Ar"><?php if (isset($menuitem) && ($menuitem->descriptionAr != "")) echo stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $menuitem->descriptionAr)); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="price">Price</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="price" id="price" placeholder="Price" <?php echo isset($menuitem) ? 'value="' . $menuitem->price . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rest_Logo" class="col-md-2 control-label">
                            Image
                            <span class="small-text">(500*any)</span>
                        </label>
                        <div class="col-md-8">
                            <input type="file" id="menuItem_image" name="menuItem_image">
                            <?php
                            if (isset($menuitem)) {
                                if (!empty($menuitem->image)) {
                                    ?>
                                    <img src="<?php echo Config::get('settings.uploadurl').'images/menuItem/thumb/' . $menuitem->image; ?>">
                                    <input type="hidden" value="<?php echo $menuitem->image; ?>" name="menuItem_image_old">
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>"/>
                            <input type="hidden" name="menuActionSave" value="menuitem"/>
                            <input type="hidden" name="cat_id" value="<?php echo $cat->cat_id; ?>"/>
                            <input type="hidden" name="menu_id" value="<?php echo $cat->menu_id; ?>"/>
                            <?php if (isset($menuitem)) {
                                ?>
                                <input type="hidden" name="id" value="<?php echo $menuitem->id; ?>"/>
                                <?php
                            }
                            ?>
                            <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                            <a href="<?php
                            if (isset($_SERVER['HTTP_REFERER'])) {
                                echo $_SERVER['HTTP_REFERER'];
                            } else {
                                echo route('adminrestmenu/', $rest->rest_ID);
                            }
                            ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                        </div>
                    </div>
                </fieldset>
            </form>
            <?php
        }
        ?>
    </article>
</div>


@endsection
