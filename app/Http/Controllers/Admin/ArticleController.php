<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Forms\ArticleForm;
use App\Services\ArticleService;
use App\Services\LanguageService;
use App\Traits\DropZoneTrait;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

/**
 * Class Article
 * @package App\Http\Controllers\Admin
 */
class ArticleController extends Controller
{
    use FormBuilderTrait, DropZoneTrait;

    /**
     * @var \App\Services\ArticleService
     */
    private ArticleService $service;

    /**
     * @param  \App\Services\ArticleService $service
     */
    public function __construct(ArticleService $service)
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

        return view('admin.articles.index')->with([
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
        $form = $this->form(ArticleForm::class, [
            'method' => 'POST',
            'url' => route('admin.articles.store'),
        ]);
        $languages = app(LanguageService::class)->getLanguagesForDashboard();

        return view('admin.articles.form', [
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
        $form = $this->form(ArticleForm::class);
        if (request('image') == null ) {
            return redirect()->back()->with('error','Image Required!')->withInput();
        }

        $form->redirectIfNotValid();

        $status = $this->service->store(
            $form->getFieldValues()
        );

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.articles.index')->with('success', 'Articles updated');
            }

            return redirect()->route('admin.articles.edit', $this->service->model->id)
                ->with('success', 'Articles updated');
        }

        return redirect()->route('admin.articles.index')->with('error', 'Looks like something went wrong!');
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View
    {
        $resource = $this->service->find($id);
        $form = $this->form(ArticleForm::class, [
            'model' => $resource,
            'url' => route('admin.articles.update', $resource),
            'method' => 'PUT',
        ]);
        $languages = app(LanguageService::class)->getLanguagesForDashboard();

        $image = !empty($resource->image) ? $this->getImages($resource->image, $resource->id) : null;

        return view('admin.articles.form')->with([
            'resource' => $resource,
            'form' => $form,
            'languages' => $languages,
            'image' => $image,
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
        $form = $this->form(ArticleForm::class, [
            'model' => $resource,
        ]);

        $form->redirectIfNotValid();

        $status = $this->service->updateResource($resource, $form->getFieldValues());

        if ($status) {
            if ($request->get('save') === 'redirect') {
                return redirect()->route('admin.articles.index')
                    ->with('success', 'Articles updated');
            }

            return redirect()->route('admin.articles.edit', $id)
                ->with('success', 'Articles updated');
        }

        return redirect()->route('admin.articles.edit', $id)
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

        return response()->json(['success' => true, 'message' => 'Articles has been deleted']);
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
