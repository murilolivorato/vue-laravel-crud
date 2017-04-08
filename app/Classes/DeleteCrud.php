<?php
namespace app\Classes;


use App\VueCrud;

use Storage;
use File;

class DeleteCrud
{

    protected $type_delete;
    protected $item_to_delete;

    public function __construct($item_to_delete)
    {
        $this->item_to_delete = $item_to_delete;

    }

// delete a massage category and those messages inside
    public function deleteItem()
    {
        $index = [];

        foreach($this->item_to_delete as $deleteItem) {

            $obj = json_decode($deleteItem);

            // Select where ID separeted
            $delete = VueCrud::where('id', $obj->id)->first();

            // delete
            $this->delete_all($delete);
            // push index into index
            array_push($index , $obj->index);


        }

        return $index;

    }




    /**********************************************************************************
    DELETE ALL PHOTOS
     ***********************************************************************************/
    protected function delete_all($item){

        //delete the image
        $item->delete();


    }





}