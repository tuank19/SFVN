<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getActionAttribute()
    {

        return '<div class="action-wrap">
            <div data-toggle="modal" data-target="#editAttrModal" data-name="'.$this->name.'" data-uuid="'.$this->uuid.'" data-inputtype="'.$this->input_type.'" data-inputOption = "'.$this->input_option.'" data-whatever="Edit Attribute '.$this->name.'" class="table-action btn  btn-primary btn-sm waves-effect waves-light">
                <i class="mdi mdi-file-document-edit-outline"></i>Edit
            </div>
            <div onclick="deleteAttr(`'.$this->uuid.'`)" class="table-action btn btn-secondary btn-sm waves-effect waves-light">
                <i class="mdi mdi-delete"></i>Delete
            </div>

        </div>
       ';
    }
}
