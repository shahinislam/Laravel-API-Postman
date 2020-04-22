# Laravel API

. CRUD Database, 
. Token Authentication, 
. Basic Authentication,
. OAuth, Passport

## api.php
```php
Route::apiResource('country', 'CountryController')->middleware('client');

Route::get('download', 'PhotoController@download');
Route::post('upload', 'PhotoController@upload');

```

## CountryController.php

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function index()
    {
        $country = Country::get();

        return response()->json($country, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'iso' => 'required|min:2|max:2',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $country = Country::create($request->all());

        return response()->json($country, 201);
    }
    
    public function show($id)
    {
        $country = Country::find($id);

        if(is_null($country)) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json($country, 200);
    }

    public function edit($id)
    {
        //
    }
    
    public function update(Request $request, $id)
    {
        $country = Country::find($id);

        if(is_null($country)) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $country->update($request->all());

        return response()->json($country, 200);
    }

    public function destroy($id)
    {
        $country = Country::find($id);

        if(is_null($country)) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $country->delete();

        return response()->json(null, 204);
    }
}

```
