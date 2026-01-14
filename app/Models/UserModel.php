<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 *
 * Provides basic access to the `users` table used for
 * authentication.  Defines the table name, primary key,
 * and allowed fields.  Additional query helper methods
 * can be added here as needed.
 */
class UserModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Whether auto-incrementing is enabled.
     *
     * @var bool
     */
    protected $useAutoIncrement = true;

    /**
     * The return type for results.
     *
     * @var string
     */
    protected $returnType = 'array';

    /**
     * Fields that are allowed to be set via mass assignment.
     *
     * @var array<string>
     */
    protected $allowedFields = [
        'email',
        'password',
        'name',
        'role',
        'is_active',
    ];
}
