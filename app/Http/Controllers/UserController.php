<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', [
            'user'=> $user,
            'tests' => $user->tests()->paginate(15),
            'courses' => $user->courses()->paginate(15),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('user.edit', [
            'user'=> $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        
        $data['image'] =
            (boolval($data['del_image'] ?? null)) ? null :
            (isset($data['image']) ? ImageHelper::uploadImage($data['image']) :
            $user->image);

        $user->fill($data);
        $user->save();

        return redirect()->route('user.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
    }
}
