<?php

namespace App\Models;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

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

    // /**
    //  * @param  \Illuminate\Database\Eloquent\Builder  $query
    //  * @param ?string $input
    //  * @return \Illuminate\Database\Eloquent\Builder
    //  */
    // public function scopeSearchCustomers($query, ?string $input = null)
    // {
    //     if (isset($input)) {
    //         // 検索フォームのインプットに先頭末尾以外に半角or全角のスペースが含まれている場合
    //         if (preg_match('/( |　)/', $input)) {

    //             //スペースを省く
    //             $trimSpaceFromInput = preg_replace("/( |　)/", "", $input);

    //             $customerModel = new Customer();

    //             // search by name
    //             if ($customerModel::where(function ($query) use ($trimSpaceFromInput) {
    //                 $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
    //                 $query->whereRaw($whereName);
    //             })->exists()) {
    //                 return $customerModel::where(function ($query) use ($trimSpaceFromInput) {
    //                     $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
    //                     $query->whereRaw($whereName);
    //                 });
    //             }

    //             // search by name
    //             if ($customerModel::where(function ($query) use ($trimSpaceFromInput) {
    //                 $whereKana = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
    //                 $query->whereRaw($whereKana);
    //             })->exists()) {
    //                 return $customerModel::where(function ($query) use ($trimSpaceFromInput) {
    //                     $whereKana = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
    //                     $query->whereRaw($whereKana);
    //                 });
    //             }
    //         } else {
    //             $customerModel = new Customer();

    //             // search by id
    //             if ($customerModel::where(function ($query) use ($input) {
    //                 $query->where('id', 'like', (string)$input);
    //             })->exists()) {
    //                 return $customerModel::where(function ($query) use ($input) {
    //                     $query->where('id', 'like', (string)$input);
    //                 });
    //             }

    //             // // search by tel
    //             if ($customerModel::where('tel', 'like', "%" . $input . "%")->exists()) {
    //                 $customerModel::where('tel', 'like', "%" . $input . "%");
    //                 return $customerModel::where('tel', 'like', "%" . $input . "%");
    //             }

    //             // search by name
    //             if ($customerModel::where(function ($query) use ($input) {
    //                 $whereName = "replace(name, ' ','') like " . "'%" . $input . "%'";
    //                 $query->whereRaw($whereName);
    //             })->exists()) {
    //                 return $customerModel::where(function ($query) use ($input) {
    //                     $whereName = "replace(name, ' ','') like " . "'%" . $input . "%'";
    //                     $query->whereRaw($whereName);
    //                 });
    //             }

    //             // search by kana
    //             if ($customerModel::where(function ($query) use ($input) {
    //                 $whereKana = "replace(kana, ' ','') like " . "'%" . $input . "%'";
    //                 $query->whereRaw($whereKana);
    //             })->exists()) {
    //                 return $customerModel::where(function ($query) use ($input) {
    //                     $whereKana = "replace(kana, ' ','') like " . "'%" . $input . "%'";
    //                     $query->whereRaw($whereKana);
    //                 });
    //             }
    //         }
    //     }
    // }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomersById($query, int $id = null)
    {
        // search by id
        return $query
            ->where('id', '=', (int)$id);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomersByName($query, string $name)
    {
        // search by name
        // 検索フォームのインプットに先頭末尾以外に半角or全角のスペースが含まれている場合
        if (preg_match('/( |　)/', $name)) {

            //スペースを省く
            $trimSpaceFromInput = preg_replace("/( |　)/", "", $name);

            if (Customer::exists()) {
                return $query->where(function ($query) use ($trimSpaceFromInput) {
                    $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                    $query->whereRaw($whereName);
                });
            }
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?string $kana
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomersByKana($query, string $kana)
    {
        // search by kana
        // 検索フォームのインプットに先頭末尾以外に半角or全角のスペースが含まれている場合
        if (preg_match('/( |　)/', $kana)) {

            //スペースを省く
            $trimSpaceFromInput = preg_replace("/( |　)/", "", $kana);

            if (Customer::exists()) {
                return $query->where(function ($query) use ($trimSpaceFromInput) {
                    $whereName = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                    $query->whereRaw($whereName);
                });
            }
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?string $tel
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomersByTel($query, string $tel)
    {
        // search by tel
        if (Customer::exists()) {
            return $query->where('tel', 'like', "%" . $tel . "%");
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?string $email
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomersByEmail($query, string $email)
    {
        // search by Email
        if (Customer::exists()) {
            return $query->where('email', 'like', "%" . $email . "%");
        }
    }
}
