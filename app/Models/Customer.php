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
        // if (!empty($input)) {
        //     if (Customer::where(function ($query) use ($input) {
        //         $query->where("name", "like", "%" . $input . "%")
        //             ->orWhere("kana", "like", "%" . $input . "%")
        //             ->orWhere("tel", "like", "%" . $input . "%");
        //     })->exists()) {
        //         return Customer::where(function ($query) use ($input) {
        //             $query->where("name", "like", "%" . $input . "%")
        //                 ->orWhere("kana", "like", "%" . $input . "%")
        //                 ->orWhere("tel", "like", "%" . $input . "%");
        //         });
        //     }
        // }
        // }
        if (!empty($input)) {
            $model = new Customer();
            if ($model::where('name', 'like', '%' . $input . '%')
                ->orWhere('kana', 'like', '%' . $input . '%')
                ->orWhere('tel', 'like', '%' . $input . '%')
                ->exists()
            ) {
                return $model::where('name', 'like', '%' . $input . '%')
                    ->orWhere('kana', 'like', '%' . $input . '%')
                    ->orWhere('tel', 'like', '%' . $input . '%');
            }
        }
    }
}
