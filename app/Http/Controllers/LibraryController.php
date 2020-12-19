<?php

namespace App\Http\Controllers;

use App\Utils\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    public function library(Request $request){
        $input = $request->all();
        $validate = Validator::make($input, [
            'ISBN' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => $validate->errors()
            ]);
        }

        $parameters = "";
        if(isset($input['ISBN'])){
            $parameters .= "bibkeys=ISBN:".$input['ISBN'];
        }
        if(isset($input['LCCN'])){
            $parameters .= ",LCCN:".$input['LCCN'];
        }
        if(isset($input['jscmd'])){
            $parameters .= "&jscmd=".$input['jscmd'];
        }

        $searchFor = "/books";

        // return response()->json($searchFor);

        $library = new Library(); // Library class initialization
        return $library->getRequest($searchFor, $parameters); // Call the requested route
    }
}
