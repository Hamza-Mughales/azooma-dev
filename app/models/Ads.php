<?php
class Ads extends Eloquent {
	protected $table="banner";
	/******
	$type
	1. Top Banner - 968x98
	2. Side Banner - 245x
	3. Results Banner - 657x50
	4. Popular results side banner - 265x146
	*****/

	public static function getRandomAd($type=0,$city=0,$cuisine=0,$alreadyloaded=array()){
        $q=DB::table('banner');
		if($type!=0){
			$q->where('banner_type',$type);
		}
		if($city!=0){
			$q->whereRaw('('.$city.' IN (city_ID) OR city_ID=0)');
		}
		if($cuisine!=0){
            $q->whereRaw($cuisine.' IN (cuisine_ID)');
		}else{
            $q->whereRaw('(cuisine_ID=0 OR cuisine_ID="")');
        }
		if(count($alreadyloaded)>0){
			$q->whereNotIn('id',$alreadyloaded);
		}
		$q->where('active',1);
        $q->whereRaw('start_date <= CURDATE()');
        $q->whereRaw('end_date > CURDATE()');
		$q->orderByRaw('RAND()');
		$banner=$q->first();
        if(count($banner)>0){
            DB::table('banner')->where('id',$banner->id)->increment('impressions');
        }else{
            //check without cuisine
            $q=DB::table('banner');
            if($type!=0){
                $q->where('banner_type',$type);
            }
            if($city!=0){
                $q->whereRaw('('.$city.' IN (city_ID) OR city_ID=0)');
            }
            if(count($alreadyloaded)>0){
                $q->whereNotIn('id',$alreadyloaded);
            }
            $q->whereRaw('(cuisine_ID=0 OR cuisine_ID="")');
            $q->where('active',1);
            $q->whereRaw('start_date <= CURDATE()');
            $q->whereRaw('end_date > CURDATE()');
            $q->orderByRaw('RAND()');
            $banner=$q->first();
            if(count($banner)>0){
                DB::table('banner')->where('id',$banner->id)->increment('impressions');
            }
        }
		return $banner;
	}

    public static function IncrementClick($banner=0){
        $lang=Config::get('app.locale');
        $cityid=$country=0;
        if(Session::has('sfcity')){
            $cityid=Session::get('sfcity');
            $city=MGeneral::getCity($cityid,false);
            $country=$city->country;
        }
        DB::table('banner')->where('id',$banner)->increment('clicked');
        $data=array(
            'banner_id'=>$banner,
            'UA'=>$_SERVER['HTTP_USER_AGENT'],
            'lang'=>$lang,
            'city_ID'=>$cityid,
            'country'=>$country
        );
        DB::table('bannerClicks')->insert($data);
    }


	public static function getAllBanners($country = 0, $status = 0, $type = 0, $limit = 0, $city_ID = 0, $banner_type = 0, $cuisine_ID = 0, $views = "") {
        $QQ = DB::table('banner');
        if (!empty($country)) {
            $QQ->where('country', '=', $country);
        }
        if (!empty($city_ID)) {
            $QQ->where('city_ID', '=', $city_ID);
        }
        if (!empty($banner_type)) {
            $QQ->where('banner_type', '=', $banner_type);
        }
        if (!empty($cuisine_ID)) {
            $QQ->where('cuisine_ID', '=', $cuisine_ID);
        }
        if (!empty($status)) {
            $QQ->where('active', '=', $status);
        }
        if (!empty($type)) {
            $QQ->where('type', '=', $type);
        }
        
        if (!empty($views)) {
            if ($views == 1) {
                $QQ->orderBy('clicked', 'DESC');
            } else {
                $QQ->orderBy('clicked', 'ASC');
            }
        }
        
        if (!empty($limit)) {
            $lists = $QQ->paginate($limit);
        } else {
            $lists = $QQ->paginate(10000);
        }
        if (count($lists) > 0) {
            return $lists;
        }
    }

    public static function getBanner($id = 0) {
        return DB::table('banner')->where('id', '=', $id)->first();
    }

    public static function deleteBanner($id = 0) {
        return DB::table('banner')->where('id', '=', $id)->delete();
    }


    public static function getAllHomePageCategories($country = 0, $status = 0, $limit = 0, $city_ID = 0) {
        $QQ = DB::table('art_work');
        $QQ->where('art_work_name','=','Home Page Category');
        if (!empty($country)) {
            $QQ->where('country', '=', $country);
        }
        if (!empty($city_ID)) {
            $QQ->where('city_ID', '=', $city_ID);
        }
        if (!empty($status)) {
            $QQ->where('active', '=', $status);
        }
        
        if (!empty($limit)) {
            $lists = $QQ->paginate($limit);
        } else {
            $lists = $QQ->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
    }

    public static function getHomePageCategory($id = 0) {
        return DB::table('art_work')->where('art_work_name','=','Home Page Category')->where('id', '=', $id)->first();
    }

    public static function deleteHomePageCategory($id = 0) {
        return DB::table('art_work')->where('art_work_name','=','Home Page Category')->where('id', '=', $id)->delete();
    }


    
}