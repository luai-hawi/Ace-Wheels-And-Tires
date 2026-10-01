<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class Controller
{
    /**
     * Loads a page's active sections/cards and renders the generic section-based
     * template. Every page-like controller (Home, Page, Service area) shares this
     * one method instead of repeating the same eager-loading + view call.
     */
    protected function renderPage(Page $page, array $allowedTypes, string $view = 'pages.show'): View
    {
        if (! $page->is_published || ! in_array($page->type, $allowedTypes, true)) {
            throw new NotFoundHttpException;
        }

        $page->load('activeSections.activeItems');

        return view($view, ['page' => $page]);
    }
}
