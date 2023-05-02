<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Forms\UserForm;
use App\Services\UserService;
use App\Services\LanguageService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

/**
 * Class User
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var \App\Services\UserService
     */
    private UserService $service;

    /**
     * @param  \App\Services\UserService $service
     */
    public function __construct(UserService $service)
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

        return view('admin.users.index')->with([
            'collection' => $collection,
            'languages' => $languages,
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request): View
    {
        $form = $this->form(UserForm::class, [
            'method' => 'POST',
            'url' => route('admin.users.store'),
        ]);
        $languages = app(LanguageService::class)->getLanguagesForDashboard();

        return view('admin.users.form', [
            'form' => $form,
            'languages' => $languages,
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $form = $this->form(UserForm::class);
        $form->redirectIfNotValid();

        $status = $this->service->store(
            $form->getFieldValues()
        );

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.users.index')->with('success', 'Users updated');
            }

            return redirect()->route('admin.users.edit', $this->service->model->id)
                ->with('success', 'Users updated');
        }

        return redirect()->route('admin.users.index')->with('error', 'Looks like something went wrong!');
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View
    {
        $resource = $this->service->find($id);
        $form = $this->form(UserForm::class, [
            'model' => $resource,
            'url' => route('admin.users.update', $resource),
            'method' => 'PUT',
        ]);
        $languages = app(LanguageService::class)->getLanguagesForDashboard();

        return view('admin.users.form')->with([
            'resource' => $resource,
            'form' => $form,
            'languages' => $languages,
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $resource = $this->service->find($id);
        $form = $this->form(UserForm::class, [
            'model' => $resource,
        ]);

        $form->redirectIfNotValid();

        $status = $this->service->updateResource($resource, $form->getFieldValues());

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.users.index')
                    ->with('success', 'Users updated');
            }

            return redirect()->route('admin.users.edit', $id)
                ->with('success', 'Users updated');
        }

        return redirect()->route('admin.users.edit', $id)
            ->with('error', 'Looks like something went wrong!');
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(['success' => true, 'message' => 'Users has been deleted']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(): JsonResponse
    {
        $id = request('id');

        try {
            $resource = $this->service->find($id);
            $this->service->update($id, [
                'published' => !$resource->published,
            ]);

            return response()->json(['status' => true]);
        } catch (Exception $e) {
            return response()->json(['status' => false]);
        }
    }
}
