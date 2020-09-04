<?php

namespace Modules\Vcore\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class VcoreApiController extends Controller
{

    //Return params from Request
    public function getParamsRequest($request, $params = [])
    {
        $defaultValues = (object)$params;//Convert to object the params


        //Set default values
        $default = (object)[
        "page" => $defaultValues->page ?? false,
        "take" => $defaultValues->take ?? false,
        "filter" => $defaultValues->filter ?? [],
        'include' => $defaultValues->include ?? [],
        'fields' => $defaultValues->fields ?? []
        ];

        //Return params
        $params = (object)[
            "page" => is_numeric($request->input('page')) ? $request->input('page') : $default->page,
            "take" => is_numeric($request->input('take')) ? $request->input('take') : ($request->input('page') ? 12 : $default->take),
            "filter" => json_decode($request->input('filter')) ?? (object)$default->filter,
            "include" => $request->input('include') ? explode(",", $request->input('include')) : $default->include,
            "fields" => $request->input('fields') ? explode(",", $request->input('fields')) : $default->fields
        ];


        //Set language translation by filter
        if (isset($params->filter->locale) && !is_null($params->filter->locale)) {
            \App::setLocale($params->filter->locale);
        }

        //Set locale to filter
        $params->filter->locale = \App::getLocale();

        return $params;//Response

    }

    //Validate if code is like status response, and return status code
    public function getStatusError($code = false)
    {
        switch ($code) {
        case 204:
            return 204;
            break;
        case 400: //Bad Request
            return 400;
            break;
        case 401:
            return 401;
            break;
        case 403:
            return 403;
            break;
        case 404:
            return 404;
            break;
        case 502:
            return 502;
            break;
        case 504:
            return 504;
            break;
        default:
            return 500;
            break;
        }
    }

    //Validate if fields are validated according to rules
    public function validateRequestApi($request)
    {
        //Create Validator
        $validator = \Validator::make($request->all(), $request->rules());

        //if get errors, throw errors
        if ($validator->fails()) {
            $errors = json_decode($validator->errors());
            throw new \Exception(json_encode($errors), 402);
        } else {//if  is sucessful, return true
            return true;
        }
    }

    //Transform data of Paginate
    public function pageTransformer($data)
    {
        return [
            "total" => $data->total(),
            "lastPage" => $data->lastPage(),
            "perPage" => $data->perPage(),
            "currentPage" => $data->currentPage()
        ];
    }


}
