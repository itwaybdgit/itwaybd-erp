# Advanced Dashboard Setup Guide

## Overview

The new advanced dashboard provides comprehensive management views for different departments with role-based access control. The dashboard includes four main sections:

1. **Sales Management** - Lead tracking, sales performance, and task management
2. **Technology Management** - Project tracking, ticket management, and developer performance
3. **HR Management** - Task management for HR department
4. **Finance Management** - Receivables, payments, and financial task tracking

## Features

### Sales Management Dashboard
- **Lead Tracking**: Today's leads, monthly leads, follow-ups, meetings, quotations
- **Sales Performance**: Today's sales, monthly sales, sales targets, achievements
- **Task Management**: All tasks, pending tasks, ongoing tasks, completed tasks
- **Performance Metrics**: Best seller identification, high priority leads

### Technology Management Dashboard
- **Project Management**: All projects, pending projects, ongoing projects, completed projects
- **Task Management**: All tasks, pending tasks, ongoing tasks, completed tasks, delay tasks
- **Ticket Management**: All tickets, pending tickets, completed tickets, solved tickets
- **Performance Metrics**: Best developer identification, first response tickets, delay response tickets

### HR Management Dashboard
- **Task Management**: All tasks, pending tasks, ongoing tasks, completed tasks for HR department

### Finance Management Dashboard
- **Receivables**: Today's scheduled receivables, monthly receivables, subscriber receivables
- **Payments**: Today's scheduled payments, monthly payments
- **Task Management**: All tasks, pending tasks, ongoing tasks, completed tasks for finance department

## Role-Based Access Control

The dashboard uses the existing `check_access()` function to control visibility of different sections based on user roles.

### Available Roles

1. **Sales** - Access to Sales Management dashboard
2. **team_leader** - Access to Sales Management dashboard
3. **level_1, level_2, level_3, level_4** - Access to Technology Management dashboard
4. **tx_planning** - Access to Technology Management dashboard
5. **transmission** - Access to Technology Management dashboard
6. **hr** - Access to HR Management dashboard
7. **billing_department** - Access to Finance Management dashboard
8. **admin** - Access to all dashboards

### Setting Up Role Permissions

1. **For Employees**: Update the `type` field in the `employees` table with the appropriate role(s)
   ```sql
   UPDATE employees SET type = 'Sales,team_leader' WHERE user_id = [USER_ID];
   ```

2. **Multiple Roles**: You can assign multiple roles by separating them with commas
   ```sql
   UPDATE employees SET type = 'Sales,hr,finance' WHERE user_id = [USER_ID];
   ```

3. **Admin Access**: Set `is_admin = 1` in the `users` table for full access
   ```sql
   UPDATE users SET is_admin = 1 WHERE id = [USER_ID];
   ```

## Dashboard Metrics

### Sales Metrics
- `todayLeads` - Number of leads created today
- `thisMonthLeads` - Number of leads created this month
- `todayFollowUp` - Number of pending leads created today (status = 0)
- `thisMonthFollowUp` - Number of pending leads created this month (status = 0)
- `todayMeeting` - Number of meetings scheduled for today (from meeting_times table)
- `thisMonthMeeting` - Number of meetings scheduled this month (from meeting_times table)
- `todayQuotation` - Number of confirmed leads created today (status = 1)
- `thisMonthQuotation` - Number of confirmed leads created this month (status = 1)
- `highPriorityLead` - Number of high priority leads (customer_priority = 'high')
- `todaySales` - Total sales amount for today
- `thisMonthSales` - Total sales amount for this month
- `salesTarget` - Monthly sales target (configurable)
- `salesAchievement` - Percentage of sales target achieved
- `bestSeller` - Name of the best performing sales person

### Technology Metrics
- `allProjects` - Total number of projects
- `pendingProjects` - Number of pending projects
- `ongoingProjects` - Number of ongoing projects
- `completedProjects` - Number of completed projects
- `delayTasks` - Number of overdue tasks
- `bestDeveloper` - Name of the best performing developer
- `allTickets` - Total number of support tickets
- `pendingTickets` - Number of pending tickets
- `completedTickets` - Number of completed tickets
- `solvedTickets` - Number of solved tickets
- `firstResponseTickets` - Number of tickets with first response
- `delayResponseTickets` - Number of tickets with delayed response

### HR Metrics
- `hrAllTasks` - Total number of HR tasks
- `hrPendingTasks` - Number of pending HR tasks
- `hrOngoingTasks` - Number of ongoing HR tasks
- `hrCompletedTasks` - Number of completed HR tasks

### Finance Metrics
- `todayScheduledReceivable` - Today's scheduled receivables
- `thisMonthScheduledReceivable` - This month's scheduled receivables
- `thisMonthSubscriberReceivable` - This month's subscriber receivables
- `thisMonthServiceChargeReceivable` - This month's service charge receivables
- `thisMonthProjectReceivable` - This month's project receivables
- `thisMonthYearlyRenewalReceivable` - This month's yearly renewal receivables
- `todayScheduledPayment` - Today's scheduled payments
- `thisMonthScheduledPayment` - This month's scheduled payments
- `financeAllTasks` - Total number of finance tasks
- `financePendingTasks` - Number of pending finance tasks
- `financeOngoingTasks` - Number of ongoing finance tasks
- `financeCompletedTasks` - Number of completed finance tasks

## Customization

### Adding New Metrics

1. **Add the metric calculation** in `app/Http/Controllers/Admin/DashboardController.php` in the `index()` method
2. **Add the metric display** in `resources/views/admin/pages/dashboard.blade.php`
3. **Add role-based access control** using `@if (check_access('role_name'))` directive

### Example: Adding a New Sales Metric

```php
// In DashboardController.php
$newMetric = SomeModel::where('condition', 'value')->count();

// In dashboard.blade.php
@if (check_access('Sales'))
<div class="metric-card">
    <div class="metric-icon sales-gradient">
        <i data-feather="icon-name"></i>
    </div>
    <div class="metric-label">New Metric</div>
    <div class="metric-value">{{ $newMetric }}</div>
</div>
@endif
```

### Styling Customization

The dashboard uses CSS classes for styling:
- `.sales-gradient` - Sales section gradient
- `.tech-gradient` - Technology section gradient
- `.hr-gradient` - HR section gradient
- `.finance-gradient` - Finance section gradient
- `.metric-card` - Individual metric card styling
- `.section-header` - Section header styling

## Database Requirements

The dashboard requires the following models and their corresponding database tables:

1. **LeadGeneration** - For lead tracking
2. **BandwidthSaleInvoice** - For sales tracking
3. **Task** - For task management
4. **SupportTicket** - For ticket management
5. **AccountTransaction** - For financial tracking
6. **Employee** - For role-based access control
7. **User** - For user management

## Troubleshooting

### Common Issues

1. **Metrics showing 0 or null values**
   - Check if the required database tables exist
   - Verify that the model relationships are correctly set up
   - Ensure the date fields are in the correct format

2. **Role-based access not working**
   - Verify the `type` field in the `employees` table contains the correct role names
   - Check that the `check_access()` function is working properly
   - Ensure the user has the correct employee record

3. **Dashboard not loading**
   - Check for any PHP errors in the logs
   - Verify all required models are imported in the controller
   - Ensure the view file exists and is properly formatted

### Performance Optimization

1. **Database Queries**: The dashboard makes multiple database queries. Consider:
   - Adding database indexes on frequently queried fields
   - Using eager loading for relationships
   - Implementing caching for static data

2. **Caching**: Consider implementing caching for:
   - Monthly metrics that don't change frequently
   - User role information
   - Static configuration data

## Support

For technical support or questions about the dashboard implementation, please refer to:
- The main application documentation
- Database schema documentation
- Role management system documentation 
