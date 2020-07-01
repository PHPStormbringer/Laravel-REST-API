<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $person = Person::get();

        return response()->json($person);
      //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'organization_id' => 'required|integer',
            'name' => 'required|max:255',
            'phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/i',
            'email' => 'required|email',
            'web' => 'url',
            'facebook' => 'url',
            'linkedin' => 'url',
            'twitter' => 'url',
            'story' => 'required|string'
        ]);

        if ($validator->fails()) {
            return ['response' => $validator->messages(), 'success' => false ];
        }

    //  The rule is, you cannot delete an organization with members
        $query = DB::table('organizations');
        $query->where('organization_id', $organization_id);

        $persons = $query->get();
    //  $persons = DB::table('people')->get();
        if(!count($organizations)){
            return ['response' => 'The requisite organization does not exist.  Th ememebr cannot added', 'success' => false ];
        }



        $person = new Person();

        if($person)
        {
            $person->organization_id = $request->input('organization_id');

            $person->name  = $request->input('name');
            $person->phone = $request->input('phone');
            $person->email = $request->input('email');
            $person->story = $request->input('story');

            if($request->input('skype'))     $person->skype = $request->input('skype');
            if($request->input('title'))     $person->title = $request->input('title');
            if($request->input('role'))      $person->role = $request->input('role');

            if($request->input('url'))       $person->url = $request->input('url');
            if($request->input('facebook'))  $person->facebook = $request->input('facebook');
            if($request->input('linkedin'))  $person->linkedin = $request->input('linkedin');
            if($request->input('twitter'))   $person->twitter = $request->input('twitter');
            if($request->input('address_1')) $person->address_1 = $request->input('address_1');
            if($request->input('address_2')) $person->address_2 = $request->input('address_2');
            if($request->input('state'))     $person->state = $request->input('state');
            if($request->input('country'))   $person->country = $request->input('country');
            if($request->input('postal'))    $person->postal = $request->input('postal');
            if($request->input('active'))    $person->active = $request->input('active');

            $person->save();

            return response()->json($person);
        }
        else {
            return ['response' => 'The requested person was not found', 'success' => false ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $person = Person::find($id);

      return response()->json($person);
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
        $validator = Validator::make($request->all(), [
            'organization_id' => 'required|integer',
            'name' => 'max:255',
            'phone' => 'regex:/^\d{3}-\d{3}-\d{4}$/i',
            'email' => 'email',
            'web' => 'url',
            'facebook' => 'url',
            'linkedin' => 'url',
            'twitter' => 'url',
            'story' => 'string'
        ]);

        if ($validator->fails()) {
            return ['response' => $validator->messages(), 'success' => false ];
        }

        $person = Person::find($id);

        if($person)
        {
            if($request->input('name'))      $person->name      = $request->input('name');
            if($request->input('phone'))     $person->phone     = $request->input('phone');
            if($request->input('email'))     $person->email     = $request->input('email');
            if($request->input('story'))     $person->story     = $request->input('story');

            if($request->input('skype'))     $person->skype     = $request->input('skype');
            if($request->input('title'))     $person->title     = $request->input('title');
            if($request->input('role'))      $person->role      = $request->input('role');

            if($request->input('url'))       $person->url       = $request->input('url');
            if($request->input('facebook'))  $person->facebook  = $request->input('facebook');
            if($request->input('linkedin'))  $person->linkedin  = $request->input('linkedin');
            if($request->input('twitter'))   $person->twitter   = $request->input('twitter');
            if($request->input('address_1')) $person->address_1 = $request->input('address_1');
            if($request->input('address_2')) $person->address_2 = $request->input('address_2');
            if($request->input('state'))     $person->state     = $request->input('state');
            if($request->input('country'))   $person->country   = $request->input('country');
            if($request->input('postal'))    $person->postal    = $request->input('postal');
            if($request->input('active'))    $person->active    = $request->input('active');

            $person->save();

            return response()->json($person);
        }
        else {
            return ['response' => 'The requested person was not found', 'success' => false ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::find($id);

        if($person)
        {
            $person->destroy();

            return response()->json($person);
        }
        else {
            return ['response' => 'The requested person was not found', 'success' => false ];
        }
    }
}
