<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\URL;
use Livewire\Component;

class PerPagePaginator extends Component
{
    public $perPage;

    protected $queryString = [
        'perPage'
    ];

    public function updatingPerPage($value)
    {
        if ($refreshUrl = request()?->header('Referer')) {
            $this->perPage = $value;
            parse_url($refreshUrl, PHP_URL_QUERY) ?
                ($refreshUrl .= '&perPage=' . $this->perPage) :
                ($refreshUrl .= '?perPage=' . $this->perPage);


            $this->redirect($refreshUrl);
        }
    }

    public function render()
    {
        return view('livewire.per-page-paginator');
    }
}
