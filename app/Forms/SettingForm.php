<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Field;
use Kris\LaravelFormBuilder\Form;

/**
 * Class SettingForm
 * @package App\Forms
 */
class SettingForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm(): void
    {
        // Main settings
        $this->add('site.title', Field::TEXT, [
            'label' => 'Site Title',
            'rules' => ['nullable', 'string', 'max:80'],
            'default_value' => $this->data['site.title'] ?? null,
        ]);
        $this->add('site.description', Field::TEXT, [
            'label' => 'Site Description',
            'rules' => ['nullable', 'string', 'max:180'],
            'default_value' => $this->data['site.description'] ?? null,
        ]);

        // Contacts
        $this->add('site.main.address', Field::TEXT, [
            'label' => 'Main address',
            'rules' => ['nullable', 'string', 'max:255'],
            'default_value' => $this->data['site.main.address'] ?? null
        ]);
        $this->add('site.secondary.address', Field::TEXT, [
            'label' => 'Secondary address',
            'rules' => ['nullable', 'string', 'max:255'],
            'default_value' => $this->data['site.secondary.address'] ?? null
        ]);
        $this->add('site.phone.number', Field::TEL, [
            'label' => 'Phone number',
            'rules' => ['nullable', 'string', 'max:15'],
            'default_value' => $this->data['site.phone.number'] ?? null
        ]);
        $this->add('site.mobile.number', Field::TEL, [
            'label' => 'Mobile number',
            'rules' => ['nullable', 'string', 'max:15'],
            'default_value' => $this->data['site.mobile.number'] ?? null
        ]);
        $this->add('site.email', Field::EMAIL, [
            'label' => 'Email',
            'rules' => ['nullable', 'string', 'email'],
            'default_value' => $this->data['site.email'] ?? null
        ]);

        // Social media
        $this->add('site.facebook', Field::URL, [
            'label' => 'Facebook URL',
            'rules' => ['nullable', 'string', 'url'],
            'default_value' => $this->data['site.facebook'] ?? null
        ]);
        $this->add('site.linkedin', Field::URL, [
            'label' => 'Linkedin URL',
            'rules' => ['nullable', 'string', 'url'],
            'default_value' => $this->data['site.linkedin'] ?? null
        ]);
        $this->add('site.instagram', Field::URL, [
            'label' => 'Instagram URL',
            'rules' => ['nullable', 'string', 'url'],
            'default_value' => $this->data['site.instagram'] ?? null
        ]);
        $this->add('site.cover.image', Field::FILE, [
            'label' => 'Cover Image',
            'rules' => ['nullable', 'image', 'mimes:jpeg', 'dimensions:width=1200,height=630'],
            'help_block' => [
                'text' => '1200x630px JPEG only',
                'tag' => 'p',
                'attr' => ['class' => 'fs-sm text-muted'],
            ],
            'default_value' => $this->data['site.cover.image'] ?? null
        ]);

        // Embedded
        $this->add('site.location.code', Field::TEXTAREA, [
            'label' => 'Location Code',
            'rules' => ['nullable', 'string'],
            'default_value' => $this->data['site.location.code'] ?? null
        ]);
        $this->add('site.google.analytics', Field::TEXTAREA, [
            'label' => 'Google Analytics',
            'rules' => ['nullable', 'string'],
            'default_value' => $this->data['site.google.analytics'] ?? null
        ]);
        $this->add('site.yandex.metrics', Field::TEXTAREA, [
            'label' => 'Yandex Metrics',
            'rules' => ['nullable', 'string'],
            'default_value' => $this->data['site.yandex.metrics'] ?? null
        ]);
        $this->add('site.facebook.pixel', Field::TEXTAREA, [
            'label' => 'Facebook Pixel',
            'rules' => ['nullable', 'string'],
            'default_value' => $this->data['site.facebook.pixel'] ?? null
        ]);
        $this->add('site.google.tag.manager', Field::TEXTAREA, [
            'label' => 'Google Tag Manager',
            'rules' => ['nullable', 'string'],
            'default_value' => $this->data['site.google.tag.manager'] ?? null
        ]);
        $this->add('site.google.remarketing', Field::TEXTAREA, [
            'label' => 'Google Remarketing',
            'rules' => ['nullable', 'string'],
            'default_value' => $this->data['site.google.remarketing'] ?? null
        ]);
    }
}
