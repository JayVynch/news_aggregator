<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Http\Resources\UserPreferenceResource;
use App\Models\News;
use App\Models\UserPreference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    
    //get all news and Search News ('title','source') table with search query and filters by published_at
    public function searchAndFilterNews(Request $request)
    {
        if($request->has('search_query') || ($request->has('published_date'))){
            
            $result = News::query()->search(request('search_query'),request('published_date'));

            return NewsResource::collection($result->paginate());
        }

        return NewsResource::collection( News::paginate());
    }

    public function getUserPreference(Request $request)
    {   
        if($request->has('search_query') || ($request->has('published_date'))){
            $term = request('search_query').'%';
            $filter_date = Carbon::parse(request('published_date'));
            $preference = UserPreference::with('news')->searchAndFilter($term,$filter_date);
            
            return UserPreferenceResource::collection($preference->paginate());
        }

        $preference = UserPreference::query()
        ->select('id','news_id','user_ip')
        ->with('news')->where('user_ip',request()->ip())->get();
        return UserPreferenceResource::collection($preference);
    }

    public function getAUserPreference($pref_id)
    {   
        $preference = UserPreference::query()
        ->select('id','news_id','user_ip')
        ->with('news')->where('id',$pref_id)->first();

        if($preference){
            return new UserPreferenceResource($preference);
        }
        
        return response()->json(['message' => 'Something went wrong'],433);
    }

    public function addUserPreference(Request $request)
    {   
        $validate = Validator::make($request->all(),[
            'news_id' => 'required|numeric',
        ]);


        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $preference = UserPreference::select('news_id')->where('news_id',$request->news_id)->exists();

        if(!$preference){
            // if preference does not exists on the database we create one
            UserPreference::create([
                'news_id' => $request->news_id,
                'user_ip' => $request->ip()
            ]);

            return response()->json([
                'message' => 'preference added successfully'
            ],201);
        }

        return response()->json(['message' => 'You have already chosen this as a preference'], 433);
    }

    public function removeUserPreference(Request $request)
    {   
        $validate = Validator::make($request->all(),[
            'news_id' => 'required|numeric',
        ]);


        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        // remove user preference
        UserPreference::select('news_id')->where('news_id',$request->news_id)->delete();

    
        return response()->json([
            'message' => 'preference removed successfully'
        ],200);
    }
}
