<?php
class GalleryController extends BaseController
{
	public function __construct()
	{
		$this->MGallery = new MGallery();
	}

	public function index()
	{
		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$cityurl = Request::segment(2);
		} else {
			$cityurl = Request::segment(1);
		}
		$data['lang'] = $lang;
		$city = MGeneral::getCityURL($cityurl, true);
		if (count($city) > 0) {
			$cityname = ($lang == "en") ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
			$cityid = $city->city_ID;
			$data['city'] = $city;
			$data['lang'] = $lang;
			$data['cityname'] = $cityname;
			$data['sufratiphotos'] = $this->MGallery->getPhotos($cityid, 0, 3, 0);
			$data['videos'] = $this->MGallery->getVideos(3, 0);
			$data['meta'] = array(
				'title' => Lang::choice('messages.restaurants', 1) . ' ' . Lang::get('messages.photos') . ' ' . Lang::get('messages.and') . ' ' . Lang::get('messages.videos') . ' ' . Lang::get('messages.inplace2', array('name' => $cityname)),
				'metadesc' => Lang::get('metadesc.gallery', array('name' => $cityname)),
				'metakey' => Lang::get('metakey.gallery', array('name' => $cityname))
			);
			return View::make('gallery', $data);
		} else {
			App::abort(404);
		}
	}

	public function photos()
	{

		$lang = Config::get('app.locale');
		if ($lang == "ar") {
			$cityurl = Request::segment(2);
		} else {
			$cityurl = Request::segment(1);
		}

		$sort = "latest";
		$data['lang'] = $lang;
		$limit = 9;
		$offset = 0;
		$city = MGeneral::getCityURL($cityurl, true);

		if (count($city) > 0) {
			$cityname = ($lang == "en") ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
			$cityid = $city->city_ID;
			$data['city'] = $city;
			$data['cityname'] = $cityname;
			$page = 1;
			if (Input::has('sort')) {
				$sort = Input::get('sort');
			}
			// if(Input::has('limit')){
			// 	$limit=Input::get('limit');
			// }
			if (Input::has('page')) {
				$offset = $limit * (Input::get('page') - 1);
				$page = Input::get('page');
			}
			$data['photos'] = $this->MGallery->getPhotos($cityid, 0, $limit, $offset, FALSE, $sort);
			$total = $this->MGallery->getPhotos($cityid, 0, $limit, $offset, TRUE, $sort);

			$data['sort'] = $sort;
			$data['paginator'] = Paginator::make($data['photos'], $total, $limit);
			$data['originallink'] = Azooma::URL($city->seo_url . '/photos');
			$data['total'] = $total;
			if ($page > 1) {
				$prev = $page - 1;
				$data['prev'] = Azooma::URL($city->seo_url . '/photos?page=' . $prev);
			}
			if (($offset + $limit) < $total) {
				$next = $page + 1;
				$data['next'] = Azooma::URL($city->seo_url . '/photos?page=' . $next);
			}
			$data['var'] = array(
				'limit' => $limit,
				'sort' => $sort,
			);

			$data['meta'] = array(
				'title' => Lang::choice('messages.restaurants', 1) . ' ' . Lang::get('messages.photos') . ' ' . Lang::get('messages.inplace2', array('name' => $cityname)),
				'metadesc' => Lang::get('metadesc.photogallery', array('name' => $cityname)),
				'metakey' => Lang::get('metakey.photogallery', array('name' => $cityname))
			);

			return view('photos', $data);
		} else {
			App::abort(404);
		}
	}


	public function videos()
	{
		$limit = 12;
		$offset = 0;
		$lang = Config::get('app.locale');
		$data['lang'] = $lang;
		if (Input::has('limit')) {
			$limit = Input::get('limit');
		}
		if ($lang == "ar") {
			$cityurl = Request::segment(2);
		} else {
			$cityurl = Request::segment(1);
		}
		$city = MGeneral::getCityURL($cityurl, true);
		if (count($city) > 0) {
			$cityname = ($lang == "en") ? stripcslashes($city->city_Name) : stripcslashes($city->city_Name_ar);
			$cityid = $city->city_ID;
			$data['city'] = $city;
			$data['cityname'] = $cityname;
		}
		$page = 1;
		if (Input::has('page')) {
			$offset = $limit * (Input::get('page') - 1);
			$page = Input::get('page');
		}
		$data['videos'] = $this->MGallery->getVideos($limit, $offset);
		$total = $this->MGallery->getTotalVideos();
		$data['total'] = $total;
		$data['paginator'] = Paginator::make($data['videos'], $total, $limit);
		$data['paginatevar'] = array(
			'limit' => $limit
		);
		$data['originallink'] = Azooma::URL('videos');
		if ($page > 1) {
			$prev = $page - 1;
			$data['prev'] = Azooma::URL('videos?page=' . $prev);
		}
		if (($offset + $limit) < $total) {
			$next = $page + 1;
			$data['next'] = Azooma::URL('videos?page=' . $next);
		}
		$data['meta'] = array(
			'title' => Lang::choice('messages.restaurants', 1) . ' ' . Lang::get('messages.videos'),
			'metadesc' => Lang::get('metadesc.videogallery'),
			'metakey' => Lang::get('metakey.videogallery')
		);
		return View::make('videos', $data);
	}

	public function video($id = 0)
	{
		$lang = Config::get('app.locale');
		$data['lang'] = $lang;
		$data['video'] = $this->MGallery->getVideo($id);
		$data['videoname'] = ($lang == "en") ? ucfirst(stripcslashes($data['video'][0]->name_en)) : ucfirst(stripcslashes($data['video'][0]->name_ar));
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$t['html'] = stripcslashes(View::make('ajax.video', $data));
			return Response::json($t);
		} else {
			$data['videos'] = $this->MGallery->getVideos(4, 0, $id);
			$data['meta'] = array(
				'title' => $data['videoname'],
				'metadesc' => $data['videoname']
			);
			return View::make('video', $data);
		}
	}
}
