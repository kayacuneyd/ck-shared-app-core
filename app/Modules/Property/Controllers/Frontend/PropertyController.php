<?php

namespace App\Modules\Property\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\Property\Models\PropertyModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Frontend PropertyController
 *
 * Handles public property listing and detail pages.
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
        helper(['property']);
    }

    /**
     * Display a listing of available properties.
     *
     * @return string
     */
    public function index(): string
    {
        $search = $this->request->getGet('q');
        $city = $this->request->getGet('city');

        $builder = $this->propertyModel->where('status', 'available');

        // Apply search filter
        if (!empty($search)) {
            $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->orLike('address', $search)
                ->groupEnd();
        }

        // Apply city filter
        if (!empty($city)) {
            $builder->where('city', $city);
        }

        $properties = $builder->orderBy('featured', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(12);

        // Get unique cities for filter dropdown
        $cities = $this->propertyModel->select('city')
            ->distinct()
            ->where('status', 'available')
            ->findAll();

        $data = [
            'title' => lang('Property.frontend.title'),
            'properties' => $properties,
            'pager' => $this->propertyModel->pager,
            'cities' => array_column($cities, 'city'),
            'search' => $search,
            'city' => $city,
        ];

        return view('App\Modules\Property\Views\frontend\index', $data);
    }

    /**
     * Display the specified property.
     *
     * @param string $slug
     * @return string|RedirectResponse
     */
    public function show(string $slug): string|RedirectResponse
    {
        $property = $this->propertyModel->findBySlug($slug);

        if ($property === null) {
            return redirect()->to('/properties')
                ->with('error', lang('Property.messages.not_found'));
        }

        // Get related properties (same city, excluding current)
        $related = $this->propertyModel
            ->where('city', $property->city)
            ->where('id !=', $property->id)
            ->where('status', 'available')
            ->orderBy('created_at', 'DESC')
            ->findAll(3);

        $data = [
            'title' => $property->title,
            'property' => $property,
            'related' => $related,
        ];

        return view('App\Modules\Property\Views\frontend\show', $data);
    }
}
