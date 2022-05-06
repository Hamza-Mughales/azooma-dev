<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MGeneral extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function getSettings(){
        //$this->db->cache_on();
        $q=$this->db->get('settings');
        //$this->db->cache_off();
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getSiteName($lang='en'){
        $this->db->select('name,nameAr');
        $q=$this->db->get('settings');
        if($q->num_rows()>0){
            $data=$q->row_Array();
            if($lang=='en'){
                return $data['name'];
            }
            else{
                return $data['nameAr'];
            }
        }
    }
    
    function updateSettings($id){
        $data=array(
            'name'=> ($this->input->post('name')),
            'nameAr'=> $this->input->post('nameAr'),
            'email'=> $this->input->post('email'),
            'keywords'=> ($this->input->post('keywords')),
            'keywordsAr'=>$this->input->post('keywordsAr'),
            'twitter'=> ($this->input->post('twitter')),
            'facebook'=> ($this->input->post('facebook')),
            'linkedin'=> ($this->input->post('linkedin')),
            'youtube'=> ($this->input->post('youtube')),
            'instagram'=> ($this->input->post('instagram')),
            'address'=> nl2br($this->input->post('address')),
            'addressAr'=> nl2br($this->input->post('addressAr')),
            'tel'=>  $this->input->post('tel'),
            'fax'=>  $this->input->post('fax'),
            'mobile'=>  $this->input->post('mobile')
        );
        $this->db->where('id',$id);
        $this->db->update('settings',$data);
    }
    
    function getLogo(){
        $this->db->where('art_work_name','Sufrati Logo')->where('active',1);
        $q=$this->db->get('art_work');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getRandomQuote(){
        $this->db->where('status',1);
        $q=$this->db->get('welcome_message');
        if($q->num_rows()>0){
            $data=$q->row_Array();
            return $data;
        }
    }
    
    function getRestFromUrl($url="",$status=0){
        if($url!=""){
            if($status!=0){
                $this->db->where('rest_Status',1);
            }
            $this->db->where('seo_url',$url);
            $q=$this->db->get('restaurant_info');
            if($q->num_rows()>0){
                return $q->row_Array();
            }
        }
    }
    
    function getSocialLinks(){
        $this->db->select('twitter','facebook');
        $q=$this->db->get('settings');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    
    function getCity($city=0){
        $this->db->where('city_ID',$city);
        $q=$this->db->get('city_list');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getCityFromUrl($city=""){
        if($city!=""){
        $this->db->where('seo_url',$city);
        $this->db->where('city_Status',1);
        $q=$this->db->get('city_list');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
        }
    }
    
    function getCuisine($cuisine){
        $this->db->where('cuisine_ID',$cuisine);
        $q=$this->db->get('cuisine_list');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getCuisineFromUrl($cuisine=""){
        $this->db->where('seo_url',$cuisine);
        $this->db->where('cuisine_Status',1);
        $q=$this->db->get('cuisine_list');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getCityDistricts($city=0,$status=""){
        if($city!=0){
            $this->db->where('city_ID',$city);
        }
        if($status!=""){
            $this->db->where('district_Status',$status);
        }
        $this->db->order_by('district_Name','ASC');
        $q=$this->db->get('district_list');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getDistrict($district=0){
        $this->db->where('district_ID',$district);
        $q=$this->db->get('district_list');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    
    function getRealIpAddr(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else{
                $ip=$_SERVER['REMOTE_ADDR'];
            }
        return $ip;
    }
    
    function getVisit($date,$lang=""){
        $date2=date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " +1 day"));
        $this->db->where('created_at BETWEEN "'.$date.'" and "'.$date2.'"');
        if($lang!=""){
            $this->db->where('lang',$lang);
        }
        return $this->db->count_all_results('analytics');
    }
    
    function convertToArabic($var){
        $digit = (string)$var;
    if(empty($digit))
            return ' ';
    $ar_digit = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩','-'=>'-',' '=>' ','.'=>'.');
    $arabic_digit = '';
    $length = strlen($digit);
    for($i=0;$i<$length;$i++){
            if(isset($ar_digit[$digit[$i]]))
        $arabic_digit .= $ar_digit[$digit[$i]];
            else
                $arabic_digit .=$digit[$i];
    }
    return $arabic_digit;
    }
    
    function getSuggestRestaruant($query=""){
        $this->db->select('rest_Name,rest_Name_Ar,rest_ID,seo_url');
        $this->db->like('rest_Name',$query,'after');
        $this->db->or_like('rest_Name_Ar',$query,'after');
        $q=$this->db->get('restaurant_info',10);
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getCountActivity(){
        return $this->db->count_all_results('activity_info');
    }
    
    function getNewRestaurants(){
        $this->db->where('is_read',0);
        return $this->db->count_all_results('restaurant_info');
    }
    
    function getAllCity($status=0){
        if($status==1){
            $this->db->where('city_Status',1);
        }
        $this->db->order_by('city_Name');
        $q=$this->db->get('city_list');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getAllCuisine($status=0,$city=0){
        $this->db->select('cuisine_list.cuisine_Name,cuisine_list.cuisine_Name_ar,cuisine_list.seo_url,cuisine_list.cuisine_ID,cuisine_list.master_id');
        if($status==1){
            $this->db->where('cuisine_Status',1);
        }
        if($city!=0){
            $this->db->join('restaurant_cuisine','restaurant_cuisine.cuisine_ID=cuisine_list.cuisine_ID');
            $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_cuisine.rest_ID AND rest_branches.city_ID='.$city);
            $this->db->join('restaurant_info','restaurant_info.rest_ID=rest_branches.rest_fk_id');
            $this->db->where('restaurant_info.rest_Status',1);
            $this->db->group_by('cuisine_list.cuisine_ID');
        }
        $this->db->order_by('cuisine_Name');
        $q=$this->db->get('cuisine_list');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getBestFor($bestfor){
        $this->db->where('bestfor_ID',$bestfor);
        $q=$this->db->get('bestfor_list');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getAllBestFor($status=0,$city=0){
        if($status==1){
            $this->db->where('bestfor_Status',1);
        }
        if($city!=0){
            $this->db->join('restaurant_bestfor','restaurant_bestfor.bestfor_ID=bestfor_list.bestfor_ID');
            $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_bestfor.rest_ID AND rest_branches.city_ID='.$city);
            $this->db->join('restaurant_info','restaurant_info.rest_ID=rest_branches.rest_fk_id');
            $this->db->where('restaurant_info.rest_Status',1);
            $this->db->group_by('bestfor_list.bestfor_ID');
        }
        $this->db->order_by('bestfor_Name');
        $q=$this->db->get('bestfor_list');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function city_list($status=0,$id="city_ID",$class="",$allCity=0){
        $cities=$this->getAllCity($status);
        $html="";
        if(count($cities)>0){
            $html.= '<select name="city" id="'.$id.'" class="'.$class.'">';
            $html.='<option value="">Select City</option>';
            if($allCity!=0){
                $html.='<option value="0">All City</option>';
            }
            foreach($cities as $city){
                $html.='<option value="'.$city['city_ID'].'">'.$city['city_Name'].'</option>';
            }
            $html.="</select>";
        }
        return $html;
    }
    
    function cuisine_list($status=0,$id="cuisine_ID",$class="",$allCity=0){
        $cuisines=$this->getAllCuisine($status);
        $html="";
        if(count($cuisines)>0){
            $html.= '<select name="cuisine" id="'.$id.'" class="'.$class.'">';
            $html.='<option value="">Select Cuisine</option>';
            if($allCity!=0){
                $html.='<option value="0">All Cuisine</option>';
            }
            foreach($cuisines as $cuisine){
                $html.='<option value="'.$cuisine['cuisine_ID'].'">'.$cuisine['cuisine_Name'].'</option>';
            }
            $html.="</select>";
        }
        return $html;
    }
    
    
    function bestfor_list($status=0,$id="bestfor_ID"){
        $bestfors=$this->getAllBestFor($status);
        $html="";
        if(count($bestfors)>0){
            $html.= '<select name="bestfor" id="'.$id.'">';
            $html.='<option value="">Select Bestfor</option>';
            foreach($bestfors as $bestfor){
                $html.='<option value="'.$bestfor['bestfor_ID'].'">'.$bestfor['bestfor_Name'].'</option>';
            }
            $html.="</select>";
        }
        return $html;
    }
    
    function getNewRestaurantComments($status=0){ 
        
        $this->db->where('review.is_read',0);
        return $this->db->count_all_results('review');
    }
    
    /****** Returns cuisines of a restaurant, if $name is 1 returns just the name as comma seperated ************/
    function getRestaurantCuisines($rest=0,$limit="",$name=0,$lang="en"){
        $this->db->distinct();
        if($name==0){
            $this->db->select('cuisine_list.*');
        }else{
            $this->db->select('cuisine_list.cuisine_Name,cuisine_list.cuisine_Name_Ar,cuisine_list.master_id');
        }
        $this->db->where('restaurant_cuisine.rest_ID',$rest);
        $this->db->join('cuisine_list','cuisine_list.cuisine_ID=restaurant_cuisine.cuisine_ID AND cuisine_list.cuisine_Status=1');
        $this->db->order_by('cuisine_list.cuisine_Name','DESC');
        if($limit!=""){
            $this->db->limit($limit);
        }
        $q=$this->db->get('restaurant_cuisine');
        if($q->num_rows()>0){
            if($name==0){
                return $q->result_Array();
            }else{
                $cuisine="";
                $i=0;
                foreach($q->result_Array() as $row){
                    $i++;
                    if($lang=="en"){
                        $cuisine.=$row['cuisine_Name'];
                    }else{
                        $cuisine.=$row['cuisine_Name_Ar'];
                    }
                    if($i!=$q->num_rows()){
                        $cuisine.=", ";
                    }
                }
                return $cuisine;
            }
        }
    }
    
    function getRestaurantBestFors($rest=0,$limit="",$name=0,$lang="en"){
        $this->db->distinct();
        if($name==0){
            $this->db->select('bestfor_list.*');
        }else{
            $this->db->select('bestfor_list.bestfor_Name,bestfor_list.bestfor_Name_Ar');
        }
        $this->db->where('restaurant_bestfor.rest_ID',$rest);
        $this->db->join('bestfor_list','bestfor_list.bestfor_ID=restaurant_bestfor.bestfor_ID AND bestfor_list.bestfor_Status=1');
        $this->db->order_by('bestfor_list.bestfor_Name','DESC');
        if($limit!=""){
            $this->db->limit($limit);
        }
        $q=$this->db->get('restaurant_bestfor');
        if($q->num_rows()>0){
            if($name==0){
                return $q->result_Array();
            }else{
                $bestfor="";
                $i=0;
                foreach($q->result_Array() as $row){
                    $i++;
                    if($lang=="en"){
                        $bestfor.=$row['bestfor_Name'];
                    }else{
                        $bestfor.=$row['bestfor_Name_Ar'];
                    }
                    if($i!=$q->num_rows()){
                        $bestfor.=", ";
                    }
                }
                return $bestfor;
            }
        }
    }
    
    function getAllBusinessType($name=0,$lang="en"){
        $this->db->where('status',1);
        $q=  $this->db->get('rest_type');
        if($q->num_rows()>0){
            if($name==0){
                return $q->result_Array();
            }else{
                $t=$q->result_Array();
                $type="";
                $i=0;
                foreach ($t as $row){
                    $i++;
                    if($row['name']!="Other/NA"){
                    if($lang=="en"){
                        $type.=$row['name'];
                    }else{
                        $type.=$row['nameAr'];
                    }
                    
                    if($i!=count($t)){
                        $type.=', ';
                    }
                    }
                }
                return $type;
            }
        }
    }
    
    function getRestaurantPermissions($rest=0){
        $this->db->where('rest_ID', $rest);
        $query = $this->db->get('subscription');
        if($query->num_rows()>0){
            $row = $query->row_array();
            return $row;
        }
    }
    
    function getRestaurantCities($rest=0,$limit="",$name=0,$lang="en"){
        $this->db->distinct();
        if($name==0){
            $this->db->select('city_list.*');
        }else{
            $this->db->select('city_list.city_Name,city_list.city_Name_Ar');
        }
        $this->db->where('rest_branches.rest_fk_id',$rest);
        $this->db->join('city_list','city_list.city_ID=rest_branches.city_ID AND city_list.city_Status=1');
        $this->db->order_by('city_list.city_Name','DESC');
        if($limit!=""){
            $this->db->limit($limit);
        }
        $q=$this->db->get('rest_branches');
        if($q->num_rows()>0){
            if($name==0){
                return $q->result_Array();
            }else{
                $city="";
                $i=0;
                foreach($q->result_Array() as $row){
                    $i++;
                    if($lang=="en"){
                        $city.=substr($row['city_Name'],0,3);
                    }else{
                        $city.=$row['city_Name_Ar'];
                    }
                    if($i!=$q->num_rows()){
                        $city.=", ";
                    }
                }
                return $city;
            }
        }
    }
    
    function isMember($rest){
        $this->db->where('rest_id',$rest);
        $this->db->where('status',1);
        $q=$this->db->get('booking_management');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function restRating($rest=0){
        $sql = "SELECT * FROM rating_info WHERE rest_ID=$rest";
        $q=$this->db->query($sql);
        if($q->num_rows()>0){
            $total=0;
            $food=0;
            $service=0;
            $atmosphere=0;
            $value=0;
            $variety=0;
            $presentation=0;
            $count=0;
            $results=$q->result_Array();
            foreach($results as $t){
                $count++;
                $food=$food+$t['rating_Food'];
                $service=$service+$t['rating_Service'];
                $atmosphere=$atmosphere+$t['rating_Atmosphere'];
                $value=$value+$t['rating_Value'];
                $variety=$variety+$t['rating_Variety'];
                $presentation=$presentation+$t['rating_Presentation'];
            }
            $data=array();
            $data['count']=$count;
            $data['food']=$food=$food/$count;
            $data['service']=$service=$service/$count;
            $data['atmosphere']=$atmosphere=$atmosphere/$count;
            $data['value']=$value=$value/$count;
            $data['variety']=$variety=$variety/$count;
            $data['presentation']=$presentation=$presentation/$count;
            $data['total']=$total=($food+$service+$atmosphere+$value+$variety+$presentation)/6;
            return $data;
        }
                
    }
    
    function getRest($id=0,$min=false,$fav=false){
        if($min==TRUE){
            $this->db->select('rest_ID,rest_Name,rest_Name_Ar,rest_Logo,seo_url,rest_TollFree');
        }
        if($fav){
            $this->db->select('restaurant_info.*,');
        }
        $this->db->where('rest_ID',$id);
        $q=$this->db->get('restaurant_info');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getRestaruantTel($restid){
        $rest=$this->getRest($restid);
        if($rest['rest_TollFree']!=""){
            return $rest['rest_TollFree'];
        }elseif($rest['rest_Telephone']!=""){
            return $rest['rest_Telephone'];
        }else{
            if($rest['rest_Mobile']!=""){
                return $rest['rest_Mobile'];
            }else{
                $this->db->where('rest_fk_id',$restid);
                $brcount=$this->db->count_all_results('rest_branches');
                if($brcount==1){
                    $this->db->where('rest_fk_id',$restid);
                    $q=$this->db->get('rest_branches');
                    $branch=$q->row_Array();
                    if(strlen($branch['br_number'])>7){
                        return str_replace(' ','',$branch['br_number']);
                    }else{
                        if($branch['br_mobile'] != '')
                                return $branch['br_mobile'];
                        else if($branch['br_toll_free'] != '')
                                return $branch['br_toll_free'];
                    }
                }
            }
        }
    }
    
    function getMembers($limit=0,$offset=""){
        $this->db->select('rest_Name,rest_Name_Ar,rest_Logo,seo_url');
        $this->db->where('rest_Subscription >',1);
        $this->db->where('rest_Status',1);
        $this->db->order_by('rest_Subscription','DESC');
        if($limit!=0){
            $this->db->limit($limit,$offset);
        }
        $q=$this->db->get('restaurant_info');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getRestaurantPlace($rest,$lang="en"){
        $this->db->distinct('city_ID');
        $this->db->select('city_list.city_Name,city_list.city_Name_Ar');
        $this->db->where('rest_branches.rest_fk_id',$rest);
        $this->db->join('city_list','city_list.city_ID=rest_branches.city_ID AND city_list.city_Status=1');
        $q=$this->db->get('rest_branches');
        if($q->num_rows()>0){
            if($q->num_rows()>1){
                return "";
            }else{
                $city=$q->result_Array();
                foreach($city as $c){
                    if($lang=="en"){
                        $place=$c['city_Name'];
                    }else{
                        $place=$c['city_Name_Ar'];
                    }
                }
                return $place;
            }
        }
    }
    
    function getLatestVideo($city_ID=0){
        if(!empty($city_ID)){
            $this->db->where('city_ID',$city_ID);
            $this->db->where('status',1);
            $videocount=  $this->db->count_all_results('rest_video');
            if($videocount==0){
                $this->db->where('status',1);
                $videocount=  $this->db->count_all_results('rest_video');
            }
            $videocount--;
            $rand=  rand(1, $videocount);
            $this->db->where('status',1);
            $this->db->limit(1,$rand);
            $q=$this->db->get('rest_video',1);
            if($q->num_rows()>0){
                return $q->row_Array();
            }
            
        }else{
            $this->db->where('status',1);
            $videocount=  $this->db->count_all_results('rest_video');
            $videocount--;
            $rand=  rand(1, $videocount);
            $this->db->where('status',1);
            $this->db->limit(1,$rand);
            $q=$this->db->get('rest_video',1);
            if($q->num_rows()>0){
                return $q->row_Array();
            }
        }
    }
    
    function getLatestArticle($city_ID=0){
        if(!empty($city_ID)){
            $this->db->where('status',1);
            $this->db->where_in('locations',$city_ID);
            $articlecount=  $this->db->count_all_results('article');
            if($articlecount>0){
                $this->db->where_in('locations',$city_ID);
            }
        }
        $this->db->select('article.*,(SELECT categories.name FROM categories WHERE categories.id=article.category) as cat,,(SELECT categories.nameAr FROM categories WHERE categories.id=article.category) as catAr');
        $this->db->where('status',1);
        $this->db->order_by('createdAt','DESC');
        $q=$this->db->get('article',1);
        if($q->num_rows()>0){
            return $q->row_Array();
        }

    }
    
    function getLatestRecipe(){
        $this->db->where('status',1);
        $this->db->order_by('createdAt','DESC');
        $q=$this->db->get('recipe',1);
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getRandomRecommended($city=0){
        $this->db->where('restaurant_info.rest_Status',1)->where('restaurant_info.sufrati_favourite !=',0);
        $total=  $this->db->count_all_results('restaurant_info');
        $rand=rand(1,$total);
        $this->db->select('restaurant_info.rest_ID,restaurant_info.rest_Name,restaurant_info.rest_Name_Ar,restaurant_info.rest_Logo,restaurant_info.seo_url');
        $this->db->select('(SELECT COUNT(*) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) as `like`');
        $this->db->where('restaurant_info.rest_Status',1)->where('restaurant_info.sufrati_favourite !=',0);
        if($city!=0){
            $this->db->join('rest_branches', 'rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= '.$city,'inner');
        }
        $this->db->limit(1,$rand);
        $q=$this->db->get('restaurant_info');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function uploadImage($name,$directory){
        $uploadDir = $directory;
        if ( $_FILES[$name]['name'] != '' &&  $_FILES[$name]['name'] != 'none'){
            $file=str_replace(' ', '_', $_FILES[$name]['name']);
            $uploadFile_1 = uniqid('sufrati').  $file;
            $uploadFile1 = $uploadDir. $uploadFile_1;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1)){
                // successfully uploaded"
            }
            else{
               return null;
            }
            return $uploadFile_1;
            }
            else
               return null;
    }
    
    function getComment($id){
        $this->db->where('review_ID',$id);
        $this->db->where('review_Status',1);
        $q=$this->db->get('review');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getPhoto($id){
        $this->db->where('image_ID',$id);
        $this->db->where('status',1);
        $q=$this->db->get('image_gallery');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function getSupport($id){
        $this->db->where('id',$id);
        $q=$this->db->get('likee_info');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    
    function checkMobile(){
        return FALSE;
    }
    
    /*********** Author: Ekram Returns time period ago *****/
    function ago($datefrom=0, $dateto=-1){
        if($datefrom==0) { return "A long time ago"; }
    $date = new DateTime(null, new DateTimeZone('Asia/Riyadh'));
        if($dateto==-1) { $dateto = strtotime($date->format("Y-m-d H:i:s")); }
        // Make the entered date into Unix timestamp from MySQL datetime field
        $datefrom = strtotime($datefrom);
        // Calculate the difference in seconds betweeen
        $difference = $dateto - $datefrom;
        // Based on the interval,Find the difference
        switch(true){
            // Seconds
            case(strtotime('-1 min', $dateto) < $datefrom):
                $datediff = $difference;
                $res = ($datediff==1) ? $datediff.' second ago' : $datediff.' seconds ago';
                break;
            // Minutes
            case(strtotime('-1 hour', $dateto) < $datefrom):
                $datediff = floor($difference / 60);
                $res = ($datediff==1) ? $datediff.' minute ago' : $datediff.' minutes ago';
                break;
            // Hours
            case(strtotime('-1 day', $dateto) < $datefrom):
                $datediff = floor($difference / 60 / 60);
                $res = ($datediff==1) ? $datediff.' hour ago' : $datediff.' hours ago';
                break;
            // Days
            case(strtotime('-1 week', $dateto) < $datefrom):
                $day_difference = 1;
                while (strtotime('-'.$day_difference.' day', $dateto) >= $datefrom){
                    $day_difference++;
                }
                $datediff = $day_difference-1;
                $res = ($datediff==1) ? 'Yesterday' : $datediff.' days ago';
                break;
            // Weeks      
            case(strtotime('-1 month', $dateto) < $datefrom):
                $week_difference = 1;
                while (strtotime('-'.$week_difference.' week', $dateto) >= $datefrom){
                    $week_difference++;
                }
                $datediff = $week_difference;
                $res = ($datediff==1) ? 'last week' : $datediff.' weeks ago';
                break;            
            // Months
            case(strtotime('-1 year', $dateto) < $datefrom):
                $months_difference = 1;
                while (strtotime('-'.$months_difference.' month', $dateto) >= $datefrom){
                    $months_difference++;
                }
                $datediff = $months_difference;
                $res = ($datediff==1) ? $datediff.' month ago' : $datediff.' months ago';
                break;
            // Years
            case(strtotime('-1 year', $dateto) >= $datefrom):
                $year_difference = 1;
                while (strtotime('-'.$year_difference.' year', $dateto) >= $datefrom){
                    $year_difference++;
                }
                $datediff = $year_difference;
                $res = ($datediff==1) ? $datediff.' year ago' : $datediff.' years ago';
                break;
        }
        return $res;
    }
    
    function agoAr($datefrom=0,$dateto=-1)
    {
        // Defaults and assume if 0 is passed in that
        // its an error rather than the epoch
        if($datefrom==0) { return "A long time ago"; }
        $date = new DateTime(null, new DateTimeZone('Asia/Riyadh'));
        if($dateto==-1) { $dateto = strtotime($date->format("Y-m-d H:i:s")); }
        // Make the entered date into Unix timestamp from MySQL datetime field
        $datefrom = strtotime($datefrom);
        // Calculate the difference in seconds betweeen
        // the two timestamps
        $difference = $dateto - $datefrom;
        // Based on the interval, determine the
        // number of units between the two dates
        // From this point on, you would be hard
        // pushed telling the difference between
        // this function and DateDiff. If the $datediff
        // returned is 1, be sure to return the singular
        // of the unit, e.g. 'day' rather 'days'
        switch(true)
        {
            // If difference is less than 60 seconds,
            // seconds is a good interval of choice
            case(strtotime('-1 min', $dateto) < $datefrom):
                $datediff = $difference;
                $res = ($datediff==1) ? 'منذ ' . $this->convertToArabic($datediff).' ثانية' : 'منذ ' . $this->convertToArabic($datediff).' ثانية';
                break;
            // If difference is between 60 seconds and
            // 60 minutes, minutes is a good interval
            case(strtotime('-1 hour', $dateto) < $datefrom):
                $datediff = floor($difference / 60);
                $res = ($datediff==1) ? 'منذ ' . $this->convertToArabic($datediff) . ' دقيقة' : 'منذ ' . $this->convertToArabic($datediff).' دقيقة';
                break;
            // If difference is between 1 hour and 24 hours
            // hours is a good interval
            case(strtotime('-1 day', $dateto) < $datefrom):
                $datediff = floor($difference / 60 / 60);
                $res = ($datediff==1) ? 'منذ ' . $this->convertToArabic($datediff).' ساعة' : 'منذ ' . $this->convertToArabic($datediff). ' ساعة';
                break;
            // If difference is between 1 day and 7 days
            // days is a good interval                
            case(strtotime('-1 week', $dateto) < $datefrom):
                $day_difference = 1;
                while (strtotime('-'.$day_difference.' يوم', $dateto) >= $datefrom)
                {
                    $day_difference++;
                }
                $datediff = $day_difference-1;
                $res = ($datediff==1) ? 'أمس' : $datediff.' منذ أيام';
                break;
            // If difference is between 1 week and 30 days
            // weeks is a good interval            
            case(strtotime('-1 month', $dateto) < $datefrom):
                $week_difference = 1;
                while (strtotime('-'.$week_difference.' week', $dateto) >= $datefrom)
                {
                    $week_difference++;
                }
                $datediff = $week_difference;
                $res = ($datediff==1) ? 'الاسبوع الماضي' : $datediff.' منذ أسابيع';
                break;            
            // If difference is between 30 days and 365 days
            // months is a good interval, again, the same thing
            // applies, if the 29th February happens to exist
            // between your 2 dates, the function will return
            // the 'incorrect' value for a day
            case(strtotime('-1 year', $dateto) < $datefrom):
                $months_difference = 1;
                while (strtotime('-'.$months_difference.' month', $dateto) >= $datefrom)
                {
                    $months_difference++;
                }
                $datediff = $months_difference;
                $res = ($datediff==1) ? ' قبل'.$this->convertToArabic($datediff).' شهر' : ' قبل'.$this->convertToArabic($datediff).' شهر';
                break;
            // If difference is greater than or equal to 365
            // days, return year. This will be incorrect if
            // for example, you call the function on the 28th April
            // 2008 passing in 29th April 2007. It will return
            // 1 year ago when in actual fact (yawn!) not quite
            // a year has gone by
            case(strtotime('-1 year', $dateto) >= $datefrom):
                $year_difference = 1;
                while (strtotime('-'.$year_difference.' year', $dateto) >= $datefrom)
                {
                    $year_difference++;
                }
                $datediff = $year_difference;
                $res = ($datediff==1) ? ' قبل'.$this->convertToArabic($datediff).' عام' : ' منذ '.$this->convertToArabic($datediff).'سنوات';
                break;
        }
        return $res;
    }   
    /********* End of Ago ***********/
    
    function generate_options($from,$to,$callback=false,$lang='en',$selected=""){
            $reverse=false; 
            if($from>$to){
                    $tmp=$from;
                    $from=$to;
                    $to=$tmp;
                    $reverse=true;
            }
            $return_string=array();
            for($i=$from;$i<=$to;$i++){
                if($lang=="en"){
                    $string='<option value="'.$i.'"';
                    if(($selected!="")&&($selected==$i)){
                        $string.=' selected="selected"';
                    }
                    $string.='>'.($callback?$this->callback_month($i):$i).'</option>';
                    $return_string[]=$string;
                }else{
                    if($callback){
                        $return_string[]='
                        <option value="'.$i.'">'.$this->convertToArabic($i).'</option>';                        
                    }else{
                        $return_string[]='
                        <option value="'.$i.'">'.$this->convertToArabic($i).'</option>';
                    }
                }
            }
            if($reverse){
                    $return_string=array_reverse($return_string);
            }
            return join('',$return_string);
    }
    
    
    function callback_month($month){
        return date('F',mktime(0,0,0,$month,1));
    }
    
    function getString($string, $start, $end){
        $string = " ".$string;
        $pos = strpos($string,$start);
        if ($pos == 0) return "";
        $pos += strlen($start);
        $len = strpos($string,$end,$pos) - $pos;
        return substr($string,$pos,$len);
    }
    
    function getIP(){
       if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else{
                $ip=$_SERVER['REMOTE_ADDR'];
            }
        return $ip;
   }
  /************** get Visits function by Haroon **************/
   function getVisitNew($lang=""){
        
        $this->db->select('COUNT(*) AS total, DATE(created_at) AS currdate');
        $this->db->where('DATE(created_at) BETWEEN DATE( DATE_ADD( DATE( DATE_ADD( CURRENT_DATE , INTERVAL -1 DAY)) , INTERVAL  -7 DAY)) AND DATE( DATE_ADD( CURRENT_DATE , INTERVAL -1 DAY))');
        if($lang!=""){
            $this->db->where('lang',$lang);
        } 
        $this->db->group_by('DATE(created_at)');
        $q=$this->db->get('analytics');
        
        return $q->result_Array();
    }
    
    function getTotalVisit(){
        $q=$this->db->get('visitor_info');
    return $q->result_Array();
    }
    
    /*********************** Arabic Text return ************/
    
    function arabiser($var=""){
        if($var!=""){
            $t=array(
                'Casual Dining'=>'مكان قيم',
                'Fine Dining'=>'مطعم فاخر',
                'Quality Dining'=>'مطعم فاخر',
                'Quick Service'=>'خدمة سريع',
                'Cuisine'=>'طبخ'  ,
                'Price Range'=> 'نطاق السعر',
                'Indoor'=>'داخلي',
                'Outdoor'=>'خارجي',
                'Child Friendly'=>'مجهز للأطفال',
                'Small'=>'صغير',
                'Medium'=>'متوسط',
                'Large'=>'كبير',
                'Banquet'=>'قاعة',
                'Classic Restaurant'=>'مطعم كلاسيكي',
                'Hotel Restaurant'=>'مطعم فندق',
                'Food Court'=>'مجمع مطاعم',
                'Home Made'=>'صنع منزلي',
                'Delivery Service'=>'خدمات توصيل',
                'Catering Service'=>'خدمات تأمين',
                'Quick Service'=>'خدمة سريعة',
                'Stall'=>'لا مكان للجلوس',
                'Indoor'=>'داخلي',
                'Outdoor'=>'خارجي',
                'Child Friendly'=>'مجهز للأطفال',
                'Single Section'=>'قسم أفراد',
                'Family Section'=>'قسم عائلات',
                'Private room'=>'غرف خاصة',
                'Wifi'=>'تغطية إنترنت',
                'TV Screens'=>'شاشات تلفاز',
                'Sheesha'=>'شيشة',
                'Wheel Chair Accessibility'=>'خدمات ذوي الإحتياجات',
                'Smoking'=>'التدخين مسموح',
                'Non Smoking'=>'التدخين ممنوع',
                'Valet Parking'=>'مواقف مؤمنة',
                'Drive Through'=>'خدمة الطلب من السيارة',
                'Buffet'=>'بوفيه',
                'Takeaway'=>'لشراء والمغادرة',
                'Delivery'=>'توصيل',
                'Business Facilities'=>'خدمات أعمال',
                'Catering services'=>'خدمات تأمين حفلات',
                'Busy'=>'مزدحم',
                'Quiet'=>'هادىء',
                'Romantic'=>'رومنسي',
                'Young Crowd'=>'مكان شبابي',
                'Trendy'=>'عصري',
        'January'=>'يناير',
        'February'=>'فبراير',
        'March'=>'مارس',
        'April'=>'أبريل/إبريل',
        'May'=>'مايو',
        'June'=>'يونيو/يونية',
        'July'=>'يوليو/يولية',
        'August'=>'أغسطس',
        'September'=>'سبتمبر',
        'October'=>'أكتوبر',
        'November'=>'نوفمبر',
        'December'=>'ديسمبر',
                'th'=>'',
                'st'=>'',
                'rd'=>''
            );
            if(array_key_exists($var, $t)){
                return $t[$var];
            }else{
                return $var;
            }
        }
    }
    
    function getMetaTags($id,$lang='en'){
        if($lang=='en'){
            $this->db->select('id, status, page_name, title, description, keywords');
        }else{
            $this->db->select('id, status, page_name,title_ar AS title, description_ar AS description, keywords_ar AS keywords');
        }
        
        $this->db->where('id',$id)->where('status',1);
        $q=$this->db->get('seo');
        if($q->num_rows()>0){
            return $q->row_Array();
        }
    }
    
    function setMetaTags($metaTags,$settings,$seo_settings,$lang='en'){
        $resultdata=array();
        $site_name=$country=$city=$distname=$cuisine=$best=$mytitle=$hotelstar=$count=$dateTitle=$author=$ingridient=$desc=$QUERY="";
        if($lang=='en'){
           $site_name=$settings['name']; 
           $country=$settings['country']; 
        }else{
           $site_name=$settings['nameAr'];  
           $country=$settings['countryAr']; 
        }
        
        if(isset($seo_settings['city'])){
            $city=$seo_settings['city'];
        }
        if(isset($seo_settings['distname'])){
            $distname=$seo_settings['distname'];
        }
        if(isset($seo_settings['cuisine'])){
            $cuisine=$seo_settings['cuisine'];
        }
        if(isset($seo_settings['best'])){
            $best=$seo_settings['best'];
        }
        
        if(isset($seo_settings['title'])){
            $mytitle=$seo_settings['title'];
        }
        
        if(isset($seo_settings['hotelstar'])){
            $hotelstar=$seo_settings['hotelstar'];
        }
        
        if(isset($seo_settings['count'])){
            $count=$seo_settings['count'];
        }
        
        if(isset($seo_settings['dateTitle'])){
            $dateTitle=$seo_settings['dateTitle'];
        }
        
        if(isset($seo_settings['author'])){
            $author=$seo_settings['author'];
        }
        
        if(isset($seo_settings['ingridient'])){
            $ingridient=$seo_settings['ingridient'];
        }
        
        if(isset($seo_settings['desc'])){
            $desc=$seo_settings['desc'];
        }
        if(isset($seo_settings['QUERY'])){
            $QUERY=$seo_settings['QUERY'];
        }
        
        if(empty($distname)&& !empty($city)){
            $city=" ".$city;
        }
        if(!empty($distname)){
            $distname=" ".$distname;
        }
        $title=$metaTags['title'];
        $title=str_replace("@CITY@", $city, $title);
        $title=str_replace("@DISTRICT@", $distname, $title);
        $title=str_replace("@COUNTRY@", $country, $title);
        $title=str_replace("@CUISINE@", $cuisine, $title);
        $title=str_replace("@BEST@", $best, $title);
        $title=str_replace("@TITLE@", $mytitle, $title);
        $title=str_replace("@STAR@", $hotelstar, $title);
        $title=str_replace("COUNT@", $count, $title);
        $title=str_replace("@INGR@", $ingridient, $title);
        $title=str_replace("@DATE@", $dateTitle, $title);
        $title=str_replace("@AUTHOR@", $author, $title);
        $resultdata['title']=$title.$QUERY.' | '.$site_name;
        $description=$metaTags['description'];
        $description=str_replace("@CITY@", $city, $description);
        $description=str_replace("@DISTRICT@", $distname, $description);
        $description=str_replace("@COUNTRY@", $country, $description);
        $description=str_replace("@CUISINE@", $cuisine, $description);
        $description=str_replace("@BEST@", $best, $description);
        $description=str_replace("@TITLE@", $mytitle, $description);
        $description=str_replace("@STAR@", $hotelstar, $description);
        $description=str_replace("@COUNT@", $count, $description);
        $description=str_replace("@INGR@", $ingridient, $description);
        $description=str_replace("@DATE@", $dateTitle, $description);
        $description=str_replace("@AUTHOR@", $author, $description);
        $resultdata['metadesc']=$description.' '.$desc;
        $keywords=$metaTags['keywords'];
        $keywords=str_replace("@CITY@", $city, $keywords);
        $keywords=str_replace("@DISTRICT@", $distname, $keywords);
        $keywords=str_replace("@COUNTRY@", $country, $keywords);
        $keywords=str_replace("@TITLE@", $mytitle, $keywords);
        $keywords=str_replace("@STAR@", $hotelstar, $keywords);
        $keywords=str_replace("@COUNT@", $count, $keywords);
        $keywords=str_replace("@INGR@", $ingridient, $keywords);
        $keywords=str_replace("@DATE@", $dateTitle, $keywords);
        $keywords=str_replace("@AUTHOR@", $author, $keywords);
        $resultdata['metakeywords']=$keywords;
        return $resultdata;
    }
    
    
    
    function readUserRating($id=0){
        $data=array(
            'is_read'=>1
        );
        $this->db->where('rating_ID',$id);
        $this->db->update('rating_info',$data);
    }
    
    function readUser($id=0){
        $userdb = $this->load->database('user', TRUE);
        $data=array(
            'is_read'=>1
        );
        $userdb->where('user_ID',$id);
        $userdb->update('user',$data);
    }
    
    public function updateAccountDetails($restid){
        $data=array();
        $data['date_upd'] = date('Y-m-d H:i:s',now());
        $data['sub_detail'] = "1,2,3,6";
        $data['accountType'] = 0;
        
        $this->db->where('rest_ID', $restid);
        $this->db->update('subscription', $data);
    }
    
    public function updateAccountDuration($restid){
        $data=array();
        $data['rest_Subscription'] = 0; //Free Subscription
        $data['member_duration'] = 0;
        $this->db->where('rest_ID', $restid);
        $true = $this->db->update('restaurant_info', $data); 
    }
    
    function addMemberDeatilsLog($rest_ID){
        //$rest_ID=$this->input->post('rest_ID');
        $this->db->where('rest_ID',  $rest_ID);        
        $q=$this->db->get('subscription');
        if($q->num_rows()>0){
            $old_data=$q->row_Array();
            $reference='';
            $this->db->where('rest_ID',  $rest_ID);
            $resQ=$this->db->get('booking_management');
            if($resQ->num_rows()>0){
                $rest_data=$q->row_Array();
                $reference=$rest_data['referenceNo'];
            }
            $logdata = array(         
                'accountType'=>$old_data['accountType'],
                'rest_ID'=>$old_data['rest_ID'],
                'sub_detail'=>$old_data['sub_detail'],
                'price'=>$old_data['price'],
                'referenceNo'=>$reference
            );
            $this->db->insert('subscription_log',$logdata);
        }
    }
    
    function deactivateMembership($restid=0){
        $data=array(
            'status'=>0,
            'date_upd'=>date('Y-m-d H:i:s',now())
        );
        $this->db->where('rest_ID', $restid);
        $this->db->update('booking_management', $data);
    }
    
    function getTotalActivity($id,$chk_date){
        $this->db->where('rest_ID',$id);
        $this->db->where('date_add >',$chk_date);
        return $this->db->count_all_results('rest_activity');
    }
    
    function getCityName($city=""){
        $this->db->select("city_Name,city_Name_ar");
        if($city!=""){
            $this->db->where('city_ID IN('.$city.')');
        }
        $q=$this->db->get('city_list');
        $return_data="";
        if($q->num_rows()>0){
            $data=$q->result_Array();
            if(is_array($data)){                
                foreach($data as $city){
                    if($return_data==""){
                        $return_data="'".$city['city_Name']."','".$city['city_Name_ar']."'";
                    }else{
                        $return_data.=",'".$city['city_Name']."','".$city['city_Name_ar']."'";
                    }
                }
            }
        }
        return $return_data;
    }
    function getTotalReviews($author){
        $this->db->where('author',$author)->where('status',1)->where('category',8);
        return $this->db->count_all_results('article');
    }
    
    
    function checkNewsletterExists($email){
        $this->db->where('email',$email);
        $count=  $this->db->count_all_results('subscribers');
        if($count>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function checkEmail($email){
        $isValid = true;
         $atIndex = strrpos($email, "@");
         if (is_bool($atIndex) && !$atIndex){
              $isValid = false;
         }else{
              $domain = substr($email, $atIndex+1);
              $local = substr($email, 0, $atIndex);
              $localLen = strlen($local);
              $domainLen = strlen($domain);
              if ($localLen < 1 || $localLen > 64){
                 // local part length exceeded
                 $isValid = false;
              }
              else if ($domainLen < 1 || $domainLen > 255){
                 // domain part length exceeded
                 $isValid = false;
              }
              else if ($local[0] == '.' || $local[$localLen-1] == '.'){
                 $isValid = false;
              }
              else if (preg_match('/\\.\\./', $local)){
                 // local part has two consecutive dots
                 $isValid = false;
              }
              else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
                 // character not valid in domain part
                 $isValid = false;
              }
              else if (preg_match('/\\.\\./', $domain)){
                 // domain part has two consecutive dots
                 $isValid = false;
              }
              else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',str_replace("\\\\","",$local))){
                 // character not valid in local part unless 
                 // local part is quoted
                 if (!preg_match('/^"(\\\\"|[^"])+"$/',str_replace("\\\\","",$local))){
                    $isValid = false;
                 }
              }
//              if ($isValid && !(checkdnsrr($domain,"MX") ||checkdnsrr($domain,"A"))){
//                 // domain not found in DNS
//                 $isValid = false;
//              }
        }
        return $isValid;
    }
    
    function closetags($html) {
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    } 
    
    
    function uniord($u) {
        // i just copied this function fron the php.net comments, but it should work fine!
        $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
    }
    
    function isArabic($str) {
        if(mb_detect_encoding($str) !== 'UTF-8') {
            $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
        }

        /*
        $str = str_split($str); <- this function is not mb safe, it splits by bytes, not characters. we cannot use it
        $str = preg_split('//u',$str); <- this function woulrd probably work fine but there was a bug reported in some php version so it pslits by bytes and not chars as well
        */
        preg_match_all('/.|\n/u', $str, $matches);
        $chars = $matches[0];
        $arabic_count = 0;
        $latin_count = 0;
        $total_count = 0;
        foreach($chars as $char) {
            //$pos = ord($char); we cant use that, its not binary safe 
            $pos = $this->uniord($char);
           // echo $char ." --> ".$pos.PHP_EOL;

            if($pos >= 1536 && $pos <= 1791) {
                $arabic_count++;
            } else if($pos > 123 && $pos < 123) {
                $latin_count++;
            }
            $total_count++;
        }
        if(($arabic_count/$total_count) > 0.6) {
            // 60% arabic chars, its probably arabic
            return true;
        }
        return false;
    }
    
    
    function checkSpam($author,$email,$comment){
        if($this->akismet->verify()){
                if($this->akismet->check($author, $email, $comment, $url = FALSE)){
                    return true;
                }else{
                    return false;
                }
            }else{
                 $stopwords=array('http://','</a>','viagra','Viagra','erection','Erection','VIAGRA','penis','href','Penis','PENIS','fuck','ass','FUCK');
                 foreach($stopwords as $stopword){
                    if(strpos( $comment,$stopword)!== FALSE){
                         return true;
                    }
                }
                return false;
            }
    }
    
    function expiry_notified($restid = 0, $status = 0) {
        $data = array(
            'expiry_notified' => $status
        );
        $this->db->where('rest_ID', $restid);
        $this->db->update('restaurant_info', $data);
    }

    function getAllMasterCuisine($status = 0, $limit = 0, $offset = "") {
        $this->db->distinct();
        $this->db->select('master_cuisine.*');
        if ($status != 0) {
            $this->db->where('master_cuisine.status', 1);
        }
        $this->db->order_by('master_cuisine.name');
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }
        $q = $this->db->get('master_cuisine');
        if ($q->num_rows() > 0) {
            return $q->result_Array();
        }
    }

    function getAllSubCuisine($city=0,$master=0) {        
        $this->db->select('cuisine_list.cuisine_Name,cuisine_list.cuisine_Name_ar, cuisine_list.cuisine_ID,cuisine_list.seo_url, (SELECT COUNT(*) FROM restaurant_cuisine JOIN restaurant_info ON restaurant_info.rest_ID=restaurant_cuisine.rest_ID AND restaurant_info.rest_Status=1  WHERE restaurant_cuisine.cuisine_ID=cuisine_list.cuisine_ID ) as totalrestaurants');
        $this->db->where('cuisine_list.cuisine_Status',1);
        $this->db->where('cuisine_list.master_id',$master);
        if($city!=0){
            $this->db->join('restaurant_cuisine','restaurant_cuisine.cuisine_ID=cuisine_list.cuisine_ID');
            $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_cuisine.rest_ID AND rest_branches.city_ID='.$city);            
        }
        $this->db->order_by('cuisine_list.cuisine_Name','ASC');
        $this->db->group_by('cuisine_list.cuisine_ID');
        $QQ = $this->db->get('cuisine_list');
        if ($QQ->num_rows() > 0) {
            return $QQ->result_Array();
        }
    }
    
    function getTotalRestByCuisine($cuisine="",$city=0,$master=0){
        if($master!=0){
            $this->db->join('restaurant_info','restaurant_info.rest_ID=restaurant_cuisine.rest_ID AND restaurant_info.rest_Status=1');
            $this->db->join('cuisine_list','cuisine_list.cuisine_ID=restaurant_cuisine.cuisine_ID AND cuisine_list.cuisine_Status=1 AND cuisine_list.master_id='.$master);
            if($city!=0){
                $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_cuisine.rest_ID AND rest_branches.city_ID ='.$city);
                $this->db->group_by('rest_branches.rest_fk_id');
            }
            $q= $this->db->get('restaurant_cuisine');
            return $q->num_rows();
        }else{
            $this->db->join('restaurant_info','restaurant_info.rest_ID=restaurant_cuisine.rest_ID AND restaurant_info.rest_Status=1');
            if($city!=0){
                $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_cuisine.rest_ID AND rest_branches.city_ID ='.$city);
                $this->db->group_by('rest_branches.rest_fk_id');
            }
            $this->db->where('restaurant_cuisine.cuisine_ID',$cuisine);
            $this->db->where('restaurant_info.openning_manner !=',"Closed Down");            
            $q= $this->db->get('restaurant_cuisine');
            return $q->num_rows();
        }
    }
    
    
    function getNewMenu($city){
        $this->db->distinct();        
        if($city!=0){
            $this->db->where('menuall.city_ID',$city); 
        }
        $this->db->where('menuall.rest_Status',1);
        $this->db->order_by('menuall.enter_time','DESC');
        $this->db->group_by('menuall.rest_ID');
        $this->db->limit(7);
        $q=$this->db->get('menuall');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getPopularMenu($city){
        $this->db->distinct();        
        if($city!=0){
            $this->db->where('menuall.city_ID',$city); 
        }
        $this->db->where('menuall.rest_Status',1);
        $this->db->order_by('menuall.total_view','DESC');
        $this->db->group_by('menuall.rest_ID');
        $this->db->limit(7);
        $q=$this->db->get('menuall');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getPopularDishes($city){
        $this->db->select('restaurant_info.rest_Logo,restaurant_info.rest_ID,restaurant_info.rest_Name,restaurant_info.seo_url,restaurant_info.rest_Name_Ar,rest_menu.menu_item,rest_menu.menu_item_ar');
        $this->db->select('COUNT(*) as rank');
        $this->db->join('rest_menu','rest_menu.id=recommendmenu.menuID');
        $this->db->join('restaurant_info','restaurant_info.rest_ID=rest_menu.rest_fk_id');
        if($city!=0){
            $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID='.$city);
        }
        $this->db->group_by('recommendmenu.menuID');
        $this->db->order_by('rank','DESC');
        $this->db->limit(7);
        $q=  $this->db->get('recommendmenu');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    
    function getRecommendedPlaces($city=0){
        $this->db->distinct();
        $this->db->select('restaurant_info.rest_ID,restaurant_info.rest_Name,restaurant_info.rest_RegisDate,restaurant_info.sufrati_favourite,restaurant_info.rest_Name_Ar,restaurant_info.rest_Logo,restaurant_info.seo_url,restaurant_info.rest_Subscription,restaurant_info.rest_ID,restaurant_info.rest_type,restaurant_info.class_category,restaurant_info.price_range,restaurant_info.fav_desc');
        $this->db->where('restaurant_info.rest_Status',1)->where('restaurant_info.sufrati_favourite !=',0);
        if($city!=0){
            $this->db->join('rest_branches', 'rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID= '.$city,'inner');
        }
        $this->db->order_by('restaurant_info.rest_Subscription','DESC');
        $this->db->order_by('restaurant_info.sufrati_favourite','DESC');
        $this->db->limit(7);
        $q=$this->db->get('restaurant_info');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getAllFeaturedRestaurants($seatings="", $services="", $atmosphere="", $limit = "", $offset = "",$count=false,$city="", $district="", $cuisine="", $price="", $sort="latest",$best=""){
        $this->db->distinct();  
        $this->db->select('restaurant_info.rest_ID,  restaurant_info.rest_Name,  restaurant_info.rest_Name_Ar,  restaurant_info.rest_Logo,  restaurant_info.seo_url,      restaurant_info.rest_type,  restaurant_info.class_category,  restaurant_info.price_range,  rest_branches.br_id,  rest_branches.br_loc,  rest_branches.latitude,  rest_branches.longitude,rest_Subscription,rest_RegisDate,sufrati_favourite,openning_manner');
        
        $this->db->join('restaurant_info','restaurant_info.rest_ID=rest_branches.rest_fk_id');
        $this->db->where('rest_branches.status',1);        
        $this->db->where('restaurant_info.rest_Status',1);
        
        if($city!="" && !empty($city)){
            $this->db->where('rest_branches.city_ID',$city);
            $this->db->join('city_list','city_list.city_ID=rest_branches.city_ID');
            $this->db->select('city_list.city_Name,city_list.city_Name_ar,city_list.city_ID');
        }
        if($district!="" && !empty($district)){
            $this->db->where('rest_branches.district_ID',$district);
        }
        if($cuisine!="" && !empty($cuisine)){
            $this->db->join('restaurant_cuisine','restaurant_cuisine.rest_ID=restaurant_info.rest_ID AND restaurant_cuisine.cuisine_ID='.$cuisine);
        }        
        if($price!="" && !empty($price)){
            $this->db->like('restaurant_info.price_range',$price);
        }
        if($best!=""){
            $this->db->join('restaurant_bestfor','restaurant_bestfor.rest_ID=restaurant_info.rest_ID AND restaurant_bestfor.bestfor_ID = '.$best);
        }
        if($seatings!=""){
            $this->db->like('rest_branches.seating_rooms',$seatings);
        }
        if($services!=""){
            $this->db->like('rest_branches.features_services',$services);
        }
        if($atmosphere!=""){
            $this->db->like('rest_branches.mood_atmosphere',$atmosphere);
        }
        $this->db->order_by('restaurant_info.rest_Subscription','DESC');
        if($sort!=""){
            switch($sort){
                case 'name':
                    $this->db->order_by('restaurant_info.rest_Name','ASC');
                    break;
                case 'latest':
                    $this->db->order_by('restaurant_info.rest_RegisDate','DESC');
                    break;
                case 'popular':
                    $this->db->select('(SELECT COUNT(*) FROM likee_info WHERE likee_info.rest_ID=restaurant_info.rest_ID AND likee_info.status=1 AND comment_id IS NULL) as `like`');
                    $this->db->order_by('like','DESC');
                    break;
            }
        }
        
        if($limit!=""){
            $this->db->limit($limit, $offset);
        }        
        $this->db->group_by('restaurant_info.rest_ID');
        $q=$this->db->get('rest_branches');
        if($q->num_rows()>0){
            if($count){
                return $q->num_rows();
            }
            return $q->result_Array();            
        }
    }
    
    function getSuggestedPlaces($city=0,$limit=0,$lang='en'){
        $hour=date('G');
        switch(TRUE){
            case (5<=$hour)&&($hour<=11):
                $t['type']='breakfast';
                if($lang=="en"){
                    $t['meal']='Breakfast Places';
                    //$t['meal']='Iftar Places';
                }else{
                    $t['meal']='للفطور';
                    //$t['meal']='الافطار';
                }
                $this->db->where('breakfast',1)->where('rest_Status',1);
                //$this->db->where('iftar',1)->where('rest_Status',1);
                if($city!=0){
                    $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID='.$city);
                    $this->db->group_by('rest_branches.rest_fk_id');
                }
                if($limit!=0){
                    $this->db->limit($limit);
                }
                $q=  $this->db->get('restaurant_info');
                if($q->num_rows()>0){
                    $t['restaurants']= $q->result_Array();
                }
                return $t;
                break;
                
            case (11<=$hour)&&($hour<=16) :
                //$t['type']='breakfast';
                $t['type']='lunch';
                if($lang=="en"){
                    $t['meal']='Lunch Places';
                    //$t['meal']='Iftar Places';
                }else{
                    $t['meal']='غداء';
                    //$t['meal']='الافطار';
                }
                $this->db->where('lunch',1)->where('rest_Status',1);
                //$this->db->where('iftar',1)->where('rest_Status',1);
                if($city!=0){
                    $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID='.$city);
                    $this->db->group_by('rest_branches.rest_fk_id');
                }
                if($limit!=0){
                    $this->db->limit($limit);
                }
                $q=  $this->db->get('restaurant_info');
                if($q->num_rows()>0){
                    $t['restaurants']= $q->result_Array();
                }
                return $t;
                break;
            case (17<=$hour)&&($hour<22) :
                //$t['type']='breakfast';
                $t['type']='dinner';
                if($lang=="en"){
                    $t['meal']='Dinner Places';
                    //$t['meal']='Iftar Places';
                }else{
                    $t['meal']='عشاء';
                    //$t['meal']='الافطار';
                }
                $this->db->where('dinner',1)->where('rest_Status',1);
                //$this->db->where('iftar',1)->where('rest_Status',1);
                if($city!=0){
                    $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID='.$city);
                    $this->db->group_by('rest_branches.rest_fk_id');
                }
                if($limit!=0){
                    $this->db->limit($limit);
                }
                $q=  $this->db->get('restaurant_info');
                if($q->num_rows()>0){
                    $t['restaurants']= $q->result_Array();
                }
                return $t;
                break;
            case (22<=$hour)&&($hour<=5):
                //$t['type']='suhur';
                $t['type']='latenight';
                if($lang=="en"){
                    $t['meal']='LateNight Places';
                    //$t['meal']='Suhur Places';
                }else{
                    $t['meal']='اخر المساء';
                    //$t['meal']='السحور';
                }
                $this->db->where('latenight',1)->where('rest_Status',1);
                //$this->db->where('suhur',1)->where('rest_Status',1);
                if($city!=0){
                    $this->db->join('rest_branches','rest_branches.rest_fk_id=restaurant_info.rest_ID AND rest_branches.city_ID='.$city);
                    $this->db->group_by('rest_branches.rest_fk_id');
                }
                if($limit!=0){
                   $this->db->limit($limit);
                }
                $q=  $this->db->get('restaurant_info');
                if($q->num_rows()>0){
                    $t['restaurants']= $q->result_Array();
                }
                return $t;
                break;
        }
    }
     
    function getAllMainCategories($status=0){
        $this->db->select('categories.*,(SELECT count(*) FROM categories cat WHERE cat.parent=categories.id) as total');
        if($status!=0){
            $this->db->where('status',1);
            $this->db->select('(SELECT count(*) FROM categories WHERE categories.parent=categories.id) as `totalarticles`');
        }
        $this->db->where('parent',0);
        $this->db->order_by('name');
        $q=$this->db->get('categories');
        if($q->num_rows()>0){
            return $q->result_Array();
        }
    }
    
    function getRestaurantMasterCuisines($rest=0,$name=0,$lang="en"){
        $this->db->distinct();
        if($name==0){
            $this->db->select('master_cuisine.*');
        }else{
            $this->db->select('master_cuisine.name,master_cuisine.name_ar,master_cuisine.id');
        }
        $this->db->where('restaurant_cuisine.rest_ID',$rest);
        $this->db->join('cuisine_list','master_cuisine.id=cuisine_list.master_id');
        $this->db->join('restaurant_cuisine','cuisine_list.cuisine_ID=restaurant_cuisine.cuisine_ID AND cuisine_list.cuisine_Status=1');
        $this->db->order_by('master_cuisine.name','DESC');        
        $q=$this->db->get('master_cuisine');
        if($q->num_rows()>0){
            if($name==0){
                return $q->result_Array();
            }else{
                $cuisine="";
                $i=0;
                foreach($q->result_Array() as $row){
                    $i++;
                    if($lang=="en"){
                        $cuisine.=$row['name'];
                    }else{
                        $cuisine.=$row['name_ar'];
                    }
                    if($i!=$q->num_rows()){
                        $cuisine.=", ";
                    }
                }
                return $cuisine;
            }
        }
    }
    
    function getMemberDeatilsLog($rest_ID){        
        $this->db->where('subscription_log.rest_ID',  $rest_ID);        
        //$this->db->join('restaurant_info','restaurant_info.rest_ID=subscription_log.rest_ID');
        $q=$this->db->get('subscription_log');
        if($q->num_rows()>0){
            $old_data=$q->result_Array();
            return $old_data;
        }
        return '';
    }
    
    public function updateBookingManagement($restid){
        $bkdata=array(
            'date_upd'=>date('Y-m-d H:i:s',now()),
            'status'=>1
        );
        $this->db->where('rest_id', $restid);
        $true = $this->db->update('booking_management', $bkdata); 
    }



    function testSpam($string){
        
        $stopwords=array('http://','</a>','viagra','Viagra','erection','Erection','VIAGRA','penis','href','Penis','PENIS','fuck','ass','FUCK','***','vagina','abortion');
        

        foreach($stopwords as $stopword){
            if(strpos( $string,$stopword)!== FALSE){
            }
        }
        return false;
        
    }


    /**
     *  Generates a random string.
     *  @param        string          $chars        Chars that can be used.
     *  @param        int             $len          Length of the output string.
     *  string
     */
    function randCensor($chars, $len) {
        
        mt_srand(); // useful for < PHP4.2
        $lastChar = strlen($chars) - 1;
        $randOld = -1;
        $out = '';
        
        // create $len chars
        for ($i = $len; $i > 0; $i--) {
            // generate random char - it must be different from previously generated
            while (($randNew = mt_rand(0, $lastChar)) === $randOld) { }
            $randOld = $randNew;
            $out .= $chars[$randNew];
        }
        
        return $out;
        
    }


    /**
     *  Apply censorship to $string, replacing $badwords with $censorChar.
     *  @param        string          $string        String to be censored.
     *  @param        string[int]     $badwords      Array of badwords.
     *  @param        string          $censorChar    String which replaces bad words. If it's more than 1-char long,
     *                                               a random string will be generated from these chars. Default: '*'
     *  string[string]
     */
    function censorString($string, $badwords, $censorChar = '*') {  
                  
            $leet_replace = array();
            $leet_replace['a']= '(a|a\.|a\-|4|@|Á|á|À|Â|à|Â|â|Ä|ä|Ã|ã|Å|å|α|Δ|Λ|λ)';
            $leet_replace['b']= '(b|b\.|b\-|8|\|3|ß|Β|β)';
            $leet_replace['c']= '(c|c\.|c\-|Ç|ç|¢|€|<|\(|{|©)';
            $leet_replace['d']= '(d|d\.|d\-|&part;|\|\)|Þ|þ|Ð|ð)';
            $leet_replace['e']= '(e|e\.|e\-|3|€|È|è|É|é|Ê|ê|∑)';
            $leet_replace['f']= '(f|f\.|f\-|ƒ)';
            $leet_replace['g']= '(g|g\.|g\-|6|9)';
            $leet_replace['h']= '(h|h\.|h\-|Η)';
            $leet_replace['i']= '(i|i\.|i\-|!|\||\]\[|]|1|∫|Ì|Í|Î|Ï|ì|í|î|ï)';
            $leet_replace['j']= '(j|j\.|j\-)';
            $leet_replace['k']= '(k|k\.|k\-|Κ|κ)';
            $leet_replace['l']= '(l|1\.|l\-|!|\||\]\[|]|£|∫|Ì|Í|Î|Ï)';
            $leet_replace['m']= '(m|m\.|m\-)';
            $leet_replace['n']= '(n|n\.|n\-|η|Ν|Π)';
            $leet_replace['o']= '(o|o\.|o\-|0|Ο|ο|Φ|¤|°|ø)';
            $leet_replace['p']= '(p|p\.|p\-|ρ|Ρ|¶|þ)';
            $leet_replace['q']= '(q|q\.|q\-)';
            $leet_replace['r']= '(r|r\.|r\-|®)';
            $leet_replace['s']= '(s|s\.|s\-|5|\$|§)';
            $leet_replace['t']= '(t|t\.|t\-|Τ|τ)';
            $leet_replace['u']= '(u|u\.|u\-|υ|µ)';
            $leet_replace['v']= '(v|v\.|v\-|υ|ν)';
            $leet_replace['w']= '(w|w\.|w\-|ω|ψ|Ψ)';
            $leet_replace['x']= '(x|x\.|x\-|Χ|χ)';
            $leet_replace['y']= '(y|y\.|y\-|¥|γ|ÿ|ý|Ÿ|Ý)';
            $leet_replace['z']= '(z|z\.|z\-|Ζ)';
         
            $words = explode(" ", $string);
            
            // is $censorChar a single char?
            $isOneChar = (strlen($censorChar) === 1);
            
            for ($x=0; $x<count($badwords); $x++) {

                $replacement[$x] = $isOneChar
                    ? str_repeat($censorChar,strlen($badwords[$x]))
                    : randCensor($censorChar,strlen($badwords[$x]));
                
                $badwords[$x] =  '/'.str_ireplace(array_keys($leet_replace),array_values($leet_replace), $badwords[$x]).'/i';
            }
            
            $newstring = array();
            $newstring['orig'] = html_entity_decode($string);
            $newstring['clean'] =  preg_replace($badwords,$replacement, $newstring['orig']);    
            
            return $newstring;
               
    }
}