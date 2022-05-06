<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
<link rel="canonical" href="<?php echo $originallink;?>"/>
<?php if(isset($prev)){ ?>
<link rel="prev" href="<?php echo $prev;?>"/>
<?php } if(isset($next)){ ?>
<link rel="next" href="<?php echo $next;?>"/>
<?php } ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
    @include('main.coming')
    @include('inc.footer')
</body>
</html>