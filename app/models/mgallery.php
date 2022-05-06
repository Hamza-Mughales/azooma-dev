<?php

class MGallery extends Eloquent {

    protected $table = 'image_gallery';

    public static function getPhotos($city = 0, $userphoto = 0, $limit = 10, $offset = 0, $count = FALSE, $sort = "latest") {
        $selectq = "SELECT DISTINCT ig.image_ID,ig.title,ig.title_ar,ig.image_full,ig.ratio,ig.width, ig.enter_time,ig.user_ID,ri.rest_Name, ri.rest_Name_Ar,ri.rest_Logo,ri.seo_url,(SELECT COUNT(id) FROM photolike WHERE image_ID=ig.image_ID) as likes ";
        $fromq = " FROM image_gallery ig JOIN restaurant_info ri ON ri.rest_ID=ig.rest_ID AND ri.rest_Status=1 JOIN rest_branches rb ";
        $whereq = " WHERE rb.rest_fk_id=ig.rest_ID AND rb.city_ID=:cityid AND ig.status=1 ";
        if ($userphoto == 1) {
            //only users
            $selectq.=", u.user_NickName,u.user_FullName,u.image ";
            $fromq.=' JOIN user u ON u.user_ID=ig.user_ID AND u.user_Status=1 ';
            $whereq.=" AND ig.user_ID IS NOT NULL";
        } else {
            if ($userphoto == 2) {
                //only restaurant
                $whereq.=" AND ig.user_ID IS NULL";
            }
        }
        switch ($sort) {
            case 'latest':
                $orderq = "ORDER BY ig.enter_time DESC";
                break;
            case 'popular':
                $orderq = "ORDER BY likes DESC";
                break;
        }
        if ($count) {
            $total = DB::select(DB::raw('SELECT COUNT(DISTINCT ig.image_ID) as total ' . $fromq . ' ' . $whereq), array('cityid' => $city));
            return $total[0]->total;
        } else {
            return DB::select(DB::raw($selectq . ' ' . $fromq . ' ' . $whereq . ' ' . $orderq . ' LIMIT ' . $offset . ', ' . $limit), array('cityid' => $city));
        }
    }

    public static function getVideos($limit = 10, $offset = 0) {
        $selectq = "SELECT rv.id, rv.name_en,rv.name_ar,rv.youtube_en,rv.youtube_ar,rv.video_description,rv.video_description_ar,rv.add_date";
        $fromq = " FROM rest_video rv ";
        $whereq = " WHERE rv.status=1 ";

        $whereq.=" ORDER BY rv.add_date DESC ";
        return DB::select(DB::raw($selectq . ' ' . $fromq . ' ' . $whereq . ' LIMIT ' . $offset . ', ' . $limit));
    }

    public static function getTotalVideos() {
        $total = DB::select(DB::raw('SELECT COUNT(id) as total FROM rest_video WHERE status=1'));
        return $total[0]->total;
    }

    public static function getVideo($id = 0) {
        $selectq = "SELECT * FROM rest_video WHERE id=:id AND status=1";
        return DB::select(DB::raw($selectq), array('id' => $id));
    }

    public static function getScrollPhoto($next = TRUE, $image = 0, $city = 0, $sort = "", $rest = 0) {
        if ($next) {
            $subq = "SELECT MAX(image_ID)";
        } else {
            $subq = "SELECT MIN(image_ID)";
        }
        $subq.=" FROM image_gallery ig JOIN rest_branches rb ON rb.rest_fk_id =ig.rest_ID AND rb.city_ID=" . $city . " WHERE rb.status=1 AND ig.status=1 AND ";
        if ($next) {
            $subq.=" ig.image_ID < " . $image;
        } else {
            $subq.=" ig.image_ID > " . $image;
        }
        $subq.=" ORDER BY ig.enter_time DESC";
        $selectq = "SELECT image_ID,image_full FROM image_gallery WHERE image_ID=(" . $subq . ")";
        if ($rest != 0) {
            $selectq.=" AND rest_ID=" . $rest;
        }

        return DB::select(DB::raw($selectq));
    }

    public static function getPhotoLikes($imageID=0) {
        $total = DB::select(DB::raw('SELECT COUNT(id) as likes FROM photolike WHERE image_ID='.$imageID.''));
        return $total[0]->likes;
    }

    function getAllImages($country = 0, $rest = 0, $status = "", $user = "", $limit = "", $sort = "") {
        $this->table = "image_gallery";
        $MGall = DB::table('image_gallery');
        $MGall->select('*', DB::Raw('(SELECT restaurant_info.rest_Name from restaurant_info where restaurant_info.rest_ID=image_gallery.rest_ID) AS restName'));
        if ($country != 0) {
            $MGall->where('image_gallery.country', $country);
        }
        if ($status != "") {
            $MGall->where('image_gallery.status', $status);
        }
        if ($rest != 0) {
            $MGall->where('image_gallery.rest_ID', $rest);
        }
        if ($user != '') {
            if ($user == 0) {
                $MGall->where('user_ID', 'IS', 'NULL');
            }
            if ($user > 0) {
                $MGall->whereNotNull('user_ID');
            }
        } elseif ($user == 0) {
            $MGall->whereNull('user_ID');
        }
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $MGall->orderBy('is_read','ASC');
                    $MGall->orderBy('image_gallery.title','DESC');
                    break;
                case 'latest':
                    $MGall->orderBy('is_read','ASC');
                    $MGall->orderBy('enter_time', 'DESC');
                    break;
            }
        } else {
            $MGall->orderBy('is_read','ASC');
            $MGall->orderBy('enter_time', 'DESC');
        }
        if ($limit != "") {
            $lists = $MGall->paginate($limit);
        } else {
            $lists = $MGall->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return $lists;
    }

    function getPhoto($image = 0) {
        $res = DB::table('image_gallery')->where('image_ID', $image)->first();
        if (count($res) > 0) {
            return $res;
        }
        return NULL;
    }

    function addImage($image = "", $ratio = 0, $width = 0) {
        $status = 0;
        $rest_ID = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (isset($_POST['rest_ID'])) {
            $rest_ID = Input::get('rest_ID');
        }
        $data = array(
            'title' => (Input::get('title')),
            'title_ar' => (Input::get('title_ar')),
            'rest_ID' => $rest_ID,
            'image_full' => $image,
            'image_thumb' => $image,
            'ratio' => $ratio,
            'width' => $width,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return DB::table('image_gallery')->insertGetId($data);
    }

    function updateImage($image = "", $ratio = 0, $width = 0) {
        $status = 0;
        $rest_ID = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        if (isset($_POST['rest_ID'])) {
            $rest_ID = Input::get('rest_ID');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        if (($ratio == 0) && ($width == 0)) {
            $data = array(
                'title' => (Input::get('title')),
                'title_ar' => (Input::get('title_ar')),
                'rest_ID' => $rest_ID,
                'image_full' => $image,
                'image_thumb' => $image,
                'status' => $status,
                'country' => $country,
                'updatedAt' => date('Y-m-d H:i:s')
            );
        } else {
            $data = array(
                'title' => (Input::get('title')),
                'title_ar' => (Input::get('title_ar')),
                'rest_ID' => $rest_ID,
                'image_full' => $image,
                'image_thumb' => $image,
                'width' => $width,
                'ratio' => $ratio,
                'status' => $status,
                'country' => $country,
                'updatedAt' => date('Y-m-d H:i:s')
            );
        }
        DB::table('image_gallery')->where('image_ID', Input::get('image_ID'))->update($data);
    }

    function getAllVideos($country = 0, $rest = 0, $status = "", $name = "", $limit = "",$sort="") {
        $this->table = "rest_video";
        $MVideo = MGallery::select('rest_video.*');
     
        if (!in_array(0, adminCountry())) {
            $MVideo->whereIn("country",  adminCountry());
        }
        if ($rest != 0) {
            $MVideo->where('rest_ID', $rest);
        }
        if ($status != "") {
            $MVideo->where('status', $status);
        }
        if ($sort != "") {
            switch ($sort) {
                case 'name':
                    $MVideo->orderBy('rest_video', 'DESC');
                    break;
                case 'latest':
                    $MVideo->orderBy('add_date', 'DESC');
                    break;
            }
        }
        
        if ($limit != "") {
            $lists = $MVideo->paginate($limit);
        } else {
            $lists = $MVideo->get();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function getVideoAdmin($id = 0, $status = 0) {
        $MVid = DB::table('rest_video')->where('id', '=', $id);
        if (!empty($status)) {
            $MVid->where('status', '=', 0);
        }
        $lists = $MVid->first();
        if (count($lists) > 0) {
            return $lists;
        }
        return NULL;
    }

    function addVideo() {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        if (isset($_POST['rest_ID']) && !empty($_POST['rest_ID'])) {
            $rest_ID = Input::get('rest_ID');
        } else {
            $rest_ID = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name_en' => (Input::get('name_en')),
            'name_ar' => (Input::get('name_ar')),
            'youtube_en' => (Input::get('youtube_en')),
            'youtube_ar' => (Input::get('youtube_ar')),
            'video_description' => htmlentities(Input::get('video_description')),
            'video_description_ar' => (Input::get('video_description_ar')),
            'video_tags' => (Input::get('video_tags')),
            'video_tags_ar' => (Input::get('video_tags_ar')),
            'country' => $country,
            'status' => $status,
            'rest_ID' => $rest_ID,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        return $insertID = DB::table('rest_video')->insertGetId($data);
    }

    function updateVideo() {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        if (isset($_POST['rest_ID']) && !empty($_POST['rest_ID'])) {
            $rest_ID = Input::get('rest_ID');
        } else {
            $rest_ID = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'name_en' => (Input::get('name_en')),
            'name_ar' => (Input::get('name_ar')),
            'youtube_en' => (Input::get('youtube_en')),
            'youtube_ar' => (Input::get('youtube_ar')),
            'video_description' => htmlentities(Input::get('video_description')),
            'video_description_ar' => (Input::get('video_description_ar')),
            'video_tags' => (Input::get('video_tags')),
            'video_tags_ar' => (Input::get('video_tags_ar')),
            'status' => $status,
            'country' => $country,
            'rest_ID' => $rest_ID,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        DB::table('rest_video')->where('id', Input::get('id'))->update($data);
    }

    function deleteVideo($id) {
        DB::table('rest_video')->where('id', '=', $id)->delete();
    }

    function getRestVideo($id = 0) {
        $res = DB::table('rest_video')->where('id', $id)->first();
        if (count($res) > 0) {
            return $res;
        }
        return NULL;
    }

}
