# Activity Log Setup Guide

This guide will help you complete the setup of the Spatie Activity Log system for tracking all changes in your application.

## Installation Steps

### 1. Install the Package

Run the following command to install Spatie Activity Log:

```bash
composer require spatie/laravel-activitylog
```

### 2. Publish the Migration

Publish the migration file to create the `activity_log` table:

```bash
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
```

### 3. Run the Migration

Run the migration to create the activity_log table:

```bash
php artisan migrate
```

### 4. Publish the Config (Optional)

If you want to customize the configuration:

```bash
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
```

## What Has Been Set Up

### ✅ Models with Activity Logging

The following models have been configured to log all changes:

- **User** - Logs user account changes
- **Investor** - Logs investor information changes
- **Product** - Logs product changes
- **Bank** - Logs bank information changes
- **BankBranch** - Logs bank branch changes
- **InvestorHasDocument** - Logs document changes
- **InvestorHasBankDetails** - Logs bank details changes

### ✅ Features

1. **Automatic Logging**: All create, update, and delete operations are automatically logged
2. **User Tracking**: Each activity is linked to the user who performed the action
3. **Change Tracking**: Tracks what fields were changed (old values → new values)
4. **Sensitive Data Protection**: Passwords, tokens, and OTPs are excluded from logs

### ✅ Modern Log Viewer

A modern, feature-rich log viewer has been created with:

- **Advanced Filtering**: Filter by subject type, event type, user, and date range
- **DataTables Integration**: Sortable, searchable, and exportable logs
- **Change Visualization**: See exactly what changed in each update
- **Detail Modal**: View complete activity details with JSON viewer
- **Responsive Design**: Works on all devices

## Accessing the Activity Logs

Once installed, you can access the activity logs at:

```
/activity-logs
```

Or use the route name:

```php
route('activity-logs.index')
```

## How It Works

### Loggable Trait

All models use the `Loggable` trait which:

- Automatically logs create, update, and delete events
- Tracks only changed fields (dirty attributes)
- Excludes sensitive information
- Links activities to the authenticated user
- Provides descriptive event messages

### Activity Log Controller

The `ActivityLogController` provides:

- **Index**: List all activity logs with filtering
- **Show**: View detailed information about a specific activity

### View Features

The activity log view includes:

1. **Filter Panel**: Filter logs by multiple criteria
2. **DataTable**: Advanced table with sorting, searching, and export
3. **Event Badges**: Color-coded badges for created/updated/deleted events
4. **Change Display**: Visual representation of field changes
5. **Detail Modal**: Full activity details with formatted JSON

## Adding Logging to New Models

To add activity logging to a new model:

1. Add the `Loggable` trait:

```php
use App\Traits\Loggable;

class YourModel extends Model
{
    use HasFactory, Loggable;
    // ...
}
```

That's it! The model will now automatically log all changes.

## Customization

### Excluding Fields from Logging

To exclude additional fields, modify the `Loggable` trait in `app/Traits/Loggable.php`:

```php
$sensitiveFields = ['password', 'remember_token', 'otp', 'your_field'];
```

### Custom Event Descriptions

Modify the `getDescriptionForEvent` method in the `Loggable` trait to customize event descriptions.

## Troubleshooting

### Logs Not Appearing

1. Ensure the migration has been run: `php artisan migrate`
2. Check that models are using the `Loggable` trait
3. Verify a user is authenticated when making changes
4. Check the `activity_log` table exists in your database

### Performance Considerations

For high-traffic applications:

- Consider adding indexes to the `activity_log` table
- Implement log cleanup/archival for old logs
- Use queue jobs for logging in high-volume scenarios

## Security Notes

- Sensitive fields (passwords, tokens) are automatically excluded
- Only authenticated users' actions are tracked
- Logs are stored in the database and should be protected accordingly
- Consider implementing access control for viewing logs

## Support

For more information about Spatie Activity Log, visit:
https://spatie.be/docs/laravel-activitylog
