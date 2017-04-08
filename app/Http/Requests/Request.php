<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    protected function validationData()
    {
        $data = $this->all();

        // if is not an array , so json_decode()
        foreach ($data as $key => $form_items) {

            if(! is_array($form_items)){
                $data[$key] = json_decode($form_items);
            }else{
                $data[$key] = $form_items;
            }

        }

        return $data;

    }
}
