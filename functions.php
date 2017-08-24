<?php
/**
 * Jobify Child Theme
 *
 * Place any custom functionality/code snippets here.
 *
 * @since Jobify Child 1.0.0
 */


//** Добавление поля "Зарплата" на фронтенд
add_filter( 'submit_job_form_fields', 'frontend_add_salary_field' );
function frontend_add_salary_field( $fields ) {
  $fields['job']['job_salary'] = array(
    'label'       => __( 'Зарплата (руб)', 'job_manager' ),
    'type'        => 'text',
    'required'    => false,
    'placeholder' => 'например, 25 000',
    'priority'    => 7
  );
  return $fields;
}


//** Добавление поля "Зарплата" в админ-панель
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_salary_field' );
function admin_add_salary_field( $fields ) {
  $fields['_job_salary'] = array(
    'label'       => __( 'Зарплата (руб)', 'job_manager' ),
    'type'        => 'text',
    'placeholder' => 'например, 25 000',
    'description' => 'Описание'
  );
  return $fields;
}

//** Вывод поля зарплата на фронтенд
add_action( 'single_job_listing_meta_end', 'display_job_salary_data' );
function display_job_salary_data() {
  global $post;

  $salary = get_post_meta( $post->ID, '_job_salary', true );

  if ( $salary ) {
    echo '<li>' . __( 'Зарплата: ' ) . esc_html( $salary ) . '</li>';
  }
}

//** Добавление поля "Опыт работы" на фронтенд
add_filter( 'submit_job_form_fields', 'frontend_add_experience_field' );
function frontend_add_experience_field( $fields ) {
  $fields['job']['job_experience'] = array(
    'label'       => __( 'Опыт', 'job_manager' ),
    'type'        => 'select',
    'required'    => false,
    'priority'    => 8,
    'options' => array(
                       'option1' => 'не имеет значения',  // 'value'=>'label'
                       'option2' => 'от 1 года',
                       'option3' => 'от 2-х лет',
                       'option4' => 'от 5 лет' )
  );
 
  return $fields;
}

//** Добавление поля "Образоваие" на фронтенд
add_filter( 'submit_job_form_fields', 'frontend_add_education_field' );
function frontend_add_education_field( $fields ) {
  $fields['job']['job_education'] = array(
    'label'       => __( 'Образование', 'job_manager' ),
    'type'        => 'select',
    'required'    => false,
    'priority'    => 9,
    'options' => array(
                       'option1' => 'не имеет значения', 
                       'option2' => 'высшее',
                       'option3' => 'неоконченное высшее',
                       'option4' => 'среднее специальное',
                       'option5' => 'среднее')
  );
 
  return $fields;
}

// Убрать некоторые поля из WP Job Manager
add_filter( 'submit_job_form_fields', 'remove_submit_job_form_fields', 9999999999 );
// This is your function which takes the fields, modifies them, and returns them
function remove_submit_job_form_fields( $fields ) {
    if( ! isset( $fields['company'] ) ) return $fields;
    // If phone, company_website, or company_video fields exist in company array, remove them
    if( isset( $fields['company']['company_tagline'] ) ) unset( $fields['company']['company_tagline']);
    if( isset( $fields['company']['company_twitter'] ) ) unset( $fields['company']['company_twitter']);
    if( isset( $fields['company']['company_video'] ) ) unset( $fields['company']['company_video']);
    // And return the modified fields
    return $fields;
}

// Add Underline button to the TinyMCE editor toolbar
add_filter( 'submit_job_form_wp_editor_args', 'customize_editor_toolbar' );
function customize_editor_toolbar( $args ) {
	$args['tinymce']['toolbar1'] = 'bold,italic,underline,|,bullist,numlist,|,link,unlink,|,undo,redo';
	return $args;
}

