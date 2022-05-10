<?php

class RestPoll extends AdminController {

    protected $MAdmins;
    protected $MGeneral;
    protected $MPoll;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
        $this->MPoll = new MPoll();
    }

    public function index($restID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $limit = 5000;

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $country = 1;
        $lists = $lists = $this->MPoll->getAllPolls($country, $restID, 0, $limit);
        if ($restID == 0) {
            $data = array(
                'sitename' => $settings['name'],
                'MGeneral' => $this->MGeneral,
                'MPoll' => $this->MPoll,
                'headings' => array('Location', 'Location Arabic', 'Result', 'Added On', 'Updated On', 'Actions'),
                'pagetitle' => 'List of All Polls ',
                'title' => 'All Polls',
                'action' => 'adminrestgallery',
                'lists' => $lists,
                'side_menu' => ['Miscellaneous','Manage Polls'],
            );
            return view('admin.partials.poll', $data);
        } else {
            $rest = $this->MRestActions->getRest($restID);
            $data = array(
                'sitename' => $settings['name'],
                'MGeneral' => $this->MGeneral,
                'MPoll' => $this->MPoll,
                'headings' => array('Location', 'Location Arabic', 'Result', 'Added On', 'Updated On', 'Actions'),
                'pagetitle' => 'List of All Polls for ' . $rest->rest_Name,
                'title' => 'All Polls for ' . $rest->rest_Name,
                'action' => 'adminrestgallery',
                'lists' => $lists,
                'rest_ID' => $restID,
                'rest' => $rest,
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );

            return view('admin.partials.restaurantpoll', $data);
        }
    }

    public function form($poll_ID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if (Input::has('rest_ID')) {
            $rest_ID = Input::get('rest_ID');
        } else {
            $rest_ID = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }


        if ($poll_ID == 0) {
            $data = array(
                'pagetitle' => 'New Poll ',
                'title' => 'New Poll ',
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'MPoll' => $this->MPoll,
                'sitename' => $settings['name'],
                'js' => 'admin/poll',
                'side_menu' => array('Miscellaneous','Manage Polls'),
            );
        } else {
            $options = $this->MPoll->getPollOptions($poll_ID);
            $poll = $this->MPoll->getPoll($poll_ID);
            $data = array(
                'pagetitle' => 'Updating Poll ' . stripslashes($poll->question),
                'title' => 'Updating Poll ' . stripslashes($poll->question),
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'MPoll' => $this->MPoll,
                'sitename' => $settings['name'],
                'poll' => $poll,
                'options' => $options,
                'js' => 'admin/poll',
                'side_menu' => ['Restaurant Mgmt'],
            );
        }
        if ($rest_ID != 0) {
            $rest = $this->MRestActions->getRest($rest_ID);
            $data['rest'] = $rest;
            $data['rest_ID'] = $rest_ID;
            $data['action'] = 'adminrestaurants/polls/' . $rest_ID;
            $data['saveurl'] = 'adminrestaurants/pollsave';
        } else {
            $data['action'] = 'adminpolls';
            $data['saveurl'] = 'adminpollsave';
        }
        return view('admin.forms.restpoll', $data);
    }

    public function save() {
        $rest = Input::get('rest_ID');
        if (!empty($rest)) {
            $restaurant = $this->MRestActions->getRest($rest);
            $restname = stripslashes($restaurant->rest_Name);
        }
        if (Input::get('question')) {
            $image = "";
            $actualWidth = "";
            $ratio = "0";
            if (Input::hasFile('image')) {
                $file = Input::file('image');
                $temp_name = $_FILES['image']['tmp_name'];
                $image = $save_name = uniqid(Config::get('settings.sitename')) . $file->getClientOriginalName();
                $thumbHeight = null;
                $conserveProportion = true;
                $positionX = 0; // px
                $positionY = 0; // px
                $position = 'MM';
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
                $thumbLayer = clone $largeLayer;
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                if ($actualWidth < 200 && $actualHeight < 200) {
                    if (!empty($rest)) {
                        return returnMsg('error','adminrestaurants/polls/','Image is very small. Please upload image which must be bigger than 200*200 width and height.',[$rest]);

                    } else {
                        return returnMsg('error','adminpolls','Image is very small. Please upload image which must be bigger than 200*200 width and height.',[$rest]);

                    }
                }
                if (!empty($rest)) {
                    $text_font = $restaurant->rest_Name . '-' . Input::get('question') . '- azooma.co';
                } else {
                    $text_font = Input::get('question') . '- azooma.co';
                }
                $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                $textLayer->opacity(75);
                $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");

                if (($actualWidth > 800) || ($actualHeight > 500)) {
                    $largeLayer->resizeInPixel(800, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/poll/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/poll/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/poll/thumb/", $save_name, true, null, 95);

            } else {
                if (Input::has('imageOld')) {
                    $image = Input::get('imageOld');
                }
            }

            if (Input::get('id')) {
                $poll = Input::get('id');
                $rest_ID = Input::get('rest_ID');
                $this->MPoll->updatePollQuestion($image);
                $options = $this->MPoll->getPollOptions($poll);
                if (count($options) > 0) {
                    foreach ($options as $option) {
                        if (Input::get('field-' . $option->id)) {
                            $field = (Input::get('field-' . $option->id));
                            $field_ar = (Input::get('field_ar-' . $option->id));
                            $status = $option->status;
                            $this->MPoll->updatePollAnswer($field, $field_ar, $status, $poll, $option->id);
                        } else {
                            $this->MPoll->deleteAnswer($option->id);
                        }
                    }
                }
                if (isset($_POST['option'])) {
                    $option = $_POST['option'];
                    $optionar = $_POST['option_ar'];
                    for ($i = 0; $i < count($option); $i++) {
                        if ($option[$i] != "") {
                            $field = $option[$i];
                            $fieldar = $optionar[$i];
                            $this->MPoll->addPollAnswer($field, $fieldar, 1, $poll);
                        }
                    }
                }

                $this->MAdmins->addActivity('Updated Poll ' . stripslashes((Input::get('question'))));
                if (!empty($rest)) {
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addRestActivity('Poll is updated.', $restaurant->rest_ID, Input::get('id'));
                    return returnMsg('success','adminrestaurants/polls/',"Poll updated Successfully.",[$rest]);

                } else {
                    return returnMsg('success','adminpolls',"Poll updated Successfully.");

                }
            } else {
                $last_inserted_id = $poll = $this->MPoll->addPollQuestion($image);
                if (isset($_POST['option'])) {
                    $option = $_POST['option'];
                    $optionar = $_POST['option_ar'];
                    for ($i = 0; $i < count($option); $i++) {
                        if ($option[$i] != "") {
                            $field = $option[$i];
                            $fieldar = $optionar[$i];
                            $this->MPoll->addPollAnswer($field, $fieldar, 1, $poll);
                        }
                    }
                }
                $this->MAdmins->addActivity('Poll updated');
                if (!empty($rest)) {
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addRestActivity('A new Poll is added.', $restaurant->rest_ID, $last_inserted_id);
                    return returnMsg('success','adminrestaurants/polls/',"Poll updated Successfully.",[$rest]);

                } else {
                    return returnMsg('success','adminpolls',"Poll updated Successfully.");
                   
                }
            }
        } else {
            show_404();
        }
    }

    public function delete($poll = 0) {
        $pollObj = $this->MPoll->getPoll($poll);
        // dd('ffffffff', $poll, $pollObj);
        $this->MAdmins->addActivity('Poll Deleted ' . stripslashes($pollObj->question));
        $this->MPoll->deleteQuestion($poll);
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
            $this->MRestActions->updateRestLastUpdatedOn($rest);
            return returnMsg('success','adminrestaurants/polls/','Poll Deleted succesfully',[$rest]);
        } else {
            return returnMsg('success','adminpolls','Poll Deleted succesfully');

        }
    }

    public function status($poll = 0) {
        $pollObj = $this->MPoll->getPoll($poll);
        $message = "";
        if ($pollObj->status == 1) {
            $this->MPoll->deActivateQuestion($poll);
            $this->MAdmins->addActivity('Deactivated Poll ' . stripslashes(($pollObj->question)));
            $message = "Poll Deactivated succesfully";
        } else {
            $this->MPoll->activateQuestion($poll);
            $this->MAdmins->addActivity('Activated Poll ' . stripslashes(($pollObj->question)));
            $message = "Poll Activated succesfully";
        }
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
            $this->MRestActions->updateRestLastUpdatedOn($rest);
            return returnMsg('success','adminrestaurants/polls/', $message,[$rest]);

        } else {
            return returnMsg('success','adminpolls',$message);

        }
    }

    public function options($pollID = 0) {
        $rest_ID = 0;
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest_ID = $_REQUEST['rest_ID'];
        }

        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $limit = 5000;
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $lists = $this->MPoll->getPollOptions($pollID);
        $poll = $this->MPoll->getPoll($pollID);
        // dd($pollID, $lists, $poll);

        $data = array(
            'sitename' => $settings['name'],
            'MGeneral' => $this->MGeneral,
            'MPoll' => $this->MPoll,
            'headings' => array('Option', 'Votes', 'Last Updated on', 'Actions'),
            'pagetitle' => 'Options for ' . $poll->question,
            'title' => 'Options for ' . $poll->question,
            'action' => 'adminrestgallery',
            'options' => $lists,
            'poll' => $poll,
            'pollID' => $pollID,
            'side_menu' => ['Miscellaneous','Manage Polls'],
        );

        if ($rest_ID != 0) {
            $rest = $rest_data = $this->MRestActions->getRest($rest_ID);
            $data['rest'] = $rest;
            $data['rest_ID'] = $rest_ID;
            $data['action'] = 'adminrestaurants/polls/' . $rest_ID;
            $data['saveurl'] = 'adminrestaurants/pollsave';
            return view('admin.partials.restaurantpolloptions', $data);
        } else {
            $data['action'] = 'adminpolls';
            $data['saveurl'] = 'adminpollsave';
            return view('admin.partials.polloptions', $data);
        }
    }

    function optionform($id = 0) {
        $status = 0;
        $rest_ID = 0;
        $poll = 0;
        if (isset($_POST['field'])) {
            $poll = Input::get('poll_id');
            if (isset($_POST['status'])) {
                $status = 1;
            }
            if (Input::has('rest_ID')) {
                $rest_ID = Input::get('rest_ID');
            }
            $field = Input::get('field');
            $field_ar = Input::get('field_ar');
            if (Input::get('id')) {
                $this->MPoll->updatePollAnswer($field, $field_ar, $status, $poll, Input::get('id'));
                $this->MAdmins->addActivity('Updated Poll ' . stripslashes((Input::get('question'))));
                if ($rest_ID == 0) {
                    return returnMsg('success','adminpolloptions/', "Poll option updated succesfully",[ $poll]);

                } else {
                    return returnMsg('success','adminrestaurants/polls/', "Poll option updated succesfully",[ $rest_ID]);

                }
            } else {
                $this->MPoll->addPollAnswer($field, $field_ar, $status, $poll);
                $this->MAdmins->addActivity('Added Poll ' . stripslashes((Input::get('question'))));
                if ($rest_ID == 0) {
                    return returnMsg('success','adminpolloptions/', "Poll option added succesfully",[ $poll]);

                } else {
                    return returnMsg('success','adminrestaurants/polls/', "Poll option added succesfully",[ $rest_ID]);

                }
            }
        } else {
            if (Session::get('admincountryName') != "") {
                $settings = Config::get('settings.' . Session::get('admincountryName'));
            } else {
                $settings = Config::get('settings.default');
            }
            if (Input::has('rest_ID')) {
                $rest_ID = Input::get('rest_ID');
            }
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            $poll_ID = 0;
            if (isset($_GET['poll']) && ($_GET['poll'] != "")) {
                $poll_ID = ($_GET['poll']);
            }

            $poll = $this->MPoll->getPoll($poll_ID);
            if ($id == 0) {
                $data = array(
                    'pagetitle' => 'Updating Poll option ' . stripslashes($poll->question),
                    'title' => 'Poll option ' . stripslashes($poll->question),
                    'MRestActions' => $this->MRestActions,
                    'MGeneral' => $this->MGeneral,
                    'MPoll' => $this->MPoll,
                    'sitename' => $settings['name'],
                    'poll' => $poll,
                    'js' => 'admin/poll'
                );
            } else {
                $options = $this->MPoll->getPollOption($id);
                $data = array(
                    'pagetitle' => 'Updating Poll ' . stripslashes($poll->question),
                    'title' => 'Updating Poll ' . stripslashes($poll->question),
                    'MRestActions' => $this->MRestActions,
                    'MGeneral' => $this->MGeneral,
                    'MPoll' => $this->MPoll,
                    'sitename' => $settings['name'],
                    'poll' => $poll,
                    'option' => $options,
                    'action' => 'adminpolls',
                    'js' => 'admin/poll'
                );
            }
            if ($rest_ID != 0) {
                $rest = $rest_data = $this->MRestActions->getRest($rest_ID);
                $data['rest'] = $rest;
                $data['rest_ID'] = $rest_ID;
                $data['action'] = 'adminrestaurants/polls/' . $rest_ID;
                $data['saveurl'] = 'adminrestaurants/pollsave';
                $data['side_menu'] =  ['Restaurant Mgmt'];
                $data['saveurl'] = 'adminpollsave';
                $data['side_menu'] = ['Restaurant Mgmt'];
            }

            // dd($data);
            return view('admin.forms.polloptionform', $data);
        }
    }

    function optionstatus($poll = 0) {
        $rest_ID = 0;
        if (Input::has('rest_ID')) {
            $rest_ID = Input::get('rest_ID');
        }
        $cuisine = $this->MPoll->getPollOption($poll);
        if ($cuisine->status == 1) {
            $this->MPoll->deActivateAnswer($poll);
            $this->MAdmins->addActivity('Deactivated Poll ' . stripslashes(($cuisine->field)));
        } else {
            $this->MPoll->activateAnswer($poll);
            $this->MAdmins->addActivity('Activated Poll ' . stripslashes(($cuisine->field)));
        }
        if ($rest_ID == 0) {
            return returnMsg('success','adminpolloptions/', "Poll option status changed succesfully",[  $cuisine->poll_id]);

        } else {
            return returnMsg('success','adminrestaurants/polls/', "Poll option status changed succesfully",[ $rest_ID]);

        }
    }

    function optiondelete($id = 0) {
        $rest_ID = 0;
        // dd('fffffffff' , Input::has('rest_ID'), $id,Input::get('poll'));
        if (Input::has('rest_ID')) {
            $rest_ID = Input::get('rest_ID');
        }
        if (Input::has('poll')) {
            $pool_id = Input::get('poll');
        }
        $cuisine = $this->MPoll->getPollOption($id);
        $this->MPoll->deleteAnswer($id);
        $this->MAdmins->addActivity('Deleted Poll ' . stripslashes(($cuisine->field)));
        if (isset($pool_id) && !empty($pool_id)) {
            return returnMsg('success','adminpolloptions/', "Poll option status changed succesfully",$pool_id);
        } else {
            
            return returnMsg('success','adminrestaurants/polls/', "Poll option deleted succesfully",$rest_ID);

        }
    }

}
