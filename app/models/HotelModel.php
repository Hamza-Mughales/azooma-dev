<?php

use Illuminate\Support\Facades\Input;

class HotelModel extends Eloquent
{

    protected $table = 'hotel_info';
    
    public static function getData()
    {
        $limit=get('length')>0?get('length'):10;
        $offset=intval(get('draw'));
        if(in_array(0,adminCountry())){
            $query= DB::table('hotel_info');
            $query->limit($limit)->offset($offset);
            if(Input::has('h_status')){
                $query->where("status",'=',intval(get('h_status')));
            }
            return $query->get();
        }
       
        $query= DB::table('hotel_info')
        ->whereIn("country",  adminCountry());
     
        $query->limit($limit)->offset($offset);
        if(Input::has('h_status')){
            $query->where("status",'=',intval(get('h_status')));
        }
        return $query->get();
    }
}
