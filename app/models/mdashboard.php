<?php

class MDashboard extends Eloquent {

    public static function getTotalRestaurants($country, $new = 0) {
        $rest = DB::table('restaurant_info');
        $rest->where('country', '=', $country);
        if (!empty($new)) {
            $rest->where('is_read', '=', 0);
        }
        return $rest->count();
    }

    public static function getTotalUsers($country, $new = 0) {
        $user = DB::table('user');
        $user->where('sufrati', '=', $country);
        if (!empty($new)) {
            $user->where('is_read', '=', 0);
        }
        return $user->count();
    }

    public static function getTotalSubscribers($country, $status = 0) {
        $subscribers = DB::table('subscribers');
        $subscribers->where('country', '=', $country);
        if (!empty($status)) {
            $subscribers->where('status', '=', 1);
            $subscribers->where('bademail', '=', 0);
        }
        return $subscribers->count();
    }

    public static function getTotalPhotos($country, $new = 0, $user = 0) {
        $photos = DB::table('image_gallery');
        $photos->where('country', '=', $country);
        if (!empty($new)) {
            $photos->where('is_read', '=', 1);
        }
        if (!empty($user)) {
            $photos->whereNotNull('user_ID');
        }
        return $photos->count();
    }

    public static function getTotalArticles($country) {
        $articles = DB::table('article');
        $articles->where('country', '=', $country);
        return $articles->count();
    }

    public static function getTotalVideos($country) {
        $videos = DB::table('rest_video');
        $videos->where('country', '=', $country);
        return $videos->count();
    }

    public static function getTotalMenuRequest($country, $new = 0) {
        $menurequest = DB::table('menurequest');
        $menurequest->where('country', '=', $country);
        if (!empty($new)) {
            $menurequest->where('is_read', '=', 1);
        }
        return $menurequest->count();
    }

    public static function getTotalReviews($country, $new = 0) {
        $menurequest = DB::table('review');
        $menurequest->where('country', '=', $country);
        if (!empty($new)) {
            $menurequest->where('is_read', '=', 1);
        }
        return $menurequest->count();
    }

    public static function getTotalRating($country, $new = 0) {
        $menurequest = DB::table('rating_info');
        $menurequest->where('country', '=', $country);
        if (!empty($new)) {
            $menurequest->where('is_read', '=', 1);
        }
        return $menurequest->count();
    }

    public static function getPopularRestaurants($country) {
        $poprest = DB::table('restaurant_info');
        $poprest->select('rest_ID', 'rest_Name', 'rest_Name_Ar', 'seo_url', 'total_view');
        $poprest->where('rest_Status', '=', 1);
        $poprest->where('country', '=', $country);
        $poprest->orderBy('total_view', 'DESC');
        return $lists = $poprest->take(5)->get();
    }

    public static function getPopularCuisines($country) {
        $popcui = DB::table('cuisine_list');
        $popcui->select('cuisine_ID', 'cuisine_Name', 'cuisine_Name_Ar', 'seo_url', 'cuisine_viewed');
        $popcui->where('cuisine_Status', '=', 1);
        $popcui->where('country', '=', $country);
        $popcui->orderBy('cuisine_viewed', 'DESC');
        return $lists = $popcui->take(5)->get();
    }

    public static function getPopularSections($country) {
        $popSec = DB::table('section_list');
        $popSec->where('country', '=', $country);
        $popSec->orderBy('viewed_eng', 'DESC');
        return $lists = $popSec->take(5)->get();
    }

    public static function getTotalMenuDownloads($country, $new = 0) {
        $menuDown = DB::table('menu_downloads');
        $menuDown->where('country', '=', $country);
        if (!empty($new)) {
            $date = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime($date . '-1 day'));
            $menuDown->whereBetween("createdAt", array($date2, $date));
        }
        return $menuDown->count();
    }

    public static function getAppDownloads($country = 0, $platform = "", $new = 0) {
        $appDown = DB::table('user_devices_list');
        $appDown->where('country', '=', $country);
        if ($platform != "") {
            $appDown->where('device_platform', '=', $platform);
        }
        if (!empty($new)) {
            $date = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime($date . '-1 day'));
            $appDown->whereBetween("createdAt", array($date2, $date));
        }
        return $appDown->count();
    }

    public static function getTotalMembers($country, $member = '', $new = 0) {
        $rest = DB::table('restaurant_info');
        $rest->where('restaurant_info.country', '=', $country);
        if ($member != "") {
            $rest->where('restaurant_info.rest_Subscription', '=', $member);
        }
        $rest->join('booking_management', 'booking_management.rest_id', '=', 'restaurant_info.rest_ID');
        if (!empty($new)) {
            $date = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime($date . '-1 day'));
            $rest->whereBetween("date_add", array($date2, $date));
        }
        return $rest->count();
    }

    public static function getTotalAnalytics($country, $new = 0) {
        $analytics = DB::table('analytics');
        $analytics->where('country', '=', $country);
        if (!empty($new)) {
            $date = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime($date . '-1 day'));
            $analytics->whereBetween("created_at", array($date2, $date));
        }
        return $analytics->count();
    }

    public static function getTotalMobileAnalytics($country, $new = 0) {
        $analytics = DB::table('mobile_analytics');
        $analytics->where('country', '=', $country);
        if (!empty($new)) {
            $date = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime($date . '-1 day'));
            $analytics->whereBetween("createdAt", array($date2, $date));
        }
        return $analytics->count();
    }

    public static function getDailyKeywords($country) {
        $date = date('Y-m-d');
        $date2 = date('Y-m-d', strtotime($date . '-1 day'));
        $search = DB::table('analytics');
        $search->select(DB::Raw('DISTINCT search_term'));
        $search->where('country', '=', $country);
        $search->whereNotNull('search_term');
        $search->where('search_term', 'NOT LIKE', '%fdj%');
        $search->whereBetween("created_at", array($date2, $date));
        $search->groupBy('search_term');
        return $search->get();
        //$query = "SELECT DISTINCT search_term FROM analytics WHERE search_term != '' AND search_term NOT LIKE '%fdj%' AND created_at BETWEEN '" . $date . "' AND '" . $date2 . "' GROUP BY search_term LIMIT 15 ";
    }

    public static function getAnnualVisits($country = 0) {
        $date = date('Y-m-d');
        return DB::table('analytics')->where('country', '=', $country)->where(DB::Raw('YEAR(created_at)'), '=', $date)->count();
    }

    public static function getAnnualTrafficPercentage($country = 0) {
        $data = array();
        $date = date('Y-m-d');
        $date2 = $date;
        $total = MDashboard::getAnnualVisits($country);
        if ($total != 0) {
            $direct = DB::table('analytics')->where('country', '=', $country)->where('ref', 'LIKE', '%.azooma.co')->where(DB::Raw('YEAR(created_at)'), '=', $date)->count();
            $directtraffic = round(($direct / $total) * 100, 1);
            $searchtraffic = 100 - $directtraffic;
            $data['direct'] = $directtraffic;
            $data['search'] = $searchtraffic;
        } else {
            $data['direct'] = 0;
            $data['search'] = 0;
        }
        return $data;
    }

    public static function getTotalGroupofRestaurants($country) {
        $videos = DB::table('restaurant_groups');
        $videos->where('country', '=', $country);
        return $videos->count();
    }

    public static function getTotalHotels($country) {
        $videos = DB::table('hotel_info');
        $videos->where('country', '=', $country);
        return $videos->count();
    }

    public static function getTotalPhotoLike($country) {
        $videos = DB::table('photolike');
        $videos->where('country', '=', $country);
        return $videos->count();
    }

    public static function getTotalRecipes($country) {
        $videos = DB::table('recipe');
        $videos->where('country', '=', $country);
        return $videos->count();
    }

    public static function getTotalCuisines($country) {
        $videos = DB::table('cuisine_list');
        $videos->where('country', '=', $country);
        return $videos->count();
    }

    public static function getTotalKnownFor($country) {
        $videos = DB::table('bestfor_list');
        $videos->where('country', '=', $country);
        return $videos->count();
    }

    public static function getTotalSuggested($country) {
        $mRest = DB::table('restaurant_info');
        $mRest->Where(
                function($mRest) {
            $mRest->where('breakfast', '=', 1)->orWhere('lunch', '=', 1)->orWhere('dinner', '=', 1)->orWhere('latenight', '=', 1)->orWhere('iftar', '=', 1)->orWhere('suhur', '=', 1);
        });
        return $mRest->count();
    }

    public static function getVisitNew($country = 0, $lang = "", $y = '', $rest_id = null) {
        $ana = DB::table('analytics');
        $ana->select(DB::raw('COUNT(id) total'),  DB::raw('MONTH(created_at) month'));
        
        if (!empty($y)) {
            $year = $y;
        } else {
            $year =  date("Y");
        }
        
        $date_from = date("$year-01-01");
        $date_to = date("$year-21-31");
        
        $ana->where("created_at",'>=' , $date_from);
        $ana->where("created_at", '<=', $date_to);

        if (!empty($lang)) {
            $ana->where('lang', '=', $lang);
        }
        if (!empty($country)) {
            $ana->where('country', '=', $country);
        }
        
        if (!empty($rest_id)) {
            $ana->where('rest_ID', '=', $rest_id);
        }
        $ana->groupby('month');
        // dd();

        // $model->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        //     ->groupby('year','month')
        //     ->get();

        // dd($ana->get(), $date_from, $date_to, $country,$lang, $rest_id);
        return $ana->get();
    }

    public static function getRestaurantSuggestionResult($country, $term) {
        $mRest = DB::table('restaurant_info');
        $mRest->select('rest_Name', 'rest_Name_Ar', 'seo_url', 'rest_ID');
        $mRest->where('country', '=', $country);
        $mRest->Where(
                function($mRest) use ($term) {
            $mRest->where('rest_Name', 'LIKE', "%" . $term . "%")->orWhere('rest_Name_Ar', 'LIKE', "%" . $term . "%");
        });
        return $mRest->get();
    }

}
