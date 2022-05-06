<!doctype html>
<html lang="<?php echo $lang;?>">

<head>
  @include('inc.metaheader',$meta)
  <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
  <meta property="og:title" content="<?php echo (isset($meta['title']))?$meta['title']:Lang::get('messages.azooma');?>">
  <meta property="og:description" content="<?php if(isset($meta['metadesc'])) echo $meta['metadesc'];?>">
  <meta property="og:url" content="<?php echo Request::url();?>">
  <meta property="og:image" content="http://azooma.co/Azoomaapp.png">
  <meta property="og:site_name" content="Azooma">
  <meta property="fb:admins" content="100000277799043">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@Azooma">
  <meta name="twitter:creator" content="@Azooma">
  <meta name="twitter:url" content="<?php echo Request::url();?>">
  <meta name="twitter:title"
    content="<?php echo (isset($meta['title']))?$meta['title']:Lang::get('messages.azooma');?>">
  <meta name="twitter:description" content="<?php if(isset($meta['metadesc'])) echo $meta['metadesc'];?>">
  <meta name="twitter:image" content="http://azooma.co/Azoomaapp.png">
  <meta name="twitter:app:id:iphone" content="709229893">
  <meta name="twitter:app:id:ipad" content="709229893">
  <meta name="twitter:app:id:googleplay" content="com.LetsEat.AzoomaLite">
</head>

<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
  <?php $nonav=array('nonav'=>false); ?>
  @include('inc.header',$nonav)

  <?php ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar);
    ?>

  {{-- City Home Section Start --}}
  {{-- Home Section Start --}}
  <section class="city-home">
    <div class="city-slider owl-carousel owl-theme <?php if($lang == 'ar'){ echo 'owl-rtl'; } ?>">
      <?php 
        $i=0;
        $image="";
        if(count($featured)>0){
        foreach ($featured as $ftr) {
          $image=($lang=="en")?Azooma::CDN('images/'.$ftr->image):Azooma::CDN('images/'.$ftr->image_ar);
              $link="";
              if($ftr->city_ID!=""&&$ftr->city_ID!=0){
                  $link=($lang=="en")?$ftr->link:$ftr->link_ar;
              }else{
                  $link=Azooma::URL($city->seo_url.'/'.$ftr->link);
              }
			?>
      <div class="home-slider">
        <div class="container">
          <div class="row p-0">
            <div class="col-md-12 col-sm-12 p-0">
              <div class="home-image">
                <img <?php if($image!=""){ ?>src="<?php echo $image;?>" <?php } ?>
                  alt="<?php echo ($lang=="en")?stripcslashes($ftr->a_title):stripcslashes($ftr->a_title_ar);?>">
              </div>
              <div class="home-content">
                <div class="center">
                  <h1 class="wow bounceInDown" data-wow-duration="1s">
                    <?php echo ($lang=="en")?stripcslashes($ftr->a_title):stripcslashes($ftr->a_title_ar);?><br>
                  </h1>
                  <a href="<?php echo $link;?>"
                    title="<?php echo ($lang=="en")?stripcslashes($ftr->a_title):stripcslashes($ftr->a_title_ar);?>"
                    class="main-btn-white wow bounceInUp" data-wow-duration="1s"><?php echo Lang::get('messages.knowmore'); ?> </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } } ?>
    </div>


    </div>
  </section>
  <script>
    var rtlmode = false; <?php
    if ($lang == 'ar') {?>
      rtlmode = true; <?php
    } ?>
    $('.city-slider').owlCarousel({
      loop: false,
      margin: 0,
      nav: false,
      dots: true,
      items: 1,
      autoplay:true,
      autoplayTimeout:5000,
      rtl: rtlmode,
    });
  </script>
  {{-- Home Section End --}}
  {{-- City Home Section End --}}
  {{-- City service section Start --}}
  <section class="city-services">
    <div class="container ">
      <div class="row col-12 pt-6">
        <div class="services-boxes mt-6 p-0">
          <div class="services-slider owl-carousel owl-theme mt-6 p-0" id="services-slider">

          <a href="<?php echo Azooma::URL($city->seo_url.'/home-delivery');?>"
            title="<?php echo Lang::get('messages.home_delivery'); ?>" class="service-box">
            <div class="box-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="45.651" height="45.65" viewBox="0 0 45.651 45.65">
                <g id="Home_delivery" data-name="Home delivery" transform="translate(-226.963 -613.96)" opacity="0.8">
                  <g id="Group_516" data-name="Group 516">
                    <path id="Path_979" data-name="Path 979"
                      d="M271.485,632.125a.762.762,0,0,0,1.129-.666v-4.565a.763.763,0,0,0-.394-.666l-8.737-4.819v-6.688a.76.76,0,0,0-.76-.761h-3.8a.761.761,0,0,0-.761.761v3.751l-8.007-4.413a.758.758,0,0,0-.736,0l-22.058,12.173a.761.761,0,0,0-.393.662v4.565a.76.76,0,0,0,1.128.666l3.437-1.9v23.295h-3.8a.76.76,0,1,0,0,1.521h9.891v2.283a2.282,2.282,0,0,0,2.282,2.282h19.782a2.283,2.283,0,0,0,2.283-2.282v-2.283h9.891a.76.76,0,1,0,0-1.521h-3.8V630.23Zm-11.806-16.644h2.283v5.089l-2.283-1.259Zm-31.194,11.862,21.3-11.753,21.31,11.753v2.828L250.15,618.62a.764.764,0,0,0-.736,0l-20.929,11.55Zm31.955,29.985a.761.761,0,0,1-.761.761H239.9a.761.761,0,0,1-.761-.761V637.546a.761.761,0,0,1,.761-.761h6.087v8.369a.76.76,0,0,0,.758.764.748.748,0,0,0,.341-.079l2.731-1.353,2.674,1.351a.76.76,0,0,0,1.1-.683v-8.369h6.087a.761.761,0,0,1,.761.761Zm-12.934-20.543h4.565v7.133l-1.911-.965a.76.76,0,0,0-.68,0l-1.974.976Zm19.021,16.739h-4.565V637.546a2.283,2.283,0,0,0-2.283-2.283H239.9a2.283,2.283,0,0,0-2.282,2.283v15.978H233.05V629.389l16.732-9.234,16.745,9.235Z"
                      fill="#515151" />
                    <path id="Path_980" data-name="Path 980"
                      d="M245.984,627.655a3.8,3.8,0,1,0,3.8-3.8A3.8,3.8,0,0,0,245.984,627.655Zm3.8-2.283a2.283,2.283,0,1,1-2.282,2.283A2.283,2.283,0,0,1,249.788,625.372Z"
                      fill="#515151" />
                  </g>
                </g>
              </svg>

            </div>
            <div class="box-title">
              <?php echo Lang::get('messages.home_delivery'); ?>
            </div>
          </a>
          <a href="<?php echo Azooma::URL($city->seo_url.'/offers');?>"
            title="<?php echo Lang::get('messages.special_offers'); ?>" class="service-box">
            <div class="box-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="47.72" height="45.114" viewBox="0 0 47.72 45.114">
                <g id="Group_533" data-name="Group 533" transform="translate(-370.222 -614.228)" opacity="0.8">
                  <g id="Group_532" data-name="Group 532">
                    <path id="Path_997" data-name="Path 997"
                      d="M396.653,659.342a11.619,11.619,0,0,1-2.376-.245l-11.085-3.11a3.408,3.408,0,0,0-.931-.13,3.445,3.445,0,0,0-1.623.41l-1.976,1.058-.024.893a.645.645,0,0,1-.648.629l-7.138-.2a.649.649,0,0,1-.63-.666l.43-15.622a.645.645,0,0,1,.646-.631l7.139.2a.651.651,0,0,1,.63.666l-.053,1.923.376-.2a11.406,11.406,0,0,1,10.563-.009l.661.342a7.159,7.159,0,0,0,3.058.79l6.492.179a5.487,5.487,0,0,1,4.67,2.881l.112.208,7.247-3.424a4.24,4.24,0,0,1,1.928-.46,4.292,4.292,0,0,1,3.736,2.183.647.647,0,0,1-.211.863l-16.012,10.358a11.647,11.647,0,0,1-4.972,1.113ZM382.26,654.56a4.694,4.694,0,0,1,1.281.178l11.015,3.092a10.468,10.468,0,0,0,2.105.215,10.358,10.358,0,0,0,4.29-.923l15.44-9.985-.235-.218a2.991,2.991,0,0,0-3.384-.473l-7.4,3.5.034.188a5.561,5.561,0,0,1,.083,1.114.646.646,0,0,1-.648.631l-10.691-.294a.648.648,0,0,1,.018-1.295l10,.274-.064-.31a4.171,4.171,0,0,0-3.98-3.335l-6.492-.178a8.468,8.468,0,0,1-3.619-.936l-.661-.342a10.122,10.122,0,0,0-10.277.548l-.108.072-.268,9.753,1.324-.709A4.732,4.732,0,0,1,382.26,654.56Zm-10.724,2.813,5.822.159.4-14.324-5.823-.161Z"
                      fill="#515151" />
                    <g id="Group_531" data-name="Group 531">
                      <g id="Group_524" data-name="Group 524">
                        <g id="Group_523" data-name="Group 523">
                          <path id="Path_998" data-name="Path 998"
                            d="M408.767,626.848a.72.72,0,0,1,0-.637l.917-1.877a2.136,2.136,0,0,0-.921-2.836l-1.846-.98a.718.718,0,0,1-.374-.515l-.361-2.058a2.136,2.136,0,0,0-2.413-1.753l-2.068.293a.723.723,0,0,1-.606-.2l-1.5-1.453a2.135,2.135,0,0,0-2.982,0l-1.5,1.453a.722.722,0,0,1-.606.2l-2.068-.293a2.136,2.136,0,0,0-2.413,1.753L389.661,620a.718.718,0,0,1-.374.515l-1.846.98a2.136,2.136,0,0,0-.922,2.836l.918,1.877a.72.72,0,0,1,0,.637l-.918,1.877a2.136,2.136,0,0,0,.922,2.836l1.846.979a.722.722,0,0,1,.374.516l.361,2.058a2.134,2.134,0,0,0,2.105,1.774,2.3,2.3,0,0,0,.308-.021l2.068-.293a.719.719,0,0,1,.606.2l1.5,1.453a2.137,2.137,0,0,0,2.982,0l1.5-1.453a.721.721,0,0,1,.606-.2l2.068.293a2.136,2.136,0,0,0,2.413-1.753l.361-2.058a.722.722,0,0,1,.374-.516l1.846-.979a2.136,2.136,0,0,0,.921-2.836Zm-.669,3.46-1.846.979a2.132,2.132,0,0,0-1.107,1.524l-.361,2.058a.723.723,0,0,1-.816.593l-2.069-.293a2.132,2.132,0,0,0-1.791.582l-1.5,1.453a.724.724,0,0,1-1.009,0l-1.5-1.453a2.131,2.131,0,0,0-1.792-.582l-2.068.293a.723.723,0,0,1-.816-.593l-.361-2.058a2.131,2.131,0,0,0-1.108-1.524l-1.845-.979a.723.723,0,0,1-.312-.96l.918-1.877a2.133,2.133,0,0,0,0-1.883l-.918-1.877a.723.723,0,0,1,.312-.96l1.845-.979a2.133,2.133,0,0,0,1.108-1.524l.36-2.058a.724.724,0,0,1,.817-.593l2.068.293a2.134,2.134,0,0,0,1.792-.582l1.5-1.453a.722.722,0,0,1,1.009,0l1.5,1.453a2.132,2.132,0,0,0,1.791.582l2.069-.293a.723.723,0,0,1,.816.593l.361,2.058a2.132,2.132,0,0,0,1.107,1.524l1.846.979a.725.725,0,0,1,.312.96l-.918,1.877a2.127,2.127,0,0,0,0,1.883l.918,1.877A.725.725,0,0,1,408.1,630.308Z"
                            fill="#515151" />
                        </g>
                      </g>
                      <g id="Group_526" data-name="Group 526">
                        <g id="Group_525" data-name="Group 525">
                          <path id="Path_999" data-name="Path 999"
                            d="M403.286,621.346a.709.709,0,0,0-1,0l-9.364,9.364a.709.709,0,1,0,1,1l9.365-9.364A.709.709,0,0,0,403.286,621.346Z"
                            fill="#515151" />
                        </g>
                      </g>
                      <g id="Group_528" data-name="Group 528">
                        <g id="Group_527" data-name="Group 527">
                          <path id="Path_1000" data-name="Path 1000"
                            d="M395.264,620.144a2.6,2.6,0,1,0,2.6,2.6A2.6,2.6,0,0,0,395.264,620.144Zm0,3.784a1.182,1.182,0,1,1,1.182-1.182A1.183,1.183,0,0,1,395.264,623.928Z"
                            fill="#515151" />
                        </g>
                      </g>
                      <g id="Group_530" data-name="Group 530">
                        <g id="Group_529" data-name="Group 529">
                          <path id="Path_1001" data-name="Path 1001"
                            d="M400.94,627.712a2.6,2.6,0,1,0,2.6,2.6A2.6,2.6,0,0,0,400.94,627.712Zm0,3.784a1.182,1.182,0,1,1,1.182-1.183A1.185,1.185,0,0,1,400.94,631.5Z"
                            fill="#515151" />
                        </g>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </div>
            <div class="box-title">
              <?php echo Lang::get('messages.special_offers'); ?>
            </div>
          </a>
          <a href="#" class="service-box" title=" <?php echo Lang::get('messages.cafes'); ?>">
            <div class="box-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="44.981" height="44.984" viewBox="0 0 44.981 44.984">
                <g id="Group_522" data-name="Group 522" transform="translate(-515.55 -614.293)">
                  <g id="Group_521" data-name="Group 521">
                    <path id="Path_992" data-name="Path 992"
                      d="M534.251,653.593a16.825,16.825,0,0,1-16.806-16.806v-6.633a.7.7,0,0,1,.7-.7h32.215a.7.7,0,0,1,.7.7v6.633A16.825,16.825,0,0,1,534.251,653.593Zm-15.41-16.806a15.409,15.409,0,0,0,30.819,0v-5.936H518.841Z"
                      fill="#fff" />
                    <path id="Path_993" data-name="Path 993"
                      d="M547.911,646.012a.7.7,0,0,1,0-1.4h6.237a4.987,4.987,0,0,0,0-9.974h-3.79a.7.7,0,0,1,0-1.4h3.79a6.383,6.383,0,0,1,0,12.766Z"
                      fill="#fff" />
                    <path id="Path_994" data-name="Path 994"
                      d="M528.742,625.167a.7.7,0,0,1-.411-1.263,1.976,1.976,0,0,0,.951-1.746,2.365,2.365,0,0,0-1.495-1.8,3.7,3.7,0,0,1-2.278-2.932,3.354,3.354,0,0,1,1.525-3,.684.684,0,0,1,.407-.133.706.706,0,0,1,.568.29.7.7,0,0,1-.157.974,1.979,1.979,0,0,0-.952,1.746,2.359,2.359,0,0,0,1.494,1.8,3.7,3.7,0,0,1,2.278,2.933,3.352,3.352,0,0,1-1.523,3A.7.7,0,0,1,528.742,625.167Z"
                      fill="#fff" />
                    <path id="Path_995" data-name="Path 995"
                      d="M537.743,625.167a.708.708,0,0,1-.568-.289.7.7,0,0,1,.157-.974,1.975,1.975,0,0,0,.951-1.746,2.365,2.365,0,0,0-1.495-1.8,3.707,3.707,0,0,1-2.278-2.932,3.351,3.351,0,0,1,1.524-3,.682.682,0,0,1,.407-.134.7.7,0,0,1,.41,1.265,1.971,1.971,0,0,0-.95,1.745,2.363,2.363,0,0,0,1.495,1.8,3.707,3.707,0,0,1,2.278,2.932,3.351,3.351,0,0,1-1.524,3A.679.679,0,0,1,537.743,625.167Z"
                      fill="#fff" />
                    <path id="Path_996" data-name="Path 996"
                      d="M520.038,659.277a4.492,4.492,0,0,1-4.488-4.488v-1.9a.7.7,0,0,1,.7-.7h36.005a.7.7,0,0,1,.7.7v1.9a4.493,4.493,0,0,1-4.488,4.488Zm-3.092-4.488a3.1,3.1,0,0,0,3.092,3.092h28.425a3.1,3.1,0,0,0,3.092-3.092v-1.2H516.946Z"
                      fill="#fff" />
                  </g>
                </g>
              </svg>
            </div>
            <div class="box-title">
              <?php echo Lang::get('messages.cafes'); ?>
            </div>
          </a>
          <a href="<?php echo Azooma::URL($city->seo_url.'/catering');?>"
            title="<?php echo Lang::get('messages.catering'); ?>" class="service-box">
            <div class="box-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="43.166" height="44.129" viewBox="0 0 43.166 44.129">
                <g id="Group_535" data-name="Group 535" transform="translate(-661.917 -614.721)" opacity="0.8">
                  <g id="Group_534" data-name="Group 534">
                    <path id="Path_1002" data-name="Path 1002"
                      d="M702.884,640.68h.176a2.084,2.084,0,0,0,2.022-2.143,2.112,2.112,0,0,0-2.129-2.015h-1.129c-1.691-7.382-8.288-12.857-16.33-13.658v-1.871a3.332,3.332,0,0,0,1.449-2.806,3.465,3.465,0,0,0-6.93,0,3.544,3.544,0,0,0,1.414,2.806v1.871c-7.95.8-14.559,6.275-16.251,13.658H663.94a2.085,2.085,0,0,0-2.022,2.144,2.113,2.113,0,0,0,2.129,2.015h.081M683.5,620.541h0a2.356,2.356,0,1,1,2.356-2.355A2.356,2.356,0,0,1,683.5,620.541Zm-.04,1.11a3.4,3.4,0,0,0,.925-.125v1.256c-.277-.013-.617-.021-.925-.021s-.554.008-.924.021v-1.256A3.954,3.954,0,0,0,683.46,621.651Zm17.224,14.87H666.316c1.818-7.371,8.93-12.651,17.184-12.651S698.866,629.151,700.684,636.521ZM665.26,640.68h28.276a.555.555,0,1,0,0-1.109H664a.973.973,0,0,1-.971-.975.991.991,0,0,1,1-.966H703a.972.972,0,0,1,.971.975.991.991,0,0,1-1,.966h-9.836a.555.555,0,1,0,0,1.109h8.62"
                      fill="#515151" />
                    <path id="Path_1003" data-name="Path 1003"
                      d="M685.828,658.85a10.347,10.347,0,0,1-2.107-.217l-9.828-2.757a3,3,0,0,0-.826-.116,3.037,3.037,0,0,0-1.438.364l-1.752.938-.022.791a.571.571,0,0,1-.574.558l-6.328-.174a.575.575,0,0,1-.559-.59l.381-13.851a.571.571,0,0,1,.573-.559l6.329.174a.577.577,0,0,1,.559.591l-.048,1.7.335-.176a10.11,10.11,0,0,1,9.364-.009l.586.3a6.35,6.35,0,0,0,2.711.7l5.756.159a4.869,4.869,0,0,1,4.141,2.554l.1.185,6.425-3.036a3.762,3.762,0,0,1,1.709-.408,3.807,3.807,0,0,1,3.313,1.936.573.573,0,0,1-.188.765l-14.2,9.183a10.327,10.327,0,0,1-4.408.987Zm-12.761-4.24a4.148,4.148,0,0,1,1.135.158l9.766,2.741a9.239,9.239,0,0,0,5.67-.627l13.689-8.853-.208-.193a2.652,2.652,0,0,0-3-.42l-6.56,3.1.03.166a4.968,4.968,0,0,1,.073.988.572.572,0,0,1-.574.559l-9.479-.26a.575.575,0,0,1,.016-1.149l8.869.243-.057-.274a3.7,3.7,0,0,0-3.528-2.956l-5.756-.159a7.519,7.519,0,0,1-3.209-.829l-.586-.3a8.976,8.976,0,0,0-9.112.486l-.095.064-.238,8.646,1.174-.628A4.2,4.2,0,0,1,673.067,654.61Zm-9.508,2.494,5.162.141.35-12.7-5.162-.143Z"
                      fill="#515151" />
                  </g>
                </g>
              </svg>
            </div>
            <div class="box-title">
              <?php echo Lang::get('messages.catering'); ?>
            </div>
          </a>
          <a href="<?php echo Azooma::URL($city->seo_url.'/fine-dining');?>"
            title="<?php echo Lang::get('messages.fine_dining'); ?>" class="service-box">
            <div class="box-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="49.771" height="45.401" viewBox="0 0 49.771 45.401">
                <g id="Group_518" data-name="Group 518" transform="translate(-799.346 -614.085)" opacity="0.8">
                  <g id="Group_517" data-name="Group 517">
                    <path id="Path_982" data-name="Path 982"
                      d="M834.467,659.484a12.106,12.106,0,0,1-5.377-1.368l-.114-.06-.117.055a13.766,13.766,0,0,1-11.785.024l-.127-.061-.12.075a8.189,8.189,0,0,1-9.1-.3.7.7,0,0,1-.3-.7l2.937-16.443h-4.84l-2.079,12.47a.687.687,0,0,1-.679.575.709.709,0,0,1-.68-.8l2.041-12.244h-1.993a.69.69,0,0,1-.683-.6l-2.1-16.833a.69.69,0,0,1,.6-.769h.013a.705.705,0,0,1,.756.6l2.028,16.23h7.867l1.025-5.744a.69.69,0,0,1,.679-.569H836.2a.689.689,0,0,1,.678.57l1.013,5.743h7.827l2.028-16.23a.69.69,0,0,1,.682-.6.726.726,0,0,1,.545.266.682.682,0,0,1,.14.508l-2.1,16.833a.692.692,0,0,1-.685.6h-1.992l2.041,12.244a.688.688,0,0,1-.678.811.664.664,0,0,1-.245-.044.689.689,0,0,1-.435-.538l-2.079-12.473h-4.8l2.9,16.446a.685.685,0,0,1-.353.726l-.342.182a12.1,12.1,0,0,1-5.673,1.422h0Zm-5.475-15.627a.689.689,0,0,1,.688.688v12.324l.14.071a10.571,10.571,0,0,0,9.6.05l.171-.086L835.62,634.4H812.893l-4.028,22.559.154.091a6.81,6.81,0,0,0,7.063-.061l.122-.075v-8.685a.689.689,0,1,1,1.378,0v8.622l.149.069a12.382,12.382,0,0,0,10.422,0l.15-.069v-12.3A.689.689,0,0,1,828.992,643.857Z"
                      fill="#515151" />
                    <path id="Path_983" data-name="Path 983"
                      d="M817.393,631.284a.69.69,0,0,1-.689-.689,7.033,7.033,0,0,1,6.088-6.939l.224-.03v-1.11a.689.689,0,1,1,1.377,0v1.11l.225.03a7.033,7.033,0,0,1,6.088,6.939.69.69,0,0,1-.689.689Zm6.311-6.312a5.629,5.629,0,0,0-5.534,4.631l-.055.3h11.18l-.055-.3a5.628,5.628,0,0,0-5.534-4.631Z"
                      fill="#515151" />
                    <path id="Path_984" data-name="Path 984"
                      d="M826.861,621.037a.689.689,0,0,1-.689-.688v-2.42a.689.689,0,0,1,1.378,0v2.42A.689.689,0,0,1,826.861,621.037Z"
                      fill="#515151" />
                    <path id="Path_985" data-name="Path 985"
                      d="M822.548,619.249a.69.69,0,0,1-.689-.689v-3.787a.689.689,0,0,1,1.377,0v3.787A.69.69,0,0,1,822.548,619.249Z"
                      fill="#515151" />
                    <path id="Path_986" data-name="Path 986"
                      d="M818.55,621.774a.69.69,0,0,1-.689-.689v-2a.688.688,0,1,1,1.377,0v2A.689.689,0,0,1,818.55,621.774Z"
                      fill="#515151" />
                  </g>
                </g>
              </svg>
            </div>
            <div class="box-title">
              <?php echo Lang::get('messages.fine_dining'); ?>
            </div>
          </a>
          <a href="<?php echo Azooma::URL($city->seo_url.'/popular');?>"
            title="<?php echo Lang::get('messages.popular'); ?>" class="service-box">
            <div class="box-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="39.033" height="37.384" viewBox="0 0 39.033 37.384">
                <g id="Group_520" data-name="Group 520" transform="translate(-947.81 -618.093)" opacity="0.8">
                  <g id="Group_519" data-name="Group 519">
                    <path id="Path_987" data-name="Path 987"
                      d="M948.384,652.182a.574.574,0,0,1-.574-.573V636.785a.575.575,0,0,1,.574-.575c5.52,0,8.428,1.85,8.549,1.929a.571.571,0,0,1,.242.621l-3.294,12.99a.571.571,0,0,1-.556.432Zm.574-1.148h3.921l3.075-12.129-.184-.089a16.672,16.672,0,0,0-6.553-1.443l-.259-.01Z"
                      fill="#515151" />
                    <path id="Path_988" data-name="Path 988"
                      d="M968.972,655.477c-3.846,0-11.318-3.255-15.43-5.194a.575.575,0,0,1,.244-1.094.58.58,0,0,1,.245.055c3.243,1.529,11.189,5.085,14.941,5.085,4.049,0,13.484-4.694,16.279-6.132l.265-.136-.181-.236a3.78,3.78,0,0,0-3.186-1.408,19.947,19.947,0,0,0-5.387,1.21,20.726,20.726,0,0,1-5.731,1.262,29.122,29.122,0,0,1-8.019-1.682.572.572,0,0,1-.344-.736.573.573,0,0,1,.736-.343,28.477,28.477,0,0,0,7.627,1.612,19.822,19.822,0,0,0,5.388-1.21,20.735,20.735,0,0,1,5.73-1.26,4.694,4.694,0,0,1,4.665,2.865.578.578,0,0,1-.277.688C985.232,649.512,973.807,655.477,968.972,655.477Z"
                      fill="#515151" />
                    <path id="Path_989" data-name="Path 989"
                      d="M974.737,648.213a.575.575,0,0,1-.574-.574v-.824a2.686,2.686,0,0,0-2.077-2.635l-15.9-3.837a.574.574,0,0,1-.356-.26.566.566,0,0,1-.068-.434.6.6,0,0,1,.7-.424l15.888,3.836a3.831,3.831,0,0,1,2.959,3.754v.824A.574.574,0,0,1,974.737,648.213Z"
                      fill="#515151" />
                    <path id="Path_990" data-name="Path 990"
                      d="M974.737,629.123a.578.578,0,0,1-.406-.167l-2.471-2.471a.573.573,0,1,1,.811-.811L974.7,627.7l3.715-4.46a.573.573,0,0,1,.439-.206.585.585,0,0,1,.37.134.577.577,0,0,1,.07.81l-4.118,4.941a.562.562,0,0,1-.407.2Z"
                      fill="#515151" />
                    <path id="Path_991" data-name="Path 991"
                      d="M969.709,634.065a2.144,2.144,0,0,1-2.134-2.15V620.244a2.145,2.145,0,0,1,2.134-2.151h11.7a2.145,2.145,0,0,1,2.135,2.151v9.641a2.145,2.145,0,0,1-.622,1.519l-2.013,2.03a2.109,2.109,0,0,1-1.511.631Zm0-14.825a1,1,0,0,0-.986,1v11.672a.994.994,0,0,0,.986,1H979.4a.976.976,0,0,0,.695-.292l2.012-2.031a.989.989,0,0,0,.292-.709v-9.641a1,1,0,0,0-.986-1Z"
                      fill="#515151" />
                  </g>
                </g>
              </svg>

            </div>
            <div class="box-title">
              <?php echo Lang::get('messages.popular'); ?>
            </div>
          </a>

        </div>
      </div>
    </div>
  </section>
  {{-- City service section End --}}
  {{-- News Feed section Start --}}
  <section class="city-newfeed mb-4">
    <div class="container">
      <div class="row my-box">
        <div class="col-md-8 col-sm-12">
          <div class="images-of-week">
            <div class="section-title mb-4">
              <h4> <?php echo Lang::get('messages.images_of_the_week'); ?></h4>
            </div>
            <div class="row">
              <?php
                if(count($newimages)>0){
                  $image = $newimages[0];
                  $img=Azooma::CDN('Gallery/'.$image->image_full);
                  $title=($lang=="en")?stripcslashes($image->title):stripcslashes($image->title_ar);
                  if($title==""){
                    $title=($lang=="en")?stripcslashes($image->rest_Name):stripcslashes($image->rest_Name_ar);
                  }
              ?>
              {{-- First Image --}}
              <div class="col-md-8 p-0">
                <a href="<?php echo Azooma::URL($city->seo_url.'/'.$image->seo_url);?>" title="<?php echo $title;?>">
                  <img class="h-300" src="<?php echo $img;?>" alt="<?php echo $title;?>" />
                </a>
              </div>
              <div class="col-md-4">
                <?php 
                  $image2 = $newimages[1];
                  $img2=Azooma::CDN('Gallery/'.$image2->image_full);
                    $title=($lang=="en")?stripcslashes($image2->title):stripcslashes($image2->title_ar);
                    if($title==""){
                        $title=($lang=="en")?stripcslashes($image2->rest_Name):stripcslashes($image2->rest_Name_ar);
                      }  
                ?>
                {{-- Secound Image --}}
                <a href="<?php echo Azooma::URL($city->seo_url.'/'.$image2->seo_url);?>" title="<?php echo $title;?>">
                  <img class="h-150 mb-2" src="<?php echo $img2;?>" alt="<?php echo $title;?>" />
                </a>
                <?php 
                  $image3 = $newimages[2];
                  $img3=Azooma::CDN('Gallery/'.$image3->image_full);
                    $title=($lang=="en")?stripcslashes($image3->title):stripcslashes($image3->title_ar);
                    if($title==""){
                        $title=($lang=="en")?stripcslashes($image3->rest_Name):stripcslashes($image3->rest_Name_ar);
                      }  
                ?>
                {{-- thired Image --}}
                <a href="<?php echo Azooma::URL($city->seo_url.'/'.$image3->seo_url);?>" title="<?php echo $title;?>">
                  <img class="h-150" src="<?php echo $img3;?>" alt="<?php echo $title;?>" />
                </a>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="news-feed">
            <?php 
             if(count($latestnews)>0){
            ?>
            <div class="section-title mb-4 d-flex align-items-center justify-content-between">
              <h4> <?php echo Lang::get('messages.news_feed'); ?></h4>
              <?php if(Session::has('userid')){ ?>
              <a href="<?php echo Azooma::URL('user/'.Session::get('userid').'#user-profile-tabs');?>"><?php echo Lang::get('messages.view_all');?></a>
              <?php } else {  ?>
              <a href="javascript:sufratiloginpopup();"><?php echo Lang::get('messages.view_all');?></a>
              <?php } ?>
            </div>
            <ul>
              <?php
              $i=0;
              foreach ($latestnews as $news) {
                  $i++;
                  $activitystring=$activityhelper="";
                  $newsuserimage=($news->image!="")?$news->image:'user_no_image.svg';
                  $newsusername=($news->user_NickName=="")?stripcslashes($news->user_FullName):stripcslashes($news->user_NickName);
                  switch ($news->activity) {
                      case 'liked':
                      case 'added as favourite':
                          $rest=MRestaurant::getRestMin($news->rest_ID);
                          $activitystring= 'has new like';
                          $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
                          $activityhelper='<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><b>'.$restname.'</b></a>';
                          $icon = '<i class="fas fa-heart"></i>';
                          break;
                      case 'rated on':
                          $rest=MRestaurant::getRestMin($news->rest_ID);
                          $activitystring=Lang::get('activity.rated_on');
                          $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
                          $activityhelper='<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><b>'.$restname.'</b></a>';
                          $icon = '<i class="fas fa-star"></i>';
                          break;
                      case 'uploaded photo for':
                          $rest=MRestaurant::getRestMin($news->rest_ID);
                          $activitystring=Lang::get('activity.uploaded_photo_for');
                          $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
                          $activityhelper='<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><b>'.$restname.'</b></a>';
                          $icon = '<i class="fas fa-camera"></i>';
                          break;
                      case 'commented on':
                          $rest=MRestaurant::getRestMin($news->rest_ID);
                          $activitystring=Lang::get('activity.commented_on');
                          $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
                          $activityhelper='<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><b>'.$restname.'</b></a>';
                          $icon = '<i class="fas fa-comments"></i>';
                          break;
                      case 'followed':
                          $followed=User::checkUser($news->activity_ID,true);
                          if(count($followed)>0){
                              $activitystring=Lang::get('activity.followed');
                              $followedusername=($followed->user_NickName=="")?stripcslashes($followed->user_FullName):stripcslashes($followed->user_NickName);
                              $activityhelper='<a class="normal-text" href="'.Azooma::URL('user/'.$followed->user_ID).'" title="'.$followedusername.'"><b>'.$followedusername.'</b></a>';
                              $icon = '<i class="fas fa-user-plus"></i>';
                            }
                          break;
                      case 'recommend menu':
                          $rest=MRestaurant::getRestMin($news->rest_ID);
                          if(count($rest) > 0){
                          $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
                          $menuitem=DB::select(DB::raw('SELECT * FROM rest_menu WHERE id=:id'),array('id'=>$news->activity_ID));
                          $icon = '<i class="fas fa-star"></i>';
                          if(count($menuitem)>0){
                              $menucat=DB::select(DB::raw('SELECT * FROM menu_cat WHERE cat_id=:cat'),array('cat'=>$menuitem[0]->cat_id));
                              $activitystring=Lang::get('activity.recommends');
                              $menuname=($lang=="en")?stripcslashes($menuitem[0]->menu_item).' - '.stripcslashes($menucat[0]->cat_name):stripcslashes($menuitem[0]->menu_item_ar).' - '.stripcslashes($menucat[0]->cat_name_ar);
                              $activityhelper=$menuname.' '.Lang::get('messages.from').' <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><b>'.$restname.'</b></a>';
                          }
                        }
                  }
                  if($activitystring!=""&&$activityhelper!=""){
                  ?>
                  {{-- 01 Box --}}
                  <li class="last-feed-box align-items-baseline">
                    <div class="box-img">
                      <?php echo $icon; ?>
                    </div>
                    <div class="box-title">
                      <h2> <?php echo $activityhelper . ' <span>' . $activitystring .'</span>'; ?></h2>
                      <a class="user" href="<?php echo Azooma::URL('user/'.$news->user_ID);?>"><?php echo Lang::get('messages.from');?>  <?php echo $newsusername;?></a>
                      <span class="time-updated"> <?php echo Azooma::Ago($news->updated);?></span>
                    </div>
                  </li>
                  <?php } } ?>
            </ul>
            <?php } else {?>
            <?php  if(Session::has('userid')){
              $followsugestions=User::followSuggestions(Session::get('userid'),10);
              if(count($followsugestions)>0){
              ?>
              <div class="section-title mb-4 d-flex align-items-center justify-content-between">
              <h4> <?php echo Lang::get('messages.find_friends');?></h4>
              <a href="<?php echo Azooma::URL('usersuggestions');?>"><?php echo Lang::get('messages.view_all');?></a>
              </div>
              <ul>
                <?php 
                  $i=0;
                  foreach ($followsugestions as $sugstn) {
                    $sugstnuserimage=($sugstn->image!="")?$sugstn->image:'user-default.svg';
                    $sugstnusername=($sugstn->user_NickName=="")?stripcslashes($sugstn->user_FullName):stripcslashes($sugstn->user_NickName);
                    $i++;
                    ?>
                    <li class="last-feed-box align-items-self-start">
                      <div class="box-img">
                        <?php if($sugstnuserimage == 'user-default.svg'){  ?>
                          <img src="<?php echo Azooma::CDN('images/'.$sugstnuserimage);?>"
                          alt="<?php echo $sugstnusername;?>">
                          <?php } else { ?>
                            <img src="<?php echo Azooma::CDN('images/userx130/'.$sugstnuserimage);?>"
                          alt="<?php echo $sugstnusername;?>">
                            <?php } ?>
                        
                      </div>
                      <div class="box-title">
                        <h4>    <a href="<?php echo Azooma::URL('user/'.$sugstn->user_ID);?>" title="<?php echo $sugstnusername;?>">
                          <?php echo $sugstnusername;?></a></h4>   
                          <span>
                        <?php  echo '<span data-total-followers'.$sugstn->user_ID.'="'.$sugstn->followers.'">'.$sugstn->followers.'</span> '.Lang::get('messages.followers').', '.$sugstn->following.' '.Lang::get('messages.following'); ?>
                      </span><button class="big-trans-btn follow-btn btn-sm" data-following="0"
                          data-user="<?php echo $sugstn->user_ID;?>">
                          <?php echo Lang::get('messages.follow');?>
                        </button>
                      </div>
                    </li>
                    <?php } ?>
              </ul>
            <?php } } }?>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- News Feed section End --}}
  {{-- newly add Section Start --}}
  <section class="city-services-2 mt-6">
    <div class="container ">
      <div class="row mt-6 mb-2">
        <div class="col-12">
          <div class="section-title">
            <h2><?php echo Lang::get('messages.newly_added_in',array('name'=>$cityname)); ?></h2>
          </div>
        </div>
      </div>
      <div class="row city-services-slider">
        <div class="col-12 mb-4">
          <ul class="filter-list mb-2" id="filter-city-services">
            <li class="active" data-bs-target="places"><?php echo Lang::get('messages.Restaurants&placse'); ?></li>
            <li data-bs-target="Photos"><?php echo Lang::get('messages.azoomaphotos'); ?></li>
            <li data-bs-target="Videos"><?php echo Lang::get('messages.azoomavideos'); ?></li>
          </ul>
        </div>
        <div class="col-12 serv-slider show places">
          <a href="<?php echo Azooma::URL($city->seo_url.'/latest');?>" c class="viewall">
                            <?php echo Lang::get('messages.view_all');?>
                        </a>
          <div class="owl-carousel owl-theme" id="places-slider">
            <?php if(count($newrestaurants)>0){
              foreach ($newrestaurants as $rest) {
                $cover = MRestaurant::getCoverPhotoStatic($rest->rest_ID);
                $likes = MRestaurant::getRestaurantLikeInfostatic($rest->rest_ID);
                if(count($cover) == 0) continue;
                  $restlogo=$rest->rest_Logo;
                  if($restlogo==""){
                      $restlogo="default_logo.gif";
                  }
                  $type = MRestaurant::getRestTypestatic($rest->rest_type);
                  $restname=stripcslashes($rest->rest_Name);
                  if($lang=="ar"){
                      $restname=stripcslashes($rest->rest_Name_ar);
                  }
                  $ratinginfo = MRestaurant::getRatingInfo($rest->rest_ID);
                  $priceGet = MRestaurant::GetPriceRange($rest->rest_ID);
                      if(count($ratinginfo)>0){
                      $ratinginfo=$ratinginfo[0];
                      if($ratinginfo->total>0){
                          $totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
                      }else{
                          $totalrating=0;
                      }
                  }
            ?>
            {{-- Service Box --}}
            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>"
              class="service-box">
              <div class="box-img">
                <?php if(count($cover)>0){ ?>
                            <img src="<?php echo Azooma::CDN('Gallery/'.$cover[0]->image_full);?>"
                                alt="<?php echo $restname;?>">
                            <?php } ?>
                  <div class="logo">
                    <img itemprop="logo" src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" />
                </div>
              </div>
              <div class="box-info">
                <div class="text-info">
                  <h3> <?php echo $restname;?></h3>

                  <span><?php echo ($lang=="en")?stripcslashes($rest->cuisine).' '.stripcslashes($rest->type).' '.Lang::get('messages.in').' '.stripcslashes($city->city_Name):stripcslashes($rest->cuisineAr).' '.stripcslashes($rest->typeAr).' '.Lang::get('messages.in').' '.stripcslashes($city->city_Name_ar); ?>
   <div class="small">
                                    <?php echo date('F dS Y',strtotime($rest->rest_RegisDate));?>
                                </div>
                </span>
                </div>
                <div class="rate-info">

                  <span class="people_like"><i class="fa fa-heart"></i> <?php echo $likes[0]->total; ?> </span>
                  <span class="priceRange"><?php echo Azooma::LangSupport($priceGet->price_range);?>
                    <?php echo Azooma::GetCurrency($city->country);?></span>
                </div>
              </div>
            </a>
            <?php }  } ?>
          </div>
        </div>
        <div class="col-12 serv-slider Photos">
          <a class="viewall" href="#2"><?php echo Lang::get('messages.view_all'); ?></a>
          <div class="owl-carousel owl-theme" id="images-slider">
            <?php
            if(count($newimages)>0){
                $i=0;
                foreach ($newimages as $image) {
                  $img=Azooma::CDN('Gallery/'.$image->image_full);
                    $title=($lang=="en")?stripcslashes($image->title):stripcslashes($image->title_ar);
                    if($title==""){
                        $title=($lang=="en")?stripcslashes($image->rest_Name):stripcslashes($image->rest_Name_ar);
                    }
                    ?>
            {{-- Service Box --}}
            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$image->seo_url);?>" title="<?php echo $title;?>"
              class="service-box">
              <div class="box-img">
                <img src="<?php echo $img;?>" alt="<?php echo $title;?>" />
              </div>
              <div class="box-info">
                <div class="text-info full">
                  <h3> <?php echo $title;?></h3>
                </div>
              </div>
            </a>
            <?php
                    $i++;
                }
            }
            ?>
          </div>
        </div>
        <div class="col-12 serv-slider Videos">
          <a class="viewall" href="#"><?php echo Lang::get('messages.view_all'); ?></a>
          <div class="owl-carousel owl-theme" id="videos-slider">
            <?php
            if(count($newvideos)>0){
                $i=0;
                foreach ($newvideos as $video) {
                    if($lang=="en"||($lang=="ar"&&$video->youtube_ar=="")){
                        parse_str( parse_url( $video->youtube_en, PHP_URL_QUERY ), $var );
                    }else{
                        parse_str( parse_url( $video->youtube_ar, PHP_URL_QUERY ), $var );
                    }
                    
                    $youtube="";
                    if(isset($var['v'])){
                        $youtube=$var['v'];
                    }
                    $img='http://img.youtube.com/vi/'.$youtube.'/hqdefault.jpg';
                    $title=($lang=="en")?stripcslashes($video->name_en):stripcslashes($video->name_ar);
                    
                    ?>
            {{-- Service Box --}}
            <a href="<?php echo Azooma::URL('video/'.$video->id.'?autoplay=1');?>" title="<?php echo $title;?>"
              class="service-box">
              <div class="box-img">
                <img src="<?php echo $img;?>" alt="<?php echo $title;?>" <?php if($i==0){ ?> width="312" <?php } ?> />
              </div>
              <div class="box-info">
                <div class="text-info full">
                  <h3> <?php echo $title;?></h3>
                </div>
              </div>
            </a>

            <?php
                    $i++;
                }
              }      ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Services Section End --}}


  {{-- recommended Section Start --}}
  <section class="recommended-suggest">
    <div class="container ">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h2>
              <?php echo Lang::get('messages.must_try_heading',array('name'=>$cityname));?>
            </h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="<?php echo Azooma::URL($city->seo_url.'/recommended'); ?>" title="<?php echo strip_tags(Lang::get('messages.must_try_heading',array('name'=>$cityname)));?>" class="viewall">
                    <?php echo Lang::get('messages.view_all');?> 
                </a>
          <div class="owl-carousel owl-theme" id="recommended-slider">
            <?php if(count($favorites)>0){ ?>
            <?php foreach ($favorites as $rest) {
                $cover = MRestaurant::getCoverPhotoStatic($rest->rest_ID);
                $likes = MRestaurant::getRestaurantLikeInfostatic($rest->rest_ID);
                if(count($cover) == 0) continue;
                  $restlogo=$rest->rest_Logo;
                  if($restlogo==""){
                      $restlogo="default_logo.gif";
                  }
                  $type = MRestaurant::getRestTypestatic($rest->rest_type);
                  $restname=stripcslashes($rest->rest_Name);
                  if($lang=="ar"){
                      $restname=stripcslashes($rest->rest_Name_ar);
                  }
                  $ratinginfo = MRestaurant::getRatingInfo($rest->rest_ID);
                  $priceGet = MRestaurant::GetPriceRange($rest->rest_ID);
                      if(count($ratinginfo)>0){
                      $ratinginfo=$ratinginfo[0];
                      if($ratinginfo->total>0){
                          $totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
                      }else{
                          $totalrating=0;
                      }
                  }
            ?>
            {{-- Service Box --}}
            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>"
              class="service-box">
              <div class="box-img">
                <?php if(count($cover)>0){ ?>
                            <img src="<?php echo Azooma::CDN('Gallery/'.$cover[0]->image_full);?>"
                                alt="<?php echo $restname;?>">
                            <?php } ?>
                  <div class="logo">
                    <img itemprop="logo" src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" />
                </div>
              </div>
              <div class="box-info">
                <div class="text-info">
                  <h3> <?php echo $restname;?></h3>

                  <span> <?php echo Lang::get('messages.a').' '.Azooma::LangSupport($rest->class_category);
                                echo ($lang=="en")?' '.stripcslashes($rest->cuisine):' '.stripcslashes($rest->cuisineAr);
                                if(count($type)>0){
                                    echo ($lang=="en")?stripcslashes(' '.$type[0]->name):stripcslashes(' '.$type[0]->nameAr);    
                                }
                                ?></span>
                </div>
                <div class="rate-info">

                  <span class="people_like"><i class="fa fa-heart"></i> <?php echo $likes[0]->total; ?> </span>
                  <span class="priceRange"><?php echo Azooma::LangSupport($priceGet->price_range);?>
                    <?php echo Azooma::GetCurrency($city->country);?></span>
                </div>
              </div>
            </a>
            <?php }  } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Time suggest Section End --}}


  {{-- Time suggest Section Start --}}
  <section class="time-suggest">
    <div class="container ">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h2>
              <?php echo $recommendedmeals['meal'].'<br> '.Lang::get('messages.suggestions').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>
            </h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">

          <a href="<?php echo Azooma::URL($city->seo_url.'/s/'.$recommendedmeals['type']); ?>" title="<?php echo strip_tags($recommendedmeals['meal']).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>"  class="viewall">
                    <?php echo Lang::get('messages.view_all');?>
                </a>
          <div class="owl-carousel owl-theme" id="time-slider">
            <?php if(count($recommendedmeals['restaurants'])>0){
              foreach ($recommendedmeals['restaurants'] as $rest) {
                $cover = MRestaurant::getCoverPhotoStatic($rest->rest_ID);
                $likes = MRestaurant::getRestaurantLikeInfostatic($rest->rest_ID);
                if(count($cover) == 0) continue;
                  $restlogo=$rest->rest_Logo;
                  if($restlogo==""){
                      $restlogo="default_logo.gif";
                  }
                  $type = MRestaurant::getRestTypestatic($rest->rest_type);
                  $restname=stripcslashes($rest->rest_Name);
                  if($lang=="ar"){
                      $restname=stripcslashes($rest->rest_Name_ar);
                  }
                  $ratinginfo = MRestaurant::getRatingInfo($rest->rest_ID);
                  $priceGet = MRestaurant::GetPriceRange($rest->rest_ID);
                      if(count($ratinginfo)>0){
                      $ratinginfo=$ratinginfo[0];
                      if($ratinginfo->total>0){
                          $totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
                      }else{
                          $totalrating=0;
                      }
                  }
            ?>
            {{-- Service Box --}}
            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>"
              class="service-box">
              <div class="box-img">
                <?php if(count($cover)>0){ ?>
                            <img src="<?php echo Azooma::CDN('Gallery/'.$cover[0]->image_full);?>"
                                alt="<?php echo $restname;?>">
                            <?php } ?>
                  <div class="logo">
                    <img itemprop="logo" src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" />
                </div>
              </div>
              <div class="box-info">
                <div class="text-info">
                  <h3> <?php echo $restname;?></h3>

                  <span> <?php echo Lang::get('messages.a').' '.Azooma::LangSupport($rest->class_category);
                                echo ($lang=="en")?' '.stripcslashes($rest->cuisine):' '.stripcslashes($rest->cuisineAr);
                                if(count($type)>0){
                                    echo ($lang=="en")?stripcslashes(' '.$type[0]->name):stripcslashes(' '.$type[0]->nameAr);    
                                }
                                ?></span>
                </div>
                <div class="rate-info">

                  <span class="people_like"><i class="fa fa-heart"></i> <?php echo $likes[0]->total; ?> </span>
                  <span class="priceRange"><?php echo Azooma::LangSupport($priceGet->price_range);?>
                    <?php echo Azooma::GetCurrency($city->country);?></span>
                </div>
              </div>
            </a>
            <?php }  } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Time suggest Section End --}}

  {{-- Explore Section Start --}}
  <section class="city-explore">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h2> <?php echo Lang::get('messages.explore').' '.$cityname;?> </h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <ul class="filter-list" id="filter-city-explore">
            <li class="active" data-bs-target="cusines"><?php echo Lang::get('messages.browse_by_cuisines'); ?></li>
            <li data-bs-target="locations"><?php echo Lang::get('messages.browse_by_locations'); ?></li>
            <li data-bs-target="features"><?php echo Lang::get('messages.by_restaurnt_features'); ?></li>
          </ul>
        </div>
        <div class="col-12 cuisines city-explore-slider">
          {{-- cuisines Box --}}

          <div class="owl-carousel owl-theme show cusines cuisines-slider" id="explore-slider">
            <a href="<?php echo Azooma::URL($city->seo_url.'/cuisines');?>" class="cuisines-box-static">
              <div class="box-info">

                <div class="text-info">
                  <span><?php echo Lang::get('messages.ExploreBy'); ?></span>
                  <h3><?php echo Lang::get('messages.ExploreCitySlider'); ?></h3>
                  <button> <?php echo Lang::get('messages.view_all'); ?></button>
                </div>

              </div>
            </a>
            <?php if(count($popularcuisines)>0){
              foreach ($popularcuisines as $cuisine) {
                $cuisinename=($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);
                $cuisineimage=($cuisine->image=="")?"default.gif":$cuisine->image;
              ?>

            {{-- cuisines Box --}}
            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$cuisine->seo_url.'/restaurants');?>"
              title="<?php echo $cuisinename;?>" class="cuisines-box">
              <div class="box-img">
                {{-- <img src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" /> --}}
                <img class="sufrati-super-lazy" src="<?php echo Config::get('settings.uploadurl') .'images/cuisine/'.$cuisineimage;?>" alt="<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?>">
               
              </div>
              <div class="box-info">
                <div class="text-info">
                  <h3> <?php echo $cuisinename;echo ' <br> ( Cuisines )' ?></h3>
                </div>

              </div>
            </a>
            <?php } }   ?>
          </div>
          <div class="locations cuisines-slider">
            <?php  if(count($popularlocalities)>0){
              ?>

              <ul>
                <?php foreach ($popularlocalities as $locality) {
                $localityname=($lang=="en")?stripcslashes($locality->district_Name):stripcslashes($locality->district_Name_ar);
                ?>
                <li>
                    <a href="<?php echo Azooma::URL($city->seo_url.'/'.$locality->seo_url.'/restaurants');?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$localityname.' - '.$cityname));?>">
                        <?php echo ($lang=="en")?stripcslashes($locality->district_Name):stripcslashes($locality->district_Name_ar);
                        echo ' ('.$locality->total.')';
                        ?>
                    </a>
                </li>
                <?php } ?>
                <li>
                    <a class="link" href="<?php echo Azooma::URL($city->seo_url.'/localities');?>" title="<?php echo Lang::get('messages.all').' '.Lang::get('messages.localities').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                    <?php echo Lang::get('messages.view_all');?>
                    </a>
                </li>
            </ul>
            <?php }   ?>
          </div>
          <div class="features cuisines-slider">
            <?php    if(count($popularfeatures)>0){
              ?>

                <ul>
                  <?php 
                  foreach ($popularfeatures as $ftr) {
                      $total=MCuisine::getTotalRestaurantsFeature($ftr['name'],$city->city_ID,$ftr['category']);
                  ?>
                  <li>
                      <a href="<?php echo Azooma::URL($city->seo_url.'/restaurants/'.$ftr['category'].'/'.$ftr['name']);?>" title="<?php echo Azooma::LangSupport($ftr['name']); echo ' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)); ?>">
                          <?php echo Azooma::LangSupport($ftr['name']).' ('.$total.')';?>
                      </a>
                  </li>
                  <?php } ?>
                  <li>
                      <a class="link" href="<?php echo Azooma::URL($city->seo_url.'/features');?>" title="<?php echo Lang::get('messages.all').' '.Lang::choice('messages.restaurants',1).' '.Lang::get('messages.features').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                      <?php echo Lang::get('messages.view_all');?>
                      </a>
                  </li>
              </ul>
            <?php }   ?>
          </div>

        </div>
      </div>
    </div>
  </section>
  {{-- Explore Section End --}}
  @include('inc.footer')
  <script type="text/javascript">
    require(['city'], function () {});
  </script>
</body>

</html>