<?php
$return = base_url() . 'ar/' . uri_string();
if (count($_GET) > 0) {
    $get = array();
    foreach ($_GET as $key => $val) {
        $get[] = $key . '=' . $val;
    }
    $return .= '?' . implode('&amp;', $get);
}
?>
<header id="header">
    <div class="container overflow lang-button">
        <div class="btn-group right-float">
            <a class="btn btn-success" href="<?php echo $return; ?>">  العربية  </a>&nbsp;
        </div>
    </div> 
    <div class="overflow container">
        <div class="left logo-box">
            <a href="<?php echo base_url(); ?>" title="<?php echo $settings['name']; ?>"> 
                <img src="http://uploads.azooma.co/sufratilogo/<?php echo $logo['image']; ?>" alt="<?php echo $settings['name']; ?>" /> 
            </a> 
        </div>
        <?php
        $restid = $this->session->userdata('rest_id');
        $permissions = $this->MGeneral->getRestPermissions($restid);
        if ($permissions['accountType'] != 3) {
            ?>
            <div id="top-banner-rest" role="banner" class="left">
                <a href="<?php echo base_url('accounts'); ?>" title="Upgrade Now"> 
                    <img src="http://uploads.azooma.co/stat/backedbanner.png" title="Upgrade Now" alt="Upgrade Now"  width="458" height="92"/> 
                </a> 
            </div>
            <?php
        }
        ?>
        <div class="right-float" >
            <div  class="banner">
                <a href="<?php echo base_url('home/logo'); ?>" title="<?php echo $rest['rest_Logo']; ?>"> <img src="http://uploads.azooma.co/logos/<?php echo $rest['rest_Logo']; ?>" title="<?php echo ($rest['rest_Name']); ?>" alt="<?php echo ($rest['rest_Name']); ?>"  width="100px" height="100px"/> </a> 
            </div>
        </div>
    </div>
</header>