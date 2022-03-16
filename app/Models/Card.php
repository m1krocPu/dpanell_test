<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model; 
use App\Models\CardItem; 

class Card extends Model
{
	protected $table = 'dp_project_todo';
    const CREATED_AT = 'todo_created';
    const UPDATED_AT = 'todo_updated';
    protected $primaryKey = 'todo_id';
    
    protected $fillable = [
        'todo_name',
        'todo_desc',
    ];

    protected $appends = ['todo_sub','todo_finish'];

    public function getTodoSubAttribute(){
    	return CardItem::where("sub_todo", $this->todo_id)->count();
    }
    public function getTodoFinishAttribute(){
        return CardItem::where("sub_todo", $this->todo_id)->where("sub_status",1)->count();
    }
}