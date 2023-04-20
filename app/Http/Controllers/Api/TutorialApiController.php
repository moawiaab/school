<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestModelRequest;
use App\Http\Requests\StoreTutorialRequest;
use App\Http\Requests\UpdateTutorialRequest;
use App\Http\Resources\Admin\TutorialResource;
use App\Models\TestItem;
use App\Models\TestModel;
use App\Models\Tutorial;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class TutorialApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('tutorial_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return TutorialResource::collection(
            Tutorial::advancedFilter()
                ->filter(Request::only(['trashed', 'type']))
                ->paginate(request('limit', 20))
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTutorialRequest $request)
    {
        $tutorial = Tutorial::create($request->validated() + ['user_id' => auth()->id()]);
        if ($request->hasFile('audio')) {
            $tutorial->addMediaFromRequest('audio')->toMediaCollection('tutorial_audio');
        }
        return  response(['data' => $tutorial])
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tutorial $tutorial)
    {
        return response([
            'data' => new TutorialResource($tutorial),
        ]);
    }


    public function asks(StoreTestModelRequest $request)
    {

        $tut = Tutorial::find($request->tutorial_id);
        $ask = new TestModel();
        $ask->ask           = $request->ask;
        $ask->details       = $request->details;
        $ask->user_id       = auth()->id();
        $ask->tutorial_id   = $request->tutorial_id;
        $ask->material_id   = $tut->material_id;

        if ($ask->save()) {
            foreach ($request->answers as $k) {
                $at = new TestItem();
                $at->ask_id = $ask->id;
                $at->answer = $k['answer'];
                $at->status = $k['id'] == $request->type ? 1 : 0;
                $at->save();
            }
        }

        return  response(['data' => $ask])
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tutorial $tutorial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTutorialRequest $request, Tutorial $tutorial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tutorial $tutorial)
    {
        //
    }
}
