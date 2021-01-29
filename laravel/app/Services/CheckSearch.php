<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;
use App\Http\Requests\ValidatateForm;

class CheckSearch
{
    public static function checkDate($search,$user_id,$user){
        //もしキーワードがなかったら
        if($search == null){
            $all_users = $user->getAllUsers($user_id);
        }else{
            //全角スペースを半角に
            $search_split = mb_convert_kana($search,'s');

            //空白で区切る
            $search_split2 = preg_split('/[\s]+/', $search_split,-1,PREG_SPLIT_NO_EMPTY);

            //単語をループで回す
            foreach($search_split2 as $value)
            {
            $all_users =$user->getSearchUsers($value);
            }
        }
        return $all_users;
    }
}
