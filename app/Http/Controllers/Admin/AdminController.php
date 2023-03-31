<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Forms\AdminForm;
use App\Services\AdminService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

/**
 * Class Admin
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    use FormBuilderTrait;

    /**
     * @var \App\Services\AdminService
     */
    private AdminService $service;

    /**
     * @param  \App\Services\AdminService  $service
     */
    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $collection = $this->service->findAllOrderByIdDescPaginated(50);

        return view('admin.admins.index')->with(['collection' => $collection]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request): View
    {
        $form = $this->form(AdminForm::class, [
            'method' => 'POST',
            'url' => route('admin.admins.store'),
        ]);

        return view('admin.admins.form', [
            'form' => $form,
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $form = $this->form(AdminForm::class);
        $form->redirectIfNotValid();

        $status = $this->service->store(
            $form->getFieldValues()
        );

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.admins.index')->with('success', 'Admins updated');
            }

            return redirect()->route('admin.admins.edit', $this->service->model->id)
                ->with('success', 'Admins updated');
        }

        return redirect()->route('admin.admins.index')->with('error', 'Looks like something went wrong!');
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View
    {
        $resource = $this->service->find($id);
        $form = $this->form(AdminForm::class, [
            'model' => $resource,
            'url' => route('admin.admins.update', $resource),
            'method' => 'PUT',
        ]);

        return view('admin.admins.form')->with([
            'resource' => $resource,
            'form' => $form,
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
        $form = $this->form(AdminForm::class, [
            'model' => $resource,
        ]);

        $form->redirectIfNotValid();

        $status = $this->service->updateResource($resource, $form->getFieldValues());

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.admins.index')
                    ->with('success', 'Admins updated');
            }

            return redirect()->route('admin.admins.edit', $id)
                ->with('success', 'Admins updated');
        }

        return redirect()->route('admin.admins.edit', $id)
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

        return response()->json(['success' => true, 'message' => 'Admins has been deleted']);
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
