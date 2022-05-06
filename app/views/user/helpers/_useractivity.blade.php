<?php



$html='';
switch ($useractivity->activity) {
	case 'rated on':
		if(isset($news[$i-1])&&isset($news[$i-1]->useractivity)&&($news[$i-1]->activity==$useractivity->activity)&&($news[$i-1]->rest_ID==$useractivity->rest_ID)){
		}else{
			$rest=MRestaurant::getRestMin($useractivity->rest_ID);
			if(count($rest)>0){
				if($useractivity->city_ID!=0){
        			$city=MGeneral::getCity($useractivity->city_ID,TRUE);
        		}else{
        			$city=MGeneral::getPossibleCity($useractivity->rest_ID);
        		}
				$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
				$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;

				$html = '
				<div class="user-news-container">
					<div class="news-type" style="background-color:red">
						<i class="fas fa-star"></i>
					</div>
					<div class="news-content">
						<div class="content-header">
							<div class="content-left">
								<div class="content-image">
								<a class="rest-logo" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'"><img src="'.Azooma::CDN('images/user_thumb/'.$userimage).'" alt="'.$username.'"/></a>
								</div>
								<div class="top">
									<div class="d-flex justify-content-start">
										<div class="content-title">
										<a class="normal-text" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'">'.$username.'</a>
										</div>
										<div class="content-type">
										'.Lang::get('activity.rated_on').'  <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#n').'" title="'.$restname.'">'.$restname.'</a>
										</div>
									</div>
									<div class="content-date">	
									'.Azooma::Ago($useractivity->updated).'
									</div>
								</div>
								
							</div>
							<div class="content-right">
								<div class="content-action">

								</div>
							</div>
						</div>
						<div class="contant-block">';
						
						$rating=User::getPossibleRating($useractivity->activity_ID,$useractivity->user_ID,$useractivity->rest_ID,$useractivity->updated);
						if(count($rating)>0){
							$total=round(($rating->rating_Food+$rating->rating_Service+$rating->rating_Atmosphere+$rating->rating_Value+$rating->rating_Presentation+$rating->rating_Variety)/6,1)/2;
							$html.='<div class="col-md-4 d-flex mb-4 align-items-center justify-content-between" style="width:100%">';
							$html.='<a style="width:20%" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#n').'" title="'.$restname.'" class="rest-logo"><img class="small-image d-block" class="small-image m-auto d-block"src="'.Azooma::CDN('logos/'.$restlogo).'" alt="'.$restname.'"/></a>';
							$html.='   <div class="rating-stars" style="width:80%"> <span class="totalrate m-4 pink" style="font-weight:bold">'.$total.' / 5</span>';
							for($as=0; $as < $total; $as++){
								$html.= '<i class="fa fa-star pink"></i>&nbsp;&nbsp;';
							}
							for($as=0; $as < 5- $total; $as++){
								$html.= '<i class="fa fa-star"></i>&nbsp;&nbsp;';
							}
							$html.='</div> </div>'; //Closes col
							$html.='<div class="rate-boxes">';
							$html.='
									<div class="rate-box">
										<span class="prog-type"> '.Lang::get('messages.food').' </span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="'.$rating->rating_Food.'"
												aria-valuemin="0" style="width:'.($rating->rating_Food*10).'%" aria-valuemax="10">
											</div>
										</div>
									</div>';
									$html.='
									<div class="rate-box">
										<span class="prog-type"> '.Lang::get('messages.service').' </span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="'.$rating->rating_Service.'"
												aria-valuemin="0" style="width:'.($rating->rating_Service*10).'%" aria-valuemax="10">
											</div>
										</div>
									</div>';
									$html.='
									<div class="rate-box">
										<span class="prog-type"> '.Lang::get('messages.atmosphere').' </span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="'.$rating->rating_Atmosphere.'"
												aria-valuemin="0" style="width:'.($rating->rating_Atmosphere*10).'%" aria-valuemax="10">
											</div>
										</div>
									</div>';
									$html.='
									<div class="rate-box">
										<span class="prog-type"> '.Lang::get('messages.value').' </span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="'.$rating->rating_Value.'"
												aria-valuemin="0" style="width:'.($rating->rating_Value*10).'%" aria-valuemax="10">
											</div>
										</div>
									</div>';
									$html.='
									<div class="rate-box">
										<span class="prog-type"> '.Lang::get('messages.variety').' </span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="'.$rating->rating_Variety.'"
												aria-valuemin="0" style="width:'.($rating->rating_Variety*10).'%" aria-valuemax="10">
											</div>
										</div>
									</div>';
									$html.='
									<div class="rate-box">
										<span class="prog-type"> '.Lang::get('messages.presentation').' </span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="'.$rating->rating_Presentation.'"
												aria-valuemin="0" style="width:'.($rating->rating_Presentation*10).'%" aria-valuemax="10">
											</div>
										</div>
									</div>';
									$html.='</div>';
						}
						$html.='</div>
					</div>
				</div>
				';
			}
		}
		break;
	case 'liked':
	case 'added as favourite':
		if(isset($news[$i-1])&&isset($news[$i-1]->useractivity)&&($news[$i-1]->activity==$useractivity->activity)&&($news[$i-1]->rest_ID==$useractivity->rest_ID)){
		}else{
			$rest=MRestaurant::getRestMin($useractivity->rest_ID);
			if(count($rest)>0){
				$mainactivity=$useractivity;
				$html = '	
				<div class="user-news-container">
				<div class="news-type" style="background-color:#EE377C">
					<i class="fas fa-heart"></i>
				</div>
				<div class="news-content">
					<div class="content-header">
						<div class="content-left">
							<div class="content-image">
							<a class="rest-logo" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'"><img src="'.Azooma::CDN('images/user_thumb/'.$userimage).'" alt="'.$username.'"/></a>
							</div>
							<div class="top">
								<div class="d-flex justify-content-start">
									<div class="content-title">
									<a class="normal-text" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'">'.$username.'</a>
									</div>
									<div class="content-type">
									'.Lang::get('activity.liked').'
									</div>
								</div>
								<div class="content-date">
								'.Azooma::Ago($mainactivity->updated).'
								</div>
							</div>
							
						</div>
						<div class="content-right">
							<div class="content-action">

							</div>
						</div>
					</div>
					<div class="contant-block">';
					$restaurants=array();
					$originali=$i;
					$restaurants[0]=$rest;
					$t=1;
					for($k=1;$k<5;$k++){
						$j=$originali+$k;
						if((isset($news[$j]))&&isset($news[$j]->useractivity)&&$news[$j]->activity==$useractivity->activity){
							if($news[$j]->rest_ID!=$useractivity->rest_ID){
								$useractivity=$news[$j];
								$rest=MRestaurant::getRestMin($useractivity->rest_ID);
								if(count($rest)>0){
									$restaurants[$t]=$rest;
									$t++;
								}	
							}
							$i++;
						}	
					}
					$k=0;

					
					foreach ($restaurants as $rt) {
						$city=MGeneral::getPossibleCity($rt->rest_ID);
						$restlogo=($rt->rest_Logo=="")?'default_logo.gif':$rt->rest_Logo;
						$restname=($lang=="en")?stripcslashes($rt->rest_Name):stripcslashes($rt->rest_Name_Ar);
						$html.='<div class="d-flex align-items-center justify-content-between"><a class="d-flex align-items-center justify-content-between rest-logo mb-2" href="'.Azooma::URL($city->seo_url.'/'.$rt->seo_url.'#n').'" title="'.$restname.'"><img class="small-image m-auto d-block" src="'.Azooma::CDN('logos/'.$restlogo).'" alt="'.$restname.'"/> <span class="d-block mr-2 ml-1" style="margin: 0 1rem;">'.$restname.'</span></a> <a class="action-btn" href="'.Azooma::URL($city->seo_url.'/'.$rt->seo_url.'#n').'"> '.Lang::get('activity.view').' </a></div>';
					}
					$html.='</div>
				</div>
				</div>

				';
				
			}	
		}
		break;
	case 'uploaded photo for':
		$rest=MRestaurant::getRestMin($useractivity->rest_ID);
		if(count($rest)>0){
			$photo=User::getPossiblePhoto($useractivity->activity_ID,$useractivity->user_ID,$useractivity->rest_ID,$useractivity->updated);
			if(count($photo)>0){
				$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
				$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;
				if($useractivity->city_ID!=0){
        			$city=MGeneral::getCity($useractivity->city_ID,TRUE);
        		}else{
        			$city=MGeneral::getPossibleCity($useractivity->rest_ID);
        		}
				$html = '
				<div class="user-news-container">
				<div class="news-type" style="background-color:#37ee85">
					<i class="fas fa-image"></i>
				</div>
				<div class="news-content">
					<div class="content-header">
						<div class="content-left">
							<div class="content-image">
							<a class="rest-logo" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'"><img src="'.Azooma::CDN('images/user_thumb/'.$userimage).'" alt="'.$username.'"/></a>
							</div>
							<div class="top">
								<div class="d-flex">
									<div class="content-title">
									<a class="normal-text" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'">'.$username.'</a> 
									</div>
									<div class="content-type">
									'.Lang::get('activity.uploaded_photo_for').' <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a>
									</div>
								</div>
								<div class="content-date">
								'.Azooma::Ago($useractivity->updated).'
								</div>
							</div>
							
						</div>
						<div class="content-right">
						</div>
					</div>
					<div class="contant-block">';
					if($lang=="en"){
						$photoname= ($photo->title!="")?stripcslashes($photo->title):stripcslashes($rest->rest_Name).' '.Lang::get('messages.photo');
					}else{
						$photoname= ($photo->title_ar!="")?stripcslashes($photo->title_ar):stripcslashes($rest->rest_Name_ar).' '.Lang::get('messages.photo');
					}
					$html.='<div class="center-photo"><a class="photo-preview ajax-link" href="'.Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID).'" title="'.$photoname.'"><img class="small-image m-auto d-block" src="'.Azooma::CDN('Gallery/'.$photo->image_full).'" alt="'.$photoname.'"/></a>';
					$html.='</div>';
					$totallikes=MGallery::getPhotoLikes($photo->image_ID);
					if(Session::has('userid')){
						$checkuserliked=User::checkPhotoLiked($photo->image_ID,Session::get('userid'));
					}
					$html.='</div>
				</div>
				</div>
				';
			}
		}
		break;
	case 'commented on':
		$rest=MRestaurant::getRestMin($useractivity->rest_ID);
		if(count($rest)>0){
			$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
			$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;
			if($useractivity->city_ID!=0){
    			$city=MGeneral::getCity($useractivity->city_ID,TRUE);
    		}else{
    			$city=MGeneral::getPossibleCity($useractivity->rest_ID);
    		}
			$html = '	
			<div class="user-news-container">
			<div class="news-type" style="background-color:#ffb110">
				<i class="far fa-comments"></i>
			</div>
			<div class="news-content">
				<div class="content-header">
					<div class="content-left">
						<div class="content-image">
						<a class="rest-logo" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'"><img src="'.Azooma::CDN('images/user_thumb/'.$userimage).'" alt="'.$username.'"/></a>
						</div>
						<div class="top">
							<div class="d-flex">
								<div class="content-title">
								<a class="normal-text" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'">'.$username.'</a>
								</div>
								<div class="content-type">
								'.Lang::get('activity.commented_on').'  <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a>
								</div>
							</div>
							<div class="content-date">
							'.Azooma::Ago($useractivity->updated).'
							</div>
						</div>
						
					</div>
					<div class="content-right">
						<div class="content-action">

						</div>
					</div>
				</div>
				<div class="contant-block commented">';
				$comment=User::getPossibleComment($useractivity->activity_ID,$useractivity->user_ID,$useractivity->rest_ID,$useractivity->updated);
				if(count($comment)>0){
					if(Azooma::isArabic($comment->review_Msg)){
						$html.=stripcslashes($comment->review_Msg);	
					}else{
						$html.=htmlspecialchars(html_entity_decode(htmlentities(ucfirst(stripcslashes($comment->review_Msg)),6,'UTF-8'),6,"UTF-8"),ENT_QUOTES,'utf-8');
					}
					
					$totalagree=MRestaurant::getTotalCommentAgree($comment->review_ID);
				}
				$html.='</div>
			</div>
			</div>
			';
		}
		break;
	case 'followed':
		$followed=User::checkUser($useractivity->activity_ID);
		if(count($followed)>0){
			$followedusers[0]=$followed;
			$html = '
			<div class="user-news-container">
			<div class="news-type" style="background-color:#108aff">
				<i class="fas fa-user"></i>
			</div>
			<div class="news-content">
				<div class="content-header">
					<div class="content-left">
						<div class="content-image">
						<a class="rest-logo" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'"><img src="'.Azooma::CDN('images/user_thumb/'.$userimage).'" alt="'.$username.'"/></a>
						</div>
						<div class="top">
							<div class="d-flex">
								<div class="content-title">
								<a class="normal-text" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'">'.$username.'</a>  
								</div>
								<div class="content-type">
								'.Lang::get('activity.followed').'
								</div>
							</div>
							<div class="content-date">
							'.Azooma::Ago($useractivity->updated).'
							</div>
						</div>
						
					</div>
					<div class="content-right">
						<div class="content-action">

						</div>
					</div>
				</div>
				<div class="contant-block">';
				$k=0;
				foreach ($followedusers as $followed) {
					$k++;
					$followed=$followed[0];
					$followedname=($followed->user_NickName=="")?stripcslashes($followed->user_FullName):stripcslashes($followed->user_NickName);
					$followedimage=($followed->image=="")?'user-default.svg':$followed->image;
					$html.='<div class="d-flex align-items-center justify-content-between"> <a href="'.Azooma::URL('user/'.$followed->user_ID).'" title="'.$followedname.'" class="rest-logo d-flex align-items-center"><img class="small-image m-auto d-block" src="'.Azooma::CDN('images/userx130/'.$followedimage).'" alt="'.$followedname.'"/> <span class="d-block mr-2 ml-1" style="margin: 0 1rem;">'.$followedname.'</span></a> <a class="action-btn" href="'.Azooma::URL('user/'.$followed->user_ID).'"> '.Lang::get('view').' </a></div>';
				}
				$html .='</div>
			</div>
			</div>
			';
		}
		break;
	case 'recommend menu':
		$rest=MRestaurant::getRestMin($useractivity->rest_ID);
		if(count($rest)>0){
			$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
			$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;
			if($useractivity->city_ID!=0){
    			$city=MGeneral::getCity($useractivity->city_ID,TRUE);
    		}else{
    			$city=MGeneral::getPossibleCity($useractivity->rest_ID);
    		}
			$html = '
			<div class="user-news-container">
			<div class="news-type" style="background-color:#108aff">
				<i class="fas fa-star"></i>
			</div>
			<div class="news-content">
				<div class="content-header">
					<div class="content-left">
						<div class="content-image">
						<a class="rest-logo" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'"><img src="'.Azooma::CDN('images/user_thumb/'.$userimage).'" alt="'.$username.'"/></a>
						</div>
						<div class="top">
							<div class="d-flex">
								<div class="content-title">
								<a class="normal-text" href="'.Azooma::URL('user/'.$user->user_ID).'" title="'.$username.'">'.$username.'</a> 
								</div>
								<div class="content-type">
								'.Lang::get('activity.recommends').' 
								</div>
							</div>
							<div class="content-date">
							'.Azooma::Ago($useractivity->updated).'
							</div>
						</div>
						
					</div>
					<div class="content-right">
					</div>
				</div>
				<div class="contant-block">
			';
				
				if($useractivity->activity_ID!=0){
					$menuitem=DB::select(DB::raw('SELECT * FROM rest_menu WHERE id=:id'),array('id'=>$useractivity->activity_ID));
					if(count($menuitem)>0){
						$menucat=DB::select(DB::raw('SELECT * FROM menu_cat WHERE cat_id=:cat'),array('cat'=>$menuitem[0]->cat_id));
						$menuname=($lang=="en")?stripcslashes($menuitem[0]->menu_item):stripcslashes($menuitem[0]->menu_item_ar);
						$menuname.=' - ';
						$menuname.=($lang=="en")?stripcslashes($menucat[0]->cat_name):stripcslashes($menucat[0]->cat_name_ar);
						$html.='
						<div class="d-flex align-items-center justify-content-between">
						<div class="d-flex align-items-center">
						<a href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'" class="rest-logo d-flex align-items-center"><img class="small-image m-auto d-block mr-2 ml-1" style="margin: 0 1rem;" src="'.Azooma::CDN('logos/'.$restlogo).'" alt="'.$restname.'"/> </a>
						<a style="margin: 0 1rem;" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#menu-item-'.$menuitem[0]->id).'" title="'.$menuname.' '.Lang::get('messages.from').' '.$restname.'" class="normal-text"> '.$menuname.'</a>
						</div>
						<a class="action-btn" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#menu-item-'.$menuitem[0]->id).'"> '.Lang::get('activity.view').' </a>
						</div>
						';
						// $html.=$menuname;
					}
				}

			$html.='</div> </div>
			</div>
			';
		}
		break;
}
echo $html;
Session::put('newi', $i);
?>