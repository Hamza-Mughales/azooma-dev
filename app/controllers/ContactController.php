<?php
class ContactController extends BaseController {

	public function __construct(){
		
	}

	public function index(){
		$lang=Config::get('app.locale');
		$data['lang']=$lang;
		$data['countries']=MGeneral::getAllCountries();
		$data['meta']=array(
			'title'=>Lang::get('messages.contact_us'),
			'metadesc'=>Lang::get('metadesc.contact_us')
		);
		return View::make('contact_us',$data);
	}

	public function contact(){
		$lang=Config::get('app.locale');
		$rules=array(
			'contactname'=>'required',
			'contactemail'=>'required|email',
			'enquiry_type'=>'required',
			'contactmessage'=>'required',
		);
		$validator=Validator::make(array('contactname'=>Input::get('contactname'),'contactemail'=>Input::get('contactemail'),'enquiry_type'=>Input::get('enquiry_type'),'contactmessage'=>Input::get('contactmessage')),$rules);
		if($validator->fails()){
			return Redirect::to('contact-us#n')->withErrors($validator);
		}else{
			$cityid=1;
			if(Session::has('sfcity')){
				$cityid=Session::get('sfcity');
			}
			$city=MGeneral::getCity($cityid,false);
			$country=MGeneral::getCountry($city->country);
			$logo=MGeneral::getLogo();
			$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
			$data=array(
				'name'=>Input::get('contactname'),
				'email'=>Input::get('contactemail'),
				'telephone'=>Input::get('contactphone'),
				'msg'=>Input::get('contactmessage'),
				'enquiry'=>Input::get('enquiry_type'),
				'city'=>$city,
				'country'=>$country,
				'logoimage'=>$logoimage
			);
			$teamemails=explode(",",$country->teamemail);
			$subject='Contact us request from '.Input::get('contactname').' - '.Input::get('enquiry_type');
			Mail::queue('emails.internal.contactus',$data,function($message) use ($subject,$teamemails) {
				foreach ($teamemails as $email) {
					//$message->to(trim($email),'Sufrati');
				}
				$message->to('fasi.manu@gmail.com','Sufrati');
				$message->subject($subject);
			});
			Session::flash('success',Lang::get('messages.contact_thanks'));
			return Redirect::to('contact-us#n');
		}
	}

}