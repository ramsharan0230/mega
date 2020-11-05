<?php

namespace App\ViewComposer;

use App\Models\Dashboard;
use App\Models\Page;
use App\Repositories\Academic\AcademicRepository;
use App\Repositories\Branch\BranchRepository;
use Illuminate\View\View;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\DateTime\DateTimeRepository;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\Proficiency\ProficiencyRepository;
use App\Repositories\Scholarship\ScholarshipRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Year\YearRepository;

class ViewComposer
{
    private $setting;
    private $page;

    public function __construct(Dashboard $setting, Page $page, CategoryRepository $category, ExhibitorRepository $exhibitor, YearRepository $year, AcademicRepository $academic, ProficiencyRepository $proficiency, DateTimeRepository $datetime, ScholarshipRepository $scholarship, UserRepository $user, CountryRepository $country, BranchRepository $branch)
    {
        $this->setting = $setting;
        $this->page = $page;
        $this->category = $category;
        $this->exhibitor = $exhibitor;
        $this->year = $year;
        $this->academic = $academic;
        $this->proficiency = $proficiency;
        $this->datetime = $datetime;
        $this->scholarship = $scholarship;
        $this->user = $user;
        $this->country = $country;
        $this->branch = $branch;
    }
    public function compose(View $view)
    {
        // dd(date('H:i'), date('Y-m-d'));
        // dd('09:00' > date('H:i'));
        $settings = $this->setting->first();
        $allPages = $this->page->get();
        $exhibitors = $this->exhibitor->with(['scholarships', 'institutions'])->get();
        $passed_years = $this->year->latest()->where('publish', 1)->get();
        $academics = $this->academic->latest()->where('publish', 1)->get();
        $proficiens = $this->proficiency->where('publish', 1)->get();
        $datetimes = $this->datetime->latest()->where('publish', 1)->where('isAvailable', 1)->get();
        $allCategories = $this->category->latest()->with(['exhibitors'])->where('publish', 1)->get();
        $allScholarships = $this->scholarship->latest()->where('publish', 1)->where('type', 'scholarship')->get();
        $allInstitutions = $this->scholarship->latest()->where('publish', 1)->where('type', 'institution')->get();
        $allAdminUsers = $this->user->latest()->where('publish', 1)->where('role', 'admin')->get();
        $allExhibitorUsers = $this->user->with(['exhibitor'])->latest()->where('publish', 1)->where('role', 'exhibitor')->get();
        $allCustomers = $this->user->latest()->where('publish', 1)->where('role', 'customer')->get();
        // latest__publish function is defined in CrudRepositiry.php
        $allCountries = $this->country->where('publish', 1)->get();

        $categories = $this->category->latest()
            ->where('publish', 1)
            ->with(['exhibitors' => function ($query) {
                $query->where('publish', 1);
            }])
            ->get();
        $random_exhibitor_categories = $this->category->latest()
            ->where('publish', 1)
            ->with(['exhibitors' => function ($query) {
                $query->where('publish', 1)->inRandomOrder();
            }])
            ->get();

        $platinum = $this->category->find(1);
        $gold = $this->category->find(2);
        $silver = $this->category->find(3);
        $association = $this->category->find(5);

        $branches = $this->branch->latest()->where('publish', 1)->get();

        $view->with([
            'dashboard_composer' => $settings,
            'dashboard_categories' => $categories,
            'dashboard_exhibitors' => $exhibitors,
            'dashboard_pages' => $allPages,
            'dashboard_years' => $passed_years,
            'dashboard_academics' => $academics,
            'dashboard_proficiens' => $proficiens,
            'dashboard_datetimes' => $datetimes,
            'dashboard_allCategories' => $allCategories,
            'dashboard_allScholarships' => $allScholarships,
            'dashboard_allInstitutions' => $allInstitutions,
            'dashboard_allAdminUsers' => $allAdminUsers,
            'dashboard_allCustomers' => $allCustomers,
            'dashboard_allExhibitorUsers' => $allExhibitorUsers,
            'dashboard_allCountries' => $allCountries,
            'dashboard_allBranches' => $branches,
            'dashboard_platinum' => $platinum,
            'dashboard_gold' => $gold,
            'dashboard_silver' => $silver,
            'dashboard_association' => $association,
            'random_exhibitor_categories' => $random_exhibitor_categories,

        ]);
    }
}
