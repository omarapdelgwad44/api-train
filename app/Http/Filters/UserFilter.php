<?php
namespace App\Http\Filters;

class UserFilter extends QueryFilter 
{
    public function include($includes)
    {
        return $this->builder->with($includes);
    }

    public function email($email)
    {
        $likeStar= str_replace("*", "%", $email);
        return $this->builder->where('email', 'like', $likeStar);
    }

    public function name($name)
    {
        $likeStar= str_replace("*", "%", $name);
        return $this->builder->where('name', 'like', $likeStar);
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