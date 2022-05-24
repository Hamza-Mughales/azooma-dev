<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus extends CI_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('MBooking');
        $this->load->model('MRestBranch');
        $this->load->library('pagination');
        $this->load->library('images');
        //$this->output->enable_profiler(true);
        if($this->session->userdata('restuser') == ''){
            redirect('home/login');
        }
    }
    
    function index($item=0){
        $limit=20;$ajax=$offset=0;
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        if(isset($_GET['sort'])&&($_GET['sort']!="")){
            $sort=($_GET['sort']);
        }
        if(isset($_GET['ajax'])&&($_GET['ajax']!="")){
            $ajax=($_GET['ajax']);
        }
		if(isset($_GET['limit'])&&($_GET['limit']!="")){
            $limit=($_GET['limit']);
        }
		
        if(isset ($_GET['menu_id'])&&($_GET['menu_id']!="")){
                $menu_id=$_GET['menu_id'];
        }else{
                $menu_id=0;
        }
        if(isset ($_GET['item'])&&($_GET['item']!="")){
                $item=$_GET['item'];
        }else{
                $item=0;
        }
	
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['title']="قائمة لي ".(htmlspecialchars($data['rest']['rest_Name_Ar']));
	
        if($item!=0){
            $data['menus']=  $this->MRestBranch->getAllMenuItems($rest,$item);
            $data['total']=$this->MRestBranch->getTotalMenuItems($rest,$item);
            $data['cat']=$this->MRestBranch->getMenuCat($item);
            $data['pagetoptitle']="قائمة الأصناف";
            $data['pagetitlelink']="إضافة قائمة جديدة للصنف";
            $data['pageview']="";
            $data['tmp_link']="";
            $data['tableheading']=" إسم الصنف ";
            $data['tableheadingAr']=" إسم الصنف بالعربي";
            $data['topName']='مجموع الوحدات في القائمة';
        }elseif($menu_id!=0){
            $data['menus']=  $this->MRestBranch->getAllMenuCats($rest,0,$menu_id);
            $data['total']=$this->MRestBranch->getTotalMenuCats($rest,$menu_id);
            $data['pagetoptitle']="قائمة الأنواع ";
            $data['pagetitlelink']=" إضافة قائمة جديدة ";
            $data['pageview']=" رؤية الأصناف";
            $data['tmp_link']="";
            $data['tableheading']="اسامي الأنواع ";
            $data['tableheadingAr']=" أسامي الأنواع بالعربي";
            $data['topName']='مجموع عدد الفئات القائمة';
        }else{
            $data['menus']=  $this->MRestBranch->getAllMenu($rest);
            $data['total']=$this->MRestBranch->getTotalMenu($rest);
            $data['pagetoptitle']="أنواع القائمة ";
            $data['pagetitlelink']="أضافة القائمة الجديدة ";
            $data['pageview']="رؤية الأصناف";
            $data['tmp_link']="";			
            $data['tableheading']=" اسم القائمة ";
            $data['tableheadingAr']=" قائمة الأسماء بالعربي ";
            $data['topName']='مجموعه القوائم';
        }
        
        $data['css']='ar';
        $data['main']='ar/menu';        
        $this->load->view('ar/template',$data);
    }
    
    function form(){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $newFlag=TRUE;
        if(isset ($_GET['menu_id'])&&($_GET['menu_id']!="")){
                $menu_id=$_GET['menu_id'];
        }else{
                $menu_id=0;
        }
        if(isset ($_GET['cat_id'])&&($_GET['cat_id']!="")){
                $cat_id=$_GET['cat_id'];
        }else{
                $cat_id=0;
        }
			
        $data['permissions']=$permissions=$this->MBooking->restPermissions($restid);
        $data['sub_detail_permissions']=$sub_detail_permissions=explode(',',$permissions['sub_detail']);
        
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        
        if(isset($_GET['cat'])&&($_GET['cat']!="")){
            $data['item']=1;
            $data['cat']=$this->MRestBranch->getMenuCat($_GET['cat']);
            if(isset($_GET['item'])&&($_GET['item']!="")){
                $newFlag=FALSE;
                $data['menuitem']=  $this->MRestBranch->getMenuItem($_GET['item']);
                $data['title']=$data['pagetitle']=' تحديث بقائمة الصنف  '.$data['menuitem']['menu_item_ar'];
            }else{
                $newFlag=TRUE;
                $data['pagetitle']='جديد - '.$data['cat']['cat_name_ar'];
            }            
        }elseif(isset($_GET['menu_id'])&&($_GET['menu_id']!="") && ( isset($_GET['cat_id']) && ( $_GET['cat_id']!="" || $_GET['cat_id']=="0" ) ) ){
            $data['category']=1;
            $data['menuList']=  $this->MRestBranch->getAllMenu($rest);
			
            if(isset($_GET['cat_id'])&&(empty($_GET['cat_id'])) ){
                $newFlag=TRUE;
                $data['title']=$data['pagetitle']='  قائمة جديدة لأنواع  '.(htmlspecialchars($data['rest']['rest_Name_Ar']));
            }else{
                $newFlag=FALSE;
                $data['menucat']=  $this->MRestBranch->getMenuCat($cat_id,$menu_id);
                $data['title']=$data['pagetitle']=' تحديث أنواع القائمة  '.$data['menucat']['cat_name_ar'];
            }
        }else{
            $data['menu']=1;
            if($menu_id==0){
                $newFlag=TRUE;
                $data['title']=$data['pagetitle']='قائمة جديدة لأنواع '.(htmlspecialchars($data['rest']['rest_Name_Ar']));
            }else{
                $newFlag=FALSE;
                $data['menucat']=  $this->MRestBranch->getMenu($menu_id);
                $data['title']= $data['pagetitle']='  تحديث أنواع القائمة '.$data['menucat']['menu_name_ar'];
            }
        }
        if($newFlag){
        ######PERMISSIONS#######
        $availableMenuType=0;
        $availableMenuCats=0;
        $availableMenuCatItems=0;
        if($permissions['accountType']==0){ ##FREE ACCOUNT
            $availableMenuType=1;
            $availableMenuCats=3;
            $availableMenuCatItems=3;
        }elseif($permissions['accountType']==1){ ##BRONZE ACCOUNT
            $availableMenuType=5;
            $availableMenuCats=100;
            $availableMenuCatItems=100;
        }elseif($permissions['accountType']==2){ ##SLIVER ACCOUNT
            $availableMenuType=5;
            $availableMenuCats=100;
            $availableMenuCatItems=100;
        }elseif($permissions['accountType']==3){ ##GOLD ACCOUNT
            $availableMenuType=5;
            $availableMenuCats=100;
            $availableMenuCatItems=100;
        }
        ##MENU TYPE###
        if(isset($data['menu']) && !empty($data['menu'])){
            $totalMenu=$this->MRestBranch->getTotalMenu($restid);
            if($totalMenu >= $availableMenuType){
                $this->session->set_flashdata('error','يمكنك إضافة نوع واحد فقط من فئة القائمة . يرجى تحديث اشتراكك');
                redirect('ar/accounts');
            }
        }
        ##MENU CATEGORIES###
        if(isset($data['category']) && !empty($data['category'])){
            $totalMenuCats=$this->MRestBranch->getTotalMenuCats($restid);
            if($totalMenuCats >= $availableMenuCats){
                $this->session->set_flashdata('error','يمكنك أضافة 3 قوائم ضمن الطلب مع التحديث');
                redirect('ar/accounts');
            }
        }
	##MENU ITEMS###
        if(isset($data['item']) && !empty($data['item'])){
            $totalMenuCats=$this->MRestBranch->getTotalMenuItems($restid,$data['cat']['cat_id']);
            if($totalMenuCats >= $availableMenuCatItems){
                $this->session->set_flashdata('error','يمكنك أضافة 3 قوائم ضمن الطلب مع التحديث');
                redirect('ar/accounts');
            }
        }
        
        }//edit flag
        
        $data['css']='ar';
        $data['main']='ar/menuform';
	$data['js']='validate';
        $this->load->view('ar/template',$data);
    }
	
    function save($option=""){
        ######PERMISSIONS#######
        $restid=$this->session->userdata('rest_id');
        $permissions=$this->MBooking->restPermissions($restid);
        $sub_detail_permissions=explode(',',$permissions['sub_detail']);
        $availableMenuType=0;
        $availableMenuCats=0;
        $availableMenuCatItems=0;
        if($permissions['accountType']==0){ ##FREE ACCOUNT
            $availableMenuType=1;
            $availableMenuCats=3;
            $availableMenuCatItems=3;
        }elseif($permissions['accountType']==1){ ##BRONZE ACCOUNT
            $availableMenuType=5;
            $availableMenuCats=100;
            $availableMenuCatItems=100;
        }elseif($permissions['accountType']==2){ ##SLIVER ACCOUNT
            $availableMenuType=5;
            $availableMenuCats=100;
            $availableMenuCatItems=100;
        }elseif($permissions['accountType']==3){ ##GOLD ACCOUNT
            $availableMenuType=5;
            $availableMenuCats=100;
            $availableMenuCatItems=100;
        }
        
        if($option=="menu"){
            $rest=$this->input->post('rest_ID');
            $rest_data=$restdata=$this->MGeneral->getRest($rest,false,true);
            if($this->input->post('menu_name')){
                $menuID=0;
                if($this->input->post('menu_id')){
                    $menuID=$menu_id=$this->input->post('menu_id');
                    $this->MRestBranch->updateMenu();
                    $this->MRestBranch->updateRest($rest);
                    $this->session->set_flashdata('message','أنواع قائمة محدثة بنجاح');
                    $this->MGeneral->addActivity('A New Menu Type is added.',$menu_id);
                    //redirect('ar/menus');
                }else{
                    ##MENU TYPE###
                    $totalMenu=$this->MRestBranch->getTotalMenu($restid);
                    if($totalMenu >= $availableMenuType){
                        $this->session->set_flashdata('error','يمكنك إضافة نوع واحد فقط من فئة القائمة . يرجى تحديث اشتراكك');
                        redirect('ar/accounts');
                    }   
                    
                    $menuID=$last_insert_id=$this->MRestBranch->addMenu();
                    $this->MRestBranch->updateRest($rest);
                    $this->MRestBranch->updateMenuCats($rest,$last_insert_id);
                    $this->session->set_flashdata('message','أنواع القائمة مضافة بنجاح ');
                    $this->MGeneral->addActivity('A New Menu Type is added.',$last_insert_id);
                    //redirect('ar/menus');
                }
                
                $firstTimeLogin=$this->session->userdata('firstTimeLogin');
                if(isset($firstTimeLogin) && $firstTimeLogin==TRUE){
                    $data['firstTimeLogin']=$this->session->userdata('firstTimeLogin');
                    $restid=$this->session->userdata('rest_id');
                    $uuserid=$this->session->userdata('id_user');
                    $profilecompletionstatus=$this->MGeneral->getProfileCompletionStatus($restid,$uuserid);
                    if($profilecompletionstatus['profilecompletion']==2){
                        //$this->MGeneral->updateProfileCompletionStatus($restid,$uuserid,3);
                        $this->session->set_flashdata('message','إضافة فئة القائمة '.$this->input->post('menu_name_ar'));
                        redirect('ar/menus?rest='.$rest.'&menu_id='.$menuID);
                    }
                }
                redirect('ar/menus');
                
            }else{
                $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
                redirect('ar/menus');
            }
        }
	if($option=="menucategory"){
            $rest=$this->input->post('rest_ID');
            $rest_data=$restdata=$this->MGeneral->getRest($rest,false,true);
            $cat_name=$this->input->post('cat_name');
            $catID=0;
            $menuID=$cat_id=$this->input->post('menu_id');
            if($this->input->post('cat_name')){
                if($this->input->post('cat_id')){
                    $catID=$cat_id=$this->input->post('cat_id');
                    $this->MRestBranch->updateMenuCat();
                    $this->MRestBranch->updateRest($rest);
                    $this->session->set_flashdata('message','قائمة الأطباق المحدثة بنجاح ');
                    $this->MGeneral->addActivity('A New Menu Category is added',$cat_id);
                    //redirect('ar/menus?rest='.$rest.'&cat_id='.$_POST['cat_id'].'&menu_id='.$_POST['menu_id']);
                }else{
                    ##MENU CATEGORIES###
                    $totalMenuCats=$this->MRestBranch->getTotalMenuCats($restid);
                    if($totalMenuCats >= $availableMenuCats){
                        $this->session->set_flashdata('error','يمكنك إضافة ثلاثة أنواع من فئة القائمة فقط . يرجى تحديث اشتراكك.');
                        redirect('ar/accounts');
                    } 
                    $catID=$last_inserted_id=$this->MRestBranch->addMenuCat();
                    $this->MRestBranch->updateRest($rest);
                    $this->session->set_flashdata('message','قائمة الأطباق المضافة بنجاح ');
                    $this->MGeneral->addActivity('A New Menu Category is added.',$last_inserted_id);
                    //redirect('ar/menus?rest='.$rest.'&cat_id='.$last_inserted_id.'&menu_id='.$_POST['menu_id']);
                }
                
                $firstTimeLogin=$this->session->userdata('firstTimeLogin');
                if(isset($firstTimeLogin) && $firstTimeLogin==TRUE){
                    $data['firstTimeLogin']=$this->session->userdata('firstTimeLogin');
                    $restid=$this->session->userdata('rest_id');
                    $uuserid=$this->session->userdata('id_user');
                    $profilecompletionstatus=$this->MGeneral->getProfileCompletionStatus($restid,$uuserid);
                    if($profilecompletionstatus['profilecompletion']==2){
                        //$this->MGeneral->updateProfileCompletionStatus($restid,$uuserid,3);
                        $this->session->set_flashdata('message','إضافة عنصر قائمة لل '.$this->input->post('cat_name'));
                        redirect('ar/menus?rest='.$rest.'&menu_id='.$menuID.'&cat_id='.$catID.'&item='.$catID);
                    }
                }
                redirect('ar/menus?rest='.$rest.'&cat_id='.$catID.'&menu_id='.$_POST['menu_id']);                
                
            }else{
                $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
                redirect('ar/menus');
            }
        }
        if($option=="menuitem"){
            $rest=$this->input->post('rest_ID');
            $rest_data=$restdata=$this->MGeneral->getRest($rest,false,true);
            if($this->input->post('menu_item')){
                $cat=$this->input->post('cat_id');
                $menu_item_id=$this->input->post('id');
                $menu_id=$this->input->post('menu_id');
                $permissions=$this->MBooking->restPermissions($rest);
                $sub_detail_permissions=explode(',',$permissions['sub_detail']);
                if($permissions['accountType']!=0){
                    if(is_uploaded_file($_FILES['menuItem_image']['tmp_name'])){
                        $image= $this->upload_image('menuItem_image',$this->config->item('upload_url').'images/menuItem/');                        
                        list($width, $height, $type, $attr)= getimagesize($this->config->item('upload_url').'images/menuItem/'.$image);
                        if($width<200 && $height<200){echo '2<br>';
                            $this->session->set_flashdata('error', 'الصورة صغيرة جدا. يرجى تحميل الحجم الصحيح (200 × 200)  بكسل ');
                            redirect("ar/menus/form?rest=".$rest."&cat=".$cat."&item=".$menu_item_id."&menu_id=".$menu_id);
                        }                        
                        if(($width>800)||($height>500)){
                            $this->images->resize($this->config->item('upload_url').'images/menuItem/' . $image,800,500,$this->config->item('upload_url').'images/menuItem/thumb/' .$image);                            
                        }                        
                        $ratio= $width/$height;
                        $config['source_image']	= $this->config->item('upload_url').'images/menuItem/'. $image;
                        $config['wm_text'] = $rest_data['rest_Name'].' - '.$this->input->post('menu_item').' - Azooma.co';
                        $config['wm_type'] = 'text';
                        $config['wm_font_path'] = './css/text.ttf';
                        $config['wm_font_size']	= '13';
                        $config['wm_font_color'] = 'ffffff';
                        $config['wm_vrt_alignment'] = 'bottom';
                        $config['wm_hor_alignment'] = 'right';
                        $config['wm_padding']='-10';
                        $this->image_lib->initialize($config);
                        $this->image_lib->watermark();
                        $this->image_lib->clear();
                        $config['maintain_ratio'] = TRUE;
                        $this->load->library('images',$config);
                        $this->images->squareThumb($this->config->item('upload_url').'images/menuItem/' . $image,$this->config->item('upload_url').'images/menuItem/thumb/'.$image,100);
                    }else{
                        $image=($this->input->post('rest_Logo_old'));
                    }                   
                }else{
                    $image="";
                }
                $menu_item=$this->input->post('menu_item');
                if($this->input->post('id')){
                    $item_id=$this->input->post('id');                    
                    $this->MRestBranch->updateMenuItem($image);
                    $this->MRestBranch->updateRest($rest);
                    $this->session->set_flashdata('message','قائمة الأنواع المحدثة بنجاح ');
                    $this->MGeneral->addActivity('A New Menu Item is added.',$item_id);
                    //redirect('ar/menus?rest='.$rest.'&cat_id='.$cat.'&menu_id='.$menu_id.'&item='.$cat);
                }else{
                    ##MENU ITEMS###
                    $totalMenuCats=$this->MRestBranch->getTotalMenuItems($restid,$this->input->post('cat_id'));
                    if($totalMenuCats >= $availableMenuCatItems){
                        $this->session->set_flashdata('error','يمكنك إضافة ثلاثة أنواع من فئة القائمة فقط . يرجى تحديث اشتراكك');
                        redirect('ar/accounts');
                    } 
                    $item_id=$this->MRestBranch->addMenuItem($image);
                    $this->MRestBranch->updateRest($rest);
                    $this->session->set_flashdata('message','قائمة الأنواع المضافة بنجاح ');
                    $this->MGeneral->addActivity('A New Menu Item is added.',$item_id);
                    //redirect('ar/menus?rest='.$rest.'&cat_id='.$cat.'&menu_id='.$menu_id.'&item='.$cat);
                }
                
                $firstTimeLogin=$this->session->userdata('firstTimeLogin');
                if(isset($firstTimeLogin) && $firstTimeLogin==TRUE){
                    $data['firstTimeLogin']=$this->session->userdata('firstTimeLogin');
                    $restid=$this->session->userdata('rest_id');
                    $uuserid=$this->session->userdata('id_user');
                    $profilecompletionstatus=$this->MGeneral->getProfileCompletionStatus($restid,$uuserid);
                    if($profilecompletionstatus['profilecompletion']==2){
                        $this->MGeneral->updateProfileCompletionStatus($restid,$uuserid,3);
                        redirect('ar');
                    }
                }
                redirect('ar/menus?rest='.$rest.'&cat_id='.$cat.'&menu_id='.$menu_id.'&item='.$cat);
                
                
            }else{
                $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
                redirect('ar/menus');
            }
        }
    }
    
    function delete($branch=0){
        $rest=($_GET['rest']);
        $rest_data=$this->MGeneral->getRest($rest,false,true);
        $this->MRestBranch->updateRest($rest);
        if(isset($_GET['menu_id']) && !isset($_GET['cat_id']) && !isset($_GET['item']) ){
            $this->MRestBranch->deleteMenu(($_GET['menu_id']),$rest);
            $this->session->set_flashdata('message','قائمة الأنواع  حذف بنجاح');
            redirect('ar/menus');
        }
        elseif( isset($_GET['menu_id']) && isset($_GET['cat_id']) ){
            $cat_id=($_GET['cat_id']);
            $menu_id=($_GET['menu_id']);
            $this->MRestBranch->deleteMenuCat($cat_id,$menu_id,$rest);
            $this->session->set_flashdata('message','قائمة الأنواع  حذف بنجاح');
            redirect('ar/menus?rest='.$rest.'&cat_id='.$cat_id.'&menu_id='.$menu_id);
        }
        elseif(isset($_GET['cat'])){
            $this->MRestBranch->deleteMenuItem(($_GET['item']));
            $this->session->set_flashdata('message','قائمة الأنواع  حذف بنجاح');
            redirect('ar/menus?rest='.$rest.'&item='.$_GET['cat'].'&cat_id='.$_GET['cat'].'&menu_id='.$_GET['menu_id']);            
        }else{
            redirect('ar/menus');
        }
    }
   
    function pdf($id=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
       
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $data['pagetitle']=$data['title']="PDF قائمة لي ".(htmlspecialchars($data['rest']['rest_Name_Ar']));

        $data['menus']=  $this->MRestBranch->getAllMenuPDF($rest);
        $data['total']=  $this->MRestBranch->getTotalMenuPDF($rest);
        $data['main']='ar/menupdf';
        $data['css']='ar';
        $this->load->view('ar/template',$data);
    }
    
    
    function formpdf($pdf=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $permissions=$this->MBooking->restPermissions($restid);
        $sub_detail_permissions=explode(',',$permissions['sub_detail']);
        $data['settings']=$settings=  $this->MGeneral->getSettings();
        $data['sitename']=$this->MGeneral->getSiteName();
        $data['logo']=$logo=$this->MGeneral->getLogo();
        $data['rest']=$restdata=$this->MGeneral->getRest($restid,false,true);
        $editFlag=FALSE;
        if($pdf==0){
            $data['pagetitle']="قائمة طعام بي دي اف جديدة";
            $editFlag=FALSE;
        }else{
            $editFlag=TRUE;
            $data['pagetitle']="تحديث قائمة طعام بيدي اف";
            $data['menu']=$this->MRestBranch->getPDFMenu($pdf);
        }
        
        ######PERMISSIONS#######
        if(!$editFlag){
            $available_pdfMenu=0;
            if($permissions['accountType']==0){ ##FREE ACCOUNT
                $available_pdfMenu=1;
            }elseif($permissions['accountType']==1){ ##BRONZE ACCOUNT
                $available_pdfMenu=3;
            }elseif($permissions['accountType']==2){ ##SLIVER ACCOUNT
                $available_pdfMenu=4;
            }elseif($permissions['accountType']==3){ ##GOLD ACCOUNT
                $available_pdfMenu=5;
            }
            $totalMenuPDF=$this->MRestBranch->getTotalMenuPDF($restid);
            if($totalMenuPDF >= $available_pdfMenu){
                $this->session->set_flashdata('error','يمكنك إضافة قائمة  pdf واحد فقط . يرجى تحديث اشتراكك');
                redirect('ar/accounts');
            }
        }
        
        $data['css']='ar';
        $data['main']='ar/menupdfform';
	$data['js']='validate';
        $this->load->view('ar/template',$data);
    }
    
    function savepdf(){
        $menu_id='';
        if($this->input->post('rest_ID')){
            $rest=$this->input->post('rest_ID');
            $this->MRestBranch->updateRest($rest);
            if($this->input->post('title')){
            ini_set('memory_limit', '-1');
                $menu=$menuar="";
                $numPages=$numPagesAr=0;
                ini_set('memory_limit', '-1');
                if($this->input->post('id')){
                    if(is_uploaded_file($_FILES['menu']['tmp_name'])){
                        $ext = pathinfo($_FILES['menu_ar']['name'], PATHINFO_EXTENSION);
                        if(!in_array($ext, array('pdf'))){
                            $this->session->set_flashdata('error','Please upload pdf file.');
                            redirect('ar/menus/formpdf/'.$menu_id.'?rest='.$this->input->post('rest_ID'));
                        }
			$menu	= $this->upload_pdf('menu',$this->config->item('upload_url').'images/menuItem/');
                        $numPages=0;//$this->savePdfAsImage($menu,$this->config->item('upload_url').'images/pdf/');
                    }else{
			$menu = $_POST['menu_old'];	
                        $numPages = $_POST['pagenumber'];
                    }
                    if(is_uploaded_file($_FILES['menu_ar']['tmp_name'])){
                        $ext = pathinfo($_FILES['menu_ar']['name'], PATHINFO_EXTENSION);
                        if(!in_array($ext, array('pdf'))){
                            $this->session->set_flashdata('error','Please upload pdf file.');
                            redirect('ar/menus/formpdf/'.$menu_id.'?rest='.$this->input->post('rest_ID'));
                        }
			$menuar	= $this->upload_pdf('menu_ar',$this->config->item('upload_url').'images/menuItem/');
                        $numPagesAr=0;//$this->savePdfAsImage($menuar,$this->config->item('upload_url').'images/pdf_ar/');
                    }else{
			$menuar = $_POST['menu_ar_old'];	
                        $numPagesAr = $_POST['pagenumberAr'];
                    }
                    $menu_id=$this->input->post('id');
                    $this->MRestBranch->updatePDFMenu($menu,$menuar,$numPages,$numPagesAr);
                    $this->session->set_flashdata('message',' قائمة الأنواع المحدثة ');
                    $this->MGeneral->addActivity('A New PDF Menu is added.',$menu_id);
                    redirect('ar/menus/pdf');
                }else{
                    if(is_uploaded_file($_FILES['menu']['tmp_name'])){
                        $ext = pathinfo($_FILES['menu']['name'], PATHINFO_EXTENSION);
                        if(!in_array($ext, array('pdf'))){
                            $this->session->set_flashdata('error','Please upload pdf file.');
                            redirect('ar/menus/formpdf?rest='.$this->input->post('rest_ID'));                            
                        }
			$menu	= $this->upload_pdf('menu',$this->config->item('upload_url').'images/menuItem/');
                        $numPages=0;//$this->savePdfAsImage($menu,$this->config->item('upload_url').'images/pdf/');
                    }
                    if(is_uploaded_file($_FILES['menu_ar']['tmp_name'])){
                        $ext = pathinfo($_FILES['menu_ar']['name'], PATHINFO_EXTENSION);
                        if(!in_array($ext, array('pdf'))){
                            $this->session->set_flashdata('error','Please upload pdf file.');
                            redirect('ar/menus/formpdf?rest='.$this->input->post('rest_ID'));                            
                        }
			$menuar	= $this->upload_pdf('menu_ar',$this->config->item('upload_url').'images/menuItem/');
                        $numPagesAr=0;//$this->savePdfAsImage($menuar,$this->config->item('upload_url').'images/pdf_ar/');
                    }
                    $menu_id=$this->MRestBranch->addPDFMenu($menu,$menuar,$numPages,$numPagesAr);
                    $this->session->set_flashdata('message','قائمة الأنواع المضافة ');
                    $this->MGeneral->addActivity('A New PDF Menu is added.',$menu_id);                    
                    redirect('ar/menus/pdf');
                }
            }
        }else{
            $this->session->set_flashdata('error','حدث خطأ يرجى المحاولة مرة أخرى');
            redirect('ar/menus/pdf');
        }
    }
    
    function deletepdf($pdf=0){
        $rest=$restid=$this->session->userdata('rest_id');
        $uuserid=$this->session->userdata('id_user');
        $this->MRestBranch->deleteMenuPDF($pdf);
        $this->MRestBranch->updateRest($rest);
        $this->session->set_flashdata('message',' قائمة الأنواع المحدوفة  ');
	redirect('ar/menus/pdf');
    }
    
    function upload_pdf($name,$directory){
        $uploadDir = $directory;
        // ======================= upload 1 ===========================
        if ( $_FILES[$name]['name'] != '' &&  $_FILES[$name]['name'] != 'none'){					
            $uploadFile_1 = uniqid('azooma').  $_FILES[$name]['name'];
            $uploadFile1 = $uploadDir. $uploadFile_1; 
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1)){
                    //print "File is valid, and was successfully uploaded. \n\n ";
            }
            else{
                            return null;
            }
            return $uploadFile_1;
        }
        else
            return null;
    }
	
    ##Haroon
    function upload_image($name,$dir,$default='no_image.jpg'){
        $uploadDir = $dir;
        if ( $_FILES[$name]['name'] != '' &&  $_FILES[$name]['name'] != 'none')
                    {              
            $filename     = $_FILES[$name]['name'];
            $filename=str_replace(' ', '_', $filename);
            $uploadFile_1 = uniqid('azooma') . $filename;
            $uploadFile1  = $uploadDir. $uploadFile_1; 
            $fileName     = $_FILES[$name]['name'];
                if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
                      $image_name = $uploadFile_1;
                else
                      $image_name = $default;                                                            
      }
      else
       $image_name = $default;

                      return $image_name;                    
    }
    
    function savePdfAsImage($fname, $directory,$savedir){
        $filename=$directory.$fname;
        return 0;
        if($fname!="" && file_exists($filename) ){
            $pdf=$filename;
            $pages=$this->getNumPagesPdf($pdf);            
            $name=explode('.', $fname);
            if(mkdir($savedir.$name[0],0755)){
                for($i=0;$i<$pages;$i++){
                    $j=$i+1;
                    $im = new imagick();
                    $im->readimage($pdf.'['.$i.']'); 
                    $im->setImageFormat('jpg');
                    file_put_contents($savedir.$name[0].'/'.$j.'.jpg', $im);
                }
            }
            return $pages;
        }
    }
    
    function getNumPagesPdf($filepath){
return 0;
        $fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
        if($fp){
            $max=0;
            while(!feof($fp)) {
                    $line = fgets($fp,255);
                    if (preg_match('/\/Count [0-9]+/', $line, $matches)){
                            preg_match('/[0-9]+/',$matches[0], $matches2);
                            if ($max<$matches2[0]) $max=$matches2[0];
                    }
            }
            fclose($fp);
        }else{
         // return 2;
        }
        if($max==0){
            $im = new imagick($filepath);
            $max=$im->getNumberImages();
        }

        return $max;
    }
}