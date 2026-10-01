<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $home = Page::query()
            ->type(Page::TYPE_PAGE)
            ->where('slug', 'home')
            ->firstOrFail();

        return $this->renderPage($home, [Page::TYPE_PAGE]);
    }
}
