<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\Card;

class Todo extends Model
{
	protected $table = 'dp_project_todo';
    const CREATED_AT = 'todo_created';
    const UPDATED_AT = 'todo_updated';
    protected $primaryKey = 'todo_id';
    
    protected $fillable = [
        'todo_name',
        'todo_desc',
    ];

    protected $appends = ['todo_card'];

    public function getTodoCardAttribute(){
    	return Card::where("todo_parent", $this->todo_id)->get();
    }
}