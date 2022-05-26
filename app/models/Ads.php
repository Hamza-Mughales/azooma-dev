<?php
class Ads extends Eloquent
{
    protected $table = "banner";
    /******
	$type
	1. Top Banner - 968x98
	2. Side Banner - 245x
	3. Results Banner - 657x50
	4. Popular results side banner - 265x146
     *****/

    public static function getRandomAd($type = 0, $city = 0, $cuisine = 0, $alreadyloaded = array())
    {
        $q = DB::table('banner');
        if ($type != 0) {
            $q->where('banner_type', $type);
        }
        if ($city != 0) {
            $q->whereRaw('(' . $city . ' IN (city_ID) OR city_ID=0)');
        }
        if ($cuisine != 0) {
            $q->whereRaw($cuisine . ' IN (cuisine_ID)');
        } else {
            $q->whereRaw('(cuisine_ID=0 OR cuisine_ID="")');
        }
        if (count($alreadyloaded) > 0) {
            $q->whereNotIn('id', $alreadyloaded);
        }
        $q->where('active', 1);
        $q->whereRaw('start_date <= CURDATE()');
        $q->whereRaw('end_date > CURDATE()');
        $q->orderByRaw('RAND()');
        $banner = $q->first();
        if (count($banner) > 0) {
            DB::table('banner')->where('id', $banner->id)->increment('impressions');
        } else {
            //check without cuisine
            $q = DB::table('banner');
            if ($type != 0) {
                $q->where('banner_type', $type);
            }
            if ($city != 0) {
                $q->whereRaw('(' . $city . ' IN (city_ID) OR city_ID=0)');
            }
            if (count($alreadyloaded) > 0) {
                $q->whereNotIn('id', $alreadyloaded);
            }
            $q->whereRaw('(cuisine_ID=0 OR cuisine_ID="")');
            $q->where('active', 1);
            $q->whereRaw('start_date <= CURDATE()');
            $q->whereRaw('end_date > CURDATE()');
            $q->orderByRaw('RAND()');
            $banner = $q->first();
            if (count($banner) > 0) {
                DB::table('banner')->where('id', $banner->id)->increment('impressions');
            }
        }
        return $banner;
    }

    public static function IncrementClick($banner = 0)
    {
        $lang = Config::get('app.locale');
        $cityid = $country = 0;
        if (Session::has('sfcity')) {
            $cityid = Session::get('sfcity');
            $city = MGeneral::getCity($cityid, false);
            $country = $city->country;
        }
        DB::table('banner')->where('id', $banner)->increment('clicked');
        $data = array(
            'banner_id' => $banner,
            'UA' => $_SERVER['HTTP_USER_AGENT'],
            'lang' => $lang,
            'city_ID' => $cityid,
            'country' => $country
        );
        DB::table('bannerClicks')->insert($data);
    }




    public static function getBanner($id = 0)
    {
        return DB::table('banner')->where('id', '=', $id)->first();
    }

    public static function deleteBanner($id = 0)
    {
        return DB::table('banner')->where('id', '=', $id)->delete();
    }




    public static function getHomePageCategory($id = 0)
    {
        return DB::table('art_work')->where('art_work_name', '=', 'Home Page Category')->where('id', '=', $id)->first();
    }

    public static function deleteHomePageCategory($id = 0)
    {
        return DB::table('art_work')->where('art_work_name', '=', 'Home Page Category')->where('id', '=', $id)->delete();
    }
}
