# Event Registration Module

A Drupal 10 module that provides comprehensive event registration functionality with email notifications, admin management, and CSV export capabilities.

## Features

- **Public Event Registration**: Users can register for events through a public form
- **Event Management**: Administrators can create and manage events
- **Email Notifications**: Automatic confirmation emails to users and notifications to admins
- **Capacity Management**: Limit registrations based on maximum attendee counts
- **Duplicate Prevention**: Prevents duplicate registrations for the same event
- **CSV Export**: Export registration data to CSV format
- **Admin Interface**: Comprehensive admin interface for managing events and registrations

## Requirements

- Drupal 10.x
- PHP 8.1 or higher

## Installation

1. Place the `event_registration` module in your Drupal installation's `modules` directory
2. Enable the module through the Drupal admin interface (`admin/modules`)
3. Or enable via Drush: `drush en event_registration`

## Configuration

### Event Creation

1. Navigate to `admin/config/event-registration/add-event`
2. Fill in the event details:
   - Event Name
   - Category
   - Registration Start/End Dates
   - Event Date
   - Location
   - Maximum Attendees (optional)
3. Save the event

### Admin Settings

1. Navigate to `admin/config/event-registration/settings`
2. Configure admin email settings and other options

## Usage

### Public Registration

1. Users can access the registration form at `/event-registration`
2. They can select from available events
3. Fill in their personal information
4. Submit the form to register

### Admin Management

1. View all registrations at `admin/event-registration/registrations`
2. Export registrations to CSV at `admin/event-registration/export/csv`

## Database Schema

The module creates two tables:

### `event_registration_event`
- `id`: Primary key
- `title`: Event name
- `description`: Event description
- `event_date`: Event date (timestamp)
- `location`: Event location
- `max_attendees`: Maximum number of attendees
- `category`: Event category
- `registration_start`: Registration start date
- `registration_end`: Registration end date
- `status`: Active/inactive status
- `uid`: Creator user ID
- `created`: Creation timestamp
- `changed`: Last changed timestamp

### `event_registration_entry`
- `id`: Primary key
- `event_id`: Foreign key to event
- `full_name`: Registrant's full name
- `email`: Registrant's email
- `college`: Registrant's college
- `department`: Registrant's department
- `created`: Registration timestamp

## Email Templates

The module sends two types of emails:

1. **Registration Confirmation**: Sent to the registrant
2. **Admin Notification**: Sent to the configured admin email

## CSV Export

Administrators can export all registrations to CSV format from the admin interface. The export includes:
- Registration ID
- Event Name
- Full Name
- Email
- College
- Department
- Registration Date

## Permissions

- `access event registration`: Allows users to access the registration form
- `administer event registration`: Allows users to manage events and registrations

## Troubleshooting

### Emails Not Sending
- Check your server's mail configuration
- Consider installing an SMTP module for reliable email delivery
- Verify the admin email address in site configuration

### Events Not Appearing
- Ensure events are marked as active
- Check that registration dates are within the valid range
- Verify event dates are in the future

## Development

This module follows Drupal coding standards and best practices. Contributions are welcome via pull requests.

## License

This project is licensed under the GPL v2 or later license.

## Support

For support, please create an issue in the issue queue or contact the module maintainer.