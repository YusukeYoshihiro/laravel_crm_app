<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Domains\Customer\UseCases\Customer\FilterCustomerActionInPurchase;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')
    ->get('/searchCustomers', function (Request $request, FilterCustomerActionInPurchase $action) {
        return $action->invoke($request)
            ->select('id', 'name', 'kana', 'tel', 'email')
            ->paginate(50);
    });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
