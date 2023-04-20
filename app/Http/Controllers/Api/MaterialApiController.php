<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialDataRequest;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Http\Resources\Admin\MaterialResource;
use App\Models\Material;
use App\Models\TeacherMaterialLevel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class MaterialApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('material_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return MaterialResource::collection(
            Material::advancedFilter()
                ->filter(Request::only(['trashed', 'type']))
                ->paginate(request('limit', 10))
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
    public function store(StoreMaterialRequest $request)
    {
        abort_if(Gate::denies('material_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $material = Material::create($request->validated());
        return (new MaterialResource($material))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function addData(MaterialDataRequest $request)
    {

        $material  = TeacherMaterialLevel::where([
            'teacher_id' => $request->teacher_id,
            'material_id' => $request->material_id,
            'level_id' => $request->level_id
        ])->first();
        if ($material) {
            return response(['message' => 'تم اضافة المادة لهذا المعلم من قبل'], Response::HTTP_FORBIDDEN);
        }
        $data = new TeacherMaterialLevel();
        $data->teacher_id = $request->teacher_id;
        $data->material_id = $request->material_id;
        $data->level_id = $request->level_id;
        $data->status = 1;
        $data->save();
        return (new MaterialResource($data))->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        abort_if(Gate::denies('material_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new MaterialResource($material),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update($request->validated());
        return (new MaterialResource($material))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        abort_if(Gate::denies('material_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($material->deleted_at) {
            $material->forceDelete();
        } else {
            $material->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function restore(Material $item)
    {
        abort_if(Gate::denies('material_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteItem(TeacherMaterialLevel $item)
    {
        abort_if(Gate::denies('material_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
