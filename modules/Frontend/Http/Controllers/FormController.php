<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Juzaweb\Contacts\Models\Contact;
use Juzaweb\Frontend\Http\Requests\ContactUsRequest;

class FormController extends Controller
{
    protected $cacheTime;
    public function __construct()
    {
        $this->cacheTime = get_config('cache_duration', 0);
    }
    public function index()
    {
        return view('frontend::contact', compact('subjects'));
    }

    public function store(ContactUsRequest $request)
    {

        $formData = [
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ];

        $record = Contact::create($formData);
        $form_email = get_config('email.contact_email');
        if (isset($form_email)) {
            $dynamicLink = config('app.url') . config('juzaweb.admin_prefix') . '/contacts/' . $record->id . '/edit';
            send_email_notification("Contact", $form_email, $dynamicLink, $formData);
        }
        return redirect()->route('contact-us.index')->with('success', __('contact successful'));
    }
}
