<?php

namespace App\Http\Controllers\chat;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ChatHelper;
use App\Models\SearchModdel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{

    public  function searchUser(Request $request)
    {
        $keySearch = $request->input('keySearch');
        $result = SearchModdel::searchUser($keySearch);
        if (count($result)  > 0) {
            foreach ($result as $key => $user) {
                $lastMessage = ChatHelper::getLastMessage($user->id);
                $lastMessageContent = count($lastMessage) == 0 ? '' : $lastMessage[count($lastMessage) - 1]->message;
                $result[$key]->lastMessage = $lastMessageContent;
            }
        }
        echo  json_encode($result);
    }
}
