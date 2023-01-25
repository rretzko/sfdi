<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\EmailAddedEvent::class => [
            \App\Listeners\SendEmailVerificationNotificationListener::class,
            \App\Listeners\StoreEmailVerificationNotificationListener::class,
        ],
        \App\Events\NewRegistrationEvent::class => [
            \App\Listeners\SendNewRegistrationEmailListener::class,
            \App\Listeners\StoreNewRegistrationEmailListener::class,
        ],
        \App\Events\ParentAttachedEvent::class => [
          \App\Listeners\StoreNewParentEmailListener::class,
          \App\Listeners\SendNewParentEmailListener::class,
        ],
        \App\Events\RegistrantPaymentEvent::class => [
            \App\Listeners\SendEmailTeacherRegistrantPaymentListener::class,
        ],
        \App\Events\MakeRegistrationIdsEvent::class => [
          \App\Listeners\MakeRegistrationIdsListener::class,
        ],
        \App\Events\ResetPasswordRequestEvent::class => [
          \App\Listeners\SendPasswordResetEmailListener::class,
          \App\Listeners\StorePasswordResetEmailListener::class,
        ],
        \App\Events\StudentAddedSchoolEvent::class => [
            \App\Listeners\StoreEmailTeacherAboutNewStudentListener::class,
            \App\Listeners\SendEmailTeacherAboutNewStudentListener::class,
        ],
 //           StudentRequestTeacher::class => [
  //              \App\Listeners\EmailTeacherNewStudent::class,
 //       ],

            \App\Events\PrimaryEmailVerifiedEvent::class => [
            \App\Listeners\EmailStudentWelcomeListener::class,
        ],
        \App\Events\UsernameReminderEvent::class => [
            \App\Listeners\SendEmailUsernameReminderListener::class,
        ],
        \App\Events\EmailDuplicateStudentNoticeEvent::class => [
            \App\Listeners\EmailDuplicateStudentNoticeListener::class,
        ],
        //Registered::class => [
        //    \App\Listeners\SendNewRegistrationEmailListener::class,
            //\App\Listeners\SendRegisteredEmailVerificationNotificationListener::class,
            //\App\Listeners\StoreEmailVerificationNotificationListener::class,
            //SendEmailVerificationNotification::class,
            //\App\Listeners\SendEmailVerificationNotificationListener::class,
        //],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
