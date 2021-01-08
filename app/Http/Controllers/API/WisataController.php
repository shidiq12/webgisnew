<?php

namespace App\Http\Controllers\API;

use App\Wisata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WisataController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api');
    }
    public function index()
    {
        return Wisata::latest()->paginate(8); 
    }

    public function store(Request $request)
    {
        $this -> validate($request,[
            'placeName' => 'required|string|max:100',
            'vicinity' => 'required|string|max:100',
            'longitude' => 'required',
            'latitude' => 'required',
            
        ]);
        return Wisata::create([
            'placeName' => $request['placeName'],
            'vicinity' => $request['vicinity'],
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],
        ]); 
    }


    public function update(Request $request, $id)
    {
        $wisata = Wisata::findOrFail($id);
        $this -> validate($request,[
            'placeName' => 'required|string|max:100',
            'vicinity' => 'required|string|max:100',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        

        $wisata->update($request->all());
        return ['message' => 'updated data'];
    }

    public function destroy($id)
    {
        $wisata = Wisata::findOrFail($id);
        $wisata->delete();
        return ['message' => 'Data deleted successfully'];
    }
    
    public function search(){

        if ($search = \Request::get('q')) {
            $wisatas = Wisata::where(function($query) use ($search){
                $query->where('placeName','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $wisatas = Wisata::latest()->paginate(8);
        }

        return $wisatas;

    }
    
    
}
