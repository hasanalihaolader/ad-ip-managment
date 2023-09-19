<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageIpRequest;
use App\Repositories\IpManagementRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IpManagementController extends Controller
{
    public static function createOrUpdate(ManageIpRequest $request)
    {
        try {
            $code = Response::HTTP_OK;
            $message = 'No changes were made.';
            $ip_address = IpManagementRepository::createOrUpdate($request);
            if ($ip_address->wasRecentlyCreated) {
                $code = Response::HTTP_CREATED;
                $message = 'New ip information created successfully';
            } elseif ($ip_address->wasChanged()) {
                $message = 'Ip information updated successfully!';
            }
            $response = responseData(
                true,
                $code,
                $message,
                optional($ip_address)->toArray()
            );
            infoLog(
                __METHOD__,
                $message,
                $response
            );
        } catch (Exception $e) {
            $response = responseData(
                false,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [],
                $e->getMessage()
            );
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                $response
            );
        }
        return response()->json($response);
    }
}
