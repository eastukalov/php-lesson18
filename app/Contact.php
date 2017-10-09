<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getFind($request)
    {
        if ($request->has('contact_table') && $request->has('phone_table')) {
            return $this->where([['contact', 'LIKE', '%' . $request->contact_table . '%'], ['phone', 'LIKE', '%' . $request->phone_table . '%']])->pluck('id');
        }
        elseif ($request->has('contact_table')) {
            return $this->where('contact', 'LIKE', '%' . $request->contact_table . '%')->pluck('id');
        }
        elseif ($request->has('phone_table')) {
            return $this->where('phone', 'LIKE', '%' . $request->phone_table . '%')->pluck('id');
        }
    }

}
