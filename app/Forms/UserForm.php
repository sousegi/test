<?php

namespace App\Forms;

use App\Services\LanguageService;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

/**
 * Class UserForm
 * @package App\Forms
 */
class UserForm extends Form
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
//        $this
//            ->add('title', Field::TEXT, [
//                'rules' => ['required', 'string', 'max:10'],
//            ])
//            ->add('published', Field::CHECKBOX, [
//                'label' => 'Publish',
//                'rules' => ['boolean']
//            ]);
        $this->add('delimiter', 'hidden');
    }
}
