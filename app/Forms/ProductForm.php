<?php

namespace App\Forms;

use App\Services\LanguageService;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ProductForm
 * @package App\Forms
 */
class ProductForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm(): void
    {
        $languages = app(LanguageService::class)->getLanguagesForDashboard();
        foreach ($languages as $language) {
            $this->add('title[' . $language['locale'] . ']', Field::TEXT, [
                'wrapper' => [
                    'data-lang' => $language['locale'],
                ],
                'label' => 'Title ',
                'label_attr' => [
                    'data-lang' => $language['locale'],
                    'class' => 'form-label acms-lang-label',
                ],
                'attr' => [
                    'data-lang' => $language['locale'],
                ],
                'value' => $this->model ? $this->model->getTranslation('title', $language['locale'], false) : '',
                'rules' => ['required', 'string', 'max:80'],
            ]);
            $this->add('description[' . $language['locale'] . ']', Field::TEXT, [
                'wrapper' => [
                    'data-lang' => $language['locale'],
                ],
                'label' => 'Description ',
                'label_attr' => [
                    'data-lang' => $language['locale'],
                    'class' => 'form-label acms-lang-label',
                ],
                'attr' => [
                    'data-lang' => $language['locale'],
                ],
                'value' => $this->model ? $this->model->getTranslation('description', $language['locale'], false) : '',
                'rules' => ['required', 'string', 'max:80'],
            ]);
        }
        $this->add('delimiter', 'hidden');
    }
}
