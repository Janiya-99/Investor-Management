# Roles and Permissions Setup Guide

This application uses Spatie Laravel Permission package for role-based access control (RBAC).

## Installation Steps

1. **Install the package** (if not already installed):
   ```bash
   composer install
   ```

2. **Publish the migration files**:
   ```bash
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
   ```

3. **Run migrations**:
   ```bash
   php artisan migrate
   ```

4. **Seed default roles and permissions**:
   ```bash
   php artisan db:seed --class=RolePermissionSeeder
   ```

   Or run all seeders:
   ```bash
   php artisan db:seed
   ```

## Default Roles and Permissions

### Super Admin
- Has access to all permissions
- Can manage users, roles, permissions, investors, and products

### Admin
- Can view, create, and edit users
- Can view, create, and edit investors
- Can view, create, and edit products

### Manager
- Can view, create, and edit investors
- Can view products

### User
- Can view investors
- Can view products

## Permission Structure

Permissions follow the pattern: `module.action`

Examples:
- `users.view` - View users
- `users.create` - Create users
- `users.edit` - Edit users
- `users.delete` - Delete users
- `investors.view` - View investors
- `roles.view` - View roles
- `permissions.view` - View permissions

## Usage

### Assigning Roles to Users

1. Go to Users page
2. Create or edit a user
3. Select a role from the dropdown
4. Save the user

### Managing Roles

1. Go to Roles page (`/roles`)
2. Create new roles with selected permissions
3. Edit existing roles to modify permissions
4. Delete roles (except Super Admin)

### Managing Permissions

1. Go to Permissions page (`/permissions`)
2. Create new permissions (format: `module.action`)
3. Edit existing permissions
4. Delete permissions

### Using Permissions in Code

#### In Blade Templates:
```blade
@can('users.view')
    <!-- Content visible only to users with users.view permission -->
@endcan

@canany(['users.view', 'users.create'])
    <!-- Content visible to users with either permission -->
@endcanany
```

#### In Controllers:
```php
// Check if user has permission
if (auth()->user()->can('users.view')) {
    // Allow access
}

// Or use middleware
$this->middleware('permission:users.view');
```

#### In Routes:
```php
Route::get('/users', [UserController::class, 'index'])
    ->middleware('permission:users.view');
```

### Sidebar Menu Permissions

The sidebar menu automatically checks permissions. Menu items will only be visible to users who have the required permissions:

- **Users** menu: Requires `users.view` permission
- **Roles** menu: Requires `roles.view` permission
- **Permissions** menu: Requires `permissions.view` permission
- **Products** menu: Requires `products.view` permission
- **Investors** menu: Requires `investors.view` or `investors.create` permission

## Creating Custom Permissions

1. Go to Permissions page
2. Click "Add Permission"
3. Enter permission name in format: `module.action`
   - Example: `reports.view`, `reports.export`, `settings.edit`

## Best Practices

1. **Use descriptive permission names**: Follow the `module.action` pattern
2. **Group related permissions**: Use the same module prefix for related permissions
3. **Assign roles, not individual permissions**: It's easier to manage roles than individual permissions
4. **Regular audits**: Periodically review roles and permissions to ensure they're still needed
5. **Test permissions**: Always test that permissions work as expected after changes

## Troubleshooting

### Permissions not working?
1. Clear the permission cache:
   ```bash
   php artisan permission:cache-reset
   ```

2. Ensure the user has the correct role assigned

3. Check that the permission exists in the database

### Menu items not showing?
1. Verify the user has the required permission
2. Check the menu-list.blade.php file for correct permission checks
3. Clear view cache:
   ```bash
   php artisan view:clear
   ```

## Additional Resources

- [Spatie Laravel Permission Documentation](https://spatie.be/docs/laravel-permission/v6/introduction)
- [Laravel Authorization Documentation](https://laravel.com/docs/authorization)


