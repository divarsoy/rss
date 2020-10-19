<?php

namespace App\Http\Controllers;

use App\Http\Requests\RSSRequest;
use App\RSSFeed;
use App\Services\RSS_Service;
use Illuminate\Support\Facades\Auth;

class RSSController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param RSS_Service $rss_service
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(RSS_Service $rss_service)
    {
        $feeds = RSSFeed::where('user_id', Auth::id())->get();
        foreach ($feeds as $feed) {
            $feed->stream = $rss_service->parse($feed->url);
        }
        return view('feeds')->with([
            'feeds' => $feeds
            ]
        );
    }

    /**
     * @param RSS_Service $rss_service
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(RSS_Service $rss_service, $id){
        $feed = RSSFeed::findOrFail($id);
        $feed->stream = $rss_service->parse($feed->url);
        return view('feed')->with(['feed' => $feed]);
    }

    /**
     * @param RSSRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(RSSRequest $request){
        RSSFeed::create($request->all());
        $request->session()->flash('status', 'RSS feed stored successfully');
        return redirect()->route('rss.index');
    }
}
