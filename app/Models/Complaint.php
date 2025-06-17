<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded = [];

    public function getStatusLabelAttribute() 
    {
        return match ($this->status) {
            'new' => 'New',
            'processing' => 'Processing',
            'completed' => 'Completed',
            default => 'Unknown',
        };
    }

    public function getReportDateLabelAttribute()
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y, H:i:s');
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'new' => 'info',
            'processing' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }
    
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
