<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'department'=> 'API\DepartmentController',
    'incomesource' => 'API\IncomesourceController',
    'expenditure' => 'API\ExpenditureController',
    'credit' => 'API\CreditController',
    'debit' => 'API\DebitController'
    ]);
Route::get('department-all', 'API\DepartmentController@DepartmentAll');
Route::get('expenditure-all', 'API\ExpenditureController@ExpenditureAll');
Route::post('credit-report', 'API\CreditController@SearchCreditReport');
Route::get('credit-month', 'API\CreditController@CreditMonth');
Route::get('debit-month', 'API\DebitController@DebitMonth');
Route::post('debit-report', 'API\DebitController@SearchDebitReport');
Route::get('balance-sheet', 'API\ReportController@index');
Route::post('balance-sheet-search', 'API\ReportController@search');
Route::get('balance-sheet-month', 'API\ReportController@month');
Route::get('total-credit', 'API\CreditController@TotalCredit');
Route::get('total-debit', 'API\DebitController@TotalDebit');
Route::get('total-balance-sheet', 'API\ReportController@TotalBalanceSheet');
