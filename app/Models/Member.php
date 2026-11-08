<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function skills()
    {
        return $this->hasMany(MemberSkill::class);
    }

    public function awards()
    {
        return $this->hasMany(MemberAward::class);
    }
}
