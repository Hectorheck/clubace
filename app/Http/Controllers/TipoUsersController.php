<?php

namespace App\Http\Controllers;

use App\DataTables\TipoUsersDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTipoUsersRequest;
use App\Http\Requests\UpdateTipoUsersRequest;
use App\Models\TipoUsers;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TipoUsersController extends AppBaseController
{
    /**
     * Display a listing of the TipoUsers.
     *
     * @param TipoUsersDataTable $tipoUsersDataTable
     * @return Response
     */
    public function index(TipoUsersDataTable $tipoUsersDataTable)
    {
        return $tipoUsersDataTable->render('tipo_users.index');
    }

    /**
     * Show the form for creating a new TipoUsers.
     *
     * @return Response
     */
    public function create()
    {
        return view('tipo_users.create');
    }

    /**
     * Store a newly created TipoUsers in storage.
     *
     * @param CreateTipoUsersRequest $request
     *
     * @return Response
     */
    public function store(CreateTipoUsersRequest $request)
    {
        $input = $request->all();

        /** @var TipoUsers $tipoUsers */
        $tipoUsers = TipoUsers::create($input);

        Flash::success('Tipo Users saved successfully.');

        return redirect(route('tipoUsers.index'));
    }

    /**
     * Display the specified TipoUsers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TipoUsers $tipoUsers */
        $tipoUsers = TipoUsers::find($id);

        if (empty($tipoUsers)) {
            Flash::error('Tipo Users not found');

            return redirect(route('tipoUsers.index'));
        }

        return view('tipo_users.show')->with('tipoUsers', $tipoUsers);
    }

    /**
     * Show the form for editing the specified TipoUsers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var TipoUsers $tipoUsers */
        $tipoUsers = TipoUsers::find($id);

        if (empty($tipoUsers)) {
            Flash::error('Tipo Users not found');

            return redirect(route('tipoUsers.index'));
        }

        return view('tipo_users.edit')->with('tipoUsers', $tipoUsers);
    }

    /**
     * Update the specified TipoUsers in storage.
     *
     * @param  int              $id
     * @param UpdateTipoUsersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTipoUsersRequest $request)
    {
        /** @var TipoUsers $tipoUsers */
        $tipoUsers = TipoUsers::find($id);

        if (empty($tipoUsers)) {
            Flash::error('Tipo Users not found');

            return redirect(route('tipoUsers.index'));
        }

        $tipoUsers->fill($request->all());
        $tipoUsers->save();

        Flash::success('Tipo Users updated successfully.');

        return redirect(route('tipoUsers.index'));
    }

    /**
     * Remove the specified TipoUsers from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TipoUsers $tipoUsers */
        $tipoUsers = TipoUsers::find($id);

        if (empty($tipoUsers)) {
            Flash::error('Tipo Users not found');

            return redirect(route('tipoUsers.index'));
        }

        $tipoUsers->delete();

        Flash::success('Tipo Users deleted successfully.');

        return redirect(route('tipoUsers.index'));
    }
}
