<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\VueCrudRequest;


use App\VueCrud;
use App\Classes\DeleteVueCrud;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

// JOBS
use App\Jobs\VueCrudSaveJob;

class VueCrudController extends Controller
{
    public function __construct()
    {
        parent::__construct();



    }

    /**********************************************************************************
    INDEX
     ***********************************************************************************/
    public function index()
    {
        return view('admin/vue_crud' );

    }

    /**********************************************************************************
    LOAD DISPLAY
     ***********************************************************************************/
    public function load_display()
    {
        $items = VueCrud::select(['id', 'title'])->latest()->with('countProducts')->paginate($this->items_per_page);


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
        $post_category = new VueCrud() ;

        // Dispatch a Job
        $new_content = $this->dispatch(new VueCrudSaveJob("create" , $post_category , $request , $this->user));


        return response()->json([$new_content]);



    }



    /**********************************************************************************
    EDIT ITEM
     ***********************************************************************************/
    public function edit(VueCrudRequest $request)
    {


        $post_category = VueCrud::findOrFail($request['postId']);
        /* $post_category->fill($request->all()) ; */

        $msg = $this->dispatch(new VueCrudSaveJob("update" , $post_category , $request , $this->user));

        return response()->json([ 'success' => true , 'new_content' => 'title_'.$msg['title'] ], 200);



    }

    /**********************************************************************************
    UPDATE
     ***********************************************************************************/
    public function update(Request $request)
    {

        /* validation */
        $post_category = ProductCategory::findOrFail(json_decode($request['id']));

        // Dispatch a Job
        $new_content= $this->dispatch(new ProductCategorySaveJob("update" , $post_category , $request , $this->user));


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
        $itemsToRemove = (new  DeleteProducCategory($value))->deleteItem();


        return response()->json(['index' => $itemsToRemove]);
    }
}
