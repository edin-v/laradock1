<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $patients = Patient::all();

        return $this->successResponse($patients);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $rules = [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $patient = Patient::create($request->all());

        return $this->successResponse($patient, Response::HTTP_CREATED);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function show($patient)
    {
        $patient = Patient::findOrFail($patient);

        return $this->successResponse($patient);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request, $patient)
    {
        $rules = [
            'firstname' => 'max:255',
            'lastname' => 'max:255',
        ];

        $this->validate($request, $rules);

        $patient = Patient::findOrFail($patient);

        $patient->fill($request->all());

        if($patient->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $patient->save();

        return $this->successResponse($patient);
    }

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function destroy($patient)
    {
        $patient = Patient::findOrFail($patient);

        $patient->delete();

        return $this->successResponse($patient);
    }
}
