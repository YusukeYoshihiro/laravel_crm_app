<?php

namespace App\Domains\Customer\UseCases\Customer;

use App\Models\Customer;
use App\Http\Requests\Customer\FilterRequest;
use Illuminate\Http\Request;

// use App\Domains\Customer\Entities\CustomerCollection;
// use App\Http\Requests\Seminar\FilterRequest;
// use Illuminate\Pagination\LengthAwarePaginator;

final class FilterAction
{
    /**
     * invoke
     * @return LengthAwarePaginator
     */
    public function invoke(Request $request)
    {
        $query = Customer::query();

        $query
            ->when(
                !empty($request['searchId']) ? $request['searchId'] : '',
                fn ($query, $value) => $query->searchCustomersById($value)
            )
            ->when(
                !empty($request['searchName']) ? $request['searchName'] : '',
                fn ($query, $value) => $query->searchCustomersByName($value)
            )
            ->when(
                !empty($request['searchKana']) ? $request['searchKana'] : '',
                fn ($query, $value) => $query->searchCustomersByKana($value)
            )
            ->when(
                !empty($request['searchTel']) ? $request['searchTel'] : '',
                fn ($query, $value) => $query->searchCustomersByTel($value)
            )
            ->when(
                !empty($request['searchEmail']) ? $request['searchEmail'] : '',
                fn ($query, $value) => $query->searchCustomersByEmail($value)
            );
        
        return $query;
    }
}