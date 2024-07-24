<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitAttachment extends Model
{
    use HasFactory;

    protected $table = 'tbl_initattachment';
    protected $primaryKey = 'initattach_id';
    protected $fillable = ['initapp_id', 'letter', 'application_form', 'cert_pot', 'sanitary_survey', 'watersite_clearance', 'engineers_report', 'plans_specs'];
    public $timestamps = false;
    public function InitialAttachment()
    {
        return $this->belongsTo(InitialApplications::class, 'initapp_id', 'initapp_id');
    }
}
