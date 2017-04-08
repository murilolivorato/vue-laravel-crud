<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

// REQUEST
use App\Http\Requests\VueCrudRequest;

// MODEL
use App\VueCrud;

// JOBS
use App\Jobs\VueCrudSaveJob;

// CLASSES
use App\Classes\DeleteCrud;

class VueCrudController extends Controller
{
    public function __construct()
    {



    }

    /**********************************************************************************
    INDEX
     ***********************************************************************************/
    public function index()
    {
        return view('vue_crud' );

    }

    /**********************************************************************************
    LOAD DISPLAY
     ***********************************************************************************/
    public function load_display()
    {
        $items = VueCrud::select(['id', 'title' , 'sub_title' , 'description'])->latest()->paginate(6);


        $response = [
            'pagination' => [
                'total'         => $items->total(),
                'per_page'      => $items->perPage(),
                'current_page'  => $items->currentPage(),
                'last_page'     => $items->lastPage(),
                'from'          => $items->firstItem(),
                'to'            => $items->lastItem()
            ],
            'data'             => $items
        ];


        return response()->json($response);

    }


    /**********************************************************************************
    STORE
     ***********************************************************************************/
    public function store(VueCrudRequest $request)
    {

        /* validation */
        $crud = new VueCrud() ;

        // Dispatch a Job
        $new_content = $this->dispatch(new VueCrudSaveJob("create" , $crud , $request));


        return response()->json([$new_content]);


    }



    /**********************************************************************************
    UPDATE
     ***********************************************************************************/
    public function update(Request $request)
    {

        /* validation */
        $crud = VueCrud::findOrFail(json_decode($request['id']));

        // Dispatch a Job
        $new_content= $this->dispatch(new VueCrudSaveJob("update" , $crud , $request));


        return response()->json($new_content);



    }


    /**********************************************************************************
    DELETE
     ***********************************************************************************/
    public function delete(Request $request)
    {

        $value        = $request['value'];

        /**********************************************************************************
         * check if the post is a single post or a multiple post , if is a single post delete only
         * one Item , if not , delete multiple Itens
         *
         ***********************************************************************************/
        $itemsToRemove = (new  DeleteCrud($value))->deleteItem();


        return response()->json(['index' => $itemsToRemove]);
    }
}
