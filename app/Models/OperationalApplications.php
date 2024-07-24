<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalApplications extends Model
{
    use HasFactory;
    protected $table = 'tbl_operatepplication';
    protected $primaryKey = 'operateapp_id';
    protected $fillable = ['operateapp_id', 'fac_id', 'user_id', 'submission_date', 'remarks', 'application_status', 'late_remarks', 'inspector_date_action', 'inspector_date_reaction', 'late_date', 'inspection_id', 'inspector_date_rejected'];
    public function Client()
    {
        return $this->belongsTo(Client::class, 'user_id', 'user_id');
    }
}
