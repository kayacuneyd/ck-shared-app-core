<?php

namespace App\Modules\Property\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\Property\Models\PropertyModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Admin PropertyController
 *
 * Handles all admin CRUD operations for properties.
 * All routes are protected by the auth filter.
 */
class PropertyController extends BaseController
{
    /**
     * The Property model instance.
     *
     * @var PropertyModel
     */
    protected PropertyModel $propertyModel;

    /**
     * Constructor - initialize the model.
     */
    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
        helper(['form', 'property']);
    }

    /**
     * Display a listing of all properties.
     *
     * @return string
     */
    public function index(): string
    {
        $data = [
            'title' => lang('Property.admin.title'),
            'properties' => $this->propertyModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('App\Modules\Property\Views\admin\index', $data);
    }

    /**
     * Show the form for creating a new property.
     *
     * @return string
     */
    public function create(): string
    {
        $data = [
            'title' => lang('Property.admin.create'),
            'property' => null,
        ];

        return view('App\Modules\Property\Views\admin\create', $data);
    }

    /**
     * Store a newly created property.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $data = $this->request->getPost();

        // Generate unique slug
        $data['slug'] = $this->propertyModel->generateUniqueSlug($data['title']);

        // Handle featured checkbox
        $data['featured'] = isset($data['featured']) ? 1 : 0;

        // Handle images (JSON encode if array)
        $data['images'] = $data['images'] ?? '[]';

        if (!$this->propertyModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->propertyModel->errors());
        }

        return redirect()->to('/admin/properties')
            ->with('message', lang('Property.messages.created'));
    }

    /**
     * Display the specified property.
     *
     * @param int $id
     * @return string|RedirectResponse
     */
    public function show(int $id): string|RedirectResponse
    {
        $property = $this->propertyModel->find($id);

        if ($property === null) {
            return redirect()->to('/admin/properties')
                ->with('error', lang('Property.messages.not_found'));
        }

        $data = [
            'title' => $property->title,
            'property' => $property,
        ];

        return view('App\Modules\Property\Views\admin\show', $data);
    }

    /**
     * Show the form for editing the specified property.
     *
     * @param int $id
     * @return string|RedirectResponse
     */
    public function edit(int $id): string|RedirectResponse
    {
        $property = $this->propertyModel->find($id);

        if ($property === null) {
            return redirect()->to('/admin/properties')
                ->with('error', lang('Property.messages.not_found'));
        }

        $data = [
            'title' => lang('Property.admin.edit'),
            'property' => $property,
        ];

        return view('App\Modules\Property\Views\admin\edit', $data);
    }

    /**
     * Update the specified property.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function update(int $id): RedirectResponse
    {
        $property = $this->propertyModel->find($id);

        if ($property === null) {
            return redirect()->to('/admin/properties')
                ->with('error', lang('Property.messages.not_found'));
        }

        $data = $this->request->getPost();

        // Regenerate slug if title changed
        if ($data['title'] !== $property->title) {
            $data['slug'] = $this->propertyModel->generateUniqueSlug($data['title'], $id);
        }

        // Handle featured checkbox
        $data['featured'] = isset($data['featured']) ? 1 : 0;

        // Handle images (keep existing if not provided)
        if (empty($data['images'])) {
            unset($data['images']);
        }

        if (!$this->propertyModel->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->propertyModel->errors());
        }

        return redirect()->to('/admin/properties')
            ->with('message', lang('Property.messages.updated'));
    }

    /**
     * Remove the specified property.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $property = $this->propertyModel->find($id);

        if ($property === null) {
            return redirect()->to('/admin/properties')
                ->with('error', lang('Property.messages.not_found'));
        }

        $this->propertyModel->delete($id);

        return redirect()->to('/admin/properties')
            ->with('message', lang('Property.messages.deleted'));
    }
}
