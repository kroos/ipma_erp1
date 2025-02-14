<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,


        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // middleware for Director, HR and User (me) purpose
        'userown' => \App\Http\Middleware\StaffProfile\RedirectIfNotOwner::class,
        'userchild' => \App\Http\Middleware\StaffProfile\RedirectIfNotChildren::class,
        'userspouse' => \App\Http\Middleware\StaffProfile\RedirectIfNotSpouse::class,
        'usersibling' => \App\Http\Middleware\StaffProfile\RedirectIfNotSibling::class,
        'usereducation' => \App\Http\Middleware\StaffProfile\RedirectIfNotEducation::class,
        'useremergencyperson' => \App\Http\Middleware\StaffProfile\RedirectIfNotEmergencyPerson::class,
        'useremergencyphone' => \App\Http\Middleware\StaffProfile\RedirectIfNotEmergencyPersonPhone::class,

        'diviaccess' => \App\Http\Middleware\Division\RedirectIfNotDivision::class,

        'deptaccess' => \App\Http\Middleware\Department\RedirectIfNotDepartment::class,

        'leaveaccess' => \App\Http\Middleware\StaffLeave\RedirectIfNotOwnerLeave::class,

        'ownerchangepassword' => \App\Http\Middleware\StaffProfile\RedirectIfNotOwnerChangePassword::class,

        'officeaccess' => \App\Http\Middleware\Office\RedirectIfStaffProduction::class,
    ];
}
