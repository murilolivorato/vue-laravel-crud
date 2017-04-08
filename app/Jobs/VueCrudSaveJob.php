<?php

namespace App\Jobs;

use App\Jobs\Job;

use App\VueCrud;

use Illuminate\Http\Request;
use App\Http\Requests;

class VueCrudSaveJob extends Job
{


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($action , VueCrud $vueCrud ,Request $vueCrudRequest)
    {
        $this->action                 = $action;
        $this->vueCrud                = $vueCrud;
        $this->vueCrudRequest         = $vueCrudRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->vueCrud->title          =  json_decode($this->vueCrudRequest['title']);
        $this->vueCrud->sub_title      =  json_decode($this->vueCrudRequest['sub_title']);
        $this->vueCrud->description    =  json_decode($this->vueCrudRequest['description']);

        //create
        $this->vueCrud->save();

        return $this->action != "create" ?  $this->updateTable() : $this->createTable();
    }

    /**********************************************************************************
    CREATE TABLE
     ***********************************************************************************/
    protected function createTable(){
        // select last post by this user
        $last_post = VueCrud::getLastCreated($this->vueCrud->user_id);
        return ['id' => $last_post->id , 'title' => $last_post->title , 'sub_title' => $last_post->sub_title];
    }

    /**********************************************************************************
    UPDATE TABLE
     ***********************************************************************************/
    protected function updateTable(){


        return ['index' => json_decode($this->vueCrudRequest['index']) , 'title' => json_decode($this->vueCrudRequest['title']) , 'sub_title' => json_decode($this->vueCrudRequest['sub_title']) ];
    }
}

