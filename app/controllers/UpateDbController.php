<?php
class UpdateDbController extends BaseController
{

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	/******
	TODO
	1. Update DB
	2. User 130 profile photo



	 *******/


	public function index()
	{
		ignore_user_abort(true);
		set_time_limit(0);
		$k = ini_set('memory_limit', '1024M');
		///$v=ini_set('max_execution_time', 6000);
		echo $k . '<br/>';
		/*
        $totalcolumns=DB::connection('sufrati-sa')->table('branch_views')->count();
        echo $totalcolumns.'<br/>';
        $allcolumns=DB::connection('sufrati-sa')->select('SELECT * FROM `branch_views` LIMIT 0,750000');
        var_dump(count($allcolumns));exit();
		//1. Copy Table Structure
		// mysqldump -d -u root -p sufrati_sufrati > sufratidbdump
		
		//2. Import this into the sufrati_db DB

		//3. Change the country field in settings table
		// ALTER TABLE `settings` CHANGE `country` `countryname` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL , CHANGE `countryAr` `countrynameAr` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL

		//4. Add `country` field to all tables in new DB sufrati_db
		/*
		$alltables=DB::connection('new-sufrati')->select('show tables');
		foreach ($alltables as $table) {
			if($table->Tables_in_diner_sufrati_db!="aaa_country"&&$table->Tables_in_diner_sufrati_db!="menuall"){
				$q="ALTER TABLE `".$table->Tables_in_diner_sufrati_db."` ADD COLUMN country INT(1) DEFAULT '1' ;";
				DB::connection('new-sufrati')->statement($q);
			}
		}
		*/
		//5. Delete some of the useless tables
		// DROP TABLE `all_ip`
		// DROP TABLE `article_rating`

		// DROP TABLE `coming_soon`
		// DROP TABLE `complains`
		// DROP TABLE `favourite_list`
		// DROP TABLE `feature`
		// DROP TABLE `follower`
		// DROP TABLE `food_for_thought`
		// DROP TABLE `fpoll_config`
		// DROP TABLE `hot_list`
		// DROP TABLE `newly_opened`
		// DROP TABLE `news`
		// DROP TABLE `notifications`
		// DROP TABLE `occupation`
		// DROP TABLE `other_links`
		// DROP TABLE `offer_rating`
		// DROP TABLE `prize_winner`
		// DROP TABLE `recent_viewed`
		// DROP TABLE `rest_index`
		// DROP TABLE `user_old`

		//Copy Table Data
		/*
		$allusers=DB::connection('sufrati-sa')->select('SELECT * FROM likee_info');
		if(count($allusers)>0){
			foreach($allusers as $columns){
				$data=array();
				foreach ($columns as $key => $value) {
					$data[$key]=$value;
				}
				DB::connection('new-sufrati')->table('likee_info')->insert($data);
			}
		}
		*/

		$alltables = DB::connection('new-sufrati')->select('show tables');
		$i = 0;

		foreach ($alltables as $table) {
			//$karr=array('newsletter','newsletter_stats','menu_downloads','photolike','searchanalytics','review','user_devices_list');
			$karr = array('activity_info', 'admin', 'analytics', 'answer', 'answeragree', 'answercomments', 'article', 'articlecomment', 'article_slide', 'artrating', 'art_work', 'askedtoanswer', 'banner', 'bannerClicks', 'bestfor_list', 'birthday', 'booking', 'booking_branches', 'booking_management', 'booking_users');
			if (!in_array($table->Tables_in_diner_sufrati_db, $karr)) {
				if ($table->Tables_in_diner_sufrati_db != "aaa_country" && $table->Tables_in_diner_sufrati_db != "menuall" && $table->Tables_in_diner_sufrati_db != "settings" && $table->Tables_in_diner_sufrati_db != "banner" && $table->Tables_in_diner_sufrati_db != "bannerClicks" && $table->Tables_in_diner_sufrati_db != "analytics" && $table->Tables_in_diner_sufrati_db != "admin") {
					if ($table->Tables_in_diner_sufrati_db != "mobile_analytics" && $table->Tables_in_diner_sufrati_db != "recent_viewed" && $table->Tables_in_diner_sufrati_db != "subscribers") {
						//Above if are large tables skip and add them later each seperately
						//Table present copy data
						//if($table->Tables_in_diner_sufrati_db=="subscribers"){
						$currenttable = $table->Tables_in_diner_sufrati_db;
						echo $currenttable . ' ---- processing...<br/>';
						$kq = DB::connection('sufrati-sa')->select('SHOW TABLES LIKE "' . $currenttable . '"');
						if (count($kq) > 0) {
							//$currentcolumns=DB::connection('new-sufrati')->select('SELECT COUNT(*) as totalcolumns FROM `'.$currenttable.'`');
							//if(count($currentcolumns)>0&&$currentcolumns[0]->totalcolumns<=0){
							$totalcolumns = DB::connection('sufrati-sa')->table($currenttable)->count();
							for ($i = 0; $i < $totalcolumns; $i = $i + 10000) {
								$allcolumns = DB::connection('sufrati-sa')->select('SELECT * FROM `' . $currenttable . '` LIMIT ' . $i . ',10000');
								if (count($allcolumns) > 0) {
									echo count($allcolumns) . ' total columns -<br/>';
									foreach ($allcolumns as $columns) {
										$data = array();
										foreach ($columns as $key => $value) {
											$data[$key] = $value;
										}
										$data['country'] = 1;
										DB::connection('new-sufrati')->table($currenttable)->insert($data);
									}
								}
							}
							//}
						}
					}
				}
			}
		}
		/*
		$usertables=DB::connection('sufrati-users')->select('show tables');
		if(count($usertables)>0){
			foreach ($usertables as $table) {
				$tarr=array('countries','nationality','occupation','user_visited_restaruants','user_list_restaurant');
				if(!in_array($table->Tables_in_diner_user, $tarr)){
					$currenttable=$table->Tables_in_diner_user;
					echo $currenttable.' ---- processing...<br/>';
					$kq=DB::connection('sufrati-users')->select('SHOW TABLES LIKE "'.$currenttable.'"');
					if(count($kq)>0){
						$currentcolumns=DB::connection('new-sufrati')->select('SELECT COUNT(*) as totalcolumns FROM `'.$currenttable.'`');
						if(count($currentcolumns)>0&&$currentcolumns[0]->totalcolumns<=0){
							$allcolumns=DB::connection('sufrati-sa')->select('SELECT * FROM `'.$currenttable.'`');
							if(count($allcolumns)>0){
								foreach($allcolumns as $columns){
									$data=array();
									foreach ($columns as $key => $value) {
										$data[$key]=$value;
									}
									//$data['country']=1;
									DB::connection('new-sufrati')->table($currenttable)->insert($data);
								}
							}
						}
					}
				}
			}
		}
		/*
		*/

		// Lebanon Data 
		// copy lebanon db into a temp db
		// Remove Auto increment fields from the tables

		//Same data for lebanon and saudi
		// bestfor_list birthday cuisine_list welcome message features_services	categories

		// Tables that has restaurant id
		// article articlecomment artrating 

		// 7. Copy just changing ID
		// activity_info admin complains email_notifications 
		/*
		$alltables=DB::connection('new-sufrati')->select('show tables');
		$i=0;
		foreach ($alltables as $table) {
			if($table->Tables_in_diner_sufrati_db!="aaa_country"&&$table->Tables_in_diner_sufrati_db!="menuall"&&$table->Tables_in_diner_sufrati_db!="settings"){
				if($table->Tables_in_diner_sufrati_db=="activity_info"||$table->Tables_in_diner_sufrati_db=="admin"||$table->Tables_in_diner_sufrati_db=="complains"||$table->Tables_in_diner_sufrati_db=="email_notifications"){
					$currenttable=$table->Tables_in_diner_sufrati_db;
					$allcolumns=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `'.$currenttable.'`');
					foreach($allcolumns as $columns){
						$data=array();
						foreach ($columns as $key => $value) {
							$data[$key]=$value;
						}
						$data['country']=2;
						DB::connection('new-sufrati')->table($currenttable)->insert($data);
					}
				}
			}
		}
		*/
		// 8. Copy tables that may have same data or same structure in general 
		/*
			Add `oldID` field to following tables DEFAULT to 0
			bestfor_list
			cuisine_list
			city_list
			restaurant_info
			rest_branches
			district_list
			rest_features
			review
			image_gallery
			rating_info
			rest_menu_pdf
			menu_cat
			rest_menu
			subscription
			booking_management
	
		*/
		//// bestfor_list birthday cuisine_list welcome_message features_services categories city_list

		//copy bestfor_list

		//ALTER TABLE  `bestfor_list` ADD  `oldID` INT NOT NULL DEFAULT 0 AFTER  `updatedAt`
		/*	$allcolumns=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `bestfor_list`');
		foreach($allcolumns as $columns){
			$name=$columns->bestfor_Name;
			$check=DB::connection('new-sufrati')->select('SELECT * FROM bestfor_list WHERE bestfor_Name =?',array($name));
			if(count($check)>0){
				$data=array('oldID'=>$columns->oldID);
				DB::connection('new-sufrati')->table('bestfor_list')->where('bestfor_ID',$check[0]->bestfor_ID)->update($data);
			}else{
				$data=array();
				foreach ($columns as $key => $value) {
					$data[$key]=$value;
				}
				$data['country']=2;
				DB::connection('new-sufrati')->table('bestfor_list')->insert($data);
			}
		} */
		//copy cuisine_list
		//ALTER TABLE  `cuisine_list` ADD  `oldID` INT NOT NULL AFTER  `updatedAt`
		//ALTER TABLE  `cuisine_list` CHANGE  `cuisine_description`  `cuisine_description` VARCHAR( 600 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `cuisine_description_ar`  `cuisine_description_ar` VARCHAR( 600 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL
		/*
		$allcolumns=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `cuisine_list`');
		foreach($allcolumns as $columns){
			$name=$columns->cuisine_Name;
			$check=DB::connection('new-sufrati')->select('SELECT * FROM cuisine_list WHERE cuisine_Name =?',array($name));
			if(count($check)>0){
				$data=array('oldID'=>$columns->oldID);
				DB::connection('new-sufrati')->table('cuisine_list')->where('cuisine_ID',$check[0]->cuisine_ID)->update($data);
			}else{
				$data=array();
				foreach ($columns as $key => $value) {
					$data[$key]=$value;
				}
				$data['country']=2;
				DB::connection('new-sufrati')->table('cuisine_list')->insert($data);
			}
		}
		*/
		/*
		copy city_list
		$alltables=array('city_list','');
		$allcolumns=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `city_list`');
		foreach($allcolumns as $columns){
				$data=array();
				foreach ($columns as $key => $value) {
					$data[$key]=$value;
				}
				$data['country']=2;
				DB::connection('new-sufrati')->table('city_list')->insert($data);
		}
	
		//copy district_list
		//ALTER TABLE  `district_list` CHANGE  `latitude`  `latitude` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL , CHANGE  `longitude`  `longitude` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL
		$alltables=array('district_list','');
		$allcolumns=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `district_list`');
		foreach($allcolumns as $columns){
				$data=array();
				foreach ($columns as $key => $value) {
					$data[$key]=$value;
				}
				$city=DB::connection('new-sufrati')->select('SELECT * FROM `city_list` WHERE oldID=?',array($data['city_ID']));
				if(count($city)>0){
					$data['city_ID']=$city[0]->city_ID;
					$data['country']=2;
					DB::connection('new-sufrati')->table('district_list')->insert($data);
				}
		}
		/*
		Update rest_type
		$allcolumns=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `rest_type`');
		foreach($allcolumns as $columns){
			$name=$columns->name;
			$check=DB::connection('new-sufrati')->select('SELECT * FROM rest_type WHERE name =?',array($name));
			if(count($check)>0){
				$data=array('oldID'=>$columns->oldID);
				DB::connection('new-sufrati')->table('rest_type')->where('id',$check[0]->id)->update($data);
			}else{
				$data=array();
				foreach ($columns as $key => $value) {
					$data[$key]=$value;
				}
				$data['country']=2;
				DB::connection('new-sufrati')->table('rest_type')->insert($data);
			}
		}
	*/
		//ALTER TABLE  `restaurant_info` ADD  `panoramafile` VARCHAR( 400 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `panorama`
		/*
 -> On Lebn temp
ALTER TABLE `restaurant_info`
  DROP `rest_InfoPage`,
  DROP `bestfor_ID`,
  DROP `rest_Menu`,
  DROP `rest_Location`,
  DROP `rest_Branch`,
  DROP `rest_OpenHour`,
  DROP `rest_TakeAway`,
  DROP `home_made`,
  DROP `rest_Offer`,
  DROP `offer_en`,
  DROP `offer_ar`,
  DROP `offer_image`,
  DROP `district_ID`,
  DROP `family_Section`,
  DROP `single_Section`,
  DROP `rest_LocationMap`,
  DROP `rest_Rating`,
  DROP `sheesha`,
  DROP `noSmoking`,
  DROP `wifi`,
  DROP `smoking`,
  DROP `pick_Up`,
  DROP `rest_zipcode`,
  DROP `menu_pdf`,
  DROP `city_id_list`,
  DROP `menu_image`,
  DROP `rest_Catering`,
  DROP `rest_Boofee`,
  DROP `food_courts`,
  DROP `hotel_restaurant`,
  DROP `children_Section`,
  DROP `rest_subs_date`,
  DROP `hot_list`;


ON New sufrati_db 

ALTER TABLE  `restaurant_info` CHANGE  `subResference`  `subResference` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `panorama`  `panorama` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `paymentMethod`  `paymentMethod` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `openning_manner`  `openning_manner` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `rest_style`  `rest_style` INT( 11 ) NULL


ALTER TABLE `restaurant_info`
  DROP `rest_InfoPage`,
  DROP `rest_TollFree`,
  DROP `rest_OpenHour`,
  DROP `rest_TakeAway`,
  DROP `home_made`,
  DROP `family_Section`,
  DROP `single_Section`,
  DROP `sheesha`,
  DROP `noSmoking`,
  DROP `wifi`,
  DROP `smoking`,
  DROP `pick_Up`,
  DROP `rest_zipcode`,
  DROP `rest_Catering`,
  DROP `rest_Boofee`,
  DROP `food_courts`,
  DROP `hotel_restaurant`,
  DROP `children_Section`,
  DROP `hot_list`;


  ALTER TABLE  `review` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `rest_ID`;

  ALTER TABLE  `rating_info` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `rest_ID`
  ALTER TABLE  `image_gallery` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `user_ID`
  ALTER TABLE  `rest_activity` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `activity_ID`
  ALTER TABLE  `user_activity` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `activity_ID`
  ALTER TABLE  `rest_website_visits` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `restID`
  ALTER TABLE  `menu_downloads` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `restID`
  ALTER TABLE  `banner` ADD  `city_ID` INT NOT NULL DEFAULT  '0' AFTER  `url_ar`
  ALTER TABLE  `banner` ADD  `cuisine_ID` VARCHAR( 50 ) NOT NULL DEFAULT  '' AFTER  `city_ID`
  ALTER TABLE  `user` ADD  `google` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' AFTER  `facebook`
  ALTER TABLE  `user` ADD  `importedfromgoogle` INT( 1 ) NOT NULL DEFAULT  '0' AFTER  `google` , ADD  `lastimportedfromgoogle` TIMESTAMP NOT NULL AFTER  `importedfromgoogle`








		$allcolumns=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `restaurant_info` ');
		echo count($allcolumns).'<br/>';
		$i=0;
		foreach($allcolumns as $columns){
			$i++;
			$check=DB::connection('new-sufrati')->select('SELECT * FROM `restaurant_info` WHERE oldID=?',array($columns->oldID));
			if(count($check)>0){
				echo $i.'<br/>';
			}else{
			$data=array();
			foreach ($columns as $key => $value) {
				$data[$key]=$value;
			}
			$data['country']=2;
			if($data['rest_type']!=0){
				$type=DB::connection('new-sufrati')->select('SELECT * FROM `rest_type` WHERE oldID=?',array($data['rest_type']));
				if(count($type)>0){
					$data['rest_type']=$type[0]->id;	
				}
				DB::connection('new-sufrati')->table('restaurant_info')->insert($data);
			}
			$oldid=$data['oldID'];
			$newid=DB::connection('new-sufrati')->getPdo()->lastInsertId();
			//branches
			$branches=DB::connection('sufrati-lb-temp')->select('SELECT * FROM `rest_branches` WHERE rest_fk_id = ?',array($oldid));
			if(count($branches)>0){
				foreach($branches as $branch){
					$data=array();
					foreach ($branch as $key => $value) {
						$data[$key]=$value;
					}
					if($data['city_ID']!=0){
						$city=DB::connection('new-sufrati')->select('SELECT * FROM `city_list` WHERE oldID=?',array($data['city_ID']));
						if(count($city)>0){
							$data['city_ID']=$city[0]->city_ID;	
						}
					}
					if($data['district_ID']!=0){
						$district=DB::connection('new-sufrati')->select('SELECT * FROM `district_list` WHERE oldID=?',array($data['district_ID']));
						if(count($district)>0){
							$data['district_ID']=$district[0]->district_ID;	
						}
					}
					$data['rest_fk_id']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('rest_branches')->insert($data);
				}
			}
			//cuisines
			$cuisines=DB::connection('sufrati-lb-temp')->select('SELECT * FROM restaurant_cuisine WHERE rest_ID =?',array($oldid));
			if(count($cuisines)>0){
				foreach ($cuisines as $cuisine) {
					$data=array(
						'rest_ID'=>$newid,
						'cuisine_ID'=>0,
						'country'=>2
					);
					$newcuisine=DB::connection('new-sufrati')->select('SELECT * FROM cuisine_list WHERE oldID =?',array($cuisine->cuisine_ID));
					if(count($newcuisine)>0){
						$data['cuisine_ID']=$newcuisine[0]->cuisine_ID;
					}
					DB::connection('new-sufrati')->table('restaurant_cuisine')->insert($data);
				}
			}
			//bestfor

			$bestfors=DB::connection('sufrati-lb-temp')->select('SELECT * FROM restaurant_bestfor WHERE rest_ID =?',array($oldid));
			if(count($bestfors)>0){
				foreach ($bestfors as $bestfor) {
					$data=array(
						'rest_ID'=>$newid,
						'bestfor_ID'=>0,
						'country'=>2
					);
					$newbest=DB::connection('new-sufrati')->select('SELECT * FROM bestfor_list WHERE oldID =?',array($bestfor->bestfor_ID));
					if(count($newbest)>0){
						$data['bestfor_ID']=$newbest[0]->bestfor_ID;
					}
					DB::connection('new-sufrati')->table('restaurant_bestfor')->insert($data);
				}
			}
			//reviews
			$reviews=DB::connection('sufrati-lb-temp')->select('SELECT * FROM review WHERE rest_ID =?',array($oldid));
			if(count($reviews)>0){
				foreach ($reviews as $review) {
					$data=array();
					foreach ($review as $key => $value) {
						$data[$key]=$value;
					}
					$data['rest_ID']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('review')->insert($data);
				}
			}
			//gallery

			$images=DB::connection('sufrati-lb-temp')->select('SELECT * FROM image_gallery WHERE rest_ID =?',array($oldid));
			if(count($images)>0){
				foreach ($images as $image) {
					$data=array();
					foreach ($image as $key => $value) {
						$data[$key]=$value;
					}
					$data['rest_ID']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('image_gallery')->insert($data);
				}
			}
			//rating

			$ratings=DB::connection('sufrati-lb-temp')->select('SELECT * FROM rating_info WHERE rest_ID =?',array($oldid));
			if(count($ratings)>0){
				foreach ($ratings as $rating) {
					$data=array();
					foreach ($rating as $key => $value) {
						$data[$key]=$value;
					}
					$data['rest_ID']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('rating_info')->insert($data);
				}
			}
			//menus
			//ALTER TABLE  `rest_menu_pdf` CHANGE  `menu`  `menu` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `title`  `title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `title_ar`  `title_ar` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `menu_ar`  `menu_ar` TINYTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL
			$pdfs=DB::connection('sufrati-lb-temp')->select('SELECT * FROM rest_menu_pdf WHERE rest_ID =?',array($oldid));
			if(count($pdfs)>0){
				foreach ($pdfs as $pdf) {
					$data=array();
					foreach ($pdf as $key => $value) {
						$data[$key]=$value;
					}
					$data['rest_ID']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('rest_menu_pdf')->insert($data);
				}
			}
			//E-MENU
			// First `menu` table then `menucat` and `rest_menu`
			//ALTER TABLE  `menu_cat` CHANGE  `menu_id`  `menu_id` INT( 11 ) NULL
			$menus=DB::connection('sufrati-lb-temp')->select('SELECT * FROM menu_cat WHERE rest_ID =?',array($oldid));
			if(count($menus)>0){
				foreach ($menus as $menu) {
					$data=array();
					foreach ($menu as $key => $value) {
						$data[$key]=$value;
					}
					$data['rest_ID']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('menu_cat')->insert($data);
				}
			}
			//menu items

			$items= DB::connection('sufrati-lb-temp')->select('SELECT * FROM rest_menu WHERE rest_fk_id =?',array($oldid));
			if(count($items)>0){
				foreach ($items as $item) {
					$data=array();
					foreach ($item as $key => $value) {
						$data[$key]=$value;
					}
					$data['rest_fk_id']=$newid;
					$newcat=DB::connection('new-sufrati')->select('SELECT * FROM menu_cat WHERE oldID =?',array($data['cat_id']));
					if(count($newcat)>0){
						$data['cat_id']=$newcat[0]->cat_id;	
					}
					$data['country']=2;
					DB::connection('new-sufrati')->table('rest_menu')->insert($data);
				}
			}
			// Membership

			$members= DB::connection('sufrati-lb-temp')->select('SELECT * FROM subscription WHERE rest_ID =?',array($oldid));
			if(count($members)>0){
				foreach ($members as $member) {
					$data=array();
					foreach ($member as $key => $value) {
						$data[$key]=$value;		
					}
					$data['rest_ID']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('subscription')->insert($data);
				}
			}
			//ALTER TABLE  `booking_management` CHANGE  `city_ID`  `city_ID` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `full_name`  `full_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `email`  `email` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `phone`  `phone` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL , CHANGE  `status`  `status` TINYINT( 2 ) NULL , CHANGE  `date_add`  `date_add` DATETIME NULL , CHANGE  `preferredlang`  `preferredlang` TINYINT( 1 ) NULL , CHANGE  `oldID`  `oldID` INT( 11 ) NULL
			$managers= DB::connection('sufrati-lb-temp')->select('SELECT * FROM booking_management WHERE rest_id =?',array($oldid));
			if(count($managers)>0){
				foreach ($managers as $manager) {
					$data=array();
					foreach ($manager as $key => $value) {
						$data[$key]=$value;		
					}
					$data['rest_id']=$newid;
					$data['country']=2;
					DB::connection('new-sufrati')->table('booking_management')->insert($data);
				}
			}
		}
		}
		//Table user update user cities id for lebanon
		//Merge User database with sufrati_db

*/
	}



	public function delete()
	{
		$alltables = array(
			'restaurant_info', 'restaurant_cuisine', 'restaurant_bestfor', 'rest_branches', 'review', 'image_gallery', 'booking_management', 'subscription', 'rest_menu', 'menu_cat', 'rest_menu_pdf', 'menu_cat', 'rating_info'
		);
		foreach ($alltables as $table) {
			$q = " DELETE FROM `" . $table . "` WHERE `country`=2";
			DB::connection('new-sufrati')->statement($q);
		}
	}



	public function userimage()
	{
		ignore_user_abort(true);
		set_time_limit(6000);
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 6000);
		$users = DB::select('SELECT * FROM user');
		if (count($users) > 0) {
			foreach ($users as $user) {
				if ($user->image != "") {
					if (!file_exists(public_path() . "/uploads/images/userx130/")) {
						$layer = PHPImageWorkshop\ImageWorkshop::initFromPath(public_path() . "/uploads/images/" . $user->image);
						$layer->cropMaximumInPixel(0, 0, "MM");
						$layer->resizeInPixel(130, 130);
						$layer->save(public_path() . "/uploads/images/userx130/", $image, true, null, 95);
					}
				}
			}
		}
	}

	public function updateMenuImage()
	{
		//copy folder
		ignore_user_abort(true);
		set_time_limit(6000);
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 6000);
		$src = public_path() . '/../sa/images/menuItem';
		$dest = public_path() . '/../uploads/images/menuItem';
		$files = glob($src . '*/*');
		foreach ($files as $file) {
			$file_to_go = str_replace($src, $dest, $file);
			if (!file_exists($file_to_go)) {
				echo $file . '<br/>';
				copy($file, $file_to_go);
			}
		}
		$src = public_path() . '/../lb/images/menuItem/';
		$dest = public_path() . '/../uploads/images/menuItem/';
		$files = glob($src . '*/*');
		foreach ($files as $file) {
			$file_to_go = str_replace($src, $dest, $file);
			if (!file_exists($file_to_go)) {
				echo $file . '<br/>';
				copy($file, $file_to_go);
			}
		}
		$src = public_path() . '/../sa/images/offers/';
		$dest = public_path() . '/../uploads/images/offers/';
		$files = glob($src . '*/*');
		foreach ($files as $file) {
			$file_to_go = str_replace($src, $dest, $file);
			if (!file_exists($file_to_go)) {
				echo $file . '<br/>';
				copy($file, $file_to_go);
			}
		}
		$src = public_path() . '/../lb/images/offers/';
		$dest = public_path() . '/../uploads/images/offers/';
		$files = glob($src . '*/*');
		foreach ($files as $file) {
			$file_to_go = str_replace($src, $dest, $file);
			if (!file_exists($file_to_go)) {
				echo $file . '<br/>';
				copy($file, $file_to_go);
			}
		}
		$pdfs = DB::connection('sufrati-sa')->table('rest_menu_pdf')->select('menu', 'menu_ar')->where('status', 1)->get();
		$src = public_path() . '/../sa/images/';
		$dest = public_path() . '/../uploads/images/menuItem/';
		if (count($pdfs) > 0) {
			foreach ($pdfs as $pdf) {
				if (!file_exists($dest . $pdf->menu)) {
					echo $pdf . '<br/>';
					copy($src . $pdf->menu, $dest . $pdf->menu);
				}
				if (!file_exists($dest . $pdf->menu_ar)) {
					echo $pdf . '<br/>';
					copy($src . $pdf->menu_ar, $dest . $pdf->menu_ar);
				}
			}
		}
	}

	public function updateCity()
	{
		$reviews = DB::select('SELECT * FROM review WHERE country=1 AND review_Status=1 AND rest_ID=101');
		$t = 0;
		if (count($reviews) > 0) {
			foreach ($reviews as $review) {
				$user = DB::table('user')->where('user_ID', $review->user_ID)->first();
				if (count($user) > 0) {
					if ($user->user_City != "" && (is_numeric($user->user_City))) {
						DB::table('review')->where('review_ID', $review->review_ID)->update(array('city_ID' => $user->user_City));
					} else {
						$branchq = "SELECT COUNT(rb.br_id) as total FROM rest_branches rb JOIN district_list dl ON dl.district_ID=rb.district_ID AND dl.district_Status=1 JOIN city_list cl ON cl.city_ID=rb.city_ID AND cl.city_Status=1 WHERE rb.rest_fk_id=:restid AND rb.status=1";
						$branch = DB::select(DB::raw($branchq), array('restid' => $review->review_ID));
						if ($branch[0]->total == 1) {
							$t++;
						}
					}
				} else {
					echo 'review: ' . $review->review_ID . '<br/>';
				}
			}
		}
		echo count($reviews) . '<br/>' . $t;
	}


	public function updateRatings()
	{
		$ratings = DB::select('SELECT * FROM rating_info WHERE country=1 ');
		$t = 0;
		if (count($ratings) > 0) {
			foreach ($ratings as $rating) {
				$rest = DB::select('SELECT DISTINCT rb.city_ID, ri.rest_Name,');
			}
		}
		echo count($reviews) . '<br/>' . $t;
	}
}
