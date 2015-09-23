<?php

su_add_api('search_all');

function su_search_all() {
    $keywords = filter_input(INPUT_POST, 'keywords');
    
    $user_query = new WP_User_Query([
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'first_name',
                'value' => $keywords,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'last_name',
                'value' => $keywords,
                'compare' => 'LIKE'
            ),
    )]);

    $school_query = new WP_Query( ['s' => $keywords, 'post_type' => 'school'] );
    
    $workshop_query = new WP_Query( ['s' => $keywords, 'post_type' => 'workshop'] );
    
    $response = [];

    // User Loop
    if (!empty($user_query->results)) {
        foreach ($user_query->results as $user) {
            $user_lite = [
                'ID' => $user->ID,
                'name' => $user->first_name . ' ' . $user->last_name,
                'avatar' => $user->avatar_url,
                'color' => get_post_meta($user->school, 'color', true),
            ];
            $response['users'][] = $user_lite;
        }
    }
    
    if ($school_query->have_posts()) {
        while ($school_query->have_posts()) {
            $school_query->the_post();
            $post_id = get_the_ID();
            $post_title = get_the_title();
            $post_lite = [
                'ID' => $post_id,
                'title' => $post_title,
                'color' => get_post_meta($post_id, 'color', true),
                'main_picture' => su_get_post_main_picture($post_id),
            ];
            $response['schools'][] = $post_lite;
        }
    }
    
    if ($workshop_query->have_posts()) {
        while ($workshop_query->have_posts()) {
            $workshop_query->the_post();
            $post_id = get_the_ID();
            $post_title = get_the_title();
            $post_lite = [
                'ID' => $post_id,
                'title' => $post_title,
                'color' => get_post_meta($post_id, 'color', true),
                'main_picture' => su_get_post_main_picture($post_id),
            ];
            $response['workshops'][] = $post_lite;
        }
    }
    
    echo json_encode($response);
    die();
}