<?php

namespace App\Services;

use App\Http\Requests\StoreApplicationRequest;
use App\Mail\ApplicationMail;
use App\Models\Application;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApplicationService
{
    /**
     * @param array $data
     * @param StoreApplicationRequest $request
     * @return Application
     * @throws Exception
     */
    public function store(array $data, StoreApplicationRequest $request): Application
    {
        DB::beginTransaction();

        try {
            $application = new Application($data);

            if( $request->file('img_receipt') ) {
                $application->img_receipt = $request->file('img_receipt')->store('public/receipts');
            }
            if( $request->file('img_ean') ) {
                $application->img_ean = $request->file('img_ean')->store('public/eans');
            }

            $application->shop_id = $request->input('shop');
            $application->product_id = $request->input('product');
            $application->whence_id = $request->input('whence');

            $params = $request->all();

            $application->legal_1 = array_key_exists('legal_1', $params);
            $application->legal_2 = array_key_exists('legal_2', $params);
            $application->legal_3 = array_key_exists('legal_3', $params);
            $application->legal_4 = array_key_exists('legal_4', $params);
            $application->legal_5 = array_key_exists('legal_5', $params);

            $application->save();

            DB::commit();

            return $application;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('Nie można zapisać zgłoszenia');
        }
    }

    /**
     * @param string $email
     * @param array $data
     * @return void
     */
    public function sendMail(string $email, array $data): void
    {
        Mail::to($email)->send(new ApplicationMail($data, 'emails.application.html', 'emails.application.text'));
    }
}
