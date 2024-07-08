<?php

namespace App\Enums\System;

enum FrontRouteNames: string
{
    case BLOG_LIST = 'blog_list';
    case BLOG_DETAILS = 'blog_details';
    case BUG_REPORT = 'bug_report';
    case COURSE_LISt = 'courses_list';
    case COURSE_DETAILS = 'course_details';
    case COURSE_ADD_TO_USER = 'course_add_to_user';
    case FRONT_INDEX = 'front_index';
    case FRONT_LEARN = 'front_learn';
    case LEARN_TASK = 'learn_task';
    case CHECK_TASK = 'check_task';
    case NEWS_LIST = 'news_list';
    case NEWS_DETAILS = 'news_details';
    case NOTIFICATIONS = 'notifications';
    case ABOUT_US = 'about_us';
    case HELP = 'help';
    case SERVICE_STATEMENT = 'service_statement';
    case PROFILE = 'profile';
    case USER_PROGRESS = 'user_progress';
    case USER_SETTINGS = 'user_settings';
    case RESET_PROGRESS = 'reset_progress';
    case SEARCH = 'search';
    case LOGIN  = 'app_login';
}
