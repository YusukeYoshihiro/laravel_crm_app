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
        //検索inputに入力された値のスペースを省く
        $trimSpaceFromInput = preg_replace("/( |　)/", "", $name);

        if (Customer::exists()) {
            return $query->where(function ($query) use ($trimSpaceFromInput) {
                //データベースにある氏名(name)のスペースを省き、スペースを省いた検索inputの値と比較
                $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                $query->whereRaw($whereName);
            });
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?string $kana
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomersByKana($query, string $kana)
    {
        //検索inputに入力された値のスペースを省く
        $trimSpaceFromInput = preg_replace("/( |　)/", "", $kana);

        if (Customer::exists()) {
            return $query->where(function ($query) use ($trimSpaceFromInput) {
                //データベースにあるカナ(kana)のスペースを省き、スペースを省いた検索inputの値と比較
                $whereName = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                $query->whereRaw($whereName);
            });
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?string $tel
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomersByTel($query, string $tel)
    {
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
        if (Customer::exists()) {
            return $query->where('email', 'like', "%" . $email . "%");
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param ?string $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomers($query, string $input = null)
    {
        if (!empty($input)) {

            $trimSpaceFromInput = preg_replace("/( |　)/", "", $input);

            if (Customer::exists()) {
                return $query->where(function ($query) use ($trimSpaceFromInput) {
                    $whereName = "replace(name, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";
                    $whereKana = "replace(kana, ' ','') like " . "'%" . $trimSpaceFromInput . "%'";

                    $query->whereRaw($whereName)
                        ->orWhereRaw($whereKana)
                        ->orWhere('tel', 'like', "%" . $trimSpaceFromInput . "%")
                        ->orWhere('email', 'like', "%" . $trimSpaceFromInput . "%");
                });
            }
        }
    }
}
