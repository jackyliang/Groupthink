<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Serverfireteam\Panel\CrudController;

use Illuminate\Http\Request;

class IBMWatsonSentimentsController extends CrudController{

    public function all($entity){
        parent::all($entity);

        $this->filter = \DataFilter::source(new \App\IBMWatsonSentiments);
        $this->filter->add('ibmwatson', 'IBM Watson', 'text');
        $this->filter->submit('search');
        $this->filter->reset('reset');
        $this->filter->build();

        $this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id', 'ID', true);
        $this->grid->add('date', 'Date', true);
        $this->grid->add('symbol_id', 'Symbol ID', true);

        $this->grid->add('anger', 'Anger', true);
        $this->grid->add('disgust', 'Disgust', true);
        $this->grid->add('fear', 'Fear', true);
        $this->grid->add('joy', 'Joy', true);
        $this->grid->add('sadness', 'Sadness', true);

        $this->grid->add('created_at', 'Created At', true);
        $this->grid->add('updated_at', 'Updated At', true);

        return $this->returnView();
    }
    
    public function  edit($entity){
        
        parent::edit($entity);

        $this->edit = \DataEdit::source(new \App\IBMWatsonSentiments());

        $this->edit->label('Edit IBM Watson Sentiments');

        $this->edit->add('date', 'Date', 'text')->rule('required');
        $this->edit->add('symbol_id', 'Symbol ID', 'text')->rule('required');

        $this->edit->add('anger', 'Anger', 'text')->rule('required');
        $this->edit->add('disgust', 'Disgust', 'text')->rule('required');
        $this->edit->add('fear', 'Fear', 'text')->rule('required');
        $this->edit->add('joy', 'Joy', 'text')->rule('required');
        $this->edit->add('sadness', 'Sadness', 'text')->rule('required');

        return $this->returnEditView();
    }    
}
