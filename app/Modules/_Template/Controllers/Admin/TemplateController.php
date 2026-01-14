<?php

namespace App\Modules\_Template\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\_Template\Models\TemplateModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Admin TemplateController
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Namespace: 'App\Modules\_Template' -> 'App\Modules\{ModuleName}'
 * 2. Class: 'TemplateController' -> '{ModuleName}Controller'
 * 3. Model: 'TemplateModel' -> '{ModuleName}Model'
 * 4. View path: '_Template' -> '{ModuleName}'
 * 5. Route: '/admin/templates' -> '/admin/{modulename}'
 * 6. Lang: 'Template.' -> '{ModuleName}.'
 * 7. Helper: 'template' -> '{modulename}'
 */
class TemplateController extends BaseController
{
    protected TemplateModel $model;

    public function __construct()
    {
        $this->model = new TemplateModel();
        helper(['form', 'template']);
    }

    /**
     * Tum kayitlari listele.
     */
    public function index(): string
    {
        $data = [
            'title' => lang('Template.admin.title'),
            'items' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('App\Modules\_Template\Views\admin\index', $data);
    }

    /**
     * Yeni kayit formu.
     */
    public function create(): string
    {
        $data = [
            'title' => lang('Template.admin.create'),
            'item' => null,
        ];

        return view('App\Modules\_Template\Views\admin\create', $data);
    }

    /**
     * Yeni kayit kaydet.
     */
    public function store(): RedirectResponse
    {
        $data = $this->request->getPost();

        // Slug uret
        $data['slug'] = $this->model->generateUniqueSlug($data['title']);

        // Checkbox'lari isle
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/templates')
            ->with('message', lang('Template.messages.created'));
    }

    /**
     * Kayit detayi goster.
     */
    public function show(int $id): string|RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/templates')
                ->with('error', lang('Template.messages.not_found'));
        }

        $data = [
            'title' => $item->title,
            'item' => $item,
        ];

        return view('App\Modules\_Template\Views\admin\show', $data);
    }

    /**
     * Duzenleme formu.
     */
    public function edit(int $id): string|RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/templates')
                ->with('error', lang('Template.messages.not_found'));
        }

        $data = [
            'title' => lang('Template.admin.edit'),
            'item' => $item,
        ];

        return view('App\Modules\_Template\Views\admin\edit', $data);
    }

    /**
     * Kaydi guncelle.
     */
    public function update(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/templates')
                ->with('error', lang('Template.messages.not_found'));
        }

        $data = $this->request->getPost();

        // Baslik degistiyse slug'i yeniden uret
        if ($data['title'] !== $item->title) {
            $data['slug'] = $this->model->generateUniqueSlug($data['title'], $id);
        }

        // Checkbox'lari isle
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/templates')
            ->with('message', lang('Template.messages.updated'));
    }

    /**
     * Kaydi sil.
     */
    public function delete(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/templates')
                ->with('error', lang('Template.messages.not_found'));
        }

        $this->model->delete($id);

        return redirect()->to('/admin/templates')
            ->with('message', lang('Template.messages.deleted'));
    }
}
