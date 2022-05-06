<?php

class AdminComments extends AdminController {

    protected $Art_Work;
    protected $MGeneral;

    public function __construct() {
        parent::__construct();
        $this->Art_Work = new ArtWork();
        $this->MGeneral = new MGeneral();
    }

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $new = 0;
        $limit = 20;
        $status = 0;
        $rest_ID = 0;
        $user_ID = 0;
        $name = "";
        $sort = "";
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['rest_ID']) && !empty($_GET['rest_ID'])) {
            $rest_ID = stripslashes($_GET['rest_ID']);
        }
        if (isset($_GET['user_ID']) && !empty($_GET['user_ID'])) {
            $user_ID = stripslashes($_GET['user_ID']);
        }
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['new']) && !empty($_GET['new'])) {
            $new = stripslashes($_GET['new']);
        }

        $lists = MComments::getAllRestaurantComments($country, $new, $status, $limit, $rest_ID, $user_ID, FALSE, $name, $sort);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Comment', 'Name', 'City', 'Restaurant', 'Email', 'Date', 'Actions'),
            'pagetitle' => 'List of All Restaurant Comments',
            'title' => ' All Restaurant Comments',
            'action' => 'admincomments',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Miscellaneous','Restaurant Comments'),
        );
        return view('admin.partials.comment', $data);
    }

    public function view($id = 0) {
        if ($id != 0) {
            MComments::readRestaurantComment($id);
            if (Session::get('admincountryName') != "") {
                $settings = Config::get('settings.' . Session::get('admincountryName'));
            } else {
                $settings = Config::get('settings.default');
            }

            $page = MComments::getRestaurantComment($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => "Edit Comment ",
                'title' => "Edit Comment",
                'comment' => $page,
            );
            if (!empty($page->user_ID)) {
                $data['user'] = MComments::getRestaurantCommentUser($page->user_ID);
            }
            return View::make('admin.index', $data)->nest('content', 'admin.forms.viewcomment', $data);
        }
    }

    public function save() {
        if (Input::has('review_ID')) {
            $review_ID = Input::get('review_ID');
            $review_Status = 0;
            if (Input::has('review_Status')) {
                $review_Status = Input::get('review_Status');
            }
            $data = array(
                'review_Msg' => (Input::get('review_Msg')),
                'review_Status' => $review_Status
            );
            DB::table('review')->where('review_ID', $review_ID)->update($data);
            if ($review_Status == 1) {
                $page = MComments::getRestaurantComment($review_ID);
                if (count($page) > 0) {
                    if ($page->review_Status == 0) {
                        $status = 1;
                        $displaymessage = "Comment activatied successfully.";
                        Admin::addActivity('Comment activatied');
                        if (!empty($page->user_ID)) {
                            $user = MComments::getRestaurantCommentUser($page->user_ID);
                            $rest = MRestActions::getRest($page->rest_ID);
                            $userRank = $user->userRank + 6;
                            $ud = array('userRank' => $userRank);
                            DB::table('user')->where('user_ID', '=', $page->user_ID)->update($ud);

                            User::addActivity($page->user_ID, $page->rest_ID, "commented on", 'تم الرفع الصورة ل', $id);
                            User::addNotification($page->user_ID, $id, 'Comment approved', 'التعليق المعتمدة');
                            $this->commentsNotification($id, $page->user_ID, $page->rest_ID, $page->review_Msg);

                            $msg = 'Great Job, your comment on ' . stripcslashes($rest->rest_Name) . ' is approved !';
                            $msgar = 'مبروك، تمت الموافقة على تعليقك على ' . stripcslashes($rest->rest_Name_Ar);
                            $pushmessage = array('message' => $msg, 'rest' => $page->rest_ID, 'comment' => $page->review_ID, 'scenario' => 'comment');
                            //User::pushNotify($page->user_ID, $pushmessage, $msg, $msgar);
                        }
                    }
                }
            }
        }
        return Redirect::route('admincomments')->with(array('message' => 'Comment modified successfully.'));
    }

    public function status($id = 0) {
        if (!empty($id)) {
            $status = 0;
            $page = MComments::getRestaurantComment($id);
            $displaymessage = "";
            if (count($page) > 0) {
                if ($page->review_Status == 0) {
                    $status = 1;
                    $displaymessage = "Comment activatied successfully.";
                    Admin::addActivity('Comment activatied');
                    if (!empty($page->user_ID)) {
                        $user = MComments::getRestaurantCommentUser($page->user_ID);
                        $rest = MRestActions::getRest($page->rest_ID);
                        $userRank = $user->userRank + 6;
                        $ud = array('userRank' => $userRank);
                        DB::table('user')->where('user_ID', '=', $page->user_ID)->update($ud);

                        User::addActivity($page->user_ID, $page->rest_ID, "commented on", 'تم الرفع الصورة ل', $id);
                        User::addNotification($page->user_ID, $id, 'Comment approved', 'التعليق المعتمدة');
                        $this->commentsNotification($id, $page->user_ID, $page->rest_ID, $page->review_Msg);

                        $msg = 'Great Job, your comment on ' . stripcslashes($rest->rest_Name) . ' is approved !';
                        $msgar = 'مبروك، تمت الموافقة على تعليقك على ' . stripcslashes($rest->rest_Name_Ar);
                        $pushmessage = array('message' => $msg, 'rest' => $page->rest_ID, 'comment' => $page->review_ID, 'scenario' => 'comment');
                        //User::pushNotify($page->user_ID, $pushmessage, $msg, $msgar);
                    }
                } else {
                    $status = 0;
                    $displaymessage = "Comment deactivatied successfully.";
                    Admin::addActivity('Comment deactivatied');
                    if (!empty($page->user_ID)) {
                        $user = MComments::getRestaurantCommentUser($page->user_ID);
                        $userRank = 0;
                        if ($user->userRank > 6) {
                            $userRank = $user->userRank - 6;
                        }
                        $ud = array('userRank' => $userRank);
                        DB::table('user')->where('user_ID', '=', $page->user_ID)->update($ud);
                    }
                }
                $data = array(
                    'review_Status' => $status
                );
                DB::table('review')->where('review_ID', $id)->update($data);

                return Redirect::route('admincomments')->with(array('message' => $displaymessage));
            }
        }
        return Redirect::route('admincomments')->with(array('message' => 'something went wrong, Please try again.'));
    }

    public function delete($id = 0) {
        if (!empty($id)) {
            $page = MComments::getRestaurantComment($id);
            if (count($page) > 0) {
                MComments::deleteRestaurantComment($id);
                Admin::addActivity('Comment Deleted');
                return Redirect::route('admincomments')->with(array('message' => 'Comment deleted successfully.'));
            }
        }
        return Redirect::route('admincomments')->with(array('message' => 'something went wrong, Please try again.'));
    }

    public function read($id = 0) {
        MComments::readRestaurantComment($id);
    }

    public function commentsNotification($user_activity_id = 0, $user_id = 0, $rest_id = 0, $review_Msg = "") {
        ignore_user_abort(true);
        set_time_limit(0);
        $subject = "";
        $userInfo = User::getUser($user_id);
        $rest = MRestActions::getRest($rest_id);
        $allusers = MComments::getAllUsersCommentedOnRest($user_id, $rest_id);
        $username = $userInfo->user_NickName;
        if ($username == "") {
            $username = $userInfo->user_FullName;
        }
        $countryID = Session::get('admincountry');
        if (empty($countryID)) {
            $countryID = 1;
        }
        $data = array();
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $data['country'] = $country = MGeneral::getCountry($countryID);
        $data['settings'] = $settings;
        $sufratiUser = $settings['teamEmails'];
        $data['sitename'] = $settings['name'];
        $data['user'] = $userInfo;
        $data['rest'] = $rest;
        $data['title'] = "Commented on " . stripslashes($rest->rest_Name);
        $subject = 'Your Comment on ' . stripslashes($rest->rest_Name) . ' is Approved - azooma.co';
        $data['review_Msg'] = $review_Msg;
        $data['user_activity_id'] = $user_activity_id;
        $user_Email = "";
        $user_Email = $userInfo->user_Email;
        if ($userInfo->user_Status == 1) {
            Mail::queue('emails.user.commentnotify', $data, function($message) use ($subject, $user_Email, $sufratiUser) {
                $message->to("ha@azooma.co", 'Sufrati.com')->subject($subject);
                #$message->to($userEmails, 'Sufrati.com')->subject($subject);
                #$message->bcc($sufratiUser, 'Sufrati.com')->subject($subject);
            });
        }

        if (is_array($allusers)) {
            $subject = stripcslashes($username) . ' commented on ' . stripcslashes($rest->rest_Name) . ' - azooma.co';
            foreach ($allusers as $user) {
                $otheruserInfo = "";
                $otheruserInfo = User::getUser($user->user_ID);
                if (is_array($otheruserInfo) && $otheruserInfo->user_Status == 1) {
                    if (User::checkNotificationStatus($user->user_ID)) {
                        $data['user'] = "";
                        $data['user'] = $otheruserInfo;
                        $data['commentUser'] = $username;
                        $user_Email = "";
                        $user_Email = $otheruserInfo['user_Email'];
                        Mail::queue('emails.user.commentnotifyother', $data, function($message) use ($subject, $user_Email, $sufratiUser) {
                            $message->to("chaudhry639@gmail.com", 'Sufrati.com')->subject($subject);
                            #$message->to($userEmails, 'Sufrati.com')->subject($subject);
                            #$message->bcc($sufratiUser, 'Sufrati.com')->subject($subject);
                        });
                    }
                }
                $msg = stripcslashes($username) . ' commented on ' . stripcslashes($rest->rest_Name);
                $msgar = stripcslashes($username) . ' commented on ' . stripcslashes($rest->rest_Name);
                $pushmessage = array('message' => $msg, 'rest' => $rest->rest_ID, 'comment' => $user_activity_id, 'scenario' => 'comment');
                //User::pushNotify($otheruserInfo->user_ID, $pushmessage, $msg, $msgar);
            }
        }

        if ($rest->rest_Email != "") {
            $data['user'] = $userInfo;
            $data['rest'] = $rest;
            $data['title'] = "Commented on " . stripslashes($rest->rest_Name);
            $data['sitename'] = $settings['name'];
            $data['review_Msg'] = $review_Msg;
            $data['user_activity_id'] = $user_activity_id;
            $subject = "";
            $subject = $username . ' Commented on ' . stripslashes($rest->rest_Name) . ' at www.azooma.co';

            $user_Email = "";
            $user_Email = $rest->rest_Email;

            Mail::queue('emails.restaurant.commentnotify', $data, function($message) use ($subject, $user_Email, $sufratiUser) {
                $message->to("aas@azooma.co", 'Sufrati.com')->subject($subject);
                #$message->to($userEmails, 'Sufrati.com')->subject($subject);
                #$message->bcc($sufratiUser, 'Sufrati.com')->subject($subject);
            });
        }
    }

    public function artcat() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $limit = 20;
        $status = 0;
        $lists = MComments::getAllArticleCategories($country);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Category Name', 'Total Comments', 'Last Update', 'Actions'),
            'pagetitle' => 'List of All Article Categories',
            'title' => 'All Article Categories',
            'action' => 'adminarticlecomments',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Miscellaneous','Article Comments'),
        );
        return view('admin.partials.artcategory', $data);
    }

    public function art($category = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $limit = 20;
        $status = 0;
        $new = 0;
        $name = "";
        $sort = "";
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['new']) && !empty($_GET['new'])) {
            $new = stripslashes($_GET['new']);
        }
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        $cat = MComments::getArticleCategory($category);
        $lists = MComments::getAllArticleComments($country, $category, $status, $limit, $new, $sort, $name);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Comment', 'Name', 'Email', 'Article', 'Comment date', 'Actions'),
            'pagetitle' => 'List of All Coments for '.$cat->name,
            'title' => 'All Coments for '.$cat->name,
            'action' => 'adminarticlecomments',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Miscellaneous','Restaurant Comments'),
        );
        return view('admin.partials.artcomment', $data);
    }
    
    public function artread($id = 0) {
        MComments::readArticleComment($id);
    }
    
    public function artdelete($id = 0) {
        if (!empty($id)) {
            $page = MComments::getArticleComment($id);
            if (count($page) > 0) {
                MComments::deleteArticleComment($id);
                Admin::addActivity('Comment Deleted');
                return Redirect::route('adminarticlecomments/view/',$page->category)->with(array('message' => 'Comment deleted successfully.'));
            }
        }
        return Redirect::route('adminarticlecomments')->with(array('message' => 'something went wrong, Please try again.'));
    }
    
    public function artstatus($id = 0) {
        if (!empty($id)) {
            $page = MComments::getArticleComment($id);
            if (count($page) > 0) {
                $displayMsg="";
                $status=0;
                if($page->status==0){
                    $displayMsg="";
                    $status=1;
                }else{
                    $displayMsg="";
                    $status=0;
                }
                MComments::setStatusArticleComment($id,$status);
                Admin::addActivity($displayMsg);
                return Redirect::route('adminarticlecomments/view/',$page->category)->with(array('message' => $displayMsg));
            }
        }
        return Redirect::route('adminarticlecomments')->with(array('message' => 'something went wrong, Please try again.'));
    }
    
}
