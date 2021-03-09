<?php

namespace App\Observers;

use App\Models\Application;
use App\Services\ApplicationService;

class ApplicationObserver
{
    /**
     * @param ApplicationService $applicationService
     */
    public function __construct(private ApplicationService $applicationService)
    {
    }

    /**
     * @param Application $application
     * @return void
     */
    public function created(Application $application): void
    {
        $this->applicationService->sendMail(
            $application->email,
            ['id' => $application->id]
        );
    }

    /**
     * @param Application $application
     * @return void
     */
    public function updated(Application $application)
    {
        //
    }

    /**
     * @param Application $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }
}
