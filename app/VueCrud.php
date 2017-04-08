<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VueCrud extends Model
{

    protected $table    =  'vue_crud';
    protected $guarded  = ['id' , 'created_at' , 'updated_at'];
    protected $fillable = [

        'title',
        'sub_title',
        'description',

    ];


    public static function getLastCreated() {


        return static::orderBy('id', 'desc')->first();

    }

}
