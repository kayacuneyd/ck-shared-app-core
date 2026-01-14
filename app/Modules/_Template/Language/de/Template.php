<?php

/**
 * Template Language - German
 */

return [
    // Admin
    'admin' => [
        'title' => 'Eintraege',
        'create' => 'Neuer Eintrag',
        'edit' => 'Eintrag bearbeiten',
        'show' => 'Eintrag Details',
        'delete' => 'Eintrag loeschen',
        'list' => 'Eintragsliste',
    ],

    // Frontend
    'frontend' => [
        'title' => 'Alle Eintraege',
        'show' => 'Eintrag Details',
        'related' => 'Verwandte Eintraege',
        'no_items' => 'Keine Eintraege gefunden.',
    ],

    // Form fields
    'fields' => [
        'title' => 'Titel',
        'slug' => 'URL Slug',
        'description' => 'Beschreibung',
        'status' => 'Status',
        'is_active' => 'Aktiv',
        'sort_order' => 'Sortierung',
        'created_at' => 'Erstellt am',
        'updated_at' => 'Aktualisiert am',
    ],

    // Status values
    'status_values' => [
        'active' => 'Aktiv',
        'inactive' => 'Inaktiv',
        'draft' => 'Entwurf',
    ],

    // Buttons
    'buttons' => [
        'create' => 'Neu hinzufuegen',
        'save' => 'Speichern',
        'update' => 'Aktualisieren',
        'delete' => 'Loeschen',
        'cancel' => 'Abbrechen',
        'back' => 'Zurueck',
        'edit' => 'Bearbeiten',
        'view' => 'Anzeigen',
    ],

    // Messages
    'messages' => [
        'created' => 'Eintrag erfolgreich erstellt.',
        'updated' => 'Eintrag erfolgreich aktualisiert.',
        'deleted' => 'Eintrag erfolgreich geloescht.',
        'not_found' => 'Eintrag nicht gefunden.',
        'delete_confirm' => 'Sind Sie sicher, dass Sie diesen Eintrag loeschen moechten?',
    ],

    // Validation errors
    'validation' => [
        'title_required' => 'Titel ist erforderlich.',
        'title_min_length' => 'Titel muss mindestens 3 Zeichen lang sein.',
    ],
];
