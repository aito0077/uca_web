<?php namespace Uca\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Log;
use DB;
use Illuminate\Support\Collection;
use Uca\User;
use Uca\Model\Page;
use Uca\Model\Organization;

class PageController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show', 'home']]);
    }

	public function index() {
        $pages = Page::all();
        return $pages;
	}

	public function show($id) {
        $page = Page::find($id);
        return $page;
	}

	public function home() {
        $home = Page::where('is_home', '=', true)->firstOrFail();
        Log::info($home);
        $organizations = DB::table('organizations')->select('id', 'name', 'main_picture', 'is_current', 'remark', 'slogan', 'description', 'details', 'more_details', 'start_event_date', 'finish_event_date')->get();

        foreach($organizations as $organization) {
            $organization->is_current = intval($organization->is_current);
            $organization->remark = intval($organization->remark);
        }
        $home->organizations = $organizations;

        return $home;
	}


	public function store(Request $request) {
        $page = new Page;

        DB::transaction(function() use ($request, $page) {
            $page->title = $request->input('title');
            $page->description = $request->input('description');
            $page->details = $request->input('details');
            $page->is_home = $request->input('is_home');

            $page->why_title = $request->input('why_title');
            $page->why_body = $request->input('why_body');
            $page->how_title = $request->input('how_title');
            $page->how_body = $request->input('how_body');
            $page->what_title = $request->input('what_title');
            $page->what_body = $request->input('what_body');
            $page->who_title = $request->input('who_title');
            $page->who_body = $request->input('who_body');

            $page->twitter_link = $request->input('twitter_link');
            $page->instagram_link = $request->input('instagram_link');
            $page->facebook_link = $request->input('facebook_link');
            $page->vimeo_link = $request->input('vimeo_link');
            $page->pinterest_link = $request->input('pinterest_link');
            $page->twitter_hashtag = $request->input('twitter_hashtag');
            $page->instagram_hashtag = $request->input('instagram_hashtag');
            $page->instagram_username = $request->input('instagram_username');

            $page->save();
        });

        return $page;
	}

	public function update(Request $request, $id) {
        $page = Page::find($id);
        DB::transaction(function() use ($request, $page) {

            $page->title = $request->input('title');
            $page->description = $request->input('description');
            $page->details = $request->input('details');
            $page->why_title = $request->input('why_title');
            $page->why_body = $request->input('why_body');
            $page->how_title = $request->input('how_title');
            $page->how_body = $request->input('how_body');
            $page->what_title = $request->input('what_title');
            $page->what_body = $request->input('what_body');
            $page->who_title = $request->input('who_title');
            $page->who_body = $request->input('who_body');

            $page->is_home = $request->input('is_home');
            $page->twitter_link = $request->input('twitter_link');
            $page->facebook_link = $request->input('facebook_link');
            $page->instagram_link = $request->input('instagram_link');
            $page->vimeo_link = $request->input('vimeo_link');
            $page->pinterest_link = $request->input('pinterest_link');

            $page->twitter_hashtag = $request->input('twitter_hashtag');
            $page->instagram_hashtag = $request->input('instagram_hashtag');
            $page->instagram_username = $request->input('instagram_username');

            $page->save();
        });

        return $page;
	}


	public function destroy($id) {
        Page::destroy($id);
	}


}
