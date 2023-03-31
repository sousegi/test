<?php

namespace App\Forms;

use App\Services\LanguageService;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

/**
 * Class TranslationForm
 * @package App\Forms
 */
class TranslationForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm(): void
    {
        $languages = app(LanguageService::class)->getLanguagesForDashboard();

        foreach ($languages as $language) {
            $this->add('content[' . $language['locale'] . ']', Field::TEXTAREA, [
                'wrapper' => [
                    'data-lang' => $language['locale'],
                    'class' => 'form-group'
                ],
                'label' => 'Constant content',
                'label_attr' => [
                    'class' => 'control-label acms-slug-control acms-lang-label',
                    'data-slug-active' => 1,
                    'data-lang-title' => $language['title'],
                    'data-lang' => $language['locale'],
                ],
                'attr' => [
                    'class' => 'form-control acms-slug-input',
                    'data-language' => $language['locale'],
                ],
                'value' => $this->model ? $this->model->getTranslation('content', $language['locale'], false) : '',
                'rules' => ['required', 'string'],
            ]);
        }
        $this->add('delimiter', 'hidden');
    }
}
