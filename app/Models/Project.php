<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Project extends Model
{
	protected $table = 'dp_project';
    const CREATED_AT = 'project_created';
    const UPDATED_AT = 'project_updated';
    protected $primaryKey = 'project_id';
    
    protected $fillable = [
        'project_name',
        'project_desc',
    ];
}