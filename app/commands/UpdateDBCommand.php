<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateDBCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'update:db';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
		//
		ignore_user_abort(true);
        set_time_limit(0);
        $k=ini_set('memory_limit', '1024M');
        $users=DB::select('SELECT image,user_ID FROM user WHERE image!="" AND image IS NOT NULL AND user_ID > 19000');
		$this->info(count($users));
		if(count($users)>0){
			foreach ($users as $user) {
				if($user->image!=""){
					$badusers=array(11700,13464,14421,14520,14554,14844,15236,15468,15712,17384,17720,18785,19549,19765,19772,19786);
					if(!in_array($user->user_ID, $badusers)){
						if(!file_exists("/home/diner/public_html/uploads/images/userx130/".$user->image)&&file_exists("/home/diner/public_html/uploads/images/".$user->image)){
							$this->info($user->user_ID);
							$layer=PHPImageWorkshop\ImageWorkshop::initFromPath("/home/diner/public_html/uploads/images/".$user->image);
							$layer->cropMaximumInPixel(0, 0, "MM");
							$layer->resizeInPixel(130, 130);
				            $layer->save("/home/diner/public_html/uploads/images/userx130/",$user->image,true,null,95);

				        }
				    }
				}
			}
		}
		/*
        $usertables=DB::connection('sufrati-users')->select('show tables');
		if(count($usertables)>0){
			$process=false;
			foreach ($usertables as $table) {
				if($table->Tables_in_diner_user=="weekly"){
					$process=true;
				}
				if($process){
					$tarr=array('countries','nationality','occupation','user_visited_restaruants','user_list_restaurant','mobile_notifications','follower','');
					if(!in_array($table->Tables_in_diner_user, $tarr)){
						$currenttable=$table->Tables_in_diner_user;
						$this->info($currenttable.' ---- processing...');
						$kq=DB::connection('sufrati-users')->select('SHOW TABLES LIKE "'.$currenttable.'"');
						if(count($kq)>0){
							$currentcolumns=DB::connection('new-sufrati')->select('SELECT COUNT(*) as totalcolumns FROM `'.$currenttable.'`');
							if(count($currentcolumns)>0&&$currentcolumns[0]->totalcolumns<=0){
								$allcolumns=DB::connection('sufrati-users')->select('SELECT * FROM `'.$currenttable.'`');
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
								$this->info(count($allcolumns).' - total columns');
							}
						}
					}
				}
			}
		}

        /*
        $alltables=DB::connection('new-sufrati')->select('show tables');
		$i=0;
		$process=false;
		foreach ($alltables as $table) {
			//$karr=array('newsletter','newsletter_stats','menu_downloads','photolike','searchanalytics','review','user_devices_list');
			
			if($table->Tables_in_diner_sufrati_db=="video"){
				$process=true;
			}
			if($process){
				$karr=array('activity_info','admin','analytics','answer','answeragree','answercomments','article','articlecomment','article_slide','artrating','art_work','askedtoanswer','banner','bannerClicks','bestfor_list','birthday','booking','booking_branches','booking_management','booking_users','branch_views','logs','mobile_analytics','searchanalytics','recent_viewed','newsletter_stats','user','user_devices_list');
				if(!in_array($table->Tables_in_diner_sufrati_db,$karr)){
				if($table->Tables_in_diner_sufrati_db!="aaa_country"&&$table->Tables_in_diner_sufrati_db!="menuall"&&$table->Tables_in_diner_sufrati_db!="settings"&&$table->Tables_in_diner_sufrati_db!="banner"&&$table->Tables_in_diner_sufrati_db!="bannerClicks"&&$table->Tables_in_diner_sufrati_db!="analytics"&&$table->Tables_in_diner_sufrati_db!="admin"){
					if($table->Tables_in_diner_sufrati_db!="mobile_analytics"&&$table->Tables_in_diner_sufrati_db!="recent_viewed"&&$table->Tables_in_diner_sufrati_db!="subscribers"){
					//Above if are large tables skip and add them later each seperately
					//Table present copy data
				//if($table->Tables_in_diner_sufrati_db=="subscribers"){
						$currenttable=$table->Tables_in_diner_sufrati_db;
						$this->info($currenttable.' ---- processing...');
						$kq=DB::connection('sufrati-sa')->select('SHOW TABLES LIKE "'.$currenttable.'"');
						if(count($kq)>0){
							//$currentcolumns=DB::connection('new-sufrati')->select('SELECT COUNT(*) as totalcolumns FROM `'.$currenttable.'`');
							//if(count($currentcolumns)>0&&$currentcolumns[0]->totalcolumns<=0){
								$totalcolumns=DB::connection('sufrati-sa')->table($currenttable)->count();
								for($i=0;$i<$totalcolumns;$i=$i+10000){
									$allcolumns=DB::connection('sufrati-sa')->select('SELECT * FROM `'.$currenttable.'` LIMIT '.$i.',10000');
									if(count($allcolumns)>0){
										//echo count($allcolumns).' total columns -<br/>';
										foreach($allcolumns as $columns){
											$data=array();
											foreach ($columns as $key => $value) {
												$data[$key]=$value;
											}
											$data['country']=1;
											DB::connection('new-sufrati')->table($currenttable)->insert($data);
										}
										$this->info(count($allcolumns).' total columns');
										usleep(200);
									}
								}
							//}
						}
					}
				}
			}
		}
		}

		*/
	}


}