<?php

/**
 * Template Language - English
 */

return [
    // Admin
    'admin' => [
        'title' => 'Items',
        'create' => 'New Item',
        'edit' => 'Edit Item',
        'show' => 'Item Details',
        'delete' => 'Delete Item',
        'list' => 'Item List',
    ],

    // Frontend
    'frontend' => [
        'title' => 'All Items',
        'show' => 'Item Details',
        'related' => 'Related Items',
        'no_items' => 'No items found.',
    ],

    // Form fields
    'fields' => [
        'title' => 'Title',
        'slug' => 'URL Slug',
        'description' => 'Description',
        'status' => 'Status',
        'is_active' => 'Active',
        'sort_order' => 'Sort Order',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    // Status values
    'status_values' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'draft' => 'Draft',
    ],

    // Buttons
    'buttons' => [
        'create' => 'Add New',
        'save' => 'Save',
        'update' => 'Update',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
        'back' => 'Back',
        'edit' => 'Edit',
        'view' => 'View',
    ],

    // Messages
    'messages' => [
        'created' => 'Item created successfully.',
        'updated' => 'Item updated successfully.',
        'deleted' => 'Item deleted successfully.',
        'not_found' => 'Item not found.',
        'delete_confirm' => 'Are you sure you want to delete this item?',
    ],

    // Validation errors
    'validation' => [
        'title_required' => 'Title field is required.',
        'title_min_length' => 'Title must be at least 3 characters.',
    ],
];
