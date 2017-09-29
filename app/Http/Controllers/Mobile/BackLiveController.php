<?php

namespace App\Http\Controllers\Mobile;

use App\Models\Comment;
use App\Models\Live_history;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use App\Events\LiveEvent;
class BackLiveController extends Controller
{
    public function __construct()
    {
        view()->share([
            '_mobile_back_live' => 'curr'
        ]);
    }

    public function index()
    {
        $back = Live_history::orderBy('id','desc')->get();
        return view('mobile.back_live.index')->with('back',$back);
    }

    public function details($id)
    {
        $details = Live_history::find($id);
        if(empty($details))
        {
            return redirect(route('home'));
        }
        Event::fire(new liveEvent($details));
        $comments = Comment::with('user','children.user.oauth')
            ->where('back_live_id',$id)
            ->where('parent_id',0)
            ->orderBy('id','desc')
            ->get();
        return view('mobile.back_live.details')->with('details',$details)->with('comments',$comments);
    }
}
