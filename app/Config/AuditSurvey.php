<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AuditSurvey extends BaseConfig
{
    public $siteName    = 'Audit Survey';
    public $siteEmail   = 'silambarasan@getechsoft.com';

    public $table_groups   = 'groups';
    public $table_users   = 'users';
    public $table_users_mapping   = 'user_staffs_mapping';
    public $table_users_districts   = 'user_districts';
    public $table_survey_template   = 'survey_templates';
    public $table_survey_template_questions = 'survey_template_questions';
    public $table_survey_template_options   = 'survey_template_question_options';
    public $table_bus_companies   = 'bus_companies';
    public $table_state_master   = 'master_states';
    public $table_city_master   = 'master_cities';
    public $table_districts   = 'school_districts';
    public $table_destination   = 'school_destinations';
    public $table_bus_company   = 'bus_company_routes';
    public $table_survey   = 'surveys';
    public $table_busroute_survey   = 'surveys_bus_routes';
    public $table_survey_shift   = 'survey_shifts';
    public $table_survey_schedule   = 'survey_schedule';
    public $table_route_destination   = 'bus_route_school_destination';


    // for menus
    public $menu_users = ['SA','RTC','LTC','OAC'];
    public $menu_user_group = [];
    public $menu_invites_approvals = ['SA','RTC','RTS','LTC','LTS'];
    public $menu_survey_templates = ['SA','RTC','RTS','LTC','LTS'];
    public $menu_survey = ['SA','RTC','RTS','LTC','LTS'];
    public $menu_districts = ['SA'];
    public $menu_bus_routes = ['SA','RTC','RTS','LTC','LTS'];
    public $menu_bus_companies = ['SA'];
    public $menu_school_destination = ['SA'];
    public $menu_students = ['SA','LTC'];
    public $menu_survey_response = ['OAC','OAS'];
    public $menu_school_calender = ['OAC','OAS'];
    //survey types
    public $survey_types = [
            '' => '--Select--',
            'On-demand' => 'On-demand',
            'System Trigger' => 'System Trigger',
    ];


}