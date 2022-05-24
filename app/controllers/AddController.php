<?php
class AddController extends BaseController {

	public function __construct(){
		
	}

	public function index(){
		
		$lang=Config::get('app.locale');
		$langstring="";
		if($lang=="ar"){
			$cityurl=Request::segment(2);
			$langstring="ar/";
		}else{
			$cityurl=Request::segment(1);
		}
		$city=MGeneral::getCityURL($cityurl,true);
		$cityname=$lang=="en"?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
		$countryid=$city->country;
		if(Input::has('name')){
			$data=array(
				'rest_Name'=>Input::get('name'),
				'rest_Name_Ar'=>Input::get('nameAr'),
				'rest_Status'=>0,
                'rest_Viewed'=>0,
                'rest_Rating'=>0,
                'rest_type'=>0,
                'paymentMethod'=>'',
                'subResference'=>'',
                'panorama'=>'',
                'openning_manner'=>'',
                'seo_url'=>urlencode(Input::get('name')),
                'fromMobile'=>0,
                'rest_Telephone'=>Input::get('restaurantNumber'),
                'rest_Email'=>Input::get('restaurantEmail'),
                'rest_Website'=>Input::get('restaurantWebsite'),
                'your_Contact'=>Input::get('yourContact'),
                'your_Position'=>Input::get('position'),
                'rest_TollFree'=>'',
                'oldID'=>0,
                'country'=>$countryid
			);
			if(Input::has('yourEmail')){
				$data['your_Email']=Input::get('yourEmail');
				$data['your_Name']=Input::get('yourName');
			}else{
				if(Session::has('userid')){
					$user=User::checkUser(Session::get('userid'),true);
					$data['your_Email']=$user->user_Email;
					$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
					$data['your_Name']=$username;	
				}
			}
			$rest=DB::table('restaurant_info')->insertGetId($data);
			$branch=array(
				'rest_fk_id'=>$rest,
				'city_ID'=>$city->city_ID,
				'br_loc'=>Input::get('location'),
				'booking_seats'=>0,
				'oldID'=>0,
				'country'=>$countryid
			);
			DB::table('rest_branches')->insert($branch);
			if(Input::has('cuisines')){
				$cuisines=Input::get('cuisines');
				foreach ($cuisines as $cuisine) {
					$cdata=array(
						'cuisine_ID'=>$cuisine,
						'rest_ID'=>$rest,
						'country'=>$countryid
					);
					DB::table('restaurant_cuisine')->insert($cdata);
				}
			}
			if(Input::hasFile('menu')){
				if (Input::file('menu')->isValid()){
					$name=Input::file('menu')->getClientOriginalName();
					Input::file('menu')->move(public_path() . "/uploads/menu/",$name);
					$pagenumber=MRestaurant::savePdfAsImage($name,'uploads/menu/','uploads/menu/pdf/');
					$menut=array(
						'rest_ID'=>$rest,
						'menu'=>$name,
						'title'=>Input::get('name').' - Menu',
						'title_ar'=>'',
						'updatedAt'=>date('Y-m-d H:i:s',now()),
						'menu_ar'=>'',
						'pagenumber'=>$pagenumber,
						'status'=>0,
						'country'=>$city->country
					);
					DB::table('rest_menu_pdf')->insert($menut);
				}
			}
			//Mail Azooma
			$logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
			$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
			$country=MGeneral::getCountry($city->country);
			$tdata=array(
				'rest_Name'=>Input::get('name'),
				'your_Name'=>$data['your_Name'],
				'your_Email'=>$data['your_Email'],
				'contact'=>Input::get('yourContact'),
				'rest_Telephone'=>Input::get('restaurantNumber'),
				'logoimage'=>$logoimage,
				'your_Position'=>Input::get('position'),
				'country'=>$country,
				'city'=>$city,
				'location'=>Input::get('location'),
			);
			$subject=$data['your_Name'].' has added a new restaurant '.Input::get('name');
			$teamemails=explode(",",$country->teamemail);
			Mail::queue('emails.internal.newrestaurant',$tdata,function($message) use ($subject,$teamemails) {
				foreach ($teamemails as $email) {
					$message->to(trim($email),'Azooma');
				}
				$message->subject($subject);
			});
			Session::flash('success',Lang::get('messages.restaurant_added_success').' '.Lang::get('messages.someone_will_contact'));
			return Redirect::to($langstring.$city->seo_url.'/add-restaurant');
		}else{
			$data['lang']=$lang;
			$data['city']=$city;
			$data['cuisines']=MCuisine::getCuisinesMin($city->city_ID);
			$data['cityname']=$cityname;
			$data['meta']=array(
				'title'=>Lang::get('messages.add_restaurant').' '.Lang::get('messages.inplace2',array('name'=>$cityname)),
				'metadesc'=>Lang::get('metadesc.add_restaurant',array('name'=>$cityname)),
				'metakey'=>Lang::get('metakey.add_restaurant',array('name'=>$cityname)),
			);
			return View::make('addrestaurant',$data);
		}
	}

	public function addComment(){
		$lang=Config::get('app.locale');
		$langstring="";
		if($lang=="ar"){
			$langstring="ar/";
		}
		$rules=array(
			'articlecomment'=>'required|min:5',
			'userid'=>'required',
		);
		$messages=array('articlecomment.required'=>Lang::get('messages.please_add_comment'),'userid.required'=>Lang::get('messages.please_login'));
		$validator=Validator::make(array('articlecomment'=>Input::get('articlecomment'),'userid'=>Input::get('userid')),$rules,$messages);
		if(Input::has('articleid')){
			$article=DB::table('article')->select('id','nameAr','name','category','country','url')->where('id',Input::get('articleid'))->first();
			if($validator->fails()){
				return Redirect::to($langstring.'article/'.$article->url)->withErrors($validator);
			}else{
				$data=array(
					'articleID'=>$article->id,
					'category'=>$article->category,
					'userID'=>Input::get('userid'),
					'comment'=>Input::get('articlecomment'),
					'name'=>'',
					'email'=>'',
					'isRead'=>0,
					'status'=>0,
					'country'=>$article->country
				);
				DB::table('articlecomment')->insert($data);
				Session::flash('success',Lang::get('messages.comment_added_success'));
				return Redirect::to($langstring.'article/'.$article->url);
			}
		}else{
			if(Input::has('recipeid')){
				$recipe=DB::table('recipe')->select('id','nameAr','name','country','url')->where('id',Input::get('recipeid'))->first();
				if($validator->fails()){
					return Redirect::to($langstring.'recipe/'.$recipe->url)->withErrors($validator);
				}else{
					$data=array(
						'recipeID'=>$recipe->id,
						'userID'=>Input::get('userid'),
						'comment'=>Input::get('articlecomment'),
						'name'=>'',
						'email'=>'',
						'isRead'=>0,
						'status'=>0,
						'country'=>$article->country
					);
					DB::table('recipecomment')->insert($data);
					Session::flash('success',Lang::get('messages.comment_added_success'));
					return Redirect::to($langstring.'recipe/'.$recipe->url);
				}	
			}
		}
	}

	public function recommendRecipe(){
		$lang=Config::get('app.locale');
		$data=array();
		if(Session::has('userid')){
			$check=MBlog::checkUserRecommended(Input::get('recipe'),Session::get('userid'));
			$recipe=DB::table('recipe')->select('id','country')->where('id',Input::get('recipe'))->where('status',1)->first();
			if($check>0){
				if(Input::get('recommended')==1){
					MBlog::RemoveUserRecommended($recipe->id,Session::get('userid'),$recipe->country);
					$data['recommendtext']=Lang::get('messages.recommend');	
				}
			}else{
				if(Input::get('recommended')==0){
					MBlog::AddUserRecommended($recipe->id,Session::get('userid'),$recipe->country);
					$data['recommendtext']=Lang::get('messages.recommends');	
				}
				
			}
			$recommendations=MBlog::getRecipeRecommendations($recipe->id);
			$data['total']=$recommendations.' '.Lang::choice('messages.recommendation',$recommendations);
		}
		return Response::json($data);
		
	}


	public function t(){
		echo 'aaa';exit();
		$country=DB::table('aaa_country')->where('id',1)->first();
		$logo=MGeneral::getLogo();
		$logoimage=$logo->image;
		$user=User::checkUser(774,true);
		$username=$user->user_FullName;
		$data=array(
			'logoimage'=>$logoimage,
			'title'=>'Azooma',
			'country'=>$country,
			'username'=>$username,
			'heading'=>'Forgot your Password? Reset Password',
			'helper'=>'To reset your password click below',
			'action'=>'Reset Password',
			'action_helper'=>'* Disregard this email, if you didnt request a password reset.',
			'actionlink'=>Azooma::URL('forgot'),
			'country'=>$country,
			'user'=>$user,
		);
		$subject="Forgot your password?";
		Mail::send('emails.general',$data,function($message) use ($subject) {
			$message->from('info@azooma.co', 'Azooma');
			$message->to('fasi.manu@gmail.com','Mohamed Fasil');
			$message->subject($subject);
		});
		exit();
		$google= OAuth::consumer( 'Google' );
		$token = $google->requestAccessToken();

        // Send a request with it
        $result = json_decode( $google->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
 
	}


}