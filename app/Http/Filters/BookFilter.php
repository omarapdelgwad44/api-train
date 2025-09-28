<?php
namespace App\Http\Filters;

class BookFilter extends QueryFilter 
{
    public function include($includes)
    {
        return $this->builder->with($includes);
    }
    public function title($title)
    {
        $likeStar =str_replace("*", "%", $title);
        return $this->builder->where('title', 'like', $likeStar);
    }
    public function author($author)
    {
        $likeStar= str_replace("*", "%", $author);
        return $this->builder->where('author', 'like', $likeStar);
    }
    public function description($description)
    {
        $likeStar= str_replace("*", "%", $description);
        return $this->builder->where('description', 'like', $likeStar);
    }
    public function isPublished($isPublished)
    {
        return $this->builder->where('is_published', $isPublished);
    }
    public function publishedYear($publishedYear)
    {
        $dates = explode('-', $publishedYear);
        if(count($dates) == 2) {
            return $this->builder->whereBetween('published_year', $dates);
        }
        return $this->builder->where('published_year', $publishedYear);
    }
    public function createdAt($createdAt)
    {
        $dates = explode(',', $createdAt);
        if(count($dates) == 2) {
            return $this->builder->whereBetween('created_at', $dates);
        }
        return $this->builder->whereDate('created_at', $createdAt);
    }


}