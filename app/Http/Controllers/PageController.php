<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /** Renders any standard page or service page reached by its flat, top-level URL. */
    public function show(Page $page): View
    {
        return $this->renderPage($page, [Page::TYPE_PAGE, Page::TYPE_SERVICE]);
    }
}
