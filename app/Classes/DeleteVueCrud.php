<?php
namespace app\Classes;


use App\VueCrud;



class DeleteVueCrud
{

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
            $item = VueCrud::where('id', $obj->id)->first();

            // delete the page
            $item->delete();

            // push index into index
            array_push($index , $obj->index);


        }

        return $index;

    }




    

}