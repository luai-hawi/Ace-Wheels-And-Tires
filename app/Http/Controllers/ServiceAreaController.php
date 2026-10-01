<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class ServiceAreaController extends Controller
{
    public function show(Page $page): View
    {
        return $this->renderPage($page, [Page::TYPE_SERVICE_AREA]);
    }
}
