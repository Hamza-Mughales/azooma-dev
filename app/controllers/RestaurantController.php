<?php
class RestaurantController extends BaseController
{

	public function __construct()
	{
		$this->MRestaurant = new MRestaurant();
	}

	public function index($branch = "")
	{

		if ($branch != "") {
			return $this->branch();
		} else {

			$lang = Config::get('app.locale');
			if ($lang == "ar") {
				$resturl = Request::segment(3);
				$cityurl = Request::segment(2);
			} else {
				$resturl = Request::segment(2);
				$cityurl = Request::segment(1);
			}
			$city = MGeneral::getCityURL($cityurl, true);
			if (count($city) > 0) {
				$cityname = ($lang == "en") ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
				$rest = DB::select('SELECT *,getCuisineName(rest_ID,"en") as cuisine, getCuisineName(rest_ID,"ar") as cuisineAr,getRestaurantTel(rest_ID) as telephone, rest_Subscription FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=' . $city->city_ID . ' WHERE rest_Status=1 AND seo_url="' . $resturl . '"');
				$rest = $rest[0];
				$restname = ($lang == "en") ? stripcslashes($rest->rest_Name) : stripcslashes($rest->rest_Name_Ar);
				$restname = trim($restname);
				$this->MRestaurant->addView($rest->rest_ID);
				$data['rest'] = $rest;
				$data['lang'] = $lang;
				$data['restname'] = $restname;
				$data['city'] = $city;
				$data['cityname'] = $cityname;
				$data['cover'] = $this->MRestaurant->getCoverPhoto($rest->rest_ID);
				$data['type'] = $this->MRestaurant->getRestType($rest->rest_type);
				$typename = $typenamear = "";
				if (count($data['type']) > 0) {
					$typename = $data['type'][0]->name;
					$typenamear = $data['type'][0]->nameAr;
				}
				$data['cuisines'] = $cuisines = $this->MRestaurant->getRestaurantCuisines($rest->rest_ID);
				$cuisinename = $cuisinenamear = '';
				if ($typename != "") {
					if (count($cuisines) > 0) {
						$i = 0;
						foreach ($cuisines as $cuisine) {
							$i++;
							if ($cuisine->cuisine_Name != $typename) {
								$cuisinename .= $cuisine->cuisine_Name;
								if ($i != count($cuisines)) {
									$cuisinename .= ', ';
								}
							}
							if ($cuisine->cuisine_Name_ar != $typenamear) {
								$cuisinenamear .= $cuisine->cuisine_Name_ar;
								if ($i != count($cuisines)) {
									$cuisinenamear .= ', ';
								}
							}
						}
					}
				}
				if (Session::has('userid')) {
					$data['userliked'] = $this->MRestaurant->checkLiked($rest->rest_ID, Session::get('userid'));
					$data['userlists'] = User::getUserLists(Session::get('userid'));
					$data['userrated'] = User::checkUserRated(Session::get('userid'), $rest->rest_ID, $city->city_ID);
					$data['userlisthasrestaurant'] = User::checkRestaurantInUserList($rest->rest_ID, Session::get('userid'));
				}
				$data['checkmember'] = $this->MRestaurant->checkMember($rest->rest_ID);
				$membership = $rest->rest_Subscription;
				if (count($data['checkmember']) > 0) {
					if ($membership == 3) {
						$data['nobanner'] = true;
					}
				}
				$data['offers'] = MRestaurant::getRestaurantOffers($rest->rest_ID);
				$data['cuisinename'] = $cuisinename;
				$data['cuisinenamear'] = $cuisinenamear;
				$data['bestfor'] = $cuisines = $this->MRestaurant->getRestaurantFamousFor($rest->rest_ID);
				$data['likes'] = $this->MRestaurant->getRestaurantLikeInfo($rest->rest_ID);
				$data['likers'] = $this->MRestaurant->getLikedPeople($rest->rest_ID, 6);
				$data['ratinginfo'] = $this->MRestaurant->getRatingInfo($rest->rest_ID);
				$data['mostagreedcomment'] = $this->MRestaurant->getMostAgreedComment($rest->rest_ID);
				$data['populardishes'] = $this->MRestaurant->getPopularDishes($rest->rest_ID);
				$data['features'] = $this->MRestaurant->getFeautures($rest->rest_ID);
				$data['restbranches'] = $this->MRestaurant->getRestaurantBranches($rest->rest_ID, $city->city_ID);
				$data['openhours'] = $this->MRestaurant->getOpenHours($rest->rest_ID);
				$data['minigallery'] = $this->MRestaurant->getRestaurantMiniGallery($rest->rest_ID, $city->city_ID);
				$data['listspresent'] = $this->MRestaurant->getListsWithRestaurant($rest->rest_ID);
				$data['menu'] = $this->MRestaurant->getEMenu($rest->rest_ID);
				$data['pdfs'] = $this->MRestaurant->getPDFMenu($rest->rest_ID);
				$data['videos'] = $this->MRestaurant->getVideos($rest->rest_ID);
				$data['sufratiphotos'] = $this->MRestaurant->getPhotos($rest->rest_ID, 0);
				$data['userphotos'] = $this->MRestaurant->getPhotos($rest->rest_ID, 1);
				$data['totalreviews'] = $this->MRestaurant->getTotalReviews($rest->rest_ID, $city->city_ID);
				$data['userreviews'] = $this->MRestaurant->getReviews($rest->rest_ID, $city->city_ID, 10);
				$data['criticreviews'] = $this->MRestaurant->getCriticReviews($rest->rest_ID);
				$metadesc = $restname . ' ' . $cityname . ', ' . $restname . ' ' . Lang::get('messages.has') . ' ' . count($data['restbranches']) . ' ' . Lang::choice('messages.branch_branches', count($data['restbranches'])) . ' ' . Lang::get('messages.inplace2', array('name' => $cityname)) . '. ' . $restname . ' ' . lcfirst(Lang::get('messages.serves')) . ' ' . $cuisinename . ' ' . lcfirst(Lang::get('messages.cuisine')) . '. ';
				$metadesc .= Lang::get('metadesc.restaurantprofile', array('restname' => $restname, 'cityname' => $cityname));
				$data['meta'] = array(
					'title' => $restname . ' ' . $cityname,
					'metadesc' => $metadesc,
					'metakey' => $restname . ', ' . $cityname . ', ' . $restname . ' ' . $cityname . ', ' . Lang::get('messages.menu') . ', ' . Lang::get('messages.ratings') . ', ' . Lang::get('messages.reviews') . ', ' . Lang::get('messages.photos') . ', ' . Lang::get('messages.videos'),
				);
				return View::make('restaurantprofile', $data);
			}
		}
	}



	public function branch()
	{
		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$resturl = Request::segment(3);
			$cityurl = Request::segment(2);
			$branchurl = Request::segment(4);
		} else {
			$resturl = Request::segment(2);
			$cityurl = Request::segment(1);
			$branchurl = Request::segment(3);
		}
		$city = MGeneral::getCityURL($cityurl, true);
		if (count($city) > 0) {
			$branch = MRestaurant::getRestaurantBranch($branchurl);
			if (count($branch) > 0) {
				$branch = $branch[0];
				$cityname = ($lang == "en") ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);

				$rest = DB::select('SELECT rest_ID,rest_Name,rest_Name_Ar,rest_Logo,seo_url,rest_TollFree,class_category,getCuisineName(rest_ID,"en") as cuisine, getCuisineName(rest_ID,"ar") as cuisineAr,getRestaurantTel(rest_ID) as telephone FROM restaurant_info ri JOIN rest_branches rb ON rb.rest_fk_id=ri.rest_ID AND rb.city_ID=' . $city->city_ID . ' WHERE rest_Status=1 AND seo_url="' . $resturl . '"');
				$rest = $rest[0];
				$restname = ($lang == "en") ? stripcslashes($rest->rest_Name) : stripcslashes($rest->rest_Name_Ar);
				$t = array(
					'city' => $city,
					'cityname' => $cityname,
					'restname' => $restname,
					'rest' => $rest,
					'branch' => $branch,
					'lang' => $lang
				);
				$thtml = stripcslashes(View::make('ajax.branch', $t));
				$data['html'] = $thtml;
				$title = $restname;
				$title = ($lang == "en") ? $title . ' - ' . $branch->br_loc : $title . ' - ' . $branch->br_loc_ar;
				if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
					if ($branch->latitude != "" && $branch->longitude != "") {
						$data['latitude'] = $branch->latitude;
						$data['longitude'] = $branch->longitude;
						$data['zoom'] = $branch->zoom;
						$data['title'] = $title;
					}
					return Response::json($data);
				} else {
					$data['rest'] = $rest;
					$data['restname'] = $restname;
					$data['lang'] = $lang;
					$data['branch'] = $branch;
					$data['city'] = $city;
					$data['cityname'] = $cityname;
					$branchname = ($lang == "en") ? stripcslashes($branch->br_loc) . ' ' . stripcslashes($branch->district_Name) . ' ' . stripcslashes($branch->city_Name) : stripcslashes($branch->br_loc_ar) . ' ' . stripcslashes($branch->district_Name_ar) . ' ' . stripcslashes($branch->city_Name_ar);
					$data['branchname'] = $branchname;
					$data['meta'] = array(
						'title' => $restname . ' ' . Lang::choice('messages.on', 1) . ' ' . $branchname,
						'metadesc' => $restname . ' ' . Lang::choice('messages.on', 1) . ' ' . $branchname,
						'metakey' => str_replace(' ', ', ', $branchname . ' ' . $restname)
					);
					return View::make('branch', $data);
				}
			} else {
				App::abort(404);
			}
		}
	}

	public function Review($review = 0)
	{
		if ($review != 0) {
			$lang = Config::get('app.locale');
			if ($lang == "ar") {
				$cityurl = Request::segment(2);
			} else {
				$cityurl = Request::segment(1);
			}
			$city = MGeneral::getCityURL($cityurl, true);
			if (count($city) > 0) {
				$review = MRestaurant::getReview($review, true);
				if (count($review) > 0) {
					$rest = MRestaurant::getRest($review->rest_ID, true);
					$user = User::checkUser($review->user_ID)[0];
					$username = ($user->user_NickName == "") ? stripcslashes($user->user_FullName) : stripcslashes($user->user_NickName);
					$restname = ($lang == "en") ? stripcslashes($rest->rest_Name) : stripcslashes($rest->rest_Name_Ar);
					$data['lang'] = $lang;
					$data['city'] = $city;
					$data['rest'] = $rest;
					$data['restname'] = $restname;
					$data['user'] = $user;
					$data['username'] = $username;
					$data['review'] = $review;
					$data['userrated'] = User::checkUserRated($user->user_ID, $rest->rest_ID, $city->city_ID);
					$data['commentupvotes'] = MRestaurant::getTotalCommentAgree($review->review_ID)[0]->total;
					$data['usertotalreviews'] = User::getTotalComments($user->user_ID, 1);
					$data['usertotalratings'] = User::getTotalRatings($user->user_ID);
					$data['meta'] = array(
						'title' => Lang::choice('messages.review', 1) . ' ' . Lang::choice('messages.by', 1) . ' ' . $username . ' ' . Lang::get('messages.for') . ' ' . $restname,
						'metadesc' => Lang::choice('messages.review', 1) . ' ' . Lang::choice('messages.by', 1) . ' ' . $username . ' ' . Lang::get('messages.for') . ' ' . $restname,
						'metakey' => Lang::choice('messages.review', 1) . ', ' . $restname
					);
					return View::make('review', $data);
				} else {
					App::abort(404);
				}
			} else {
				App::abort(404);
			}
		}
	}
}
