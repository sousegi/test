<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

/**
 * Class LanguageForm
 * @package App\Forms
 */
class LanguageForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm(): void
    {
        $uniqueId = null;
        $localeAttributes = ['class' => 'form-control'];
        $localeRules = ['required', 'string', 'max:2', 'unique:languages,locale'];

        if (!empty($this->model)) {
            $uniqueId = $this->model->id;
            $localeAttributes = ['class' => 'form-control', 'disabled' => 'disabled'];
            $localeRules = [];
        }

        $this->add('title', Field::TEXT, [
            'label' => 'Title ',
            'rules' => ['required', 'string', 'max:10', 'unique:languages,title,' . $uniqueId . ',id'],
        ]);
        $this->add('locale', Field::TEXT, [
            'label' => 'Locale',
            'rules' => $localeRules,
            'attr' => $localeAttributes,
        ]);
        $this->add('admin', Field::CHECKBOX, [
            'label' => 'Enable in CMS',
            'rules' => ['boolean'],
        ]);
        $this->add('site', Field::CHECKBOX, [
            'label' => 'Enable on website',
            'rules' => ['boolean'],
        ]);

        $this->add('delimiter', 'hidden');
    }
}
