<meta charset="UTF-8">
<title><?php echo (isset($title))?$title.' | '.Lang::get('messages.azooma'):Lang::get('messages.azooma');?></title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="alexaVerifyID" content="Wej2bahyMcHhLX3q-YprTVvABVI" />
<meta name="description" content="<?php if(isset($metadesc)) echo $metadesc;?>">
<meta name="keywords" content="<?php if(isset($metakey)) echo $metakey;?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo URL::to('favicon_en.png'); ?>" type="image/png"/>
<link rel="apple-touch-icon-precomposed" href="http://app.azooma.co/images/icon.png">
<link rel="icon" href="<?php echo URL::to('favicon_en.png'); ?>" type="image/png">
<link type="text/plain" rel="author" href="<?php echo URL::to('humans.txt');?>" />
<link href="https://plus.google.com/+Sufratiplus" rel="publisher"/>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

<?php
$lang= Config::get('app.locale');
$altlang=($lang=="en")?"ar-sa":'en-us';?>
<link rel="alternate" href="<?php echo Azooma::LanguageSwitch(Request::path());?>" hreflang="<?php echo $altlang;?>">
<meta name="robots" content="index, follow"/>

<?php 
// echo HTML::style('css/default.css?v=0.3b');
echo HTML::style('css/bootstrap.min.css');

echo HTML::style('css/animate.css');
echo HTML::style('css/all.min.css');
echo HTML::style('css/owl.carousel.min.css');
echo HTML::style('css/intlTelInput.min.css');

// echo HTML::style('css/owl.theme.default.min.css');

if($lang=="ar"){
	echo HTML::style('css/new-rtl.css');
	?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/earlyaccess/droidarabicnaskh.css">
	<?php
}
else{
	echo HTML::style('css/new.css');
}

?>
<script src="<?php echo URL::asset('js/jquery-3.5.1.min.js');?>"></script>
<script src="<?php echo URL::asset('js/bootstrap.bundle.min.js');?>"></script>
<script src="<?php echo URL::asset('js/owl.carousel.min.js');?>"></script>

<script src="https://www.gstatic.com/firebasejs/ui/4.8.0/firebase-ui-auth.js"></script>

<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.8.0/firebase-ui-auth.css" />
  <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

  <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>

  <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-analytics.js"></script>

  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-firestore.js"></script>




<script type="text/javascript">
	var originalbase='<?php echo URL::to(""); ?>';
	var uploadbase='<?php echo Azooma::CDN("");?>';
<?php 
if($lang=="en"){
?>
	var base='<?php echo URL::to(""); ?>',lang='en';
<?php
}else{
	?>
	var base='<?php echo URL::to("ar"); ?>',lang='ar';
	<?php
}
if(Session::get('sfcity')!=null){
	$city=DB::connection('new-sufrati')->select('SELECT city_ID,city_Name,city_Name_ar,seo_url FROM city_list WHERE city_Status=1 AND city_ID='.Session::get('sfcity').' LIMIT 1');
	?>
	var city={'id':'<?php echo stripcslashes($city[0]->city_ID);?>','name':'<?php echo stripcslashes($city[0]->city_Name);?>','nameAr':'<?php echo stripcslashes($city[0]->city_Name_ar);?>','url':'<?php echo stripcslashes($city[0]->seo_url);?>'};
	<?php
}
if(Session::has('userid')){ ?>var loggedinuser=<?php echo Session::get('userid');?>;<?php
	if(Session::has('fbid')&&Session::has('fb_publish')&&Session::get('fb_publish')!=0&&Session::get('fbid')!=""){
		?><?php
	}
 }else{ ?>var loggedinuser=false;
<?php  } ?>
</script>
<script>
  var RtlMode = false;
  <?php  if ($lang == 'ar') {?>
    RtlMode = true; <?php
    } ?>
</script>