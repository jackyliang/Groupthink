<?php

namespace App\Http\Controllers;

use Serverfireteam\Panel\CrudController;

class PricesController extends CrudController
{
    public function all($entity)
    {
        parent::all($entity);

        $this->filter = \DataFilter::source(new \App\Prices());
        $this->filter->add('prices', 'Prices', 'text');
        $this->filter->submit('search');
        $this->filter->reset('reset');
        $this->filter->build();

        $this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id', 'ID', true);
        $this->grid->add('date', 'Date', true);
        $this->grid->add('symbol_id', 'Symbol ID', true);
        $this->grid->add('open', 'Open', true);
        $this->grid->add('high', 'High', true);
        $this->grid->add('low', 'Low', true);
        $this->grid->add('last', 'Last', true);
        $this->grid->add('settle', 'Settle', true);
        $this->grid->add('volume', 'Volume', true);
        $this->grid->add('open_interest', 'Open Interest', true);
        $this->grid->add('created_at', 'Created At', true);
        $this->grid->add('updated_at', 'Updated At', true);
        $this->addStylesToGrid();

        return $this->returnView();
    }

    public function edit($entity)
    {
        parent::edit($entity);

        $this->edit = \DataEdit::source(new \App\Prices());
        $this->edit->label('Edit Prices');
        $this->edit->add('date', 'Date i.e. 2010-05-13 *', 'text')->rule('required|date_format:Y-m-d');
        $this->edit->add('open', 'Open', 'text');
        $this->edit->add('high', 'High', 'text');
        $this->edit->add('low', 'Low', 'text');
        $this->edit->add('last', 'Last', 'text');
        $this->edit->add('settle', 'Settle', 'text');
        $this->edit->add('volume', 'Volume', 'text');
        $this->edit->add('open_interest', 'Open Interest', 'text');

        return $this->returnEditView();
    }
}
