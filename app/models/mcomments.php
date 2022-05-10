<?php

class MComments extends Eloquent {

    public static function getAllRestaurantComments($country = 0, $new = 0, $status = 0, $limit = 0, $rest_ID = 0, $user_ID = 0, $excel = false, $commentMsg = "", $sort = "") {
        $com = DB::table('review');
        $com->select('review_ID AS id', 'review_Status as status', 'review_Msg', 'review_Date', 'review.is_read', 'review.user_ID',
         DB::Raw('(SELECT restaurant_info.rest_Name FROM restaurant_info WHERE restaurant_info.rest_ID=review.rest_ID) as restaurant'),
         DB::Raw('(SELECT user.user_FullName FROM user WHERE user.user_ID = review.user_ID) AS uname'),
          DB::Raw('(SELECT user.user_Email FROM user WHERE user.user_ID = review.user_ID) AS email'));
        if ($excel) {
            $com->select('COUNT(review.review_ID) AS total');
            $com->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'review.rest_ID');
            $com->group_by('restaurant_info.rest_ID');
        }

        if ($country != 0) {
            $com->where('country', '=', $country);
        }

        if (!empty($commentMsg)) {
            $com->where('review_Msg', 'LIKE', '%' . $commentMsg . '%');
        }

        if ($rest_ID != 0) {
            $com->where('rest_ID', '=', $rest_ID);
        }

        if ($user_ID != 0) {
            $com->where('user_ID', '=', $user_ID);
        }

        if ($new != 0) {
            $com->where('review.is_read', '=', 0);
        }

        if ($status != 0) {
            $com->where('review.review_Status', '=', 0);
        }
        if (empty($sort)) {
            $com->orderBy('review.is_read');
            $com->orderBy('review.review_Date', 'DESC');
        } else {
            switch ($sort) {
                case 'latest':
                    $com->orderBy('review.review_Date', 'DESC');
                    break;
                case 'name':
                    $com->orderBy('review.review_Msg', 'ASC');
                    break;
                case 'new':
                    $com->orderBy('review.is_read');
                    break;
            }
        }

        if (!empty($limit)) {
            $lists = $com->paginate($limit);
        } else {
            $lists = $com->paginate(10000);
        }
        if (count($lists) > 0) {
            return $lists;
        }
    }

    
    public static function readRestaurantComment($id) {
        $data = array(
            'is_read' => 1
        );
        DB::table('review')->where('review_ID', '=', $id)->update($data);
    }

    public static function readArticleComment($id) {
        $data = array(
            'isRead' => 1
        );
        DB::table('articlecomment')->where('id', '=', $id)->update($data);
    }

    public static function setStatusArticleComment($id, $status) {
        $data = array(
            'status' => $status
        );
        DB::table('articlecomment')->where('id', '=', $id)->update($data);
    }

    public static function getRestaurantComment($id) {
        return DB::table('review')->where('review_ID', '=', $id)->first();
    }

    public static function getArticleComment($id) {
        return DB::table('articlecomment')->where('id', '=', $id)->first();
    }

    public static function getArticleCategory($id) {
        return DB::table('categories')->where('id', '=', $id)->first();
    }

    public static function getRestaurantCommentUser($id) {
        return DB::table('user')->where('user_ID', '=', $id)->first();
    }

    public static function deleteRestaurantComment($id = 0) {
        return DB::table('review')->where('review_ID', '=', $id)->delete();
    }

    public static function deleteArticleComment($id = 0) {
        return DB::table('articlecomment')->where('id', '=', $id)->delete();
    }

    public static function getAllUsersCommentedOnRest($user_ID = 0, $rest_ID = 0) {
        return DB::table('review')->where('rest_ID', '=', $rest_ID)->where('review_Status', '=', 1)->where('user_ID', '!=', $user_ID)->get();
    }

    public static function getAllArticleCategories($country = 0, $status = "") {
        $artCom = DB::table('categories');
        $artCom->select('*', DB::Raw('(SELECT count(*) FROM articlecomment where articlecomment.category=categories.id) AS totalcomment'));
        if (!empty($country)) {
            $artCom->where('country', '=', $country);
        }
        if (!empty($status)) {
            $artCom->where('status', '=', $status);
        }
        $artCom->orderBy('position', 'ASC');
        //$artCom->orderBy('position');
        $lists = $artCom->paginate(1000);
        if (count($lists) > 0) {
            return $lists;
        }
    }

    public static function getAllArticleComments($country = 0, $category = 0, $status = "", $limit = "", $new = "", $sort = "", $comment = "") {
        $artCom = DB::table('articlecomment');

        $artCom->select('*', 'isRead as is_read', DB::Raw('(SELECT article.name FROM article WHERE article.id=articlecomment.articleID) as article'));

        if (!empty($country)) {
            $artCom->where('country', '=', $country);
        }

        if (!empty($comment)) {
            $artCom->where('comment', 'LIKE', '%' . $comment . '%');
        }

        if (empty($sort)) {
            $artCom->orderBy('isRead', 'ASC');
            $artCom->orderBy('createdAt', 'DESC');
        } else {
            switch ($sort) {
                case 'latest':
                    $artCom->orderBy('createdAt', 'DESC');
                    break;
                case 'name':
                    $artCom->orderBy('commnet', 'ASC');
                    break;
                case 'new':
                    $artCom->orderBy('isRead');
                    break;
            }
        }

        if (!empty($category)) {
            $artCom->where('category', '=', $category);
        }

        if (!empty($status)) {
            $artCom->where('status', '=', $status);
        }


        if (!empty($limit)) {
            $lists = $artCom->paginate($limit);
        } else {
            $lists = $artCom->paginate(1000);
        }
        if (count($lists) > 0) {
            return $lists;
        }
    }

    public static function getAllMenuRequests($country = 0, $new = "", $limit = "", $rest = "", $sort = "", $name = "") {
        $menuReq = DB::table('menurequest');
        $menuReq->select('*', DB::Raw('COUNT(menurequest.rest_ID) AS total'), DB::Raw('(SELECT GROUP_CONCAT(DISTINCT city_Name) FROM city_list INNER JOIN rest_branches ON rest_branches.city_ID = city_list.city_ID WHERE rest_branches.rest_fk_id = restaurant_info.rest_ID ) AS city'));
        $menuReq->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'menurequest.rest_ID');
        if (!empty($country)) {
            $menuReq->where('menurequest.country', '=', $country);
        }

        if (!empty($new)) {
            $menuReq->where('menurequest.is_read', '=', 0);
        }

        if (!empty($name)) {
            $menuReq->where('menurequest.name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($rest)) {
            $menuReq->where('menurequest.rest_ID', '=', $rest);
        }

        if (empty($sort)) {
            $menuReq->orderBy('menurequest.is_read', 'ASC');
            $menuReq->orderBy('menurequest.createdAt', 'DESC');
        } else {
            switch ($sort) {
                case 'latest':
                    $menuReq->orderBy('menurequest.createdAt', 'DESC');
                    break;
                case 'name':
                    $menuReq->orderBy('menurequest.name', 'ASC');
                    break;
                case 'new':
                    $menuReq->orderBy('menurequest.is_read');
                    break;
            }
        }
        $menuReq->groupBy('menurequest.rest_ID');
        $lists = "";
        if (!empty($limit)) {
            $lists = $menuReq->paginate($limit);
        } else {
            $lists = $menuReq->paginate(10000);
        }
        return $lists;
    }

    public static function getMenuRequest($id = 0, $rest_ID = 0) {
        $menu = DB::table('menurequest');
        $menu->select('menurequest.*', 'restaurant_info.rest_ID', 'restaurant_info.rest_Name', 'restaurant_info.rest_Name_Ar');
        $menu->join('restaurant_info', 'restaurant_info.rest_ID', '=', 'menurequest.rest_ID');

        if ($id != 0 && empty($rest_ID)) {
            $menu->where('id', '=', $id);
        }
        if ($rest_ID != 0) {
            $menu->where('menurequest.rest_ID', '=', $rest_ID);
            return $lists = $menu->paginate(1000000);
        }
        return $lists = $menu->first();
    }
    
    public static function readMenuRequest($id) {
        $data = array(
            'is_read' => 1
        );
        DB::table('menurequest')->where('id', '=', $id)->update($data);
    }
    

}
