<?php
/** @noinspection PhpUnused */
/** @noinspection PhpClassConstantAccessedViaChildClassInspection */
/** @noinspection DuplicatedCode */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Forms\LanguageForm;
use App\Services\LanguageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\FormBuilderTrait;

/**
 * class LanguageController
 * @package App\Http\Controllers\Amigo
 */
class LanguageController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var \App\Services\LanguageService $service
     */
    private LanguageService $service;

    /**
     * @param  \App\Services\LanguageService  $service
     */
    public function __construct(LanguageService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $collection = $this->service->findAll();

        return view('admin.languages.index')->with(['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $form = $this->form(LanguageForm::class, [
            'method' => 'POST',
            'url' => route('admin.languages.store'),
        ]);

        return view('admin.languages.form', [
            'form' => $form,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @noinspection DuplicatedCode
     * @noinspection PhpUndefinedFieldInspection
     */
    public function store(Request $request): RedirectResponse
    {
        $form = $this->form(LanguageForm::class);
        $form->redirectIfNotValid();

        $status = $this->service->store(
            $form->getFieldValues()
        );

        $this->service->clearLanguageCache();

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.languages.index')
                    ->with('success', 'Languages updated');
            }

            return redirect()->route('admin.languages.edit', $this->service->model->id)
                ->with('success', 'Languages updated');
        }

        return redirect()->route('admin.settings.index', ['tab' => 2])
            ->with('error', 'Looks like something went wrong');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View
    {
        $resource = $this->service->find($id);
        $form = $this->form(LanguageForm::class, [
            'model' => $resource,
            'url' => route('admin.languages.update', $resource),
            'method' => 'PUT',
        ]);

        return view('admin.languages.form', [
            'resource' => $resource,
            'form' => $form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return RedirectResponse
     * @noinspection PhpUndefinedClassInspection
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $resource = $this->service->find($id);
        $form = $this->form(LanguageForm::class, [
            'model' => $resource,
        ]);

        // Custom validation for language
        $validator = Validator::make($request->all(), $form->getRules());
        $lastLanguageStatus = $this->service->checkIfLastLanguageAvailableInDashboard($resource->id);
        $validator->after(function ($validator) use ($lastLanguageStatus, $request) {
            if ($lastLanguageStatus && !$request->has('admin')) {
                $validator->errors()->add('admin', 'You cannot disable all languages in the admin panel');
            }
        });
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = $this->service->updateResource($resource, $validator->safe()->except('locale'));
        \Cache::forget('languages');

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.languages.index')
                    ->with('success', 'Languages updated');
            }

            return redirect()->route('admin.languages.edit', $id)
                ->with('success', 'Language updated');
        }

        return redirect()->route('admin.languages.edit', $id)
            ->with('error', 'Looks like something went wrong');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $status = $this->service->checkIfLastLanguageAvailable($id);
        if ($status) {
            return response()->json(['success' => false, 'message' => 'Cant delete last available language'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->service->delete($id);

        $this->service->clearLanguageCache();

        return response()->json(['success' => true, 'message' => 'Language has been deleted']);
    }
}
