<?php

namespace App\Forms;

use App\Services\LanguageService;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ArticleForm
 * @package App\Forms
 */
class ArticleForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm(): void
    {
//        $languages = app(LanguageService::class)->getLanguagesForDashboard();
//        foreach ($languages as $language) {
//            $this->add('title[' . $language['locale'] . ']', Field::TEXT, [
//                'wrapper' => [
//                    'data-lang' => $language['locale'],
//                ],
//                'label' => 'Title ',
//                'label_attr' => [
//                    'data-lang' => $language['locale'],
//                    'class' => 'form-label acms-lang-label',
//                ],
//                'attr' => [
//                    'data-lang' => $language['locale'],
//                ],
//                'value' => $this->model ? $this->model->getTranslation('title', $language['locale'], false) : '',
//                'rules' => ['required', 'string', 'max:80'],
//            ]);
//        }
        $this
            ->add('title', Field::TEXT, [
                'rules' => ['required', 'string'],
                'value' => $this->model ? $this->model->title : '',
            ])
            ->add('content', Field::TEXTAREA, [
                'rules' => ['required', 'string'],
                'attr' => [
                    'class' => 'ckeditor',

                ],

            ])
            ->add('published', Field::CHECKBOX, [
                'label' => 'Publish',
                'rules' => ['boolean']
            ]);
        $this->add('delimiter', 'hidden');
        $this->add('image', Field::FILE, [
            'label' => false,
            'attr' => [
                'hidden' => 'hidden'
            ],
        ]);
    }
}
