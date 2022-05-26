<?php
class NewSearchController extends AdminController
{

	public function admin()
	{
		$lang = Config::get('app.locale');
		$search = "";
		$city = "";
		$data = array();

		if (Input::has('search')) {
			$search = Input::get('search');
		}
		// echo $query2[1];

		$restresults = mSearch::getRestaurantsAll($search);

		$data['restaurants'] = $restresults;
		$data['search'] = $search;
		$data['lang'] = $lang;
		return Response::json($data);
	}
}
