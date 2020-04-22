# Laravel API

1. CRUD Database, 
2. Token Authentication, 
3. Basic Authentication,
4. OAuth, Passport

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
## 2. Token Authentication

- php artisan make:middleware AuthKey <br/>


### AuthKey.php
```php 
    public function handle($request, Closure $next)
    {
        $token = $request->header('APP_KEY');

        if($token != 'ABCDEFGHIJK') {
            return response()->json(['message' => 'App Key Not Found'], 401);
        }
        return $next($request);
    }

```
### kernel.php

```php
'api' => [
            AuthKey::class,
        ],
```
Postman->header->key=""->value=""

## 3. Basic Authentication

- php artisan make:middleware AuthBasic <br/>


### AuthBasic.php
```php 
        if(Auth::onceBasic()) {
            return response()->json(['message' => 'Auth Failed'], 401);
        }else {
            return $next($request);
        }

```
### kernel.php

```php
'api' => [
            AuthBasic::class,
        ],
```
Postman->Authorization->Basic Auth

## 4. OAuth

- composer require laravel/passport <br>
- php artisan migrate <br>
- php artisan passport:install <br>

### User.php
```php
use Laravel\Passport\HasApiTokens;
{
    use Notifiable, HasApiTokens;
}
```

### AuthServiceProvider.php
```php
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        $startTime = date("Y-m-d H:i:s");
        $endTime = date("Y-m-d H:i:s",
            strtotime('+7 days +1 hour +30 minutes +45 seconds', strtotime($startTime)));
        $expTime = \DateTime::createFromFormat("Y-m-d H:i:s", $endTime);

        Passport::tokensExpireIn($expTime);
    }
```

### auth.php

```php
'api' => [
            'driver' => 'passport',
            'provider' => 'users',
            'hash' => false,
        ],
```

### kernel.php
```php
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
{
protected $routeMiddleware = [
        'client' => CheckClientCredentials::class,
    ];
}
```
- php artisan passport:install

### Postman:

(POST) http://127.0.0.1:8000/oauth/token <br>
Body-> <br>
grant_type => client_credentials <br>
client_id => 3 <br>
client_secret => gOflfjlMjfklsdMFjlkjJFjbflkjaldsfBkjljHHFIEj <br>
SEND -> access_token = "?????????" <br>

(GET) http://127.0.0.1:8000/api/country/1 <br>
Header-> <br>
Accept => application/json <br>
Authorization => Bearer "????????????" SEND <br>

## 5. Download & Upload File

### api.php
```php
Route::get('download', 'PhotoController@download');
Route::post('upload', 'PhotoController@upload');
```
### PhotoController.php

```php
class PhotoController extends Controller
{
    public function download()
    {
        return response()->download(public_path('arnob.png'), 'Bangladesh Flag');
    }

    public function upload(Request $request)
    {
        $fileName = "User.jpg";
        $path = $request->file('photo')->move(public_path('/'), $fileName);
        $photoURL = url('/' . $fileName);
        return response()->json(['url' => $photoURL], 200);
    }
}

```
Body->form-data->file

























