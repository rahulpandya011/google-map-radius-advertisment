<?php

namespace App\Http\Controllers\Front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Advertisment\SearchRequest;
use App\Http\Requests\Advertisment\StoreRequest;
use App\Models\Advertisment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('advertisment.search');
    }

    public function add(Request $request)
    {
        return view('advertisment.add');
    }

    public function search(SearchRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = Advertisment::selectRaw("id, name ,
                         ( 6371 * acos( cos( radians(?) ) *
                           cos( radians( lat ) )
                           * cos( radians( lng ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( lat ) ) )
                         ) AS distance", [$validated['lat'], $validated['lng'], $validated['lat']]);

            if ($validated['radius']) {
                $data = $data->having("distance", "<", $validated['radius']);
            }
            $data = $data
                ->orderBy("distance", 'asc')
                ->get();

            $list = view('advertisment.list', compact('data'))->render();

            return Helper::responseData(
                Response::HTTP_OK,
                "Location Fetched Successfully",
                [
                    'view' => $list
                ]
            );
        } catch (Exception $e) {
            return Helper::responseData(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $exist = Advertisment::where(
                'lat',
                $validated['lat']
            )->where(
                'lng',
                $validated['lng']
            )->count();
            if ($exist > 0) {
                return Helper::responseData(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    "Advertisment already added on same location"
                );
            }
            Advertisment::create($validated);

            return Helper::responseData(
                Response::HTTP_OK,
                "Advertisment added Successfully"
            );
        } catch (Exception $e) {
            return Helper::responseData(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
