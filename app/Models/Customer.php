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
        if (isset($input)) {
            // 検索フォームのインプットに先頭末尾以外に半角or全角のスペースが含まれている場合
            if (preg_match('/( |　)/', $input)) {

                //スペースを省く
                $trimSpaceFromInput = preg_replace("/( |　)/", "", $input);

                $customerModel = new Customer();

                // search by name
                if ($customerModel::where(function ($query) use ($trimSpaceFromInput) {
                    $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                    $query->whereRaw($whereName);
                })->exists()) {
                    return $customerModel::where(function ($query) use ($trimSpaceFromInput) {
                        $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                        $query->whereRaw($whereName);
                    });
                }

                // search by name
                if ($customerModel::where(function ($query) use ($trimSpaceFromInput) {
                    $whereKana = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                    $query->whereRaw($whereKana);
                })->exists()) {
                    return $customerModel::where(function ($query) use ($trimSpaceFromInput) {
                        $whereKana = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                        $query->whereRaw($whereKana);
                    });
                }
            } else {
                $customerModel = new Customer();

                // search by id
                if ($customerModel::where(function ($query) use ($input) {
                    $query->where('id', 'like', (string)$input);
                })->exists()) {
                    return $customerModel::where(function ($query) use ($input) {
                        $query->where('id', 'like', (string)$input);
                    });
                }

                // // search by tel
                if ($customerModel::where('tel', 'like', "%" . $input . "%")->exists()) {
                    $customerModel::where('tel', 'like', "%" . $input . "%");
                    return $customerModel::where('tel', 'like', "%" . $input . "%");
                }

                // search by name
                if ($customerModel::where(function ($query) use ($input) {
                    $whereName = "replace(name, ' ','') like " . "'%" . $input . "%'";
                    $query->whereRaw($whereName);
                })->exists()) {
                    return $customerModel::where(function ($query) use ($input) {
                        $whereName = "replace(name, ' ','') like " . "'%" . $input . "%'";
                        $query->whereRaw($whereName);
                    });
                }

                // search by kana
                if ($customerModel::where(function ($query) use ($input) {
                    $whereKana = "replace(kana, ' ','') like " . "'%" . $input . "%'";
                    $query->whereRaw($whereKana);
                })->exists()) {
                    return $customerModel::where(function ($query) use ($input) {
                        $whereKana = "replace(kana, ' ','') like " . "'%" . $input . "%'";
                        $query->whereRaw($whereKana);
                    });
                }
            }
        }
    }
}
