<?php

class Wp_Pushpress_Model {

    function __construct() {
        
    }

    public function get_products() {
        $productsList = array();
        try {
            $params = array(
                'active' => 1
            );

            //get products object
            $productsObj = Pushpress_Product::all($params);

            foreach ($productsObj['data'] as $product) {
                //get categories
                $catId = $product->category->uuid;
                $productsList[$catId]['category_name'] = $product->category->name;

                //get products
                $productsList[$catId]['products'][$product->uuid]['slug'] = $product->slug;
                $productsList[$catId]['products'][$product->uuid]['name'] = $product->name;
                $productsList[$catId]['products'][$product->uuid]['description'] = $product->description;

                $prices = array();
                $options = $product->options;
                foreach ($options as $option) {
                    $prices[] = $option->price;
                }
                sort($prices);
                $productsList[$catId]['products'][$product->uuid]['price'] = $prices;
            }

            //get preorder
            $livePreorders = Pushpress_Preorder::all(array(
                        "closed" => 0, "completed" => 0, "cancelled" => 0
            ));
            if (count($livePreorders) > 0) {
                $client = Pushpress_Client::retrieve('self');
                $timeNow = LocalTime::toGM($client);
                foreach ($livePreorders['data'] as $product) {

                    if ($product->end_timestamp >= $timeNow) {
                        //get categories
                        $catId = 'preorder_categories_id';
                        $productsList[$catId]['category_name'] = 'Preorder';

                        //get products
                        $productsList[$catId]['products'][$product->uuid]['slug'] = $product->product->slug;
                        $productsList[$catId]['products'][$product->uuid]['name'] = $product->product->name;
                        $productsList[$catId]['products'][$product->uuid]['description'] = $product->product->description;

                        $prices = array();
                        $options = $product->product->options;
                        foreach ($options as $option) {
                            $prices[] = $option->price;
                        }
                        sort($prices);
                        $productsList[$catId]['products'][$product->uuid]['price'] = $prices;
                    }
                }
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Products. Please check with Administrator.</p>';
            return;
        }
        return $productsList;
    }

    public function get_products_by_category($category) {
        $productsList = array();
        try {
            $params = array(
                'active' => 1
            );

            //get products object
            $productsObj = Pushpress_Product::all($params);

            foreach ($productsObj['data'] as $product) {
                //get categories
                $catId = $product->category->uuid;
                if ($catId == $category) {
                    $productsList[$catId]['category_name'] = $product->category->name;

                    //get products
                    $productsList[$catId]['products'][$product->uuid]['slug'] = $product->slug;
                    $productsList[$catId]['products'][$product->uuid]['name'] = $product->name;
                    $productsList[$catId]['products'][$product->uuid]['description'] = $product->description;

                    $prices = array();
                    $options = $product->options;
                    foreach ($options as $option) {
                        $prices[] = $option->price;
                    }
                    sort($prices);
                    $productsList[$catId]['products'][$product->uuid]['price'] = $prices;
                }
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Products. Please check with Administrator.</p>';
            return;
        }
        return $productsList;
    }

    public function get_plans($atts = array()) {
        $plansList = array();
        try {

            $planType = array('R' => 'Recurring', 'N' => 'Non-Recurring', 'P' => 'Punchcards');

            $params = array(
                'active' => 1,
                'public' => 1
            );
            //get all products object
            $plans = Pushpress_Plan::all($params);
            foreach ($plans['data'] as $plan) {
                $plansList[$plan->type][$plan->uuid]['name'] = $plan->name;
                $plansList[$plan->type][$plan->uuid]['price'] = $plan->amount;
                $plansList[$plan->type][$plan->uuid]['type'] = $planType[$plan->type];
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Plans. Please check with Administrator.</p>';
            return;
        }
        return $plansList;
    }

    public function get_plans_by_id($id) {
        $plansList = array();
        try {

            $planType = array('R' => 'Recurring', 'N' => 'Non-Recurring', 'P' => 'Punchcards');

            if (!empty($id) && $this->plan_exist($id)) {
                //get all products object
                $plan = Pushpress_Plan::retrieve($id);
                $plansList[$plan->type][$plan->uuid]['name'] = $plan->name;
                $plansList[$plan->type][$plan->uuid]['price'] = $plan->amount;
                $plansList[$plan->type][$plan->uuid]['type'] = $planType[$plan->type];
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Plans. Please check with Administrator.</p>';
            return;
        }
        return $plansList;
    }

    public function get_plans_for_help() {
        $plansList = array();
        try {

            $params = array(
                'active' => 1,
                'public' => 1
            );
            //get all products object
            $plans = Pushpress_Plan::all($params);
            foreach ($plans['data'] as $plan) {
                $plansList[$plan->slug] = $plan->name;
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress information. Please check with Administrator.</p>';
            return;
        }
        return $plansList;
    }

    public function get_categories_for_help() {
        $categories = array();
        try {

            $params = array(
                'active' => 1
            );
            //get all products object
            $items = Pushpress_ProductCategories::all($params);
            foreach ($items['data'] as $item) {
                $categories[$item->uuid] = mb_convert_encoding($item->name, 'UTF-8', 'HTML-ENTITIES');
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress information. Please check with Administrator.</p>';
            return;
        }
        return $categories;
    }

    public function get_events($isEvent = "event", $atts) {
        $eventsList = array();
        try {
            $doy = date("z");
            $year = date("Y");
            if ($doy >= 365) {
                $doy = ($doy % 365);
                $year++;
            }
            $start = strtotime("today 00:00:00");
            $end = strtotime("today 00:00:00 +1 year"); // 1 year later
            $calendar = Pushpress_Calendar::all(array(
                        'active' => 1,
                        'type' => $isEvent,
                        'start_time' => $start,
                        'end_time' => $end
            ));
            foreach ($calendar['data'] as $item) {
                if (($item->doy) >= $doy) {
                    $eventsList[$item->uuid]['title'] = $item->title;
                    $eventsList[$item->uuid]['start_datetime'] = date('m/d/Y', $item->start_timestamp);
                    $eventsList[$item->uuid]['end_datetime'] = date('m/d/Y', $item->end_timestamp);
                    $eventsList[$item->uuid]['price'] = $item->price;
                }
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Events. Please check with Administrator.</p>';
            return;
        }
        return $eventsList;
    }

    public function get_event_by_id($id) {
        $eventsList = array();
        try {

            if ($this->event_exist($id)) {
                $item = Pushpress_Calendar::retrieve($id);

                $eventsList[$item->uuid]['title'] = $item->title;
                $eventsList[$item->uuid]['start_datetime'] = date('m/d/Y', $item->start_timestamp);
                $eventsList[$item->uuid]['end_datetime'] = date('m/d/Y', $item->end_timestamp);
                $eventsList[$item->uuid]['price'] = $item->price;
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Events. Please check with Administrator.</p>';
            return;
        }
        return $eventsList;
    }

    public function get_events_for_help() {
        $eventsList = array();
        try {
            $doy = date("z");
            $year = date("Y");
            if ($doy >= 365) {
                $doy = ($doy % 365);
                $year++;
            }
            $start = strtotime("today 00:00:00");
            $end = strtotime("today 00:00:00 +1 year"); // 1 year later
            $calendar = Pushpress_Calendar::all(array(
                        'active' => 1,
                        'type' => "event",
                        'start_time' => $start,
                        'end_time' => $end
            ));
            foreach ($calendar['data'] as $item) {
                if (($item->doy) >= $doy) {
                    $eventsList[$item->uuid] = $item->title;
                }
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress information. Please check with Administrator.</p>';
            return;
        }
        return $eventsList;
    }

    public function get_schedules($date, $timeNow, $atts) {
        $schedulesList = array();
        try {

            $start_dayofweek = strtotime("this week", $date);

            $doyCurrent = date("z", $start_dayofweek);

            $year = date("Y", $timeNow);
            if ($doyCurrent >= 365) {
                $doyCurrent = ($doyCurrent % 365);
                $year++;
            }
            $n = 7;
            for ($i = 0; $i < $n; $i++) {
                $doy = $doyCurrent + $i;
                $calendar = Pushpress_Calendar::all(array(
                            'active' => 1,
                            'doy' => $doy,
                            'year' => $year,
                            'type' => 'Class',
                ));

                foreach ($calendar['data'] as $item) {
                    if (($item->doy) >= $doy) {
                        $timestamp = strtotime("$year-01-01 + $doy days 00:00:00");
                        $schedulesList[$timestamp][$item->uuid]['start_timestamp'] = $item->start_timestamp;
                        $schedulesList[$timestamp][$item->uuid]['end_timestamp'] = $item->end_timestamp;
                        $schedulesList[$timestamp][$item->uuid]['title'] = $item->title;

                        $lastName = substr($item->coach_last_name, 0, 1);
                        $schedulesList[$timestamp][$item->uuid]['fullname'] = $item->coach_first_name . " " . $lastName;

                        $status = array();
                        if ($item->attendance_cap == 0 || $item->registration_count < $item->attendance_cap) {
                            $status['name'] = 'Reservation available';
                            $status['class'] = 'schedule-reservation';
                        } else {
                            $status['name'] = 'Class full';
                            $status['class'] = 'schedule-full';
                        }
                        $schedulesList[$timestamp][$item->uuid]['status'] = $status;
                    }
                }
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Schedules. Please check with Administrator.</p>';
            return;
        }
        return $schedulesList;
    }

    public function get_workout($date, $timeNow, $atts) {
        try {
            $client = Pushpress_Client::retrieve('self');
            $firtday = strtotime("last sunday this week", $date);
            $startDate = date('m/d/Y', $firtday);
            $endDate = date('m/d/Y', strtotime("next sunday", $date));
            $params = array(
                'active' => 1,
                'deleted' => 0,
                'start_date' => $startDate,
                'end_date' => $endDate
            );

            $tracks = Pushpress_Track::all();
            
            $results = array();
            foreach ($tracks['data'] as $key => $track) {
                //check public to wordpress plugin
                if($track->publish_wordpress !== 0 ){
                    $results[$key] = array(
                        'track_id' => $track->uuid,
                        'track_name' => $track->name
                    );
                    $public_setting = array(
                        'publish_day' => $track->publish_day,
                        'publish_time' => $track->publish_time
                    );

                    $params['track_id'] = $track->uuid;
                    $workouts = Pushpress_Track_Workout::all($params);
                    $results[$key]['workouts'] = $this->filter_data_by_date($workouts, $timeNow, $client, $public_setting);
                    
                }
            }            
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress Workouts. Please check with Administrator.</p>';
            return;
        }
        return $results;
    }

    private function filter_data_by_date($workouts, $timeNow, $client, $public_setting) {        
        
        $workoutList = array();
        foreach ($workouts['data'] as $item) {

            $public_day = $public_setting['publish_day'];
            $public_time = $public_setting['publish_time'];
            $workout_date_timestamp = strtotime($item->workout_date);
            $public_date_timestamp = strtotime($item->workout_date."-$public_day day +$public_time hour");
            $public_date_timestamp_not_time = strtotime($item->workout_date."-$public_day day");
            
//            if ($timeNow < LocalTime::localTimestamp($client, $item->create_timestamp)) {
            if ($timeNow < $public_date_timestamp) {
                $workoutList[$workout_date_timestamp][$item->uuid]['type'] = "";
//                $local_time = LocalTime::toGM($client, $public_date_timestamp);
                $publish = date('g:ia m/d/Y', $public_date_timestamp);                
                $workoutList[$workout_date_timestamp][$item->uuid]['description'] = "Workout will publish @" . $publish;
            } else {                
                $workoutList[$workout_date_timestamp][$item->uuid]['type'] = $item->workout_type['name'];
                $descriptionArr = preg_split("/((\r?\n)|(\r\n?))/", $item->description);
                $descriptionStr = implode("<br />", $descriptionArr);
                $workoutList[$workout_date_timestamp][$item->uuid]['name'] = null;
                $workoutList[$workout_date_timestamp][$item->uuid]['description'] = $descriptionStr;
                $workoutList[$workout_date_timestamp][$item->uuid]['public_notes'] = $item->public_notes;

                if ($item->favorite_workout) { 
                    $workoutList[$workout_date_timestamp][$item->uuid]['name'] = $item->favorite_workout->name;
                }
            }
        }
        return $workoutList;
    }

    public function get_leads() {
        $leadsList = array();
        $referral = array();
        try {

            // get integration settings
            $integration_settings = Pushpress_Client::settings('lead_capture');

            foreach ($integration_settings as $item) {
                if (is_array($item)) {
                    foreach ($item as $v) {
                        $leadsList[$v['name']] = $v['value'];
                    }
                }
            }

            $referral_sources = Pushpress_Client::referralSources();
            foreach ($referral_sources['data'] as $item) {
                $referral[] = array('id' => $item['id'], 'name' => $item['name']);
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress information. Please check with Administrator.</p>';
            return;
        }

        // default all settings
        if (!isset($leadsList['lead_page_title'])) {
            $leadsList['lead_page_title'] = "Interested?";
        }
        if (!isset($leadsList['lead_page_description']) || !strlen(trim($leadsList['lead_page_description']))) {
            $leadsList['lead_page_description'] = "Simply enter your contact information below and we'll get back to you as soon as possible with more information!";
        }
        if (!isset($leadsList['lead_page_client_objectives'])) {
            $leadsList['lead_page_client_objectives'] = array(
                "Weight Loss",
                "Athletic Performance",
                "Health Reasons",
                "Other"
            );
        }
        if (!isset($leadsList['lead_page_complete_redirect'])) {
            $leadsList['lead_page_complete_redirect'] = null;
        }
        if (!isset($leadsList['lead_page_allow_message'])) {
            $leadsList['lead_page_allow_message'] = 0;
        }
        if (!isset($leadsList['lead_page_show_client_objectives'])) {
            $leadsList['lead_page_show_client_objectives'] = 1;
        }
        if (!isset($leadsList['lead_page_show_lead_types'])) {
            $leadsList['lead_page_show_lead_types'] = 0;
        }
        if (!isset($leadsList['lead_page_show_phone'])) {
            $leadsList['lead_page_show_phone'] = 1;
        }
        if (!isset($leadsList['lead_page_show_dob'])) {
            $leadsList['lead_page_show_dob'] = 1;
        }
        if (!isset($leadsList['lead_page_show_referral_source'])) {
            $leadsList['lead_page_show_referral_source'] = 1;
        }
        if (!isset($leadsList['lead_page_show_postal'])) {
            $leadsList['lead_page_show_postal'] = 1;
        }
        if (!isset($leadsList['lead_page_phone_required'])) {
            $leadsList['lead_page_phone_required'] = 0;
        }
        if (!isset($leadsList['lead_page_dob_required'])) {
            $leadsList['lead_page_dob_required'] = 0;
        }
        if (!isset($leadsList['lead_page_postal_required'])) {
            $leadsList['lead_page_postal_required'] = 0;
        }
        if (!isset($leadsList['lead_page_referral_required'])) {
            $leadsList['lead_page_referral_required'] = 0;
        }
        if (!isset($leadsList['lead_page_preferred_comm_required'])) {
            $leadsList['lead_page_preferred_comm_required'] = 0;
        }
        if (!isset($leadsList['lead_page_message_required'])) {
            $leadsList['lead_page_message_required'] = 0;
        }


        if (!$leadsList['lead_page_show_postal']) {
            $leadsList['lead_page_postal_required'] = 0;
        }
        if (!$leadsList['lead_page_show_referral_source']) {
            $leadsList['lead_page_referral_required'] = 0;
        }
        if (!$leadsList['lead_page_show_dob']) {
            $leadsList['lead_page_dob_required'] = 0;
        }
        if (!$leadsList['lead_page_show_phone']) {
            $leadsList['lead_page_phone_required'] = 0;
        }
        if (!$leadsList['lead_page_show_referral_source']) {
            $leadsList['lead_page_referral_required'] = 0;
        }
        if (!$leadsList['lead_page_show_preferred_communication']) {
            $leadsList['lead_page_preferred_comm_required'] = 0;
        }
        if (!$leadsList['lead_page_allow_message']) {
            $leadsList['lead_page_message_required'] = 0;
        }

        $data['leads_list'] = $leadsList;
        $data['referral'] = $referral;
        return $data;
    }

    public static function check_page_slug_exist($slug) {
        global $wpdb;
        $raw = "SELECT `post_name` FROM `" . $wpdb->prefix . "posts` WHERE `post_name` = '" . $slug . "' and `post_type` = 'page'";
        $pages = $wpdb->get_row($raw, 'ARRAY_A');
        if ($pages) {
            return true;
        } else {
            return false;
        }
    }

    public function save_integration_page_status() {
        $pagesID = get_option('wp-pushpress-page-id');
        $arrayArgs = array('products' => 'product-enabled', 'plans' => 'plan-enabled', 'schedule' => 'schedule-enabled', 'workouts' => 'workout-enabled', 'leads' => 'lead-enabled');
        $result = array();
        foreach ($arrayArgs as $key => $arrayArg) {
            // feature check box available
            if (isset($_POST[$arrayArg]) && sanitize_text_field($_POST[$arrayArg]) == 'yes') {
                //enable feature option
                update_option('wp-pushpress-feature-' . $arrayArg, 'yes');
                //update post 
                $post = array(
                    'ID' => $pagesID[$key],
                    'post_status' => 'publish'
                );
                $result['result'] = wp_update_post($post);
                $result['status'] = 'yes';
            }

            if (isset($_POST[$arrayArg]) && sanitize_text_field($_POST[$arrayArg]) == 'no') {
                //disable feature option
                update_option('wp-pushpress-feature-' . $arrayArg, 'no');
                //update post 
                $post = array(
                    'ID' => $pagesID[$key],
                    'post_status' => 'private'
                );
                $result['result'] = wp_update_post($post);
                $result['status'] = 'no';
            }
        }
        echo json_encode($result);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    // get plans, events, products categories by slug
    public function get_section() {
        $results = array();
        $section = sanitize_text_field($_POST['slSection']);

        switch ($section) {
            case 'plans':

                $item = $this->get_plans_for_help();

                break;

            case 'events':

                $item = $this->get_events_for_help();

                break;
            case 'products':

                $item = $this->get_categories_for_help();

                break;
        }


        if (count($item) > 0) {
            $i = 0;
            foreach ($item as $key => $value) {
                $result[$i]['id'] = $key;
                $result[$i]['name'] = $value;
                $i = $i + 1;
            }
        } else {
            $result['result'] = 0;
        }

        echo json_encode($result);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    function event_exist($id) {
        $eventsList = array();
        try {
            $doy = date("z");
            $year = date("Y");
            if ($doy >= 365) {
                $doy = ($doy % 365);
                $year++;
            }
            $start = strtotime("today 00:00:00");
            $end = strtotime("today 00:00:00 +1 year"); // 1 year later
            $calendar = Pushpress_Calendar::all(array(
                        'active' => 1,
                        'type' => 'event',
                        'start_time' => $start,
                        'end_time' => $end
            ));
            foreach ($calendar['data'] as $item) {
                if (($item->doy) >= $doy) {
                    if ($item->uuid == $id) {
                        return TRUE;
                    }
                }
            }
        } catch (Exception $e) {
            return FALSE;
        }
        return FALSE;
    }

    public function plan_exist($id) {
        $plansList = array();
        try {

            $params = array(
                'active' => 1
            );
            //get all products object
            $plans = Pushpress_Plan::all($params);
            foreach ($plans['data'] as $plan) {
                if ($plan->slug == $id) {
                    return TRUE;
                }
            }
        } catch (Exception $e) {
            return FALSE;
        }
        return FALSE;
    }

    public function facebook_integrations() {
        try {
            // get integration settings
            $integration_settings = Pushpress_Client::settings('integration');
            $integrations = array();
            $i = array();

            foreach ($integration_settings as $item) {
                if (is_array($item)) {
                    foreach ($item as $v) {
                        $integrations[$v['name']] = $v['value'];
                    }
                }
            }

            $integrations['facebook_audience_pixel'] = base64_decode($integrations['facebook_audience_pixel']);
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress information. Please check with Administrator.</p>';
            return;
        }
        return $integrations;
    }

    public function facebook_metrics() {
        $metrics = array();
        try {
            // get settings
            $settingsObj = Pushpress_Client::settings('metrics');
            $i = array();

            foreach ($settingsObj as $item) {
                if (is_array($item)) {
                    foreach ($item as $v) {
                        $metrics[$v['name']] = $v['value'];
                    }
                }
            }
            if (!isset($metrics['average_lead_value'])) {
                $metrics['average_lead_value'] = 0;
            }
        } catch (Exception $e) {
            echo '<p>Could not show the pushpress information. Please check with Administrator.</p>';
            return;
        }
        return $metrics;
    }

}
