<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatemodelosRequest;
use App\Http\Requests\UpdatemodelosRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\modelos;
use Illuminate\Http\Request;
use Flash;
use Response;

class modelosController extends AppBaseController
{
    /**
     * Display a listing of the modelos.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var modelos $modelos */
        $modelos = modelos::paginate(10);

        return view('modelos.index')
            ->with('modelos', $modelos);
    }

    /**
     * Show the form for creating a new modelos.
     *
     * @return Response
     */
    public function create()
    {
        return view('modelos.create');
    }

    /**
     * Store a newly created modelos in storage.
     *
     * @param CreatemodelosRequest $request
     *
     * @return Response
     */
    public function store(CreatemodelosRequest $request)
    {
        $input = $request->all();

        /** @var modelos $modelos */
        $modelos = modelos::create($input);

        Flash::success('Modelos saved successfully.');

        return redirect(route('modelos.index'));
    }

    /**
     * Display the specified modelos.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var modelos $modelos */
        $modelos = modelos::find($id);

        if (empty($modelos)) {
            Flash::error('Modelos not found');

            return redirect(route('modelos.index'));
        }

        return view('modelos.show')->with('modelos', $modelos);
    }

    /**
     * Show the form for editing the specified modelos.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var modelos $modelos */
        $modelos = modelos::find($id);

        if (empty($modelos)) {
            Flash::error('Modelos not found');

            return redirect(route('modelos.index'));
        }

        return view('modelos.edit')->with('modelos', $modelos);
    }

    /**
     * Update the specified modelos in storage.
     *
     * @param int $id
     * @param UpdatemodelosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemodelosRequest $request)
    {
        /** @var modelos $modelos */
        $modelos = modelos::find($id);

        if (empty($modelos)) {
            Flash::error('Modelos not found');

            return redirect(route('modelos.index'));
        }

        $modelos->fill($request->all());
        $modelos->save();

        Flash::success('Modelos updated successfully.');

        return redirect(route('modelos.index'));
    }

    /**
     * Remove the specified modelos from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var modelos $modelos */
        $modelos = modelos::find($id);

        if (empty($modelos)) {
            Flash::error('Modelos not found');

            return redirect(route('modelos.index'));
        }

        $modelos->delete();

        Flash::success('Modelos deleted successfully.');

        return redirect(route('modelos.index'));
    }
}
