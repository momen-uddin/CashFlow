<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class agentController extends Controller
{
    public function index()
    {
        return view('agent.dashboard');
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'name' => 'string',
            'number' => ['string', 'max:50', 'unique:'.User::class.',number,'.$request->id],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$request->id],

        ]);


        $user = $request->id;
        $user = User::find($user);

        $user->name = $request->name;
        $user->number = $request->number;
        $user->email = $request->email;

        if ($user->save()) {
            return redirect()->back()->with('success', 'User updated successfully.');
        }else {
            return redirect()->back()->with('error', 'User not updated.');

        }

    }

}
