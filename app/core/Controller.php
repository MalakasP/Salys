<?php

class Controller
{
    protected function model($model)
    {
        //might need to check if exists
        require_once '../app/models/' . $model . '.php';
        return new $model;
        
    }

    protected function view($view, $data = [])
    {
        //might need to check if exists
        require_once '../app/views/' . $view . '.php';
    }

    protected function validator($validations, $required, $maxLengths)
    {
        $validator = new validator($validations, $required, $maxLengths);
        return $validator;
    }
}

?>