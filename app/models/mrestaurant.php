<?php
class MRestaurant extends Eloquent{
    protected $table = 'restaurant_info';

    public static function getRest($id=0,$min=FALSE,$nophone=false){
        if($min){
            if($nophone){
                return MRestaurant::select('rest_ID','rest_Name','rest_Logo','seo_url','rest_Name_Ar')->where('rest_ID',$id)->first();
            }else{
                $q="SELECT rest_ID, rest_Name, rest_Name_Ar,rest_Logo,seo_url, getRestaurantTel(rest_ID) as telephone FROM restaurant_info WHERE rest_ID=:restid ";
                $result=DB::select(DB::raw($q),array('restid'=>$id));
                return $result[0];
            }
        }else{
            return MRestaurant::where('rest_ID','=',$id)->first();
        }
    }

    function getAllSuggested($city="",$type="",$limit=0,$rest_Name="",$frontend=FALSE,$district=0,$cuisine=0,$bestfor=0,$feature=0,$price=0,$sort="name"){  
        $mRest = MRestaurant::select('*');            
        if($city!=""){
            $mRest->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            $mRest->where('rest_branches.city_ID','=',$city);
            if($district!=0){
                $mRest->where('rest_branches.district_ID','=',$district);
            }
            $mRest->groupBy('rest_branches.rest_fk_id');
        }

        if($type!=""){
            $mRest->where(''.$type.'','=',1);
        }else{
            $mRest->Where(
             function($mRest){
                $mRest->where('breakfast','=',1)->orWhere('lunch','=',1)->orWhere('dinner','=',1)->orWhere('latenight','=',1)->orWhere('iftar','=',1)->orWhere('suhur','=',1);
            });            
        }
        
        if($cuisine!=""){
            $mRest->join('restaurant_cuisine', 'restaurant_cuisine.rest_ID', '=', 'restaurant_info.rest_ID');
            $mRest->where('restaurant_cuisine.cuisine_ID','=',$cuisine);            
        }

        if($bestfor!=""){
            $mRest->join('restaurant_bestfor', 'restaurant_bestfor.rest_ID', '=', 'restaurant_info.rest_ID');
            $mRest->where('restaurant_bestfor.bestfor_ID','=',$bestfor);
        }

        if($price!=""){            
            $mRest->where('restaurant_info.price_range','=',$price);
        }

        if($rest_Name!=""){
            $mRest->Where('restaurant_info.rest_Name','LIKE',$rest_Name.'%'); 
        }

        if($sort!=""){
            switch($sort){
                case 'name':                    
                $mRest->orderBy('restaurant_info.rest_Name','DESC');
                break;
                case 'latest':                    
                $mRest->orderBy('restaurant_info.rest_RegisDate','DESC');
                break;
                case 'popular':                    
                $mRest->orderBy('restaurant_info.total_view','DESC');
                break;
                case 'favorite':                    
                $mRest->where('restaurant_info.sufrati_favourite','=',1);
                $mRest->orderBy('restaurant_info.rest_Name','DESC');                    
                break;
            }
        }
        $mRest->orderBy('restaurant_info.rest_Subscription','DESC');
        if($limit!=""){
         $lists = $mRest->paginate($limit);
         }else{        
            $lists = $mRest->paginate();
        }        
        if(count($lists)>0){
            return $lists;
        }
        return null;
    }
    public static function GetPriceRange($rest=0){
        return MRestaurant::select('rest_Name','price_range')->where('rest_ID',$rest)->first();
    }
    function suggestedType($id,$type){
        $check=1;
        $rest = MRestaurant::where('rest_ID', '=', $id)->first();
        if(count($rest)>0){
            $temp = array('breakfast' => $rest->breakfast , 'lunch' => $rest->lunch , 'dinner' => $rest->dinner , 'latenight' => $rest->latenight , 'iftar' => $rest->iftar , 'suhur' => $rest->suhur );            
            if($temp[$type]==1){
                $check=0;
            }else{
                $check=1;
            }
        }
        $data=array(
            $type=>$check
            );
        DB::table('restaurant_info')->where('rest_ID',$id)->update($data);
    }

    function updateFavoriteRest() {
        $data = array(
            'fav_desc' => htmlentities(input::get('fav_desc')),
            'fav_desc_ar' => (input::get('fav_desc_ar'))
        );
        DB::table('restaurant_info')->where('rest_ID',input::get('rest_ID'))->update($data);
    }

    function getAllFavourites($city="",$limit=0,$rest_Name=""){
        $mRest = MRestaurant::select('*');

        //$this->db->distinct();
        //$this->db->select('rest_ID as id, rest_Status as status,rest_Name,rest_Name_Ar,total_view');
        if($rest_Name!=""){
            $mRest->Where('restaurant_info.rest_Name','LIKE',$rest_Name.'%'); 
        }

        if($city!=""){
            $mRest->join('rest_branches', 'rest_branches.rest_fk_id', '=', 'restaurant_info.rest_ID');
            $mRest->where('rest_branches.city_ID','=',$city);        
        }

        $mRest->where('restaurant_info.sufrati_favourite','!=',0);        
        
        $mRest->orderBy('restaurant_info.rest_Subscription','DESC');
        $mRest->orderBy('restaurant_info.sufrati_favourite','DESC');
        if($limit!=""){
         $lists = $mRest->paginate($limit);
         }else{        
            $lists = $mRest->get();
        }        
        if(count($lists)>0){
            return $lists;
        }
        return null;
    }

    function removeFavorite($id){
        $data=array(
            'sufrati_favourite'=>0
        );
        DB::table('restaurant_info')->where('rest_ID',$id)->update($data);
    }



    //From Fasil 

    public static function getRestMin($id=0){
         return MRestaurant::select('rest_Name','rest_Name_Ar','seo_url','rest_Logo')->where('rest_ID',$id)->first();
    }
 

    function getCoverPhoto($rest=0){
        $query="SELECT title,title_ar,image_full FROM image_gallery WHERE status=1 AND is_featured=1 AND rest_ID=".$rest.' LIMIT 1';
        $cover= DB::select($query);
        if(count($cover)>0){
            return $cover;
        }else{
            $query="SELECT title,title_ar,image_full FROM image_gallery WHERE status=1 AND rest_ID=".$rest." ORDER BY width DESC LIMIT 1";
            return DB::select($query);
        }
    }
    public static function getCoverPhotoStatic($rest=0){
        $query="SELECT title,title_ar,image_full FROM image_gallery WHERE status=1 AND is_featured=1 AND rest_ID=".$rest.' LIMIT 1';
        $cover= DB::select($query);
        if(count($cover)>0){
            return $cover;
        }else{
            $query="SELECT title,title_ar,image_full FROM image_gallery WHERE status=1 AND rest_ID=".$rest." ORDER BY width DESC LIMIT 1";
            return DB::select($query);
        }
    }
    public static  function getRestTypestatic($type=0){
        $query="SELECT GROUP_CONCAT(name) AS name, GROUP_CONCAT(nameAr) AS nameAr FROM rest_type WHERE status=1 AND id IN ('.$type.')"; 
        return DB::select($query);
    }

    function getRestType($type=0){
        $query="SELECT GROUP_CONCAT(name) AS name, GROUP_CONCAT(nameAr) AS nameAr FROM rest_type WHERE status=1 AND id IN ('.$type.')"; 
        return DB::select($query);
    }

    function getRestaurantLikeInfo($rest=0){
        $query="SELECT count(*) as total,sum(CASE WHEN status=1 then 1 else 0 end) as likers FROM likee_info WHERE rest_ID=".$rest;
        return DB::select($query);   
    }
    public static function getRestaurantLikeInfostatic($rest=0){
        $query="SELECT count(*) as total,sum(CASE WHEN status=1 then 1 else 0 end) as likers FROM likee_info WHERE rest_ID=".$rest;
        return DB::select($query);   
    }

    function getRestaurantCuisines($rest=0){
        $query = "SELECT cl.cuisine_Name,cl.cuisine_Name_ar,cl.cuisine_ID, cl.seo_url FROM cuisine_list cl JOIN restaurant_cuisine rc ON rc.cuisine_ID = cl.cuisine_ID AND rc.rest_ID=:restid WHERE cl.cuisine_Status=1";
        return DB::select(DB::raw($query),array('restid'=>$rest));
    }

    function getRestaurantFamousFor($rest=0){
        $query = "SELECT bl.bestfor_Name,bl.bestfor_Name_ar,bl.bestfor_ID, bl.seo_url FROM bestfor_list bl JOIN restaurant_bestfor rb ON rb.bestfor_ID = bl.bestfor_ID AND rb.rest_ID=:restid WHERE bl.bestfor_Status=1";
        return DB::select(DB::raw($query),array('restid'=>$rest));
    }

    function getLikedPeople($rest=0,$limit=0){
        $query="SELECT user.user_ID,user.user_FullName,user.user_NickName,user.image FROM likee_info JOIN user ON user.user_ID =likee_info.user_ID AND user.user_Status=1 WHERE likee_info.status=1 AND likee_info.rest_ID=".$rest;
        if($limit!=0){
            $query.=' LIMIT '.$limit;
        }
        return DB::select($query);
    }

    function getMostAgreedComment($rest=0){
        $query="SELECT r.review_ID,r.review_Msg,us.user_ID,us.user_NickName,us.user_FullName,us.image,(SELECT COUNT(*) FROM likee_info li WHERE li.comment_id=r.review_ID AND li.status=1 ) as total,ri.rating_Food,ri.rating_Service,ri.rating_Atmosphere,ri.rating_Value,ri.rating_Variety,ri.rating_Presentation FROM review as r JOIN user us ON us.user_ID=r.user_ID AND us.user_Status=1 JOIN rating_info ri ON ri.rest_ID=r.rest_ID AND ri.user_ID = r.user_ID  WHERE r.review_Status=1 AND r.rest_ID=".$rest." ORDER BY total DESC LIMIT 1";
        return DB::select($query);
    }

    public static function getRatingInfo($rest=0){
        $query="SELECT COUNT(*) as total,sum(rating_Food) as totalfood,SUM(rating_Service) as totalservice,SUM(rating_Atmosphere) as totalatmosphere,SUM(rating_Value) as totalvalue,SUM(rating_Variety) as totalvariety,SUM(rating_Presentation) as totalpresentation FROM rating_info WHERE rest_ID=".$rest;
        return DB::select($query);
    }

    function getRestaurantBranches($rest=0,$city=0){
        $query="SELECT rb.br_loc,rb.br_loc_ar,rb.br_number,rb.br_mobile,rb.br_toll_free,rb.branch_type,rb.latitude,rb.longitude,rb.br_id,rb.url,dl.district_Name,dl.district_Name_ar,cl.city_Name,cl.city_Name_ar FROM rest_branches rb JOIN district_list dl ON dl.district_ID=rb.district_ID  JOIN city_list cl ON cl.city_ID=rb.city_ID AND cl.city_Status=1 WHERE rb.rest_fk_id=".$rest." AND rb.status=1";
        if($city!=0){
            $query.=" AND rb.city_ID=".$city;
        }
        return DB::select($query);
    }
    public static function getRestaurantBranch($branch=0){
        $query="SELECT rb.*,dl.district_Name,dl.district_Name_ar,cl.city_Name,cl.city_Name_ar FROM rest_branches rb JOIN district_list dl ON dl.district_ID=rb.district_ID AND dl.district_Status=1 JOIN city_list cl ON cl.city_ID=rb.city_ID AND cl.city_Status=1 WHERE rb.url=:branch AND rb.status=1";
        return DB::select(DB::raw($query),array('branch'=>$branch));
    }

    function getOpenHours($rest=0){
        $query="SELECT * FROM open_hours WHERE rest_ID=".$rest;
        return DB::select($query);   
    }

    function checkLiked($rest=0,$user=0){
        return DB::table('likee_info')->where('rest_ID',$rest)->where('user_ID',$user)->first();
    }

    function getFeautures($rest=0){
        $query="SELECT features_services,mood_atmosphere,seating_rooms FROM rest_branches WHERE rest_fk_id=".$rest;
        $results=DB::select($query);
        $features=array();
        if(count($results)>0){
            $fetarray=explode(',', $results[0]->features_services);
            $moodarray=explode(',', $results[0]->mood_atmosphere);
            $seatarray=explode(',', $results[0]->seating_rooms);
            $features=array_merge($fetarray,$moodarray,$seatarray);
            $features=array_unique($features);
        }
        $featuresmain=array(
            'indoor'=>array(
                'name'=>'Indoor',
                'presenten'=>'Indoor Seatings Available',
                'presentar'=>'الجلوس في الأماكن المغلقة متاح',
                'notpresenten'=>'Indoor Seatings Not Available',
                'notpresentar'=>'الجلوس في الأماكن المغلقة غير متوفرة'
            ),
            'buffet'=>array(
                'name'=>'Buffet',
                'presenten'=>'Buffet Available',
                'presentar'=>'متوفر بوفيه',
                'notpresenten'=>'Buffet Not Available',
                'notpresentar'=>'بوفيه غير متوفر'
            ),
            'busy'=>array(
                'name'=>'Busy',
                'presenten'=>'Busy Atmosphere',
                'presentar'=>'مشغول جو',
                'notpresenten'=>'Not Busy Atmosphere',
                'notpresentar'=>'غير مشغول جو'
            ),
            'outdoor'=>array(
                'name'=>'Outdoor',
                'presenten'=>'Outdoor Seatings Available',
                'presentar'=>'في الهواء الطلق الجلوس متاح',
                'notpresenten'=>'Outdoor Seatings Not Available',
                'notpresentar'=>'الجلوس في الهواء الطلق لا تتوفر'
            ),
            'takeaway'=>array(
                'name'=>'Takeaway',
                'presenten'=>'Takeaway Available',
                'presentar'=>'تتوفر الوجبات الجاهزة',
                'notpresenten'=>'Takeaway Not Available',
                'notpresentar'=>'الوجبات الجاهزة غير متوفر'
            ),
            'quiet'=>array(
                'name'=>'Quiet',
                'presenten'=>'Quiet Atmosphere',
                'presentar'=>'الجو تماما',
                'notpresenten'=>'Not Quiet Atmosphere',
                'notpresentar'=>'ليس تماما الجو'
            ),
            'single_section'=>array(
                'name'=>'Single Section',
                'presenten'=>'Single Section Available',
                'presentar'=>'وحيد متاح القسم',
                'notpresenten'=>'Single Section Not Available',
                'notpresentar'=>'واحد قسم متوفر'
            ),
            'delivery'=>array(
                'name'=>'Delivery',
                'presenten'=>'Delivery Available',
                'presentar'=>'متاح تسليم',
                'notpresenten'=>'Delivery Not Available',
                'notpresentar'=>'تسليم غير متوفر'
            ),
            'romantic'=>array(
                'name'=>'Romantic',
                'presenten'=>'Romantic Atmosphere',
                'presentar'=>'الجو الرومانسي',
                'notpresenten'=>'Not Romantic Atmosphere',
                'notpresentar'=>'ليس جو رومانسي'
            ),
            'family_section'=>array(
                'name'=>'Family Section',
                'presenten'=>'Family Section Available',
                'presentar'=>'القسم المخصص للعائلات متاح',
                'notpresenten'=>'Family Section Not Available',
                'notpresentar'=>'القسم المخصص للعائلات غير متوفر'
            ),
            'catering_services'=>array(
                'name'=>'Catering Services',
                'presenten'=>'Catering Services Available',
                'presentar'=>'تقديم الخدمات المتاحة',
                'notpresenten'=>'Catering Services Not Available',
                'notpresentar'=>'تقديم الخدمات غير متوفرة'
            ),
            'young_crowd'=>array(
                'name'=>'Young Crowd',
                'presenten'=>'Young Crowd Atmosphere',
                'presentar'=>'الشباب حشد الجو',
                'notpresenten'=>'Not Young Crowd Atmosphere',
                'notpresentar'=>'ليس جو حشد الشباب'
            ),
            'private_room'=>array(
                'name'=>'Private Room',
                'presenten'=>'Private Room Available',
                'presentar'=>'خاصة غرفة متاحة',
                'notpresenten'=>'Private Room Not Available',
                'notpresentar'=>'غرفة خاصة غير متوفرة'
            ),
            'drive_through'=>array(
                'name'=>'Drive Through',
                'presenten'=>'Drive Through Available',
                'presentar'=>'من خلال دفع متاح',
                'notpresenten'=>'Drive Through Not Available',
                'notpresentar'=>'من خلال حملة غير متوفر'
            ),
            'trendy'=>array(
                'name'=>'Trendy',
                'presenten'=>'Trendy Atmosphere',
                'presentar'=>'العصرية الجو',
                'notpresenten'=>'Not Trendy Atmosphere',
                'notpresentar'=>'يس جو عصري'
            ),
            'wheel_chair_accessibility'=>array(
                'name'=>'Wheel Chair Accessibility',
                'presenten'=>'Wheel Chair Accessibility Available',
                'presentar'=>'متاح على كرسي متحرك',
                'notpresenten'=>'Wheel Chair Accessibility Not Available',
                'notpresentar'=>'متوفر على كرسي متحرك'
            ),
            'valet_parking'=>array(
                'name'=>'Valet Parking',
                'presenten'=>'Valet Parking Available',
                'presentar'=>'خدمة صف السيارات متاح',
                'notpresenten'=>'Valet Parking Not Available',
                'notpresentar'=>'خدمة صف السيارات غير متوفر'
            ),
            'tv_screens'=>array(
                'name'=>'TV Screens',
                'presenten'=>'TV Screens Available',
                'presentar'=>'شاشة التلفزيون متاح',
                'notpresenten'=>'TV Screens Not Available',
                'notpresentar'=>'شاشة التلفزيون غير متوفر'
            ),
            'smoking'=>array(
                'name'=>'Smoking',
                'presenten'=>'Smoking Allowed',
                'presentar'=>'التدخين مسموح',
                'notpresenten'=>'Smoking Not Allowed',
                'notpresentar'=>'التدخين غير مسموح'
            ),
            'business_facilities'=>array(
                'name'=>'Business Facilities',
                'presenten'=>'Business Facilities Available',
                'presentar'=>'التسهيلات التجارية المتاحة',
                'notpresenten'=>'Business Facilities Not Available',
                'notpresentar'=>'مرافق تجارية غير متوفرة'
            ),
            'sheesha'=>array(
                'name'=>'Sheesha',
                'presenten'=>'Sheesha Available',
                'presentar'=>'الشيشة متوفرة',
                'notpresenten'=>'Sheesha Not Available',
                'notpresentar'=>'الشيشة غير متوفرة'
            ),
            'non_smoking'=>array(
                'name'=>'Non Smoking',
                'presenten'=>'Non Smoking Environment',
                'presentar'=>'سمح لغير المدخنين',
                'notpresenten'=>'Smoking Allowed',
                'notpresentar'=>'لغير المدخنين غير مسموح'
            ),
            'wifi'=>array(
                'name'=>'Wifi',
                'presenten'=>'Wifi Available',
                'presentar'=>'متوفر واي فاي',
                'notpresenten'=>'Wifi Not Available',
                'notpresentar'=>'واي فاي متوفر'
            ),
            'child_friendly'=>array(
                'name'=>'Child Friendly',
                'presenten'=>'Child Friendly Environment',
                'presentar'=>'بيئة صديقة للطفل',
                'notpresenten'=>'Not Very Child Friendly',
                'notpresentar'=>'ليس جدا صديقة للطفل'
            ),
        );
        return array('mainfeatures'=>$featuresmain,'restaurantfeatures'=>$features);
    }


    function getRestaurantMiniGallery($rest=0,$city=0){
        $q="SELECT ig.image_full,ig.title,ig.title_ar,ig.image_ID,ig.user_ID,ig.enter_time ,(SELECT COUNT(id) FROM photolike WHERE image_ID=ig.image_ID) as likes FROM image_gallery ig JOIN restaurant_info ri ON ri.rest_ID=ig.rest_ID AND ri.rest_Status=1 WHERE ig.status=1 AND ig.rest_ID=".$rest." ORDER BY enter_time DESC LIMIT 4";
        return DB::select($q);
    }

    public static function getListsWithRestaurant($rest=0,$full=false){
        $q="SELECT ul.name,ul.user_ID,u.user_NickName,u.user_FullName,u.image FROM  user_lists ul JOIN user_list_restaurant ulr ON ulr.list_id=ul.id AND ulr.rest_ID=:restid JOIN user u ON u.user_ID=ul.user_ID AND u.user_Status=1 ";
        if(!$full){
            $q.=" LIMIT 3 ";
        }
        return DB::select(DB::raw($q),array('restid'=>$rest));
    }

    function getEMenu($rest=0){
        $menu=array();
        $q="SELECT menu_name,menu_name_ar,menu_id FROM menu WHERE rest_ID=:restid ORDER BY createdAt DESC";
        $menus=DB::select(DB::raw($q),array('restid'=>$rest));
        if(count($menus)>0){
            foreach ($menus as $menutype) {
                $i=0;
                $q="SELECT cat_name,cat_name_ar,cat_id FROM menu_cat WHERE rest_ID=:restid AND menu_id=:menuid ORDER BY listOrder ASC";
                $menucats= DB::select(DB::raw($q),array('restid'=>$rest,'menuid'=>$menutype->menu_id));
                $menu[$i]=array(
                    'menu_name'=>$menutype->menu_name,
                    'menu_name_ar'=>$menutype->menu_name_ar,
                    'menu_id'=>$menutype->menu_id
                );
                $categories=array();
                if(count($menucats)>0){
                    $k=0;
                    foreach ($menucats as $cat) {
                        $q="SELECT menu_item,menu_item_ar,id,description,descriptionAr,image,price,(SELECT COUNT(id) FROM recommendmenu WHERE menuID=rest_menu.id) as recommend FROM rest_menu WHERE rest_fk_id=:restid AND cat_id=:catid";
                        $items= DB::select(DB::raw($q),array('restid'=>$rest,'catid'=>$cat->cat_id));
                        $categories[$k]=array(
                            'cat_name'=>$cat->cat_name,
                            'cat_name_ar'=>$cat->cat_name_ar,
                            'cat_id'=>$cat->cat_id,
                            'items'=>$items
                        );
                        $k++;
                    }
                }
                $menu[$i]['categories']=$categories;
            }
        }else{
            $menu=array();
            $tmenu[0]=array(
                'menu_name'=>'E-Menu',
                'menu_name_ar'=>'القائمة الإلكترونية',
                'menu_id'=>0,
            );
            $q="SELECT cat_name,cat_name_ar,cat_id FROM menu_cat WHERE rest_ID=:restid ORDER BY listOrder ASC";
            $menucats= DB::select(DB::raw($q),array('restid'=>$rest));
            $categories=array();
            if(count($menucats)>0){
                $k=0;
                foreach ($menucats as $cat) {
                    $q="SELECT menu_item,menu_item_ar,id,description,descriptionAr,image,price,(SELECT COUNT(id) FROM recommendmenu WHERE menuID=rest_menu.id) as recommend FROM rest_menu WHERE rest_fk_id=:restid AND cat_id=:catid";
                    $items= DB::select(DB::raw($q),array('restid'=>$rest,'catid'=>$cat->cat_id));
                    $categories[$k]=array(
                        'cat_name'=>$cat->cat_name,
                        'cat_name_ar'=>$cat->cat_name_ar,
                        'cat_id'=>$cat->cat_id,
                        'items'=>$items
                    );
                    $k++;
                }
                $tmenu[0]['categories']=$categories;
                $menu=$tmenu;
            }
        }
        return $menu;
    }


    public function getPDFMenu($rest=0){
        $q="SELECT menu,title,title_ar,menu_ar,pagenumber,pagenumberAr,id FROM rest_menu_pdf WHERE rest_ID=:restid AND status=1";
        return DB::select(DB::raw($q),array('restid'=>$rest));
    }

    public function getVideos($rest=0){
        $q="SELECT id,name_en,name_ar,video_en,video_ar,youtube_en,youtube_ar FROM rest_video WHERE rest_ID=:restid AND status=1";
        return DB::select(DB::raw($q),array('restid'=>$rest));
    }

    public function getPhotos($rest=0,$user=0){
        $q="SELECT image_ID,title,title_ar,image_full,width,ratio,enter_time,user_ID,(SELECT COUNT(id) FROM photolike WHERE image_ID=image_gallery.image_ID) as likes FROM image_gallery WHERE rest_ID=:restid AND status=1 ";
        if($user==0){
            $q.=" AND user_ID IS NULL";
        }else{
            $q.=" AND user_ID IS NOT NULL";
        }
        $q.=" ORDER BY enter_time DESC";
        return DB::select(DB::raw($q),array('restid'=>$rest));
    }


    public static function checkMember($rest=0){
        return DB::table('booking_management')->where('rest_id',$rest)->where('status',1)->count();
    }


    public static function getReviews($rest=0,$city=0,$limit=0,$offset=0){
        $q="SELECT r.review_ID,r.user_ID,r.review_Msg,r.review_Date,r.recommend,r.orderType,u.user_FullName,u.user_NickName,u.image,u.user_Status,(SELECT COUNT(id) FROM likee_info WHERE likee_info.comment_id=r.review_ID) as upvotes, (SELECT COUNT(review_ID) FROM review WHERE user_ID=r.user_ID AND review_Status=1 ) as totalreviews, (SELECT count(rating_ID) FROM rating_info WHERE user_ID=r.user_ID) as totalratings,(SELECT CONCAT(rating_Food,':',rating_Presentation,':',rating_Variety,':',rating_Value,':',rating_Atmosphere,':',rating_Service) FROM rating_info WHERE rest_ID=".$rest." AND user_ID=r.user_ID LIMIT 1 ) as userrating FROM review r JOIN user u ON u.user_ID=r.user_ID WHERE r.review_Status=1 AND r.rest_ID=:restid AND (r.city_ID=:city OR r.city_ID=0) ORDER BY r.review_Date DESC LIMIT ".$offset.", ".$limit;
        return DB::select(DB::raw($q),array('restid'=>$rest,'city'=>$city));
    }

    public static function getReview($review=0,$full=false){
        return DB::table('review')->where('review_ID',$review)->first();
    }

    public static function getTotalReviews($rest=0,$city=0){
        return DB::table('review')->where('rest_ID',$rest)->where(function ($query) use ($city){ $query->where('city_ID','=',$city)->orWhere('city_ID','=',0); })->where('review_Status',1)->count();
    }

    public function getCriticReviews($rest=0){
        $q="SELECT author,authorAr,description,descriptionAr,url,name,nameAr FROM article WHERE rest_ID=:restid AND status=1";
        return DB::select(DB::raw($q),array('restid'=>$rest));
    }

    public static function getMenuItem($id=0){
        return DB::select(DB::raw('SELECT * FROM rest_menu WHERE id=:id'),array('id'=>$id));
    }

    public static function getMenuItemRecommendations($id=0){
        return DB::select(DB::raw('SELECT COUNT(id) as recommend FROM recommendmenu WHERE menuID=:id'),array('id'=>$id));
    }

    public function getMenuCategory($id=0){
        return DB::table('menu_cat')->where('id',$id)->first();
    }
    public static function getTotalCommentAgree($comment=0){
        $q='SELECT COUNT(id) as total FROM likee_info WHERE comment_id=:comment AND status=1';
        return DB::select(DB::raw($q),array('comment'=>$comment));
    }

    public static function getPopularDishes($rest=0){
        $q="SELECT DISTINCT rm.id, rm.menu_item,rm.menu_item_ar,mc.cat_name,mc.cat_name_ar,rm.cat_id, (SELECT COUNT(id) FROM recommendmenu WHERE recommendmenu.menuID=rm.id) as count FROM rest_menu rm JOIN menu_cat mc ON mc.cat_id=rm.cat_id JOIN recommendmenu rcm ON rcm.menuID=rm.id WHERE rm.rest_fk_id=:restid AND (SELECT COUNT(id) FROM recommendmenu WHERE recommendmenu.menuID=rm.id) >0 ORDER BY count DESC LIMIT 5";
        return DB::select(DB::raw($q),array('restid'=>$rest));
    }


    public static function getPossiblePDFMenu($activity=0,$rest=0,$time=0,$updated=false){
        if($activity!=0){
            return DB::table('rest_menu_pdf')->where('id',$activity)->first();
        }else{
            if($updated){
                $q="SELECT * FROM rest_menu_pdf rmp WHERE rest_ID=:rest AND ABS(UNIX_TIMESTAMP(updatedAt))-UNIX_TIMESTAMP(:time) < 2 AND status=1 ORDER BY enter_time ASC LIMIT 0,1";
            }else{
                $q="SELECT * FROM rest_menu_pdf rmp WHERE rest_ID=:rest AND ABS(UNIX_TIMESTAMP(enter_time))-UNIX_TIMESTAMP(:time) < 2 AND status=1 ORDER BY enter_time ASC LIMIT 0,1";
            }
            $pdf= DB::select(DB::raw($q),array('rest'=>$rest,'time'=>$time));
            if(count($pdf)>0){
                return $pdf[0];
            }
        }
    }

    public static function getPossibleBranch($activity=0,$rest=0,$time=0,$updated=false){
        if($activity!=0){
            $q="SELECT cl.city_ID,cl.seo_url,cl.city_Name,cl.seo_url,cl.city_Name_ar,dl.district_Name,dl.district_Name_ar,rb.br_loc,rb.br_loc_ar,rb.rest_fk_id,rb.url FROM rest_branches rb JOIN city_list cl ON cl.city_ID=rb.city_ID AND cl.city_Status=1 JOIN district_list dl ON dl.district_ID=rb.district_ID AND dl.district_Status=1 WHERE rb.br_id=:branch";
            $branch= DB::select(DB::raw($q),array('branch'=>$activity));
            if(count($branch)>0){
                return $branch[0];
            }
        }else{
            if($updated){
                $q="SELECT cl.city_Name,cl.city_Name_ar,cl.seo_url,dl.district_Name,dl.district_Name_ar,rb.br_loc,rb.br_loc_ar FROM rest_branches rb JOIN city_list cl ON cl.city_ID=rb.city_ID AND cl.city_Status=1 JOIN district_list dl ON dl.district_ID=rb.district_ID AND dl.district_Status=1 WHERE rb.rest_fk_id=:rest AND ABS(UNIX_TIMESTAMP(lastUpdated))-UNIX_TIMESTAMP(:time) < 2 ORDER BY dl.createdAt ASC LIMIT 0,1";
            }else{
                $q="SELECT cl.city_Name,cl.city_Name_ar,cl.seo_url,dl.district_Name,dl.district_Name_ar,rb.br_loc,rb.br_loc_ar FROM rest_branches rb JOIN city_list cl ON cl.city_ID=rb.city_ID AND cl.city_Status=1 JOIN district_list dl ON dl.district_ID=rb.district_ID AND dl.district_Status=1 WHERE rb.rest_fk_id=:rest AND ABS(UNIX_TIMESTAMP(dl.createdAt))-UNIX_TIMESTAMP(:time) < 2 ORDER BY dl.createdAt ASC LIMIT 0,1";
            }
            $branch= DB::select(DB::raw($q),array('rest'=>$rest,'time'=>$time));
            if(count($branch)>0){
                return $branch[0];
            }
        }
    }

    public static function getMenuType($activity=0,$rest=0,$time=0){
        if($activity!=0){
            return DB::table('menu')->where('menu_id',$activity)->first();
        }
    }

    public static function getMenuCat($activity=0,$rest=0,$time=0){
        if($activity!=0){
            return DB::table('menu_cat')->where('cat_id',$activity)->first();
        }   
    }

    public static function getTotalMenuRequests($rest=0){
        return DB::table('menurequest')->where('rest_ID',$rest)->count();
    }

    public static function getAllMenuRequests($rest=0){
        return DB::table('menurequest')->where('rest_ID',$rest)->get();
    }

    public static function checkUserRecommended($user=0,$menu=0){
        return DB::table('recommendmenu')->where('user_ID',$user)->where('menuID',$menu)->count();
    }

    public static function recommendMenu($menu=0,$user=0,$country=0){
        $data=array(
            'menuID'=>$menu,
            'user_ID'=>$user,
            'country'=>$country
        );
        return DB::table('recommendmenu')->insertGetId($data);
    }

    public static function unrecommendMenu($menu=0,$user=0,$country=0){
        DB::table('recommendmenu')->where('user_ID',$user)->where('menuID',$menu)->where('country',$country)->delete();
    }

    public static function agreeComment($user=0,$review=0,$city=0,$rest=0,$country=0){
        $data=array(
            'rest_ID'=>$rest,
            'user_ID'=>$user,
            'city_ID'=>$city,
            'facebook'=>0,
            'status'=>1,
            'ip'=>NULL,
            'fromMobile'=>0,
            'comment_id'=>$review,
            'country'=>$country
        );
        return DB::table('likee_info')->insertGetId($data);
    }

    public static function checkUserAgreed($user=0,$comment=0){
        return DB::table('likee_info')->where('user_ID',$user)->where('comment_id',$comment)->count();
    }

    public static function removeAgreeComment($user=0,$review=0,$country=0){
        DB::table('likee_info')->where('user_ID',$user)->where('comment_id',$review)->where('country',$country);
    }

    public static function getRestaurantOffers($rest=0){
        return DB::table('rest_offer')->select('id','offerName','offerNameAr','shortDesc','shortDescAr','image','imageAr')->where('rest_ID',$rest)->where('status',1)->get();
    }



    public static function savePdfAsImage($fname, $directory,$savedir){
        $filename=$directory.$fname;
        if($fname!="" && file_exists($filename) ){
            $pdf=$filename;
            $pages=Self::getNumPagesPdf($pdf);
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
    
    public static function getNumPagesPdf($filepath){
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

    public static function addView($rest=0){
        $q="UPDATE restaurant_info SET rest_Viewed=rest_Viewed+1,total_view=total_view+1,last_viewed=NOW() WHERE rest_ID=:rest";
        DB::update(DB::raw($q),array('rest'=>$rest));
       

    }


}