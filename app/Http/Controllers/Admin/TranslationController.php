<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Forms\TranslationForm;
use App\Services\LanguageService;
use App\Services\TranslationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

/**
 * Class Translation
 * @package App\Http\Controllers\Admin
 */
class TranslationController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var \App\Services\TranslationService
     */
    private TranslationService $service;

    /**
     * @param  \App\Services\TranslationService  $service
     */
    public function __construct(TranslationService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $collection = $this->service->findAllOrderByIdDescPaginated(50);
        $languages = app(LanguageService::class)->getLanguagesForDashboard();

        return view('admin.translations.index')->with([
            'collection' => $collection,
            'languages' => $languages,
        ]);
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View
    {
        $resource = $this->service->find($id);
        $form = $this->form(TranslationForm::class, [
            'model' => $resource,
            'url' => route('admin.translations.update', $resource),
            'method' => 'PUT',
        ]);
        $languages = app(LanguageService::class)->getLanguagesForDashboard();

        return view('admin.translations.form')->with([
            'resource' => $resource,
            'form' => $form,
            'languages' => $languages
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $resource = $this->service->find($id);
        $form = $this->form(TranslationForm::class, [
            'model' => $resource,
        ]);

        $form->redirectIfNotValid();

        $status = $this->service->updateResource($resource, $form->getFieldValues());

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.translations.index')
                    ->with('success', 'Translations updated');
            }

            return redirect()->route('admin.translations.edit', $id)
                ->with('success', 'Translations updated');
        }

        return redirect()->route('admin.translations.edit', $id)
            ->with('error', 'Looks like something went wrong!');
    }
}
