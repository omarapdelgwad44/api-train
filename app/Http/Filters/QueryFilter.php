<?php
namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter 
{
    protected $builder;
    protected $request;
    protected $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter ($arr)
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $this->builder;
    }

    protected function sort($value) {
        $sortAtrbutes = explode(',', $value);
        foreach ($sortAtrbutes as $sortAtrbute) {
            $direction= 'asc' ;
            if(strpos($sortAtrbute, '-') === 0) {
                $direction = 'desc';
                $sortAtrbute = substr($sortAtrbute, 1);
            }
            if(!in_array($sortAtrbute, $this->sortable)&&!array_key_exists($sortAtrbute, $this->sortable)) {
                continue;
            }
            $columnName = $this->sortable[$sortAtrbute] ?? $sortAtrbute;
            $this->builder->orderBy($columnName, $direction);
        }
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $builder;
    }
}