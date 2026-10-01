<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    /** The /blog listing: the "blog" page's own sections, followed by the post cards. */
    public function index(): View
    {
        $blogPage = Page::query()
            ->type(Page::TYPE_PAGE)
            ->where('slug', 'blog')
            ->published()
            ->with('activeSections.activeItems')
            ->firstOrFail();

        $search = trim((string) request('q'));

        $posts = Page::query()
            ->type(Page::TYPE_BLOG_POST)
            ->published()
            ->when($search !== '', fn($query) => $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            }))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('pages.blog-index', compact('blogPage', 'posts', 'search'));
    }

    public function show(Page $page): View
    {
        return $this->renderPage($page, [Page::TYPE_BLOG_POST], 'pages.blog-show');
    }
}
