<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['uuid','name', 'parent_id', 'lft', 'rgt', 'slug'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault();
    }

    // Một category có thể có nhiều category con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getActionAttribute()
    {
        $parent = $this->parent->uuid;
        return '<div class="action-wrap">
            <div data-toggle="modal" data-target="#editCatModal" data-parent="'.$parent.'" data-name="'.$this->name.'" data-uuid="'.$this->uuid.'" data-whatever="Edit category '.$this->name.'" class="table-action btn  btn-primary btn-sm waves-effect waves-light">
                <i class="mdi mdi-file-document-edit-outline"></i>Edit
            </div>
            <div onclick="deleteCat(`'.$this->uuid.'`)" class="table-action btn btn-secondary btn-sm waves-effect waves-light">
                <i class="mdi mdi-delete"></i>Delete
            </div>

        </div>
       ';
    }
}
