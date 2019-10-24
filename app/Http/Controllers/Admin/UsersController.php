<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UsersRequest;
use App\Events\ImagMiniEvent;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::All();

        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $user = User::add($request->all());

        if($request->hasFile('avatar')) {

            $path = $user->uploadAvatar($request->file('avatar'));

            event(new ImagMiniEvent($path));
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'avatar' => 'nullable|image',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user = User::find($id);

        $oldFileName = $user->avatar;

        $user->edit($request->all());
        $user->generatePassword($request->get('password'));
        if($request->hasFile('avatar')) {

            if($oldFileName !== null) {

                $user->deleteImages($oldFileName);

                $user->deleteMiniImages($oldFileName);
            }
            $path = $user->uploadAvatar($request->file('avatar'));

            event(new ImagMiniEvent($path));
        }
        $user->toggleUser($request->is_admin)->toggleBan($request->status);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if($user->avatar !== null) {

            $user->deleteImages($user->avatar);

            $user->deleteMiniImages($user->avatar);
        }

        $user->delete();
    }
}
