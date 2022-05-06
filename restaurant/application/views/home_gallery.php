<link rel="stylesheet" type="text/css" href="<?= base_url(css_path()) ?>photoswipe.css">

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5><?= lang('restaurant_photos') ?></h5>
                    <div class="card-header-right">
                    <a class="btn  btn-primary" href="<?= base_url('gallery') ?>"><?= lang('view_all') ?></a>

                </div>
                </div>
              
                <div class="my-gallery card-body row gallery-with-description" itemscope="">
                    <?php if (isset($gelary_images) and !empty($gelary_images)) { ?>
                        <?php
                        $i = 0;
                        foreach ($gelary_images as $g) {
                            // var_dump($g);
                            //exit;
                            if (file_exists(files_path() . 'Gallery/' . $g->image_full)) {                  ?>
                                <figure class="col-xl-3 col-sm-6" itemprop="associatedMedia" itemscope=""><a href="<?= app_files_url() ?>Gallery/<?php echo $g->image_full; ?>" itemprop="contentUrl" data-size="1600x950">
                                        <img style="max-height: 250px;" src="<?= app_files_url() ?>Gallery/<?php echo $g->image_full; ?>" itemprop="thumbnail" alt="Image description">
                                        <div class="caption">
                                            <h4> <?= sys_lang() == "arabic" ? $g->title_ar : $g->title; ?></h4>
                                            <p> </p>
                                        </div>
                                    </a>
                                    <figcaption itemprop="caption description">
                                        <h4><?= sys_lang() == "arabic" ? $g->title_ar : $g->title; ?></h4>
                                        <p></p>
                                    </figcaption>
                                </figure>
                        <?php }
                        } ?>
                    <?php } else { ?>

                        <?= lang('no_photo_yet') ?>

                    <?php } ?>
                </div>
                <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                    <!--
                    Background of PhotoSwipe.
                    It's a separate element, as animating opacity is faster than rgba().
                    -->
                    <div class="pswp__bg"></div>
                    <!-- Slides wrapper with overflow:hidden.-->
                    <div class="pswp__scroll-wrap">
                        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory.-->
                        <!-- don't modify these 3 pswp__item elements, data is added later on.-->
                        <div class="pswp__container">
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                        </div>
                        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed.-->
                        <div class="pswp__ui pswp__ui--hidden">
                            <div class="pswp__top-bar">
                                <!-- Controls are self-explanatory. Order can be changed.-->
                                <div class="pswp__counter"></div>
                                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                <button class="pswp__button pswp__button--share" title="Share"></button>
                                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR-->
                                <!-- element will get class pswp__preloader--active when preloader is running-->
                                <div class="pswp__preloader">
                                    <div class="pswp__preloader__icn">
                                        <div class="pswp__preloader__cut">
                                            <div class="pswp__preloader__donut"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                <div class="pswp__share-tooltip"></div>
                            </div>
                            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                            <div class="pswp__caption">
                                <div class="pswp__caption__center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
<script src="<?= base_url(js_path()) ?>photoswipe/photoswipe.min.js"></script>
<script src="<?= base_url(js_path()) ?>photoswipe/photoswipe-ui-default.min.js"></script>
<script src="<?= base_url(js_path()) ?>photoswipe/photoswipe.js"></script>