<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Serverfireteam\Panel\CrudController;

use Illuminate\Http\Request;

class TweetsController extends CrudController{

    public function all($entity){
        parent::all($entity); 

        // Simple code of  filter and grid part , List of all fields here : http://laravelpanel.com/docs/master/crud-fields

		$this->filter = \DataFilter::source(new \App\Tweets);
		$this->filter->add('tweets', 'Tweets', 'text');
		$this->filter->submit('search');
		$this->filter->reset('reset');
		$this->filter->build();

		$this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id', 'ID', true);
		$this->grid->add('message_id', 'Message ID', true);
        $this->grid->add('username', 'Username', true);
        $this->grid->add('body', 'Message Body', true);
        $this->grid->add('symbol', 'Symbol', true);
        $this->grid->add('timestamp', 'Message Timestamp', true);
        $this->grid->add('created_at', 'Created At', true);
        $this->grid->add('updated_at', 'Updated At', true);

		$this->addStylesToGrid();

        return $this->returnView();
    }
    
    public function  edit($entity){
        
        parent::edit($entity);

        // Simple code of  edit part , List of all fields here : http://laravelpanel.com/docs/master/crud-fields
	
		$this->edit = \DataEdit::source(new \App\Tweets());

		$this->edit->label('Edit Tweets');

		$this->edit->add('message_id', 'Message ID', 'text')->rule('integer|required');
		$this->edit->add('username', 'Username', 'text')->rule('required');
        $this->edit->add('body', 'Message Body', 'text')->rule('required');
        $this->edit->add('symbol', 'Symbol', 'text')->rule('required');
        $this->edit->add('timestamp', 'Message Timestamp', 'text')->rule('required');

        return $this->returnEditView();
    }    
}
