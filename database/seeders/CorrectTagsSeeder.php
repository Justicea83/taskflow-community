<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorrectTagsSeeder extends Seeder
{
    private array $tags = [
        ['name' => 'Admin', 'slug' => 'admin'],
        // Admin specific tags
        ['name' => 'User Management', 'slug' => 'user-management'],
        ['name' => 'Job', 'slug' => 'job'],
        ['name' => 'Organization', 'slug' => 'organization'],
        ['name' => 'Qualifications', 'slug' => 'qualifications'],
        ['name' => 'Nationalities', 'slug' => 'nationalities'],
        ['name' => 'Configuration', 'slug' => 'configuration'],
        ['name' => 'Corporate Branding', 'slug' => 'corporate-branding'],
        ['name' => 'Modules', 'slug' => 'modules'],
        ['name' => 'LDAP', 'slug' => 'ldap'],
        ['name' => 'Skills', 'slug' => 'skills'],
        ['name' => 'Education', 'slug' => 'Education'],
        ['name' => 'Licenses', 'slug' => 'licenses'],
        ['name' => 'Languages', 'slug' => 'languages'],
        ['name' => 'Membership', 'slug' => 'membership'],
        ['name' => 'Locations', 'slug' => 'locations'],
        ['name' => 'Structure', 'slug' => 'structure'],
        ['name' => 'General Information', 'slug' => 'general-information'],
        ['name' => 'Email Subscriptions', 'slug' => 'email-subscriptions'],
        ['name' => 'PIM', 'slug' => 'pim'],
        ['name' => 'Leave', 'slug' => 'leave'],
        ['name' => 'Time', 'slug' => 'time'],
        ['name' => 'Recruitment', 'slug' => 'recruitment'],
        ['name' => 'My Info', 'slug' => 'my-info'],
        ['name' => 'Performance', 'slug' => 'performance'],
        ['name' => 'Dashboard', 'slug' => 'dashboard'],
        ['name' => 'Directory', 'slug' => 'directory'],
        ['name' => 'Maintenance', 'slug' => 'maintenance'],
        ['name' => 'Payroll', 'slug' => 'payroll'],
        ['name' => 'Buzz', 'slug' => 'buzz'],
        ['name' => 'Onboarding', 'slug' => 'onboarding'],
        ['name' => 'Offboarding', 'slug' => 'offboarding'],
        ['name' => 'Job Title', 'slug' => 'job-titles'],
        ['name' => 'Pay Grades', 'slug' => 'pay-grades'],
        ['name' => 'Employment Status', 'slug' => 'employment-status'],
        ['name' => 'Job Categories', 'slug' => 'job-categories'],
        ['name' => 'Work Shifts', 'slug' => 'work-shifts'],
        ['name' => 'Optional Fields', 'slug' => 'optional-fields'],
        ['name' => 'Custom Fields', 'slug' => 'custom-fields'],
        ['name' => 'Data Import', 'slug' => 'data-import'],
        ['name' => 'Reporting Methods', 'slug' => 'reporting-methods'],
        ['name' => 'Termination Reasons', 'slug' => 'termination-reasons'],
        ['name' => 'Employee', 'slug' => 'employee'],
        ['name' => 'Reports', 'slug' => 'reports'],
        ['name' => 'Assign Leave', 'slug' => 'assign-leave'],
        ['name' => 'Leave entitlements', 'slug' => 'leave-entitlements'],
        ['name' => 'Timesheets', 'slug' => 'timesheets'],
        ['name' => 'Attendance', 'slug' => 'attendance'],
        ['name' => 'Project Info', 'slug' => 'Project Info'],
        ['name' => 'Candidate', 'slug' => 'Vacancies'],
        ['name' => 'Personal Details', 'slug' => 'personal-details'],
        ['name' => 'Contact Details', 'slug' => 'contact-details'],
        ['name' => 'Emergency Contacts', 'slug' => 'emergency-contacts'],
        ['name' => 'Dependants', 'slug' => 'dependants'],
        ['name' => 'Immigration', 'slug' => 'immigration'],
        ['name' => 'Salary', 'slug' => 'salary'],
        ['name' => 'Report To', 'slug' => 'report-to'],
        ['name' => 'KPIs', 'slug' => 'kpis'],
        ['name' => 'Appraisal', 'slug' => 'appraisal'],
        ['name' => 'Anniversary', 'slug' => 'anniversary'],
        ['name' => 'TaskflowHR', 'slug' => 'taskflowhr'],
    ];

    public function run()
    {
        foreach ($this->tags as $tag) {
            Tag::query()->firstOrCreate($tag);
        }
    }
}
