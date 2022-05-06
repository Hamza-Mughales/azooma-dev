<?php
if($totalcomments>0){
	if(!isset($userreviews)){
		$userreviews=User::getReviews($user->user_ID,$limit,$offset);
	}
	if(count($userreviews)>0){
		foreach ($userreviews as $review) {
			$rest=MRestaurant::getRestMin($review->rest_ID);
			$html='';
			if(count($rest)>0){
				$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
				$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;
				$totalagree=MRestaurant::getTotalCommentAgree($review->review_ID);
				$html = '
				<div class="user-news-container">
				<div class="news-type" style="background-color:#3773ee">
					<i class="fas fa-comments"></i>
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
									'.Lang::get('activity.commented_on').'  <a class="normal-text" href="'.Azooma::URL('').'" title="'.$restname.'">'.$restname.'</a>
									</div>
								</div>
								<div class="content-date">
								' .Azooma::Ago($review->review_Date).'
								</div>
							</div>
							
						</div>
						<div class="content-right">
							<div class="content-action">
							<button class="btn btn-light btn-sm review-agree-btn" data-review="'.$review->review_ID.'">'.Lang::get('messages.agree'). '<span>'.$totalagree[0]->total.' <i class="fa fa-thumbs-o-up"></i></span>
							</div>
						</div>
					</div>
					<div class="contant-block commented">';
					if(Azooma::isArabic($review->review_Msg)){
						$html.=stripcslashes($review->review_Msg);
					}else{
						$html.=htmlspecialchars(html_entity_decode(htmlentities(ucfirst(stripcslashes($review->review_Msg)),6,'UTF-8'),6,"UTF-8"),ENT_QUOTES,'utf-8');
					}
					$html.='</div>
				</div>
				</div>
				';

			}
			echo $html;
		}
	}
}
?>