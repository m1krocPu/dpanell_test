<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\Card;

class CardItem extends Model
{
	protected $table = 'dp_project_todo_sub';
    const CREATED_AT = 'sub_created';
    const UPDATED_AT = 'sub_updated';
    protected $primaryKey = 'sub_id';
    
    protected $fillable = [
        'sub_name',
        'sub_status',
    ];

}