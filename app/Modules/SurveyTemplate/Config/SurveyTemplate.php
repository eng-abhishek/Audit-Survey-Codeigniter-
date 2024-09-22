<?php
namespace Modules\SurveyTemplate\Config;

class SurveyTemplate extends \CodeIgniter\Config\BaseConfig
{
        public $dropdown_types = [
                'Text' => 'Text',
                'Textarea' => 'Textarea',
                'Email' => 'Email',
                'Number' => 'Number',
                'Dropdown' => 'Dropdown',
                'Datepicker' => 'Datepicker',
                'Checkbox' => 'Checkbox',
                'Radio' => 'Radio',
                'Image' => 'Image',
        ];

         public $default_question_options = [
                'Yes' => 'Yes',
                'No' => 'No',
        ];
}

?>