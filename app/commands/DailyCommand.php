<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DailyCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'daily:job';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Daily Cron job for Sufrati.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		//Birthday Messages
		$lang="en";
        $date = new DateTime(null, new DateTimeZone('Asia/Riyadh'));
        $today = '%'.$date->format('m-d').'%';
        $logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
	    $logoimage=($lang=="en")?$logo->image:$logo->image_ar;
        
        $users=DB::table('user')->select('user_ID','user_Email','user_NickName','user_FullName','sufrati','user_City')->where('user_Status',1)->where('user_BirthDate','LIKE',$today)->get();
        if(count($users)>0){
        	$randommessage=Cron::getRandomBirthdayMemssage();
        	foreach ($users as $user) {
        		$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
        		$usercountry=$user->sufrati;
        		$country=MGeneral::getCountry($usercountry);
        		$cityid=0;
        		$data=array(
					'logoimage'=>$logoimage,
					'title'=>'Sufrati',
					'country'=>$country,
					'lang'=>$lang,
					'randommessage'=>$randommessage,
					'user'=>$user
				);
        		if($user->user_City!=NULL){
					if(is_numeric($user->user_City)){
						$city=MGeneral::getCity($user->user_City,false);
						$cityid=$city->city_ID;
						$restaurants=Cron::getRandomMembers($usercountry,$cityid);
					}
        		}
        		Mail::queue('emails.user.birthday',$data,function($message) use ($user) {
					$message->to($user->user_Email,$user->user_FullName)->subject('Happy Birthday from Sufrati');
				});
        	}
        }
        //Analytics
        $countriesq="SELECT DISTINCT c.id FROM aaa_country c JOIN restaurant_info ri ON ri.country=c.id AND ri.rest_Status=1 ";
        $countries=DB::select(DB::raw($countriesq));
        if(count($countries)>0){
        	foreach ($countries as $cntry) {
        		$country=MGeneral::getCountry($cntry->id);
        		$date = date("Y-m-d", strtotime("yesterday"));
        		$data=array(
					'logoimage'=>$logoimage,
					'title'=>'Sufrati',
					'country'=>$country,
					'date'=>$date		
				);
				$data['dailyvisits']=Cron::getDailyVisits($country->id,$date);
				$data['totalvisits']=Cron::getDailyVisits($country->id);
				$data['keywords']=Cron::getDailyKeywords($country->id,$date);
				$data['trafficdetails']=Cron::getTrafficDetails($country->id,$date);
				$data['comments']=Cron::getTotalComments($country->id,$date);
				$data['ratings']=Cron::getTotalRatings($country->id,$date);
				$data['menudownloads']=Cron::getTotalMenuDownloads($country->id,$date);
				$data['menurequests']=Cron::getTotalMenuRequests($country->id,$date);
				$data['websiteclicks']=Cron::getTotalWebsiteClicks($country->id,$date);
				$data['newrestaruants']=Cron::getTotalNewRestaurants($country->id,$date);
				$data['newusers']=Cron::getNewUsers($country->id,$date);
				$data['photos']=Cron::getNewPhotos($country->id,$date);
				$data['totalbronze']=Cron::getMember($country->id,1);
				$data['totalsilver']=Cron::getMember($country->id,2);
				$data['totalgold']=Cron::getMember($country->id,3);
				$data['newbronze']=Cron::getMember($country->id,1,$date);
				$data['newsilver']=Cron::getMember($country->id,2,$date);
				$data['newgold']=Cron::getMember($country->id,3,$date);
				$data['dailyappdownloads']=Cron::getTotalAppDownloads($country->id,$date);
				$data['dailyiosdownloads']=Cron::getTotalAppDownloads($country->id,$date,"Android");
				$data['dailyandroiddownloads']=Cron::getTotalAppDownloads($country->id,$date,"iOS");
				$data['dailyapphits']=Cron::getTotalAppHits($country->id,$date);
				$data['dailyevents']=Cron::getTotalEvents($country->id,$date);
				$data['totalapphits']=Cron::getTotalAppHits($country->id);
				$data['popularcities']=Cron::getPopularCities($country->id,$date);
				$teamemails=explode(",",$country->teamemail);
				Mail::queue('emails.internal.daily_analytics',$data,function($message) use ($country,$date,$teamemails) {
					foreach ($teamemails as $email) {
						$message->to(trim($email),'Sufrati');
					}
					$message->subject(date('dS F Y', strtotime($date)) .' '. $country->name.'  report - Sufrati');
				});
        	}
        }

        
	}

	/*
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
	*/

}