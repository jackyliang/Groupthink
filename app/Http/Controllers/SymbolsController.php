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
		$this->grid->add('exchange', 'Exchange', true);
		$this->grid->add('symbol', 'Symbol', true);
        $this->grid->add('type', 'Type', true);
        $this->grid->add('cat', 'Category', true);
        $this->grid->add('expire_month', 'Expire Month', true);
        $this->grid->add('expire_year', 'Expire Year', true);
        $this->grid->add('created_at', 'Created At', true);
        $this->grid->add('updated_at', 'Updated At', true);

		$this->addStylesToGrid();

        return $this->returnView();
    }
    
    public function  edit($entity){
        
        parent::edit($entity);

        // Simple code of filter and grid part.
        // List of all fields here: http://laravelpanel.com/docs/master/crud-fields

        // Pre-load the months to the select box
        $months = [null];
        for($i = 1; $i < 13; $i++) {
            array_push($months, $i);
        }

        // Pre-load the years to the select box
        $years = [null];
        for($i = 2000; $i < 2101; $i++) {
            array_push($years, $i);
        }

		$this->edit = \DataEdit::source(new \App\Symbols());
		$this->edit->label('Edit Symbols');
		$this->edit->add('exchange', 'Exchange', 'text');
        $this->edit->add('symbol', 'Symbol', 'text')->rule('required');
        $this->edit->add('expire_month', 'Expire Month', 'select')
            ->options($months)->getValue();
        $this->edit->add('expire_year', 'Expire Year', 'select')
            ->options($years)->getValue();
        $this->edit->add('type', 'Type, i.e. future', 'text');
        $this->edit->add('cat', 'Category', 'text')->rule('required');

        return $this->returnEditView();
    }    
}
