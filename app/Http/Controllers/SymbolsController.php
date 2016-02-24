<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Serverfireteam\Panel\CrudController;

use Illuminate\Http\Request;

class SymbolsController extends CrudController{

    public function all($entity){
        parent::all($entity); 

        // Simple code of filter and grid part.
        // List of all fields here: http://laravelpanel.com/docs/master/crud-fields

        $this->filter = \DataFilter::source(new \App\Symbols);
		$this->filter->add('symbol', 'Symbols', 'text');
		$this->filter->submit('search');
		$this->filter->reset('reset');
		$this->filter->build();
		$this->grid = \DataGrid::source($this->filter);
		$this->grid->add('exchange', 'Exchange');
		$this->grid->add('symbol', 'Symbol');
        $this->grid->add('type', 'Type');
        $this->grid->add('cat', 'Category');
		$this->addStylesToGrid();

        return $this->returnView();
    }
    
    public function  edit($entity){
        
        parent::edit($entity);

        // Simple code of filter and grid part.
        // List of all fields here: http://laravelpanel.com/docs/master/crud-fields

		$this->edit = \DataEdit::source(new \App\Symbols());
		$this->edit->label('Edit Symbols');
		$this->edit->add('exchange', 'Exchange', 'text')->rule('required');
        $this->edit->add('symbol', 'Symbol', 'text')->rule('required');
        $this->edit->add('type', 'Type', 'text')->rule('required');
        $this->edit->add('cat', 'Category', 'text')->rule('required');

        return $this->returnEditView();
    }    
}
