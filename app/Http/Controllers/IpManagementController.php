<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageIpRequest;
use App\Repositories\IpManagementRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IpManagementController extends Controller
{
    public static function get(): JsonResponse
    {
        infoLog(
            __METHOD__,
            'Ip list request accepted',
            []
        );
        try {
            $code = Response::HTTP_OK;
            $ip_list = IpManagementRepository::get();
            $response = responseData(
                true,
                $code,
                'Fetch Ip information successfully',
                optional($ip_list)->toArray()
            );
        } catch (Exception $e) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = responseData(
                false,
                $code,
                Response::$statusTexts[$code],
                [],
                $e->getMessage()
            );
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                $response
            );
        }
        return response()->json($response, $code);
    }

    public static function createOrUpdate(ManageIpRequest $request): JsonResponse
    {
        infoLog(
            __METHOD__,
            'Ip operation request accepted',
            [
                'request' => $request->all(),
                'headers' => $request->header()
            ]
        );
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
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = responseData(
                false,
                $code,
                Response::$statusTexts[$code],
                [],
                $e->getMessage()
            );
            errorLog(
                __METHOD__,
                Response::$statusTexts[$code],
                $response
            );
        }
        return response()->json($response, $code);
    }

    public static function getById(int $id): JsonResponse
    {
        try {
            infoLog(
                __METHOD__,
                'Ip get request accepted',
                [
                    'request' => $id
                ]
            );
            $ip = IpManagementRepository::getById($id);
            $code = $ip ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;
            $response = responseData(
                true,
                $code,
                $ip ? 'Fetch ip information successfully' : 'No ip information found',
                $ip ? optional($ip)->toArray() : []
            );
        } catch (Exception $e) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = responseData(
                false,
                $code,
                Response::$statusTexts[$code],
                [],
                $e->getMessage()
            );
            errorLog(
                __METHOD__,
                Response::$statusTexts[$code],
                $response
            );
        }
        return response()->json($response);
    }
}
