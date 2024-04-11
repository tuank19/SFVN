<?php
namespace App\Classes;

use Illuminate\Support\Facades\DB;
use App\Http\Classes\FileUploader;
use Illuminate\Support\Facades\Storage;

class Utils
{

    public static function rederAttrForm()
    {
        $attrs = DB::table('attributes')->get();
        $form = '';
        foreach ($attrs as $attr) {
            switch ($attr->input_type) {
                case('text'):
                    $form .= '
                    <div class="form-group row">
                        <label for="unit" class="col-sm-2 col-form-label validate-require">Unit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate-require" id="'.$attr->slug.'" name="'.$attr->slug.'">
                            <span class="text-danger validate-require validate-text '.$attr->slug.'Error" id="'.$attr->slug.'Error"></span>
                        </div>
                    </div>
                    ';
                    break;
                case('select'):
                    $inputOptions = json_decode($attr->input_option, true);
                    $option='';
                    foreach ($inputOptions as $value => $label) {
                        $option .= '<option value="' . $value . '">' . $label . '</option>';
                    }
                    $form .= '
                    <div class="form-group row">
                        <label for="unit" class="col-sm-2 col-form-label validate-require">'.$attr->name.'</label>
                            <div class="col-sm-10">
                                <select id="'.$attr->slug.'" class="form-control validate-require" name="'.$attr->slug.'">
                                    '.$option.'
                                </select>
                                <span class="text-danger validate-require validate-text categoryError" id="categoryError"></span>
                            </div>
                            <span class="text-danger validate-require validate-text '.$attr->slug.'Error" id="'.$attr->slug.'Error"></span>
                    </div>
                    ';
                    break;
            }
        }
        return $form;
    }

    public static function rederAttrFormEdit($propductID)
    {
        $attrs = DB::table('attributes')->get();
        $form = '';
        foreach ($attrs as $attr) {
            $pAttrValue = DB::table('product_attributes')->where('product_id', $propductID)->where('attr_slug',$attr->slug)->first();
            switch ($attr->input_type) {
                case('text'):
                    $form .= '
                    <div class="form-group row">
                        <label for="unit" class="col-sm-2 col-form-label validate-require">Unit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate-require" id="'.$attr->slug.'" value="'.$pAttrValue->attr_value.'" name="'.$attr->slug.'">
                            <span class="text-danger validate-require validate-text '.$attr->slug.'Error" id="'.$attr->slug.'Error"></span>
                        </div>
                    </div>
                    ';
                    break;
                case('select'):

                    $inputOptions = json_decode($attr->input_option, true);
                    $option='';
                    foreach ($inputOptions as $value => $label) {
                        $check = '';
                        if(isset($pAttrValue->attr_value) && $value == $pAttrValue->attr_value){
                            $check = "selected";
                        }
                        $option .= '<option '.$check.' value="' . $value . '">' . $label . '</option>';
                    }
                    $form .= '
                    <div class="form-group row">
                        <label for="unit" class="col-sm-2 col-form-label validate-require">'.$attr->name.'</label>
                            <div class="col-sm-10">
                                <select id="'.$attr->slug.'" class="form-control validate-require" name="'.$attr->slug.'">
                                    '.$option.'
                                </select>
                                <span class="text-danger validate-require validate-text categoryError" id="categoryError"></span>
                            </div>
                            <span class="text-danger validate-require validate-text '.$attr->slug.'Error" id="'.$attr->slug.'Error"></span>
                    </div>
                    ';
                    break;
            }
        }
        return $form;
    }

}
