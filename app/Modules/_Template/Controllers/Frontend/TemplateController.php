<?php

namespace App\Modules\_Template\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\_Template\Models\TemplateModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Frontend TemplateController
 *
 * KULLANIM: Bu dosyayi kopyalayin ve asagidaki degisiklikleri yapin:
 * 1. Namespace: 'App\Modules\_Template' -> 'App\Modules\{ModuleName}'
 * 2. Class: 'TemplateController' -> '{ModuleName}Controller'
 * 3. Model: 'TemplateModel' -> '{ModuleName}Model'
 * 4. View path: '_Template' -> '{ModuleName}'
 * 5. Lang: 'Template.' -> '{ModuleName}.'
 * 6. Helper: 'template' -> '{modulename}'
 */
class TemplateController extends BaseController
{
    protected TemplateModel $model;

    public function __construct()
    {
        $this->model = new TemplateModel();
        helper(['template']);
    }

    /**
     * Listeleme sayfasi.
     */
    public function index(): string
    {
        // Arama parametresi
        $search = $this->request->getGet('search');

        if ($search) {
            $items = $this->model->search($search);
        } else {
            $items = $this->model->getPaginated(12);
        }

        $data = [
            'title' => lang('Template.frontend.title'),
            'items' => $items,
            'pager' => $this->model->pager,
            'search' => $search,
        ];

        return view('App\Modules\_Template\Views\frontend\index', $data);
    }

    /**
     * Detay sayfasi.
     */
    public function show(string $slug): string|RedirectResponse
    {
        $item = $this->model->findBySlug($slug);

        if ($item === null || !$item->isActive()) {
            return redirect()->to('/templates')
                ->with('error', lang('Template.messages.not_found'));
        }

        // Ilgili kayitlar (ayni kategoriden veya rastgele)
        $relatedItems = $this->model
            ->where('id !=', $item->id)
            ->where('is_active', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll(4);

        $data = [
            'title' => $item->title,
            'item' => $item,
            'relatedItems' => $relatedItems,
        ];

        return view('App\Modules\_Template\Views\frontend\show', $data);
    }
}
