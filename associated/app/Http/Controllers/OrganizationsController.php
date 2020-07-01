<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrganizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organization = Organization::get();

        return response()->json($organization);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'name' => 'required|max:255',
            'phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/i',
            'email' => 'required|email',
            'web' => 'url',
            'facebook' => 'url',
            'linkedin' => 'url',
            'twitter' => 'url',
            'short_desc' => 'required|string'
        ]);

        if ($validator->fails()) {
            return ['response' => $validator->messages(), 'success' => false ];
        }

        $organization = new Organization();
        $organization->name = $request->input('name');
        $organization->phone = $request->input('phone');
        $organization->email = $request->input('email');
        $organization->short_desc = $request->input('short_desc');

        if($request->input('url'))       $organization->url = $request->input('url');
        if($request->input('facebook'))  $organization->facebook = $request->input('facebook');
        if($request->input('linkedin'))  $organization->linkedin = $request->input('linkedin');
        if($request->input('twitter'))   $organization->twitter = $request->input('twitter');
        if($request->input('long_desc')) $organization->long_desc = $request->input('long_desc');
        if($request->input('address_1')) $organization->address_1 = $request->input('address_1');
        if($request->input('address_2')) $organization->address_2 = $request->input('address_2');
        if($request->input('state'))     $organization->state = $request->input('state');
        if($request->input('country'))   $organization->country = $request->input('country');
        if($request->input('postal'))    $organization->postal = $request->input('postal');
        if($request->input('active'))    $organization->active = $request->input('active');

        $organization->save();

        return response()->json($organization);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = Organization::find($id);

        return response()->json($organization);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'name' => 'max:255',
            'phone' => 'regex:/^\d{3}-\d{3}-\d{4}$/i',
            'email' => 'email',
            'web' => 'url',
            'facebook' => 'url',
            'linkedin' => 'url',
            'twitter' => 'url',
            'short_desc' => 'string'
        ]);

        if ($validator->fails()) {
            return ['response' => $validator->messages(), 'success' => false ];
        }

        $organization = Organization::find($id);

        if($organization)
        {
        //  If there are no new values for any required field, don't update that filed.
            if($request->input('name'))       $organization->name       = $request->input('name');
            if($request->input('phone'))      $organization->phone      = $request->input('phone');
            if($request->input('email'))      $organization->email      = $request->input('email');
            if($request->input('short_desc')) $organization->short_desc = $request->input('short_desc');

            if($request->input('url'))        $organization->url        = $request->input('url');
            if($request->input('facebook'))   $organization->facebook   = $request->input('facebook');
            if($request->input('linkedin'))   $organization->linkedin   = $request->input('linkedin');
            if($request->input('twitter'))    $organization->twitter    = $request->input('twitter');
            if($request->input('long_desc'))  $organization->long_desc  = $request->input('long_desc');
            if($request->input('address_1'))  $organization->address_1  = $request->input('address_1');
            if($request->input('address_2'))  $organization->address_2  = $request->input('address_2');
            if($request->input('state'))      $organization->state      = $request->input('state');
            if($request->input('country'))    $organization->country    = $request->input('country');
            if($request->input('postal'))     $organization->postal     = $request->input('postal');
            if($request->input('active'))     $organization->active     = $request->input('active');

            $organization->save();

            return response()->json($organization);
        }
        else {
            return ['response' => 'The requested organization was not found', 'success' => false ];
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
    //  The rule is, you cannot delete an organization with members
        $persons_query = DB::table('people');
        $persons_query->where('organization_id', $id);

        $persons = $persons_query->get();
    //  $persons = DB::table('people')->get();
        if(count($persons)){
            return ['response' => 'The requested organization Has members.  It cannot be deleted', 'success' => false ];
        }

        $organization = Organization::find($id);

        if($organization)
        {
            $organization->destroy();

            return ['response' => 'Organization deleted', 'success' => true ];
        }
        else {
            return ['response' => 'The requested organization was not found', 'success' => false ];
        }
    }
}
