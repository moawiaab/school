<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\Level;
use App\Models\Student;
use App\Models\StudentLevel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class StudentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return StudentResource::collection(
            Student::advancedFilter()
                ->filter(Request::only(['trashed', 'type']))
                ->paginate(request('limit', 10))
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'meta' => [
                'levels' => Level::get(['id', 'name'])
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $student = Student::create($request->validated() + ['account_id' => 1]);
        $student->levels()->sync($request->level_id);

        if ($request->hasFile('photo')) {
            $student->addMediaFromRequest('photo')->toMediaCollection('student_photos');
        }

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        abort_if(Gate::denies('student_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new StudentResource($student),
            'meta' => [
                'levels' => Level::get(['id', 'name'])
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $level2 = StudentLevel::where(['student_id' => $student->id, 'level_id' => $request->level_id])->first();
        // $student->update($request->validated());
        $level = $student->level[0] ?? null;
        if ($level) {
            // $level = $student->level[0];
            if($level->level_id != $request->level_id){
                $level->status = 0;
                $level->save();
            }else{
                $level->status = 1;
                $level->save();
            }
        } else {
            $student->levels()->syncWithoutDetaching($request->level_id);
            if($level2){
                $level2->status = 1;
                $level2->save();
            }
        }



        return response(['data' => $level2], Response::HTTP_ACCEPTED);
        // return (new StudentResource($student))
        //     ->response()
        //     ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($student->deleted_at) {
            $student->forceDelete();
        } else {
            $student->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function restore(Student $item)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
