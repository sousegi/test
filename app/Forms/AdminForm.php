<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

/**
 * Class AdminForm
 * @package App\Forms
 */
class AdminForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm(): void
    {
        $uniqueId = (empty($this->model)) ?: $this->model->id;
        $passwordRules = (empty($this->model))
            ? [
                'required',
                'string',
                'min:6',
                'max:255',
                'confirmed',
            ]
            : [
                'nullable',
                'string',
                'min:6',
                'max:255',
                'confirmed',
                'required_with:password_confirmation',
            ];

        $this->add('name', Field::TEXT, [
            'label' => 'Name ',
            'rules' => ['required', 'string', 'max:255'],
        ]);
        $this->add('email', Field::EMAIL, [
            'label' => 'Email ',
            'rules' => ['required', 'email', 'unique:admins,email,' . $uniqueId . ',id'],
        ]);
        $this->add('password', 'repeated', [
            'type' => 'password',
            'second_name' => 'password_confirmation',
            'first_options' => [
                'value' => '',
                'rules' => $passwordRules,
            ],
            'second_options' => [
            ],
        ]);
        $this->add('delimiter', 'hidden');
    }
}
