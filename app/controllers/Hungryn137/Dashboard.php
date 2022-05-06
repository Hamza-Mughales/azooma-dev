<?php

class Dashboard extends AdminController {

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

        $TotalVisits = MDashboard::getVisitNew($country);
        $EnglishVisits = MDashboard::getVisitNew($country, 'en');
        $ArabicVisits = MDashboard::getVisitNew($country, 'ar');

        $data = array(
            'sitename' => $settings['name'],
            'pagetitle' => 'Dashboard',
            'title' => 'Dashboard',
            'action' => 'dashboard',
            'country' => $country,
            'settings' => $settings,
            'TotalVisits' => $TotalVisits,
            'EnglishVisits' => $EnglishVisits,
            'ArabicVisits' => $ArabicVisits,
            'partials_name' => 'coursescatpage',
            'side_menu' => array('home'),
        );

        // $side_menu = 'home';

        return view('admin.partials.dashboard', $data);
    }

    public function suggest() {
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

    public function search() {
        if (Input::has('type') && Input::get('type') == 'restaurants') {

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
        } else {
            exit('qqq');
        }
        if (isset($_GET['excel']) && $_GET['excel'] == '1') {
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
