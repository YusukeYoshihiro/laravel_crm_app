<?php

namespace App\Domains\Customer\UseCases\Customer;

use App\Models\Customer;
use App\Http\Requests\Customer\FilterRequest;
use Illuminate\Http\Request;
final class FilterCustomerActionInPurchase
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
                !empty($request['search']) ? $request['search'] : '',
                fn ($query, $value) => $query->searchCustomers($value)
            );
        
        return $query;
    }
}