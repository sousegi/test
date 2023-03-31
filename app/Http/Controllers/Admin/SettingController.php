<?php

namespace App\Http\Controllers\Admin;

use App\Forms\SettingForm;
use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

/**
 * Class SettingController
 * @package App\Http\Controllers\Amigo
 */
class SettingController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var \App\Services\SettingService
     */
    public SettingService $service;

    /**
     * @param  \App\Services\SettingService   $settingService
     * @param  \App\Services\LanguageService  $languageService
     */
    public function __construct(SettingService $settingService)
    {
        $this->service = $settingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $tab = $request->get('tab') ?: 1;
        $settings = $this->service->getSettingsFromCache();
        $form = $this->form(SettingForm::class, [
            'method' => 'post',
            'url' => route('admin.settings.store'),
            'data' => $settings
        ]);

        return view('admin.settings.index', [
            'tab' => $tab,
            'form' => $form,
            'settings' => $settings
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $form = $this->form(SettingForm::class, [
            'method' => 'post',
            'url' => route('admin.settings.store'),
        ]);

        return view('admin.settings.form', [
            'form' => $form,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(): RedirectResponse
    {
        $form = $this->form(SettingForm::class);
        $form->redirectIfNotValid();

        $data = $form->getFieldValues();

        $status = $this->service->updateAllSettingsFromRequest($data);

        $this->service->clearSettingsCache();

        if ($status) {
            return redirect()->route('admin.settings.index')->with('success', 'New setting has been created.');
        }

        return back()->with('error', 'Looks like something went wrong.');
    }
}
