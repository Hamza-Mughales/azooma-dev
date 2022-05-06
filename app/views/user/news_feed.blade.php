
<?php
if(count($news)>0){
	for($i=0;$i<count($news);$i++){
		$activity=$news[$i];
		$html='';
		if(isset($activity->useractivity)){
			$useractivity=$activity;
			$user=User::checkUser($useractivity->user_ID)[0];
			$userimage=($user->image=="")?'user-default.svg':$user->image;
			$username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
			$tdata=array(
				'user'=>$user,
				'username'=>$username,
				'userimage'=>$userimage,
				'useractivity'=>$useractivity,
				'news'=>$news,
				'i'=>$i
			);
			?>
			@include('user.helpers._useractivity',$tdata)
			<?php
			if(Session::has('newi')){
				$i=Session::get('newi');
				Session::forget('newi');
			}
		}
		if(isset($activity->restactivity)){
			$restactivity=$activity;
			$rest=MRestaurant::getRest($restactivity->rest_ID,TRUE);
			if(count($rest)>0){
				$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
				$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;
				switch ($restactivity->activity) {
					case 'A new image is added':
	                case 'A new image is added. ':
	                case 'A new image is added.':
	                	$photo=User::getPossiblePhoto($restactivity->activity_ID,0,$restactivity->rest_ID,$restactivity->updated);
	                	if(count($photo)>0){
	                		if($restactivity->city_ID!=0){
		            			$city=MGeneral::getCity($restactivity->city_ID,TRUE);
		            		}else{
	                			$city=MGeneral::getPossibleCity($restactivity->rest_ID);
	                		}
							if($lang=="en"){
								$photoname= ($photo->title!="")?stripcslashes($photo->title):stripcslashes($rest->rest_Name).' '.Lang::get('messages.photo');
							}else{
								$photoname= ($photo->title_ar!="")?stripcslashes($photo->title_ar):stripcslashes($rest->rest_Name_ar).' '.Lang::get('messages.photo');
							}
							if(Session::has('userid')){
                                $checkuserliked=User::checkPhotoLiked($photo->image_ID,Session::get('userid'));
                            }
							$html = '
						<div class="user-news-container">
						<div class="news-type" style="background-color:#EE377C">
							<i class="fas fa-image"></i>
						</div>
						<div class="news-content">
							<div class="content-header">
								<div class="content-left">
								<div class="content-image">
								<img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/>
								</div>
									<div class="top">
										<div class="d-flex">
											<div class="content-title">
											<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a> 
											</div>
											<div class="content-type">
											'.Lang::get('activity.added_photo').'
											</div>
										</div>
										<div class="content-date">
									<a href="'.Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID).'">'.Azooma::Ago($restactivity->updated).'</a>
									</div>
									</div>
									
								</div>
							
								<div class="content-right">
									<div class="content-action">
								';
								$totallikes=MGallery::getPhotoLikes($photo->image_ID);
								if(Session::has('userid')&&$checkuserliked>0){

									$html.= '<button class="btn btn-light btn-sm heart-btn heart-btn liked" data-id="'.$photo->image_ID.'" data-total-likes="'.$totallikes.'" data-city="'.$city->seo_url.'"><i class="fas fa-heart pr-2"></i> '.Lang::get('messages.liked').' </button>';
							}else{
								$html.= '<button class="btn btn-light btn-sm heart-btn heart-btn" data-id="'.$photo->image_ID.'" data-total-likes="'.$totallikes.'" data-city="'.$city->seo_url.'"><i class="far fa-heart pr-2"></i>'.Lang::get('messages.like').' </button>';
								}
								$html.= '</div>
								</div>
							</div>
							<div class="contant-block">
								<div class="center-photo">
									<a class="photo-preview ajax-link" href="'.Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID).'" title="'.$photoname.'"><img src="'.Azooma::CDN('Gallery/400x/'.$photo->image_full).'" alt="'.$photoname.'"/></a>
								</div>
							</div>
						</div>
						</div>
							
							';
							
						}
						break;
					case 'We have Updated our Offer.':
		            case 'Updated his offer.':
		            	$offer=User::getPossibleOffer($restactivity->activity_ID,$restactivity->rest_ID,$restactivity->updated);
		            	
		            	if(count($offer)>0){
							$offername=($lang=="en")?stripcslashes($offer->offerName):stripcslashes($offer->offerNameAr);
		            		if($restactivity->city_ID!=0){
		            			$city=MGeneral::getCity($restactivity->city_ID,TRUE);
		            		}else{
		            			$city=MGeneral::getPossibleCity($offer->id);
		            		}
							$html .='
							<div class="user-news-container">
							<div class="news-type" style="background-color:#ff3600">
							<i class="fab fa-hotjar"></i>
							</div>
							<div class="news-content">
								<div class="content-header">
									<div class="content-left">
										<div class="content-image">
										<a class="rest-logo" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>
										</div>
										<div class="top">
											<div class="d-flex">
												<div class="content-title">
												<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a> 
												</div>
												<div class="content-type">
												'.Lang::get('activity.added').' <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/offer/'.$offer->id).'" title="'.$offername.'">'.$offername.'</a>
												</div>
											</div>
											<div class="content-date">
											'.Azooma::Ago($restactivity->updated).'
											</div>
										</div>
										
									</div>
									<div class="content-right">
									</div>
								</div>
								<div class="contant-block">
									<div class="center-photo">
									<a class="photo-preview " href="'.Azooma::URL($city->seo_url.'/offer/'.$offer->id).'" title="'.$offername.'"><img src="'.Azooma::CDN('images/offers/'.$offer->image).'" alt="'.$offername.'"/> </a>
									</div>
								</div>
							</div>
							</div>
							';
		            	}
		            	break;
		            case 'We have Added a New Offer.':
		            case 'Added a New offer.';
					$offer=User::getPossibleOffer($restactivity->activity_ID,$restactivity->rest_ID,$restactivity->updated);
					$offer = get_object_vars((object)$offer);
					if(count($offer)>0){
						$offername=($lang=="en")?stripcslashes($offer['offerName']):stripcslashes($offer['offerNameAr']);
						if($restactivity->city_ID!=0){
							$city=MGeneral::getCity($restactivity->city_ID,TRUE);
						}else{
							$city=MGeneral::getPossibleCity($offer['id']);
						}
						$html.='
						<div class="user-news-container">
							<div class="news-type" style="background-color:#EE377C">
								<i class="fas fa-heart"></i>
							</div>
							<div class="news-content">
								<div class="content-header">
									<div class="content-left">
										<div class="content-image">
										<a class="rest-logo" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>
										</div>
										<div class="top">
											<div class="d-flex">
												<div class="content-title">
												<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a> 
												</div>
												<div class="content-type">
												'.Lang::get('activity.added').' <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/offer/'.$offer['id']).'" title="'.$offername.'">'.$offername.'</a>
												</div>
											</div>
											<div class="content-date">
											'.Azooma::Ago($restactivity->updated).'
											</div>
										</div>
										
									</div>
									<div class="content-right">
										<div class="content-action">

										</div>
									</div>
								</div>
								<div class="contant-block">
										<div class="center-photo">
										<a class="photo-preview " href="'.Azooma::URL($city->seo_url.'/offer/'.$offer['id']).'" title="'.$offername.'"><img src="'.Azooma::CDN('images/offers/'.$offer['image']).'" alt="'.$offername.'"/></a>
										</div>
								</div>
							</div>
							</div>
						';

		            	}
		           		break;
		           	case 'A New PDF Menu is added.':
		            case 'PDF Menu is Added.':
		            	$menu=MRestaurant::getPossiblePDFMenu($restactivity->activity_ID,$restactivity->rest_ID,$restactivity->updated);
		            	if(count($menu)>0){
		            		$menuname=($lang=="en")?stripcslashes($menu->title):stripcslashes($menu->title_ar);
		            		if($restactivity->city_ID!=0){
		            			$city=MGeneral::getCity($restactivity->city_ID,TRUE);
		            		}else{
		            			$city=MGeneral::getPossibleCity($restactivity->rest_ID);
		            		}
							$html='
							<div class="user-news-container">
							<div class="news-type" style="background-color:#00beff">
							<i class="far fa-file-pdf"></i>
							</div>
							<div class="news-content">
								<div class="content-header">
									<div class="content-left">
										<div class="content-image">
										<a class="rest-logo" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>
										</div>

										<div class="top">
											<div class="d-flex">
												<div class="content-title">
												<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a> 
												</div>
												<div class="content-type">
												'.Lang::get('activity.uploaded_new_pdf').' <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title="'.$menuname.' - '.$restname.'">'.$menuname.'</a>
												</div>
											</div>
											<div class="content-date">
											'.Azooma::Ago($restactivity->updated).'
											</div>
										</div>
										
									</div>
									<div class="content-right">
										<div class="content-action">
										<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title="'.$menuname.' - '.$restname.'">'.Lang::get('activity.view').'</a>
										</div>
									</div>
								</div>
							</div>
							</div>
							
							';
		      
		            	}
		            	break;
		            case 'New Restaurant Branch Added':
		        	case 'We have opened our new branch.':
		        		$branch=MRestaurant::getPossibleBranch($restactivity->activity_ID,$restactivity->rest_ID,$restactivity->updated);
		        		if(count($branch)>0){
		        			$branchname=($lang=="en")?stripcslashes($branch->br_loc.' '.$branch->district_Name.' - '.$branch->city_Name):stripcslashes($branch->br_loc_ar.' '.$branch->district_Name_ar.' - '.$branch->city_Name_ar);
							$html='
							<div class="user-news-container">
								<div class="news-type" style="background-color:#EE377C">
								<i class="fas fa-home"></i>
								</div>
								<div class="news-content">
									<div class="content-header">
										<div class="content-left">
											<div class="content-image">
											<a class="rest-logo" href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>
											</div>
											<div class="top">
												<div class="d-flex">
													<div class="content-title">
													<a class="normal-text" href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a>
													</div>
													<div class="content-type">
													'.Lang::get('activity.opened_new_branch_in').' <a class="normal-text" href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url.'#rest-branches').'" title="'.$branchname.' - '.$restname.'">'.$branchname.'</a>
													</div>
												</div>
												<div class="content-date">
												'.Azooma::Ago($restactivity->updated).'
												</div>
											</div>
											
										</div>
										<div class="content-right">
											<div class="content-action">
											<a class="normal-text"  href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url.'#rest-branches').'" title="'.$branchname.' - '.$restname.'">'.Lang::get('activity.view').'</a>

											</div>
										</div>
									</div>
								</div>
								</div>';
		
		        		}
		        		break;
		        	case 'We have updated our profile information.':
		        		break;
		        	case 'Restaurant Branch Data Updated':
		        		$branch=MRestaurant::getPossibleBranch($restactivity->activity_ID,$restactivity->rest_ID,$restactivity->updated,true);
		        		if(count($branch)>0){
		        			$branchname=($lang=="en")?stripcslashes($branch->br_loc.' '.$branch->district_Name.' - '.$branch->city_Name):stripcslashes($branch->br_loc_ar.' '.$branch->district_Name_ar.' - '.$branch->city_Name_ar);
		        			$html='
							<div class="user-news-container">
								<div class="news-type" style="background-color:#EE377C">
								<i class="fas fa-home"></i>
								</div>
								<div class="news-content">
									<div class="content-header">
										<div class="content-left">
											<div class="content-image">
											<a class="rest-logo" href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>											</div>
											<div class="top">
												<div class="d-flex">
													<div class="content-title">
													<a class="normal-text" href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a> 													</div>
													<div class="content-type">
													'.Lang::get('activity.branch_info_updated').' <a class="normal-text" href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url.'#rest-branches').'" title="'.$branchname.' - '.$restname.'">'.$branchname.'</a>	
												</div>
												<div class="content-date">
												'.Azooma::Ago($restactivity->updated).'
												</div>
											</div>
											
										</div>
										<div class="content-right">
											<div class="content-action">
											<a class="normal-text"  href="'.Azooma::URL($branch->seo_url.'/'.$rest->seo_url.'#rest-branches').'" title="'.$branchname.' - '.$restname.'">'.Lang::get('activity.view').'</a>

											</div>
										</div>
									</div>
								</div>
								</div>';
		        		}
		        		break;
		        	case 'A New Menu Type is added.':
		        		$menutype=MRestaurant::getMenuType($restactivity->activity_ID,$restactivity->rest_ID,$restactivity->updated);
		        		if(count($menutype)>0){
		        			$menuname=($lang=="en")?stripcslashes($menutype->menu_name):stripcslashes($menutype->menu_name_ar);
		        			if($restactivity->city_ID!=0){
		            			$city=MGeneral::getCity($restactivity->city_ID,TRUE);
		            		}else{
		            			$city=MGeneral::getPossibleCity($restactivity->rest_ID);
		            		}
							$html.= '
							<div class="user-news-container">
			<div class="news-type" style="background-color:#EE377C">
				<i class="fas fa-heart"></i>
			</div>
			<div class="news-content">
				<div class="content-header">
					<div class="content-left">
						<div class="content-image">
						<a class="rest-logo" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>

						</div>
						<div class="top">
							<div class="d-flex">
								<div class="content-title">
								<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a>

								</div>
								<div class="content-type">
								'. Lang::get('activity.added').'
								</div>
							</div>
							<div class="content-date">
							'.Azooma::Ago($restactivity->updated).'
							</div>
						</div>
						
					</div>
					<div class="content-right">
						<div class="content-action">
						<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title="'.$menuname.' - '.$restname.'">'.Lang::get('activity.view').'</a>

						</div>
					</div>
				</div>
				<div class="contant-block">
				<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a> '. Lang::get('activity.added').'  <a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title="'.$menuname.' - '.$restname.'">'.$menuname.'</a> '.Lang::get('activity.to_menu').'

				</div>
			</div>
			</div>
			';

		        		}
		        		break;
		        	case 'A New Menu Category is added.':
		        		$menucat=MRestaurant::getMenuCat($restactivity->activity_ID,$restactivity->rest_ID,$restactivity->updated);
		        		if(count($menucat)>0){
		        			$menuname=($lang=="en")?stripcslashes($menucat->cat_name):stripcslashes($menucat->cat_name_ar);
		        			if($restactivity->city_ID!=0){
		            			$city=MGeneral::getCity($restactivity->city_ID,TRUE);
		            		}else{
		            			$city=MGeneral::getPossibleCity($restactivity->rest_ID);
		            		}
							// $branchname=($lang=="en")?stripcslashes($branch->br_loc.' '.$branch->district_Name.' - '.$branch->city_Name):stripcslashes($branch->br_loc_ar.' '.$branch->district_Name_ar.' - '.$branch->city_Name_ar);
							$html='
							<div class="user-news-container">
			<div class="news-type" style="background-color:#0048ff">
			<i class="far fa-list-alt"></i>
			</div>
							<div class="news-content">
								<div class="content-header">
									<div class="content-left">
										<div class="content-image">
										<a class="rest-logo" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>
										</div>
										<div class="top">
											<div class="d-flex">
												<div class="content-title">
												<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a>
												</div>
												<div class="content-type">
												'.Lang::get('activity.to_menu').'
												</div>
											</div>
											<div class="content-date">
											'.Azooma::Ago($restactivity->updated).'  <a class="normal-text menu-item" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title=" '.$restname.'">'.$menuname.'</a>
											</div>
										</div>
										
									</div>
									<div class="content-right">
										<div class="content-action">
										<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title=" '.$restname.'"">'.Lang::get('activity.view').'</a>

										</div>
									</div>
								</div>
							</div>
							</div>
							';
		        		}
		        		break;
		        	case 'A New Menu Item is added.':
		        		$menuitem=MRestaurant::getMenuItem($restactivity->activity_ID);
		        		if(count($menuitem)>0){
		        			$cat=MRestaurant::getMenuCat($menuitem[0]->cat_id);
		        			$menuitem=$menuitem[0];
		        			if($restactivity->city_ID!=0){
		            			$city=MGeneral::getCity($restactivity->city_ID,TRUE);
		            		}else{
		            			$city=MGeneral::getPossibleCity($restactivity->rest_ID);
		            		}
		            		$menus=array();
		            		$originali=$i;
		            		$menus[0]=$menuitem;
		            		$t=1;
							for($k=1;$k<5;$k++){
								$j=$originali+$k;
								if((isset($news[$j]))&&isset($news[$j]->restactivity)&&$news[$j]->activity==$restactivity->activity&&($news[$j]->rest_ID==$restactivity->rest_ID)){
									$nmenuitem=MRestaurant::getMenuItem($news[$j]->activity_ID);
									if(count($nmenuitem)>0&&$nmenuitem[0]->cat_id==$menuitem->cat_id){
										$menus[$t]=$nmenuitem[0];$t++;
										$i++;
									}
								}
							}
							$catname=($lang=="en")?stripcslashes($cat->cat_name):stripcslashes($cat->cat_name_ar);
							$html ='
							<div class="user-news-container">
							<div class="news-type" style="background-color:#0048ff">
							<i class="fas fa-turkey"></i>
							</div>
							<div class="news-content">
								<div class="content-header">
									<div class="content-left">
										<div class="content-image">
										<a class="rest-logo" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'"><img src="'.Azooma::CDN('logos/thumb/'.$restlogo).'" alt="'.$restname.'"/></a>
										</div>
										<div class="top">
											<div class="d-flex">
												<div class="content-title">
												<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url).'" title="'.$restname.'">'.$restname.'</a>
												</div>
												<div class="content-type">
												' . Lang::get('activity.added'). ' 
												' .Lang::get('messages.to'). '
												<a class="normal-text" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title="'.$restname.'">'.$catname.'</a>
												</div>
											</div>
											<div class="content-date">
											'.Azooma::Ago($restactivity->updated).'
											</div>
										</div>
										
									</div>
									<div class="content-right">
										<div class="content-action">
				
										</div>
									</div>
								</div>
								<div class="contant-block">';
								$kt=0;
								foreach ($menus as $mn) {
									$kt++;
									$menuname=($lang=="en")?stripcslashes($mn->menu_item):stripcslashes($mn->menu_item_ar);
									$html.='<div class="d-flex align-items-center justify-content-between mb-2"> <a class="d-flex align-items-center justify-content-between normal-text menu-item" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'" title="'.$restname.'"> <span class="d-block mr-2 ml-1" style="margin: 0 1rem;">'.$menuname.'</span></a> <a class="action-btn" href="'.Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu').'">'.Lang::get('activity.view').' </a> </div>';
								}
								$html.='</div>
							</div>
							</div>
							';
						
		        		}
		        		break;
		        	case (preg_match('/has been added to our menu/', $restactivity->activity) ? true : false):
		        		break;
		        	case (preg_match('/has been just added to our menu/', $restactivity->activity) ? true : false):
		        		break;
					default:
						# code...
						break;
				}
				echo $html;
			}
		}
	}
}