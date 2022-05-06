<!--
 #####              ####                       #         #    
 #     #            #                           #              
 #        #     #  ####      # ###    ######  ######    ###    
  #####   #     #   #        ##      #     #    #         #    
       #  #     #   #        #       #     #    #         #    
 #     #  #    ##   #        #       #    ##    #         #    
  #####    #### #   #        #        #### #     ###    ##### 
  -->
<meta charset="utf-8">
<title><?php if(isset($title)) echo $title;?></title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="http://www.sufrati.com/sa/favicon.ico" />
<meta name="robots" content="index, follow"/>
<link href="<?php echo base_url('css/bootstrap.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/adminmenu.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/admin.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/docs.css');?>" rel="stylesheet" type="text/css" />
<?php 
	if(isset($css)){
		$files=explode(",", $css);  
		foreach($files as $val){
			?>
			<link rel="stylesheet" href="<?php echo base_url();?>css/<?php echo $val;?>.css" />
			<?php
		}
	}
 ?>

<script type="text/javascript">
    var base="<?php echo base_url();?>";
    <?php
    if($this->session->userdata('sufratiuser')&&($this->session->userdata('sufratiuser')!="")){
      ?>
          var loggedin=1;
          <?php
    }
    ?>
 </script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo base_url();?>/js/new/jquery.js"><\/script>')</script>
<script type="text/javascript" src="<?php echo base_url('js/bootstrap.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/bootstrap.min.js');?>"></script>

<script>
    $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
    });
    </script>
 <?php 
	if(isset($js)){
		$files=explode(",", $js);  
		foreach($files as $val){
			?>
            <script src="<?php echo base_url();?>js/<?php echo $val;?>.js"></script>
			<?php
		}
	}
 ?>

            
<script type='text/javascript'>
//var googletag = googletag || {};
//googletag.cmd = googletag.cmd || [];
//(function() {
//var gads = document.createElement('script');
//gads.async = true;
//gads.type = 'text/javascript';
//var useSSL = 'https:' == document.location.protocol;
//gads.src = (useSSL ? 'https:' : 'http:') + 
//'//www.googletagservices.com/tag/js/gpt.js';
//var node = document.getElementsByTagName('script')[0];
//node.parentNode.insertBefore(gads, node);
//})();
</script>

<script type='text/javascript'>
//googletag.cmd.push(function() {
//googletag.defineSlot('/6866964/Sufrati.com-saudi', [560, 90], 'div-gpt-ad-1344948428819-0').addService(googletag.pubads());
//googletag.defineSlot('/6866964/Sufrati_side_banner', [267, 250], 'div-gpt-ad-1346506023410-0').addService(googletag.pubads());
//googletag.pubads().enableSingleRequest();
//googletag.enableServices();
//});
</script>