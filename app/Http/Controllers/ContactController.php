<?php

namespace App\Http\Controllers;

use App\Mail\LeadSubmitted;
use App\Models\Lead;
use App\Models\Page;
use App\Models\Setting;
use App\Http\Requests\StoreLeadRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create(): View
    {
        $page = Page::query()
            ->type(Page::TYPE_PAGE)
            ->where('slug', 'contact')
            ->published()
            ->with('activeSections.activeItems')
            ->firstOrFail();

        return view('pages.contact', [
            'page' => $page,
            // Lets the "Request Service" links (?service=Oil+Change) pre-fill the select.
            'preselectedService' => request('service'),
            'recaptchaSiteKey' => config('services.recaptcha.site_key'),
        ]);
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $lead = Lead::create($request->validated() + [
            'source_url' => url()->previous(),
        ]);

        $recipient = Setting::get('email', config('mail.admin_address'));

        if (filled($recipient)) {
            Mail::to($recipient)->send(new LeadSubmitted($lead));
        }

        return back()->with('status', 'Thanks! We received your request and will be in touch shortly.');
    }
}
