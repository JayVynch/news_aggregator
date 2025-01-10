<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'title',
        'author',
        'url',
        'category',
        'published_at',
        'abstract',
        'content',
        'image'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function userPreference()
    {
        return $this->belongsTo(UserPreference::class,'news_id');
    }

    public function scopeSearch($query, string $search = null, $start_date = null)
    {
        
        collect(str_getcsv($search,' ','"'))->filter()->each(function($search) use ($query,$start_date){
            $term = $search.'%';
            
            $filter_date = Carbon::parse($start_date);
            $query->where(function($query) use ($term){
                $query->where('source','like',$term)
                ->orWhere('title','like',$term)
                ->orWhere('author','like',$term);
            })
            ->when( !is_null($start_date)  ,function ($query) use ($filter_date) {
                $query->whereDate('published_at',[ $filter_date->format('Y-m-d H:i:s')]);
            });
            
        });
    }
}
