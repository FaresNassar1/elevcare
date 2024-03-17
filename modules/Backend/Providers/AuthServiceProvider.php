<?php

namespace Juzaweb\Backend\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Juzaweb\Applications\Models\Application;
use Juzaweb\Appointments\Models\Appointment;
use Juzaweb\Contacts\Models\Contact;
use Juzaweb\Inquiries\Models\Inquiry;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Models\User;
use Juzaweb\Backend\Policies\PostPolicy;
use Juzaweb\Backend\Policies\TaxonomyPolicy;
use Juzaweb\Backend\Policies\UserPolicy;
use Juzaweb\Backend\Policies\ApplicationPolicy;
use Juzaweb\Backend\Policies\AppointmentPolicy;
use Juzaweb\Backend\Policies\DonationPolicy;
use Juzaweb\Backend\Policies\SectorPolicy;
use Juzaweb\Backend\Policies\ContactPolicy;
use Juzaweb\Backend\Policies\InquiryPolicy;
use Juzaweb\Backend\Policies\HrPolicy;
use Juzaweb\Hresource\Models\Hr;
use Juzaweb\Donations\Models\Donation;
use Juzaweb\Sectors\Models\Sector;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Taxonomy::class => TaxonomyPolicy::class,
        User::class => UserPolicy::class,
        Application::class => ApplicationPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        Contact::class => ContactPolicy::class,
        Hr::class => HrPolicy::class,
        Donation::class => DonationPolicy::class,
        Sector::class => SectorPolicy::class,
        Inquiry::class => InquiryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(
            function ($user, $ability) {
                if ($user->isAdmin()) {
                    return true;
                }

                return null;
            }
        );

        ResetPassword::createUrlUsing(
            function ($notifiable, $token) {
                return config('app.frontend_url')
                    . "/password-reset/{$token}?email={$notifiable->getEmailForPasswordReset()}";
            }
        );
    }
}
