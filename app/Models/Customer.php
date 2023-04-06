<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'memo'
    ];

    public function scopeSearchCustomers($query, $input = null)
    {
        if (!empty($input)) {
            if (preg_match('/( |　)/', $input)) {
                // インプットの名前もしくはフリガナに半角・全角のスペースが含まれている場合、スペースを省く
                $trimSpaceFromInput = preg_replace("/( |　)/", "", $input);

                if (Customer::where(function ($query) use ($trimSpaceFromInput) {
                    $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                    $query->whereRaw($whereName);
                })->exists()) {
                    return Customer::where(function ($query) use ($trimSpaceFromInput) {
                        $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                        $query->whereRaw($whereName);
                    });
                }

                if (Customer::where(function ($query) use ($trimSpaceFromInput) {
                    $whereKana = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                    $query->whereRaw($whereKana);
                })->exists()) {
                    return Customer::where(function ($query) use ($trimSpaceFromInput) {
                        $whereKana = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                        $query->whereRaw($whereKana);
                    });
                }
            } else {
                $customerModel = new Customer();

                if ($customerModel::where(function ($query) use ($input) {
                    $whereName = "replace(name, ' ','') like " . "'%" . $input . "%'";
                    $query->whereRaw($whereName);
                })->exists()) {
                    return $customerModel::where(function ($query) use ($input) {
                        $whereName = "replace(name, ' ','') like " . "'%" . $input . "%'";
                        $query->whereRaw($whereName);
                    });
                } elseif ($customerModel::where(function ($query) use ($input) {
                    $whereKana = "replace(kana, ' ','') like " . "'%" . $input . "%'";
                    $query->whereRaw($whereKana);
                })->exists()) {
                    return $customerModel::where(function ($query) use ($input) {
                        $whereKana = "replace(kana, ' ','') like " . "'%" . $input . "%'";
                        $query->whereRaw($whereKana);
                    });
                } else {
                    return $customerModel::where('name', 'like', '%' . $input . '%')
                        ->orWhere('kana', 'like', '%' . $input . '%')
                        ->orWhere('tel', 'like', '%' . $input . '%');
                }
            }
        }
    }
}
