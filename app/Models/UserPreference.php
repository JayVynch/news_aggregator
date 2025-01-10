<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_ip',
        'news_id'
    ];
    
    public function news()
    {
        return $this->hasMany(News::class,'id');
    }

    public function scopeSearchAndFilter($query,$term,$filter_date)
    {
        $query->whereHas('news',function($query) use($term,$filter_date) {    
            $query->where(function($query) use ($term){
            $query->where('source','like',$term)
                ->orWhere('title','like',$term)
                ->orWhere('author','like',$term);
            })
            ->when( !is_null($filter_date)  ,function ($query) use ($filter_date) {
                $query->whereDate('published_at',[ $filter_date->format('Y-m-d H:i:s')]);
            });
        });
    }

}
