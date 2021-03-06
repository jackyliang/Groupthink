<?php

namespace App\Http\Controllers;

use Serverfireteam\Panel\CrudController;

class TextBlobSentimentsController extends CrudController
{
    public function all($entity)
    {
        parent::all($entity);

        $this->filter = \DataFilter::source(new \App\TextBlobSentiments());
        $this->filter->add('textblob', 'TextBlob', 'text');
        $this->filter->submit('search');
        $this->filter->reset('reset');
        $this->filter->build();

        $this->grid = \DataGrid::source($this->filter);
        $this->grid->add('id', 'ID', true);
        $this->grid->add('date', 'Date', true);
        $this->grid->add('symbol_id', 'Symbol ID', true);
        $this->grid->add('polarity', 'Polarity', true);
        $this->grid->add('created_at', 'Created At', true);
        $this->grid->add('updated_at', 'Updated At', true);

        return $this->returnView();
    }

    public function edit($entity)
    {
        parent::edit($entity);

        $this->edit = \DataEdit::source(new \App\TextBlobSentiments());

        $this->edit->label('Edit TextBlob Sentiments');

        $this->edit->add('date', 'Date', 'text')->rule('required');
        $this->edit->add('symbol_id', 'Symbol ID', 'text')->rule('required');
        $this->edit->add('polarity', 'Polarity', 'text')->rule('required');

        return $this->returnEditView();
    }
}
