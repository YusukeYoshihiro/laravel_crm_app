<?php

namespace App\Models;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

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

    /**
     * Get PurchaseModel instance
     * (Enable to call as Dynamic Property)
     * 
     * @return \Illuminate\Database\Eloquent\Relations
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }



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
