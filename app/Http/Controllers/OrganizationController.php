<?php namespace Uca\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Log;
use DB;
use Carbon;
use Illuminate\Support\Collection;
use Uca\User;
use Uca\Model\Organization;
use Uca\Model\Media;
use Uca\Model\OrganizationMedia;
use Uca\Model\UserOrganization;

class OrganizationController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index() {
        $organizations = Organization::all();
        foreach($organizations as $organization) {
            $organization->remark = intval($organization->remark);
        }
        return $organizations;
	}

	public function show($id) {
        $organization = Organization::find($id);
        $organization->is_current = intval($organization->is_current);

        $organization->medias;
        return $organization;
	}

	public function medias($id) {
        $organization = Organization::find($id);
        return $organization->medias;
	}

	public function store(Request $request) {
        $user = User::find($request['user']['sub']);
        $organization = new Organization;

        DB::transaction(function() use ($request, $organization, $user) {
            $organization->user_id = $user->id;

            $organization->name = $request->input('name');
            $organization->slug = $this->slugify($organization->name);

            $organization->show_title = $request->has('show_title') ? $request->input('show_title') : true;
            $organization->description = $request->input('description');
            $organization->slogan = $request->input('slogan');
            $organization->is_current = $request->has('is_current') ? $request->input('is_current') : false;
            $organization->remark = $request->input('remark');
            $organization->main_picture = $request->input('main_picture');
            $organization->details = $request->input('details');
            $organization->more_details = $request->input('more_details');

            $organization->website = $request->input('website');
            $organization->twitter_hashtag = $request->input('twitter_hashtag');
            $organization->instagram_hashtag = $request->input('instagram_hashtag');
            $organization->media_id = $request->input('media_id');


            if($request->has('start_event_date')) {
                $arr = explode(".", $request->input('start_event_date'), 2);
                $event_date = str_replace("T", " ", $arr[0]);
                $organization->start_event_date = Carbon::createFromFormat('Y-m-d H:i:s', $event_date);
            }

            if($request->has('finish_event_date')) {
                $arr = explode(".", $request->input('finish_event_date'), 2);
                $finish_event_date = str_replace("T", " ", $arr[0]);
                $organization->finish_event_date = Carbon::createFromFormat('Y-m-d H:i:s', $finish_event_date);
            }
            $organization->remark = $request->has('remark') ? $request->input('remark') : true;



            $organization->save();
                 
            if($organization->media_id) {
                $organizationMedia = OrganizationMedia::firstOrCreate([
                    'media_id' => $organization->media_id,
                    'organization_id' => $organization->id
                ]);
            }

        });

        return $organization;
	}

	public function update(Request $request, $id) {
        $user = User::find($request['user']['sub']);
        $organization = Organization::find($id);
        DB::transaction(function() use ($request, $organization, $user) {


            $organization->user_id = $user->id;

            $organization->name = $request->input('name');
            $organization->slug = $this->slugify($organization->name);

            $organization->show_title = $request->has('show_title') ? $request->input('show_title') : true;
            $organization->description = $request->input('description');
            $organization->slogan = $request->input('slogan');
            $organization->is_current = $request->has('is_current') ? $request->input('is_current') : false;
            $organization->remark = $request->input('remark');
            $organization->main_picture = $request->input('main_picture');
            $organization->details = $request->input('details');
            $organization->more_details = $request->input('more_details');

            $organization->website = $request->input('website');
            $organization->twitter_hashtag = $request->input('twitter_hashtag');
            $organization->instagram_hashtag = $request->input('instagram_hashtag');
            $organization->media_id = $request->input('media_id');


            if($request->has('start_event_date')) {
                $arr = explode(".", $request->input('start_event_date'), 2);
                $event_date = str_replace("T", " ", $arr[0]);
                $organization->start_event_date = Carbon::createFromFormat('Y-m-d H:i:s', $event_date);
            }

            if($request->has('finish_event_date')) {
                $arr = explode(".", $request->input('finish_event_date'), 2);
                $finish_event_date = str_replace("T", " ", $arr[0]);
                $organization->finish_event_date = Carbon::createFromFormat('Y-m-d H:i:s', $finish_event_date);
            }
            $organization->remark = $request->has('remark') ? $request->input('remark') : true;

            $organization->save();
         
        });

        return $organization;
	}

	public function destroy($id) {
        DB::table('organizations_medias')->where('organization_id', '=', $id)->delete();
        Organization::destroy($id);
	}


	public function setMainPicture(Request $request, $organizationId, $mediaId) {
        $user = User::find($request['user']['sub']);
        $organization = Organization::find($organizationId);
        $media = Media::find($mediaId);
        DB::transaction(function() use ($request, $organization, $media) {
            $organization->main_picture = $media->name;
            $organization->save();
        });

        return $media;
    }

    static public function slugify($text) { 
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

	public function remark(Request $request, $id) {
        $user = User::find($request['user']['sub']);
        $organization = Organization::find($id);
        DB::transaction(function() use ($request, $organization) {
            $organization->remark = 1;
            $organization->save();
        });

        return $organization;
    }

	public function unremark(Request $request, $id) {
        $user = User::find($request['user']['sub']);
        $organization = Organization::find($id);
        DB::transaction(function() use ($request, $organization) {
            $organization->remark = 0;
            $organization->save();
        });

        return $organization;
    }




}

