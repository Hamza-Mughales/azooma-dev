<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateDBCommand extends Command
{

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
		$k = ini_set('memory_limit', '1024M');
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
						$this->info($currenttable . ' ---- processing...');
						$kq = DB::connection('sufrati-sa')->select('SHOW TABLES LIKE "' . $currenttable . '"');
						if (count($kq) > 0) {
							//$currentcolumns=DB::connection('new-sufrati')->select('SELECT COUNT(*) as totalcolumns FROM `'.$currenttable.'`');
							//if(count($currentcolumns)>0&&$currentcolumns[0]->totalcolumns<=0){
							$totalcolumns = DB::connection('sufrati-sa')->table($currenttable)->count();
							for ($i = 0; $i < $totalcolumns; $i = $i + 10000) {
								$allcolumns = DB::connection('sufrati-sa')->select('SELECT * FROM `' . $currenttable . '` LIMIT ' . $i . ',10000');
								if (count($allcolumns) > 0) {
									//echo count($allcolumns).' total columns -<br/>';
									$this->info(count($allcolumns) . ' total columns');
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
	}
}
