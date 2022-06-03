<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class Dashboard extends AdminController
{

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

        $YearsChart = DB::table('analytics')
            ->select(DB::raw('YEAR(created_at) year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        $years_chart = [];
        foreach ($YearsChart as $value) {
            $years_chart[] = $value->year;
        }

        $data = array(
            'sitename' => $settings['name'],
            'pagetitle' => 'Dashboard',
            'title' => 'Dashboard',
            'action' => 'dashboard',
            'country' => $country,
            'settings' => $settings,
            'YearsChart' => $years_chart,
            'TotalVisits' => $this->visitors_chart()['TotalVisits'],
            'EnglishVisits' => $this->visitors_chart()['EnglishVisits'],
            'ArabicVisits' => $this->visitors_chart()['ArabicVisits'],
            'partials_name' => 'coursescatpage',
            'side_menu' => array('home'),
        );

        return view('admin.partials.dashboard', $data);
    }
    public function ownerHome()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
     
        $countries = DB::table('aaa_country')
            ->get();
    
        $data = array(
            'sitename' => $settings['name'],
            'pagetitle' => 'Owner Dashboard',
            'title' => 'Dashboard',
            'action' => 'dashboard',
            'partials_name' => 'coursescatpage',
            "countries"=>$countries,
            'side_menu' => array('home'),
        );

        return view('admin.owner.home', $data);
    }
public function countryDashboard($id){
    
    Session::forget('admincountry');
    Session::put('admincountry', $id);
    $this->MGeneral = new MGeneral();
    Session::put('admincountryName', Str::slug($this->MGeneral->getAdminCountryName($id), '-', TRUE));
    return Redirect::route('adminhome');

}
    public function visitors_chart()
    {
        $year = '';
        if (Input::has('year')) {
            $year = get('year');
        }
        // dd($year, get('year'));

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $TotalVisits =  MDashboard::getVisitNew($country, "", $year);
        $EnglishVisits = MDashboard::getVisitNew($country, 'en', $year);
        $ArabicVisits = MDashboard::getVisitNew($country, 'ar', $year);

        // dd($years_chart);

        $total_visits = $english_visits = $arabic_visits = [];

        for ($i = 1; $i <= 12; $i++) {
            $month_visitor = $month_visitor_en = $month_visitor_ar = 0;

            foreach ($TotalVisits as $t) {

                if ($i == intval($t->month)) {
                    $month_visitor = intval($t->total);
                }
            }
            $total_visits[] = $month_visitor;

            foreach ($EnglishVisits as $t) {

                if ($i == intval($t->month)) {
                    $month_visitor_en = intval($t->total);
                }
            }
            $english_visits[] = $month_visitor_en;

            foreach ($ArabicVisits as $t) {

                if ($i == intval($t->month)) {
                    $month_visitor_ar = intval($t->total);
                }
            }
            $arabic_visits[] = $month_visitor_ar;
        }

        $data = array(
            'TotalVisits' => $total_visits,
            'EnglishVisits' => $english_visits,
            'ArabicVisits' => $arabic_visits
        );

        if (!empty($year)) {
            $data =  json_encode($data);
        }

        // dd($data);
        return $data;
    }

    public function suggest()
    {
        $term = "";
        if (Input::has('term')) {
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }
            $term = stripslashes(Input::get('term'));
            echo $term;
            $restaurants = MDashboard::getRestaurantSuggestionResult($country, $term);
            return Response::json($restaurants);
        }
    }

    public function search()
    {
        if (Input::has('type') && Input::get('type') == 'restaurants') {
            // dd( Input::get());
            // dd('fffffffff', Input::get('type') );

            $status = $city = $cuisine = $best = $membership = $rest_style = $class_category = $price_range = '';
            $limit = "";
            $country = 0;
            $count = false;
            $district = '';
            $rest_viewed = 0;
            $country = Session::get('admincountry');
            if (empty($country)) {
                $country = 1;
            }

            if (Input::has('status')) {
                $status = Input::get('status');
            }
            if (Input::has('city')) {
                $city = Input::get('city');
            }
            if (Input::has('cuisine')) {
                $cuisine = Input::get('cuisine');
            }
            if (Input::has('best')) {
                $best = Input::get('best');
            }
            if (Input::has('membership')) {
                $membership = Input::get('membership');
            }
            if (Input::has('rest_style')) {
                $rest_style = Input::get('rest_style');
            }
            if (Input::has('class_category')) {
                $class_category = Input::get('class_category');
            }
            if (Input::has('price_range')) {
                $price_range = Input::get('price_range');
            }


            $reaturants = MRestActions::getAllRestaurants($country, $city, $status, $limit, $count, $district, $rest_viewed, $cuisine, $best, $membership, $price_range);
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Haroon Akram")
                ->setLastModifiedBy("Haroon Akram")
                ->setTitle("Restaurants Report Genereated by Haroon")
                ->setSubject("Restaurants Report Genereated by Haroon")
                ->setDescription("Restaurants Report Genereated by Haroon")
                ->setKeywords("Restaurants")
                ->setCategory("Restaurants");
            //HEADINGS
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Restaurant Name')
                ->setCellValue('B1', 'Restaurant Name Arabic')
                ->setCellValue('C1', 'Membership Type')
                ->setCellValue('D1', 'Joined On')
                ->setCellValue('E1', 'Expire Date')
                ->setCellValue('F1', 'Member Duration')
                ->setCellValue('G1', 'Contact Name')
                ->setCellValue('H1', 'Email')
                ->setCellValue('I1', 'Phone')
                ->setCellValue('J1', 'Status');
            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('f7f7f7');
            $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



            //DATA
            if (is_array($reaturants) && count($reaturants) > 0) {
                // dd('gggggggggg');

                $counter = 2;
                foreach ($reaturants as $rest) {
                    $expiryDate = "";
                    if (!empty($rest->member_duration)) {
                        $expiryDate = date("Y-m-d", strtotime("+" . $rest->member_duration . " month", strtotime($rest->member_date)));
                    } elseif (!empty($rest->member_date)) {
                        $expiryDate = date("Y-m-d", strtotime($rest->member_date));
                    }
                    $membershipType = "";
                    if ($rest->rest_Subscription == 0) {
                        $membershipType = "FREE";
                    } elseif ($rest->rest_Subscription == 1) {
                        $membershipType = "FREE";
                    } elseif ($rest->rest_Subscription == 2) {
                        $membershipType = "SLVER";
                    } elseif ($rest->rest_Subscription == 3) {
                        $membershipType = "GOLD";
                    }
                    $statusType = "Deactive";
                    if ($rest->rest_Status == 1) {
                        $statusType = "Active";
                    }

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, stripslashes($rest->rest_Name))
                        ->setCellValue('B' . $counter, stripslashes($rest->rest_Name_Ar))
                        ->setCellValue('C' . $counter, $membershipType)
                        ->setCellValue('D' . $counter, $rest->member_date)
                        ->setCellValue('E' . $counter, $expiryDate)
                        ->setCellValue('F' . $counter, $rest->member_duration)
                        ->setCellValue('G' . $counter, $rest->your_Name)
                        ->setCellValue('H' . $counter, $rest->your_Email)
                        ->setCellValue('I' . $counter, $rest->your_Contact)
                        ->setCellValue('J' . $counter, $statusType);

                    $counter++;
                }
            }


            $objPHPExcel->getActiveSheet()->setTitle('Restaurants report');
            $objPHPExcel->setActiveSheetIndex(0);
            $filename = 'restaurants-' . date('d-m-Y H:i:s') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $filename);
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }

        if (Input::has('type') && Input::get('type') == 'users') {
            // dd( Input::get(), Session::get('userid'), 'ggggggg');

            $status = $city = '';
            $users = DB::table('user')->select(
                'user_Name',
                DB::Raw('(SELECT city_list.name FROM city_list WHERE user_City.name = user.user_City) AS city'),
                'user_Sex',
                'user_Mobile',
                'user_Email',
                'user_Status'
            );

            // }
            if (Input::has('status')) {
                // dd('Input::has("status")');
                $users->where('user_Status', '=', Input::get('status'));
            }
            if (Input::has('city')) {

                // dd('Input::has("city")', Input::get('city'));
                // $user= DB::select((DB::raw('SELECT `name` FROM city_list ON city_list.name=users.user_City WHERE city_list.id = ') AS city);
                // $users->where('user_City', '=', Input::get('city'));
                $users->where('user_City', '=', DB::Raw('(SELECT city_list.name FROM city_list WHERE city_list.id =' . Input::get('city') . ' ) AS city'));
            }


            // $users = $this->MUser->getAllUsers($country,$status);
            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Haroon Akram")
                ->setLastModifiedBy("Haroon Akram")
                ->setTitle("Restaurants Report Genereated by Haroon")
                ->setSubject("Restaurants Report Genereated by Haroon")
                ->setDescription("Restaurants Report Genereated by Haroon")
                ->setKeywords("Restaurants")
                ->setCategory("Restaurants");
            //HEADINGS
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', ' Name')
                ->setCellValue('B1', ' City')
                ->setCellValue('C1', ' Sex')
                ->setCellValue('D1', ' Mobile')
                ->setCellValue('E1', ' Email')
                ->setCellValue('F1', ' Status');

            //DATA
            if (is_array($users) && count($users) > 0) {

                $counter = 2;
                foreach ($users as $user) {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, stripslashes($user->user_FullName))
                        ->setCellValue('B' . $counter, stripslashes($user->city))
                        ->setCellValue('C' . $counter, stripslashes($user->user_Sex))
                        ->setCellValue('D' . $counter, stripslashes($user->user_Mobile))
                        ->setCellValue('E' . $counter, stripslashes($user->user_Email))
                        ->setCellValue('F' . $counter, stripslashes($user->user_Status));

                    $user++;
                }
            }


            $objPHPExcel->getActiveSheet()->setTitle('Users report');
            $objPHPExcel->setActiveSheetIndex(0);
            $filename = 'users-' . date('d-m-Y H:i:s') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $filename);
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }



        if (isset($_GET['excel']) && $_GET['excel'] == '1') {
            // dd('aaaaaaaaaa');

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("www.azooma.co")
                ->setLastModifiedBy("www.azooma.co")
                ->setTitle($data['pagetitle'])
                ->setSubject($data['pagetitle']);

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Hello')
                ->setCellValue('B1', 'world!')
                ->setCellValue('C1', 'Hello')
                ->setCellValue('D2', 'world!');

            $objPHPExcel->getActiveSheet()->setTitle('report');
            $objPHPExcel->setActiveSheetIndex(0);

            //EXCEL FILE DOWNLOAD
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="filename.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }
    }
}
