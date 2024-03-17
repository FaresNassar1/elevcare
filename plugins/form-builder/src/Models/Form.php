<?php

namespace Progmix\FormBuilder\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\ResourceModel;

class Form extends Model
{
    use ResourceModel;
    protected $fillable = ['form_definition','validations'];
}
