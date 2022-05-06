<?php
Class Azooma{
	public static function CDN($filename="",$cdn=1){
		if($cdn==1){
            return 'http://uploads.azooma.co/'.$filename;    
        }else{
            return 'http://uploads.azooma.co/'.$filename;
        }
        
	}

	public static function URL($url=""){
		$base=Config::get('app.url');
		$lang= Config::get('app.locale');
		if($lang=="ar"){
			$base=$base.'ar/';
		}
		return $base.$url;
	}

	public static function LanguageSwitch($path=""){
		$lang=Config::get('app.locale');
		$newurl=Config::get('app.url');
		if($lang=="en"){
            if($path!="/"){
                $newurl.='ar/'.$path;
            }else{
                $newurl.='ar'.$path;
            }
			
		}else{
			$newurl.=substr($path, 3);
		}
		return $newurl;
	}
    public static function LanguageSwitch_new($path="",$lang=""){

		$newurl=Config::get('app.url');
		if($lang=="en"){
            if($path!="/"){
                $newurl.='ar/'.$path;
            }else{
                $newurl.='ar'.$path;
            }
			
		}else{
			$newurl.=substr($path, 3);
		}
		return $newurl;
	}

    public static function ExtURL($str=""){
        if ($str == 'http://' OR $str == ''){
            return '';
        }
        $url = parse_url($str);
        if ( ! $url OR ! isset($url['scheme'])){
            $str = 'http://'.$str;
        }
        return $str;
    }

	public static function LangSupport($string){
		$lang=Config::get('app.locale');
		if($lang=="en"){
            if($string!="Undefined"&&$string!="undefined"){
                return stripcslashes($string);    
            }else{
                return '';
            }
		}else{
			$arabic=array(
                'Casual Dining'=>'مكان قيم',
                'Fine Dining'=>'مطعم فاخر',
                'Quality Dining'=>'مطعم فاخر',
                'Quick Service'=>'خدمة سريع',
                'Cuisine'=>'طبخ'  ,
                'Price Range'=> 'نطاق السعر',
                'Indoor'=>'داخلي',
                'Outdoor'=>'خارجي',
                'Child Friendly'=>'مجهز للأطفال',
                'Small'=>'صغير',
                'Medium'=>'متوسط',
                'Large'=>'كبير',
                'Banquet'=>'قاعة',
                'Classic Restaurant'=>'مطعم كلاسيكي',
                'Hotel Restaurant'=>'مطعم فندق',
                'Food Court'=>'مجمع مطاعم',
                'Home Made'=>'صنع منزلي',
                'Delivery Service'=>'خدمات توصيل',
                'Catering Service'=>'خدمات تأمين',
                'Quick Service'=>'خدمة سريعة',
                'Stall'=>'لا مكان للجلوس',
                'Indoor'=>'داخلي',
                'Outdoor'=>'خارجي',
                'Child Friendly'=>'مجهز للأطفال',
                'Single Section'=>'قسم أفراد',
                'Family Section'=>'قسم عائلات',
                'Private room'=>'غرف خاصة',
                'Wifi'=>'تغطية إنترنت',
                'TV Screens'=>'شاشات تلفاز',
                'Sheesha'=>'شيشة',
                'Wheel Chair Accessibility'=>'خدمات ذوي الإحتياجات',
                'Smoking'=>'التدخين مسموح',
                'Non Smoking'=>'التدخين ممنوع',
                'Valet Parking'=>'مواقف مؤمنة',
                'Drive Through'=>'خدمة الطلب من السيارة',
                'Buffet'=>'بوفيه',
                'Takeaway'=>'لشراء والمغادرة',
                'Delivery'=>'توصيل',
                'Business Facilities'=>'خدمات أعمال',
                'Catering services'=>'خدمات تأمين حفلات',
                'Busy'=>'مزدحم',
                'Quiet'=>'هادىء',
                'Romantic'=>'رومنسي',
                'Young Crowd'=>'مكان شبابي',
                'Trendy'=>'عصري',
				'January'=>'يناير',
				'February'=>'فبراير',
				'March'=>'مارس',
				'April'=>'أبريل/إبريل',
				'May'=>'مايو',
				'June'=>'يونيو/يونية',
				'July'=>'يوليو/يولية',
				'August'=>'أغسطس',
				'September'=>'سبتمبر',
				'October'=>'أكتوبر',
				'November'=>'نوفمبر',
				'December'=>'ديسمبر',
                'th'=>'',
                'st'=>'',
                'rd'=>'',
                'Undefined'=>'',
                'undefined'=>'',
            );
            if(isset($arabic[$string])){
                return $arabic[$string];
            }else{
                if($string=="Undefined"||$string=="undefined"){
                    return '';
                }else{
                    return $string;    
                }
                
            }
			
		}
	}

    public static function CallbackMonth($month){
        return date('F',mktime(0,0,0,$month,1));
    }

    public static function Generate($from,$to,$callback=false,$selected=""){
        $reverse=false; 
        $lang= Config::get('app.locale');
        if($from>$to){
                $tmp=$from;
                $from=$to;
                $to=$tmp;
                $reverse=true;
        }
        $return_string=array();
        for($i=$from;$i<=$to;$i++){
            if($lang=="en"){
                $string='<option value="'.$i.'"';
                if(($selected!="")&&($selected==$i)){
                    $string.=' selected="selected"';
                }
                $string.='>'.($callback?self::CallbackMonth($i):$i).'</option>';
                $return_string[]=$string;
            }else{
                if($callback){
                    $return_string[]='
                    <option value="'.$i.'">'.self::LangSupport($i).'</option>';                        
                }else{
                    $return_string[]='
                    <option value="'.$i.'">'.self::LangSupport($i).'</option>';
                }
            }
        }
        if($reverse){
                $return_string=array_reverse($return_string);
        }
        return join('',$return_string);
    }


    public static function GetCurrency($countryid){
        $country=DB::select('SELECT * FROM aaa_country WHERE id='.$countryid);
        $lang= Config::get('app.locale');
        if($lang=="en"){
            return $country[0]->currency;
        }else{
            return $country[0]->currencyAr;
        }
    }

    public static function Ago($datefrom=0,$dateto=-1){
        $lang= Config::get('app.locale');
        if($datefrom==0) {
            if($lang=="en"){
                return "4 years ago";     
            }else{
                return "قبل 4 سنوات";
            }
        }
        $date = new DateTime();
        if($dateto==-1) { $dateto = strtotime($date->format("Y-m-d H:i:s")); }
        $datefrom = strtotime($datefrom);
        $difference = $dateto - $datefrom;
        switch(true){
            // Seconds
            case(strtotime('-1 min', $dateto) < $datefrom):
                $datediff = $difference;
                if($lang=="en"){
                    $res = ($datediff==1) ? $datediff.' second ago' : $datediff.' seconds ago';    
                }else{
                    $res = ($datediff==1) ? 'منذ ' .$datediff.' ثانية' : 'منذ ' . $datediff.' ثانية';
                }
                
                break;
            // Minutes
            case(strtotime('-1 hour', $dateto) < $datefrom):
                $datediff = floor($difference / 60);
                if($lang=="en"){
                    $res = ($datediff==1) ? $datediff.' minute ago' : $datediff.' minutes ago';    
                }else{
                    $res = ($datediff==1) ? 'منذ ' . $datediff . ' دقيقة' : 'منذ ' . $datediff.' دقيقة';
                }
                
                break;
            // Hours
            case(strtotime('-1 day', $dateto) < $datefrom):
                $datediff = floor($difference / 60 / 60);
                if($lang=="en"){
                    $res = ($datediff==1) ? $datediff.' hour ago' : $datediff.' hours ago';    
                }else{
                    $res = ($datediff==1) ? 'منذ ' . $datediff.' ساعة' : 'منذ ' .$datediff. ' ساعة';
                }
                
                break;
            // Days
            case(strtotime('-1 week', $dateto) < $datefrom):
                $day_difference = 1;
                while (strtotime('-'.$day_difference.' day', $dateto) >= $datefrom){
                    $day_difference++;
                }
                $datediff = $day_difference-1;
                if($lang=="en"){
                    $res = ($datediff==1) ? 'Yesterday' : $datediff.' days ago';
                }else{
                    $res = ($datediff==1) ? 'أمس' : $datediff.' منذ أيام';
                }
                break;
            // Weeks      
            case(strtotime('-1 month', $dateto) < $datefrom):
                $week_difference = 1;
                while (strtotime('-'.$week_difference.' week', $dateto) >= $datefrom){
                    $week_difference++;
                }
                $datediff = $week_difference;
                if($lang=="en"){
                    $res = ($datediff==1) ? 'last week' : $datediff.' weeks ago';
                }else{
                    $res = ($datediff==1) ? 'الاسبوع الماضي' : $datediff.' منذ أسابيع';
                }
                break;            
            // Months
            case(strtotime('-1 year', $dateto) < $datefrom):
                $months_difference = 1;
                while (strtotime('-'.$months_difference.' month', $dateto) >= $datefrom){
                    $months_difference++;
                }
                $datediff = $months_difference;
                if($lang=="en"){
                    $res = ($datediff==1) ? $datediff.' month ago' : $datediff.' months ago';    
                }else{
                    $res = ($datediff==1) ? ' قبل'.$datediff.' شهر' : ' قبل'.$datediff.' شهر';
                }
                break;
            // Years
            case(strtotime('-1 year', $dateto) >= $datefrom):
                $year_difference = 1;
                while (strtotime('-'.$year_difference.' year', $dateto) >= $datefrom){
                    $year_difference++;
                }
                $datediff = $year_difference;
                if($lang=="en"){
                    $res = ($datediff==1) ? $datediff.' year ago' : $datediff.' years ago';    
                }else{
                    $res = ($datediff==1) ? ' قبل'.$datediff.' عام' : ' منذ '.$datediff.'سنوات';
                }
                break;
        }
        return $res;
    }

    public static function isArabic($string=""){
        if(mb_detect_encoding($string) !== 'UTF-8') {
            $string = mb_convert_encoding($string,mb_detect_encoding($string),'UTF-8');
        }
        preg_match_all('/.|\n/u', $string, $matches);
        $chars = $matches[0];
        $arabic_count = 0;
        $latin_count = 0;
        $total_count = 0;
        foreach($chars as $char) {
            //$pos = ord($char); we cant use that, its not binary safe 
            $pos = self::uniord($char);
           // echo $char ." --> ".$pos.PHP_EOL;
            if($pos >= 1536 && $pos <= 1791) {
                $arabic_count++;
            } else if($pos > 123 && $pos < 123) {
                $latin_count++;
            }
            $total_count++;
        }
        if(($arabic_count/$total_count) > 0.6) {
            // 60% arabic chars, its probably arabic
            return true;
        }
        return false;
    }

    public static function uniord($u) {
        $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
    }

    public static function checkUserLiked($rest=0,$user=0){
        return DB::table('likee_info')->where('user_ID',$user)->where('rest_ID',$rest)->first();
    }

    public static function getCountries(){
        return DB::table('countries')->orderBy('name','ASC')->get();
    }

    public static function getNationalities(){
        return DB::table('nationality')->orderBy('name','ASC')->get();
    }

    public static function getOccupations(){
        return DB::table('occupation')->orderBy('name','ASC')->get();
    }

    public static function closetags($html=""){
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

    public static function checkSpam($comment,$email,$author){
        $apikey=Config::get('app.akismet_api_key');
        $siteurl='www.azooma.co';
        $akismet = new Akismet($siteurl ,$apikey);
        if($akismet->isKeyValid()){
            $akismet->setCommentAuthor($author);
            $akismet->setCommentAuthorEmail($email);
            $akismet->setCommentAuthorURL($siteurl);
            $akismet->setCommentContent($comment);
            if($akismet->isCommentSpam()){
                return true;
            }else{
                return false;
            }
        }
    }
    

    public static function getRealIpAddr(){
        $ipaddress = '';
        if ((!empty($_SERVER['HTTP_CLIENT_IP']))&&$_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if((!empty($_SERVER['HTTP_X_FORWARDED_FOR']))&&$_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if((!empty($_SERVER['HTTP_X_FORWARDED']))&&$_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if((!empty($_SERVER['HTTP_FORWARDED_FOR']))&&$_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if((!empty($_SERVER['HTTP_FORWARDED']))&&$_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if((!empty($_SERVER['REMOTE_ADDR']))&&$_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }



    function truncate($text, $length = 100, $ending = ‘…’, $exact = true, $considerHtml = false){
        if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/','', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';

        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
            // if it’s an “empty element” with or without xhtml-conform closing slash (f.e. )
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                // do nothing
                // if tag is a closing tag (f.e. )
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag (f.e. )
                }else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate’d text
                $truncate .= $line_matchings[1];
            }

            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length > $length) {
                // the number of characters which are left
                $left = $length-$total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
             
            // if the maximum length is reached, get off the loop
            if($total_length >= $length) {
            break;
            }
        }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = substr($text, 0, $length - strlen($ending));
            }
        }

        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = substr($truncate, 0, $spacepos);
            }
        }
        // add the defined ending to the text
        $truncate .= $ending;

        if($considerHtml) {
            // close all unclosed html-tags
            foreach ($open_tags as $tag) {
                $truncate .= ' ';
            }
        }

        return $truncate;
    }
}