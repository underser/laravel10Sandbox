<?php

namespace App\Models\Queue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model
{
    public $timestamps = false;

    protected $table = 'jobs_history';

    use HasFactory;

    public function batch(): object
    {
        return  $this->getConnection()->table('job_batches')
            ->where('id', $this->batch_id)
            ->first();
    }
}
