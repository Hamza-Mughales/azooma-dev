<?php

use Yajra\DataTables\Facades\DataTables;

class AdminComments extends AdminController
{

    protected $Art_Work;
    protected $MGeneral;

    public function __construct()
    {
        parent::__construct();
        $this->Art_Work = new ArtWork();
        $this->MGeneral = new MGeneral();
    }

    public function index()
    {
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

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Comment', 'Name', 'Restaurant', 'Email', 'Date', 'Actions'),
            'pagetitle' => 'List of All Restaurant Comments',
            'title' => ' All Restaurant Comments',
            'action' => 'admincomments',
            'country' => $country,
            'side_menu' => array('Miscellaneous', 'Restaurant Comments'),
        );
        return view('admin.partials.comment', $data);
    }

    public function data_table()
    {
        $query = DB::table('review')->select(
            'review_ID AS id',
            'review_Status as status',
            'review_Msg',
            'review_Date',
            'review.is_read',
            'review.user_ID',
            DB::Raw('(SELECT restaurant_info.rest_Name FROM restaurant_info WHERE restaurant_info.rest_ID=review.rest_ID) as restaurant'),
            DB::Raw('(SELECT user.user_FullName FROM user WHERE user.user_ID = review.user_ID) AS uname'),
            DB::Raw('(SELECT user.user_Email FROM user WHERE user.user_ID = review.user_ID) AS email')
        );
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("review_Status", '=', intval(get('status')));
        }
        if (Input::has('rest_ID')) {
            $query->where("rest_ID", '=', intval(get('rest_ID')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns = '';
                $btns = '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admincomments/view/', $list->id)  . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($list->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admincomments/status/', $list->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admincomments/status/', $list->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-button" href="#" link="' . route('admincomments/delete/', $list->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })

            ->editColumn('review_Msg', function ($list) {
                return stripslashes($list->review_Msg);
            })
            ->editColumn('uname', function ($list) {
                return stripslashes($list->uname);
            })
            ->editColumn('restaurant', function ($list) {
                return stripslashes($list->restaurant);
            })
            ->editColumn('email', function ($list) {
                return stripslashes($list->email);
            })
            ->editColumn('review_Date', function ($list) {
                if ($list->review_Date != "" && $list->review_Date != "0000-00-00") {
                    $btn = date('d/m/Y', strtotime($list->review_Date));
                    $btn .= '<br>';
                    $btn .= date('h:i:s', strtotime($list->review_Date));
                    return $btn;
                } else {
                    $btn = 'Unknown';
                    return $btn;
                }
            })
            ->make(true);
    }

    public function view($id = 0)
    {
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
                'side_menu' => array('Miscellaneous', 'Restaurant Comments'),
            );
            if (!empty($page->user_ID)) {
                $data['user'] = MComments::getRestaurantCommentUser($page->user_ID);
            }
            return view('admin.forms.viewcomment', $data);
        }
    }

    public function save()
    {
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

        return returnMsg('success', 'admincomments', 'Comment modified successfully.');
    }

    public function status($id = 0)
    {
        try {
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


                    return returnMsg('success', 'admincomments', $displaymessage);
                }
            }

            return returnMsg('error', 'admincomments', 'something went wrong, Please try again.');
        } catch (Exception $ex) {
            // return $ex->getMessage();
            return returnMsg('error', 'admincomments', mb_substr($ex->getMessage(), 1, 50));
        }
    }

    public function delete($id = 0)
    {
        if (!empty($id)) {
            $page = MComments::getRestaurantComment($id);
            if (count($page) > 0) {
                MComments::deleteRestaurantComment($id);
                Admin::addActivity('Comment Deleted');

                return returnMsg('success', 'admincomments', 'Comment deleted successfully.');
            }
        }

        return returnMsg('error', 'admincomments', 'something went wrong, Please try again.');
    }

    public function read($id = 0)
    {
        MComments::readRestaurantComment($id);
    }

    public function commentsNotification($user_activity_id = 0, $user_id = 0, $rest_id = 0, $review_Msg = "")
    {
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
            Mail::queue('emails.user.commentnotify', $data, function ($message) use ($subject, $user_Email, $sufratiUser) {
                $message->to("ha@azooma.co", 'Azooma.co')->subject($subject);
                #$message->to($userEmails, 'Azooma.co')->subject($subject);
                #$message->bcc($sufratiUser, 'Azooma.co')->subject($subject);
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
                        Mail::queue('emails.user.commentnotifyother', $data, function ($message) use ($subject, $user_Email, $sufratiUser) {
                            $message->to("chaudhry639@gmail.com", 'Azooma.co')->subject($subject);
                            #$message->to($userEmails, 'Azooma.co')->subject($subject);
                            #$message->bcc($sufratiUser, 'Azooma.co')->subject($subject);
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

            Mail::queue('emails.restaurant.commentnotify', $data, function ($message) use ($subject, $user_Email, $sufratiUser) {
                $message->to("aas@azooma.co", 'Azooma.co')->subject($subject);
                #$message->to($userEmails, 'Azooma.co')->subject($subject);
                #$message->bcc($sufratiUser, 'Azooma.co')->subject($subject);
            });
        }
    }

    public function artcat()
    {
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
            'side_menu' => array('Miscellaneous', 'Article Comments'),
        );
        return view('admin.partials.artcategory', $data);
    }

    public function artcat_data_table()
    {
        $query = DB::table('categories')
            // ->select('*', DB::Raw('(SELECT count(id) FROM articlecomment where category=categories.id) as totalcomment'));
            ->select('*', DB::Raw('(SELECT count(id) FROM articlecomment where articlecomment.category=categories.id) AS totalcomment'));
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        return  DataTables::of($query)

            ->editColumn('name', function ($list) {
                return  stripslashes($list->name) . '<br>' . stripslashes($list->nameAr);
            })
            ->addColumn('totalcomment', function ($list) {
                return $list->totalcomment;
            })
            ->editColumn('lastupdatedArticle', function ($list) {
                if ($list->lastupdatedArticle == "" || $list->lastupdatedArticle == "0000-00-00 00:00:00") {
                    return date('d/m/Y', strtotime($list->createdAt));
                } else {
                    return date('d/m/Y', strtotime($list->lastupdatedArticle));
                }
            })
            ->editColumn('action', function ($list) {
                return '<a class="btn btn-xs btn-info mytooltip" href="' . route('adminarticlecomments/view/', $list->id)  . '" title="Edit Content"><i class="fa fa-eye"></i> View Comments </a>';
            })
            ->make(true);
    }

    public function art($category = 0)
    {
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
            'pagetitle' => 'List of All Coments for ' . $cat->name,
            'title' => 'All Coments for ' . $cat->name,
            'action' => 'adminarticlecomments',
            'lists' => $lists,
            'country' => $country,
            'side_menu' => array('Miscellaneous', 'Restaurant Comments'),
        );
        return view('admin.partials.artcomment', $data);
    }

    public function artread($id = 0)
    {
        MComments::readArticleComment($id);
    }

    public function artdelete($id = 0)
    {
        if (!empty($id)) {
            $page = MComments::getArticleComment($id);
            if (count($page) > 0) {
                MComments::deleteArticleComment($id);
                Admin::addActivity('Comment Deleted');

                return returnMsg('success', 'adminarticlecomments/view/', 'Comment deleted successfully.', $page->category);
            }
        }

        return returnMsg('error', 'adminarticlecomments', 'Something went wrong, Please try again.');
    }

    public function artstatus($id = 0)
    {
        if (!empty($id)) {
            $page = MComments::getArticleComment($id);
            if (count($page) > 0) {
                $displayMsg = "";
                $status = 0;
                if ($page->status == 0) {
                    $displayMsg = "";
                    $status = 1;
                } else {
                    $displayMsg = "";
                    $status = 0;
                }
                MComments::setStatusArticleComment($id, $status);
                Admin::addActivity($displayMsg);

                return returnMsg('success', 'adminarticlecomments/view/', $displayMsg, $page->category);
            }
        }

        return returnMsg('error', 'adminarticlecomments', 'something went wrong, Please try again.');
    }
}
