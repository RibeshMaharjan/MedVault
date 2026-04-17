<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model
{
    protected string $table = 'tbl_admin';
    protected string $primaryKey = 'admin_id';
}
