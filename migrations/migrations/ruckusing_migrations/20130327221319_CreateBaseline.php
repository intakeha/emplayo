<?php

class CreateBaseline extends Ruckusing_Migration_Base
{
    public function up()
    {
        // ci_sessions
        $ci_sessions = $this->create_table("ci_sessions", array("id"=>false));

        $ci_sessions->column("session_id", "string");
        $ci_sessions->column("ip_address", "string");
        $ci_sessions->column("user_agent", "string");
        $ci_sessions->column("last_activity", "integer");
        $ci_sessions->column("user_data", "text");

        $ci_sessions->finish();

        // company
        $company = $this->create_table("company", array("id"=>false));

        $company->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $company->column("company_name", "string");
        $company->column("company_url", "string");
        $company->column("jobs_url", "string");
        $company->column("facebook_url", "string");
        $company->column("twitter_url", "string");
        $company->column("company_logo", "string");
        $company->column("creative_logo", "string");
        $company->column("type_id", "tinyinteger");
        $company->column("pace_id", "tinyinteger");
        $company->column("lifecycle_id", "tinyinteger");
        $company->column("corp_citizenship_id", "tinyinteger");
        $company->column("update_time", "datetime");

        $company->finish();

        // company_benefits
        $company_benefits = $this->create_table("company_benefits", array("id"=>false));

        $company_benefits->column("company_id", "smallinteger");
        $company_benefits->column("benefits_id", "smallinteger");

        $company_benefits->finish();

        // company_category
        $company_category = $this->create_table("company_category", array("id"=>false));

        $company_category->column("company_id", "smallinteger");
        $company_category->column("category_id", "tinyinteger");

        $company_category->finish();

        // company_profile_pics
        $company_profile_pics = $this->create_table("company_profile_pics", array("id"=>false));

        $company_profile_pics->column("company_id", "smallinteger");
        $company_profile_pics->column("pic_shape", "tinyinteger");
        $company_profile_pics->column("file_name", "string");

        $company_profile_pics->finish();

        // company_quotes
        $company_quotes = $this->create_table("company_quotes", array("id"=>false));

        $company_quotes->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $company_quotes->column("company_id", "smallinteger");
        $company_quotes->column("tile_shape", "tinyinteger");
        $company_quotes->column("quote", "string");

        $company_quotes->finish();

        // group
        $group = $this->create_table("group", array("id"=>false));

        $group->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $group->column("name", "string");
        $group->column("description", "string");

        $group->finish();

        // login_attempts
        $login_attempts = $this->create_table("login_attempts", array("id"=>false));

        $login_attempts->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $login_attempts->column("ip_address", "binary");
        $login_attempts->column("login", "string");
        $login_attempts->column("time", "integer");

        $login_attempts->finish();

        // ref_benefits
        $ref_benefits = $this->create_table("ref_benefits", array("id"=>false));

        $ref_benefits->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_benefits->column("benefits", "string");

        $ref_benefits->finish();

        // ref_category
        $ref_category = $this->create_table("ref_category", array("id"=>false));

        $ref_category->column("category_id", "tinyinteger");
        $ref_category->column("name", "string");

        $ref_category->finish();

        // ref_city
        $ref_city = $this->create_table("ref_city", array("id"=>false));

        $ref_city->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_city->column("country_code", "string");
        $ref_city->column("city", "string");
        $ref_city->column("display_city", "string");
        $ref_city->column("region", "string");
        $ref_city->column("population", "smallinteger");
        $ref_city->column("latitude", "decimal", array('precision' => 10, 'scale' => 7));
        $ref_city->column("longitude", "decimal", array('precision' => 10, 'scale' => 7));

        $ref_city->finish();

        // ref_college
        $ref_college = $this->create_table("ref_college", array("id"=>false));

        $ref_college->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_college->column("college", "string");

        $ref_college->finish();

        // ref_communication
        $ref_communication = $this->create_table("ref_communication", array("id"=>false));

        $ref_communication->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_communication->column("communication", "string");

        $ref_communication->finish();

        // ref_corp_citizenship
        $ref_corp_citizenship = $this->create_table("ref_corp_citizenship", array("id"=>false));

        $ref_corp_citizenship->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_corp_citizenship->column("corp_citizenship", "string");

        $ref_corp_citizenship->finish();

        // ref_degree_type
        $ref_degree_type = $this->create_table("ref_degree_type", array("id"=>false));

        $ref_degree_type->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_degree_type->column("degree_type", "string");
        $ref_degree_type->column("degree_type_short", "string");

        $ref_degree_type->finish();

        // ref_environment
        $ref_environment = $this->create_table("ref_environment", array("id"=>false));

        $ref_environment->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_environment->column("environment", "string");

        $ref_environment->finish();

        // ref_leadership
        $ref_leadership = $this->create_table("ref_leadership", array("id"=>false));

        $ref_leadership->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_leadership->column("leadership", "string");

        $ref_leadership->finish();

        // ref_lifecycle
        $ref_lifecycle = $this->create_table("ref_lifecycle", array("id"=>false));

        $ref_lifecycle->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_lifecycle->column("lifecycle", "string");

        $ref_lifecycle->finish();

        // ref_major
        $ref_major = $this->create_table("ref_major", array("id"=>false));

        $ref_major->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_major->column("major", "string");
        $ref_major->column("major_category_id", "tinyinteger");

        $ref_major->finish();

        // ref_major_category
        $ref_major_category = $this->create_table("ref_major_category", array("id"=>false));

        $ref_major_category->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_major_category->column("major_category", "string");

        $ref_major_category->finish();

        // ref_motivation
        $ref_motivation = $this->create_table("ref_motivation", array("id"=>false));

        $ref_motivation->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_motivation->column("motivation", "string");

        $ref_motivation->finish();

        // ref_pace
        $ref_pace = $this->create_table("ref_pace", array("id"=>false));

        $ref_pace->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_pace->column("pace", "string");

        $ref_pace->finish();

        // ref_pic_shape
        $ref_pic_shape = $this->create_table("ref_pic_shape", array("id"=>false));

        $ref_pic_shape->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_pic_shape->column("pic_shape", "string");

        $ref_pic_shape->finish();

        // ref_promotion
        $ref_promotion = $this->create_table("ref_promotion", array("id"=>false));

        $ref_promotion->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_promotion->column("promotion", "string");

        $ref_promotion->finish();

        // ref_recognition
        $ref_recognition = $this->create_table("ref_recognition", array("id"=>false));

        $ref_recognition->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_recognition->column("recognition", "string");

        $ref_recognition->finish();

        // ref_resource
        $ref_resource = $this->create_table("ref_resource", array("id"=>false));

        $ref_resource->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_resource->column("resource", "string");

        $ref_resource->finish();

        // ref_responsibilities
        $ref_responsibilities = $this->create_table("ref_responsibilities", array("id"=>false));

        $ref_responsibilities->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_responsibilities->column("responsibilities", "string");

        $ref_responsibilities->finish();

        // ref_supervisor
        $ref_supervisor = $this->create_table("ref_supervisor", array("id"=>false));

        $ref_supervisor->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_supervisor->column("supervisor", "string");

        $ref_supervisor->finish();

        // ref_tasks
        $ref_tasks = $this->create_table("ref_tasks", array("id"=>false));

        $ref_tasks->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_tasks->column("tasks", "string");

        $ref_tasks->finish();

        // ref_traits
        $ref_traits = $this->create_table("ref_traits", array("id"=>false));

        $ref_traits->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_traits->column("traits", "string");

        $ref_traits->finish();

        // ref_travel
        $ref_travel = $this->create_table("ref_travel", array("id"=>false));

        $ref_travel->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_travel->column("travel", "string");

        $ref_travel->finish();

        // ref_type
        $ref_type = $this->create_table("ref_type", array("id"=>false));

        $ref_type->column("id", "tinyinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $ref_type->column("type", "string");

        $ref_type->finish();

        // user
        $user = $this->create_table("user", array("id"=>false));

        $user->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $user->column("ip_address", "binary");
        $user->column("username", "string");
        $user->column("password", "string");
        $user->column("salt", "string");
        $user->column("email", "string");
        $user->column("activation_code", "string");
        $user->column("forgotten_password_code", "string");
        $user->column("forgotten_password_time", "integer");
        $user->column("remember_code", "string");
        $user->column("created_on", "integer");
        $user->column("last_login", "integer");
        $user->column("active", "tinyinteger");
        $user->column("first_name", "string");
        $user->column("last_name", "string");
        $user->column("company", "string");
        $user->column("phone", "string");

        $user->finish();

        // user_benefits
        $user_benefits = $this->create_table("user_benefits", array("id"=>false));

        $user_benefits->column("user_id", "smallinteger");
        $user_benefits->column("benefits_id", "smallinteger");
        $user_benefits->column("rank", "tinyinteger");

        $user_benefits->finish();

        // user_category
        $user_category = $this->create_table("user_category", array("id"=>false));

        $user_category->column("user_id", "smallinteger");
        $user_category->column("category_id", "tinyinteger");

        $user_category->finish();

        // user_communication
        $user_communication = $this->create_table("user_communication", array("id"=>false));

        $user_communication->column("user_id", "smallinteger");
        $user_communication->column("communication_id", "tinyinteger");

        $user_communication->finish();

        // user_corp_citizenship
        $user_corp_citizenship = $this->create_table("user_corp_citizenship", array("id"=>false));

        $user_corp_citizenship->column("user_id", "smallinteger");
        $user_corp_citizenship->column("corp_citizenship_id", "tinyinteger");

        $user_corp_citizenship->finish();

        // user_education
        $user_education = $this->create_table("user_education", array("id"=>false));

        $user_education->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $user_education->column("user_id", "smallinteger");
        $user_education->column("college_id", "smallinteger");
        $user_education->column("college_name", "string");
        $user_education->column("start_date", "date");
        $user_education->column("end_date", "date");
        $user_education->column("degree_id", "tinyinteger");
        $user_education->column("major_id", "tinyinteger");

        $user_education->finish();

        // user_environment
        $user_environment = $this->create_table("user_environment", array("id"=>false));

        $user_environment->column("user_id", "smallinteger");
        $user_environment->column("environment_id", "tinyinteger");

        $user_environment->finish();

        // user_group
        $user_group = $this->create_table("user_group", array("id"=>false));

        $user_group->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $user_group->column("user_id", "smallinteger");
        $user_group->column("group_id", "smallinteger");

        $user_group->finish();

        // user_leadership
        $user_leadership = $this->create_table("user_leadership", array("id"=>false));

        $user_leadership->column("user_id", "smallinteger");
        $user_leadership->column("leadership_id", "tinyinteger");

        $user_leadership->finish();

        // user_lifecycle
        $user_lifecycle = $this->create_table("user_lifecycle", array("id"=>false));

        $user_lifecycle->column("user_id", "smallinteger");
        $user_lifecycle->column("lifecycle_id", "tinyinteger");

        $user_lifecycle->finish();

        // user_location
        $user_location = $this->create_table("user_location", array("id"=>false));

        $user_location->column("user_id", "smallinteger");
        $user_location->column("location_id", "smallinteger");

        $user_location->finish();

        // user_matches
        $user_matches = $this->create_table("user_matches", array("id"=>false));

        $user_matches->column("user_id", "smallinteger");
        $user_matches->column("company_id", "smallinteger");
        $user_matches->column("score", "decimal", array('precision' => 5, 'scale' => 2));

        $user_matches->finish();

        // user_motivation
        $user_motivation = $this->create_table("user_motivation", array("id"=>false));

        $user_motivation->column("user_id", "smallinteger");
        $user_motivation->column("motivation_id", "tinyinteger");

        $user_motivation->finish();

        // user_next
        $user_next = $this->create_table("user_next", array("id"=>false));

        $user_next->column("user_id", "smallinteger");
        $user_next->column("category_id", "tinyinteger");

        $user_next->finish();

        // user_pace
        $user_pace = $this->create_table("user_pace", array("id"=>false));

        $user_pace->column("user_id", "smallinteger");
        $user_pace->column("pace_id", "tinyinteger");

        $user_pace->finish();

        // user_promotion
        $user_promotion = $this->create_table("user_promotion", array("id"=>false));

        $user_promotion->column("user_id", "smallinteger");
        $user_promotion->column("promotion_id", "tinyinteger");
        $user_promotion->column("rank", "tinyinteger");

        $user_promotion->finish();

        // user_recognition
        $user_recognition = $this->create_table("user_recognition", array("id"=>false));

        $user_recognition->column("user_id", "smallinteger");
        $user_recognition->column("recognition_id", "tinyinteger");
        $user_recognition->column("rank", "tinyinteger");

        $user_recognition->finish();

        // user_resource
        $user_resource = $this->create_table("user_resource", array("id"=>false));

        $user_resource->column("user_id", "smallinteger");
        $user_resource->column("resource_id", "tinyinteger");
        $user_resource->column("rank", "tinyinteger");

        $user_resource->finish();

        // user_responsibilities
        $user_responsibilities = $this->create_table("user_responsibilities", array("id"=>false));

        $user_responsibilities->column("user_id", "smallinteger");
        $user_responsibilities->column("responsibilities_id", "tinyinteger");

        $user_responsibilities->finish();

        // user_supervisor
        $user_supervisor = $this->create_table("user_supervisor", array("id"=>false));

        $user_supervisor->column("user_id", "smallinteger");
        $user_supervisor->column("supervisor_id", "tinyinteger");

        $user_supervisor->finish();

        // user_tasks
        $user_tasks = $this->create_table("user_tasks", array("id"=>false));

        $user_tasks->column("user_id", "smallinteger");
        $user_tasks->column("tasks_id", "tinyinteger");
        $user_tasks->column("rank", "tinyinteger");

        $user_tasks->finish();

        // user_traits
        $user_traits = $this->create_table("user_traits", array("id"=>false));

        $user_traits->column("user_id", "smallinteger");
        $user_traits->column("traits_id", "tinyinteger");

        $user_traits->finish();

        // user_travel
        $user_travel = $this->create_table("user_travel", array("id"=>false));

        $user_travel->column("user_id", "smallinteger");
        $user_travel->column("travel_id", "tinyinteger");

        $user_travel->finish();

        // user_type
        $user_type = $this->create_table("user_type", array("id"=>false));

        $user_type->column("user_id", "smallinteger");
        $user_type->column("type_id", "tinyinteger");

        $user_type->finish();

        // user_work
        $user_work = $this->create_table("user_work", array("id"=>false));

        $user_work->column("id", "smallinteger", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true));
        $user_work->column("user_id", "smallinteger");
        $user_work->column("company_id", "smallinteger");
        $user_work->column("company_name", "string");
        $user_work->column("start_date", "date");
        $user_work->column("end_date", "date");
        $user_work->column("current", "tinyinteger");
        $user_work->column("job_type_id", "tinyinteger");
        $user_work->column("rating", "tinyinteger");

        $user_work->finish();        
    }//up()

    public function down()
    {
        $this->drop_table("ci_sessions");
        $this->drop_table("company");
        $this->drop_table("company_benefits");
        $this->drop_table("company_category");
        $this->drop_table("company_profile_pics");
        $this->drop_table("company_quotes");
        $this->drop_table("group");
        $this->drop_table("login_attempts");
        $this->drop_table("ref_benefits");
        $this->drop_table("ref_category");
        $this->drop_table("ref_city");
        $this->drop_table("ref_college");
        $this->drop_table("ref_communication");
        $this->drop_table("ref_corp_citizenship");
        $this->drop_table("ref_degree_type");
        $this->drop_table("ref_environment");
        $this->drop_table("ref_leadership");
        $this->drop_table("ref_lifecycle");
        $this->drop_table("ref_major");
        $this->drop_table("ref_major_category");
        $this->drop_table("ref_motivation");
        $this->drop_table("ref_pace");
        $this->drop_table("ref_pic_shape");
        $this->drop_table("ref_promotion");
        $this->drop_table("ref_recognition");
        $this->drop_table("ref_resource");
        $this->drop_table("ref_responsibilities");
        $this->drop_table("ref_supervisor");
        $this->drop_table("ref_tasks");
        $this->drop_table("ref_traits");
        $this->drop_table("ref_travel");
        $this->drop_table("ref_type");
        $this->drop_table("user");
        $this->drop_table("user_benefits");
        $this->drop_table("user_category");
        $this->drop_table("user_communication");
        $this->drop_table("user_corp_citizenship");
        $this->drop_table("user_education");
        $this->drop_table("user_environment");
        $this->drop_table("user_group");
        $this->drop_table("user_leadership");
        $this->drop_table("user_lifecycle");
        $this->drop_table("user_location");
        $this->drop_table("user_matches");
        $this->drop_table("user_motivation");
        $this->drop_table("user_next");
        $this->drop_table("user_pace");
        $this->drop_table("user_promotion");
        $this->drop_table("user_recognition");
        $this->drop_table("user_resource");
        $this->drop_table("user_responsibilities");
        $this->drop_table("user_supervisor");
        $this->drop_table("user_tasks");
        $this->drop_table("user_traits");
        $this->drop_table("user_travel");
        $this->drop_table("user_type");
        $this->drop_table("user_work");        
    }//down()
}
