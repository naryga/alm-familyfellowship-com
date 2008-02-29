<?php
// $Id: advuser_filters.inc,v 1.1.2.1 2008/01/10 15:29:48 sign Exp $

/**
 * Return form for advuser administration filters.
 */
function advuser_filter_form() {
  $session = &$_SESSION['advuser_overview_filter'];
  $session = is_array($session) ? $session : array();
  $filters = advuser_filters();

  $i = 0;
  $form['filters'] = array(
    '#type' => 'fieldset',
    '#title' => t('Show only users where'),
    '#theme' => 'advuser_filters',
    );
  foreach ($session as $filter) {
    list($type, $value, $op, $qop) = $filter;
    // Merge an array of arrays into one if necessary.
    if ($filters[$type]['form_type'] == 'select') {
      $options = $type == 'permission' ? call_user_func_array('array_merge', $filters[$type]['options']) : $filters[$type]['options'];
      $params = array('%property' => $filters[$type]['title'] , '%value' => $options[$value]);
    } else {
      $params = array('%property' => $filters[$type]['title'] , '%value' => $value);
    }
    if ($i++ > 0) {
      $form['filters']['current'][] = array('#value' => t('<em>'.$op.'</em> where <strong>%property</strong> '.$qop.' <strong>%value</strong>', $params));
    }
    else {
      $form['filters']['current'][] = array('#value' => t('<strong>%property</strong> '.$qop.' <strong>%value</strong>', $params));
    }
  }

  foreach ($filters as $key => $filter) {
    $names[$key] = $filter['title'];
    if ($filter['form_type'] == 'select') {
      $form['filters']['status'][$key] = array(
        '#type' => 'select',
        '#options' => $filter['options'],
        );
    } elseif ($filter['form_type'] == 'textfield') {
      $form['filters']['status'][$key] = array(
        '#type' => 'textfield',
        );
    } else {
      $autocomplete = '';
      if ($filter['autocomplete']) $autocomplete = "profile/autocomplete/". $filter['autocomplete'];
      $form['filters']['status'][$key] = array(
        '#type' => $filter['type'],
        'options' => $filter['options'],
        '#autocomplete_path' => $autocomplete,
      );
    }
  }

  $form['filters']['filter'] = array(
    '#type' => 'radios',
    '#options' => $names,
    );
  $form['filters']['buttons']['submit'] = array(
    '#type' => 'submit',
    '#value' => (count($session) ? t('Refine') : t('Filter'))
    );
  if (count($session)) {
    $form['filters']['buttons']['undo'] = array(
      '#type' => 'submit',
      '#value' => t('Undo')
      );
    $form['filters']['buttons']['reset'] = array(
      '#type' => 'submit',
      '#value' => t('Reset')
      );
  }

  $form['filters']['filters_ops'] = array(
    '#type' => 'select',
    '#options' => array('and' => t('and'), 'or' => t('or'))
    );

  $form['filters']['filters_qops'] = array(
    '#type' => 'select',
    '#options' => array('=' => t('is equal'), '!=' => t('is not equal'), 'LIKE' => 'LIKE','NOT LIKE' => 'NOT LIKE', '<' => t('is lower'), '>' => t('is greater'))
    );

  return $form;
}

/**
 * Theme advuser administration filter form.
 */
function theme_advuser_filter_form($form) {
  $output = '<div id="advuser-admin-filter">';
  $output .= drupal_render($form['filters']);
  $output .= '</div>';
  $output .= drupal_render($form);
  return $output;
}

/**
 * List advuser administration filters that can be applied.
 */
function advuser_filters() {
  // Regular filters
  $filters = array();
  $options = array();
  $t_module = t('module');
  foreach (module_list() as $module) {
    if ($permissions = module_invoke($module, 'perm')) {
      asort($permissions);
      foreach ($permissions as $permission) {
        $options["$module $t_module"][$permission] = t($permission);
      }
    }
  }

  ksort($options);
  $filters['permission'] = array(
    'title' => t('permission'),
    'join' => 'LEFT JOIN {permission} p ON ur.rid = p.rid',
    'where' => " ((p.perm IS NOT NULL AND p.perm %op '%%%s%%') OR u.uid = 1) ",
    'options' => $options,
    'form_type' => 'select'
    );

  $filters['status'] = array(
    'title' => t('status'),
    'where' => 'u.status %op %d',
    'options' => array(1 => t('active'), 0 => t('blocked')),
    'form_type' => 'select'
    );

  $filters['email'] = array(
    'title' => t('E-mail'),
    'where' => 'u.mail %op "%s"',
    'form_type' => 'textfield'
    );

  $filters['uid'] = array(
    'title' => t('User Id'),
    'where' => "u.uid %op '%s'",
    'form_type' => 'textfield'
    );

  $filters['name'] = array(
    'title' => t('User Name'),
    'where' => "u.name %op '%s'",
    'form_type' => 'textfield'
    );

  $filters['user_roles'] = array(
    'title' => t('Role'),
    'where' => "ur.rid %op %d",
    'form_type' => 'select',
    'options' => user_roles()
    );
/*
  $filters['last_access'] = array(
    'title' => t('Last access'),
    'where' => "u.access %op %d",
    'form_type' => 'textfield'
    );
*/

  if (module_exists('profile')) {
    $fields = variable_get('advuser_profile_fields', ADVUSER_DEFAULT_PROFILE_FIELDS);
    if (is_array($fields)) {
      foreach ( $fields as $fid => $value) {
        if ( $value ) {
          $field = db_fetch_object(db_query('SELECT * FROM {profile_fields} WHERE fid = %d', $fid));
          $options = array();
          if ( $field->type == 'selection' ) {
            $result_v = db_query('SELECT DISTINCT * FROM {profile_values} WHERE fid = %d', $field->fid);
            while ( $value = db_fetch_object($result_v)) {
              $options[$value->value] = $value->value;
            }
          }
          if ($field->fid) {
            $autocomplete = '';
            // Regular filters
            if ($field->autocomplete) $autocomplete = $field->fid;
            $filters[$field->name] = array(
              'title' => $field->title,
              'type' => $field->type,
              'options' => $options,
              'join' => 'INNER JOIN {profile_values} '.$field->name.' ON u.uid = '.$field->name.'.uid',
              'where' => $field->name.'.fid = '.$field->fid.' AND '.$field->name.'.value %op "%s"',
              'autocomplete' => $autocomplete,
              );
          }
        }
      }
    }
  }
  return $filters;
}
/**
 * Build query for advuser administration filters based on session.
 */
function advuser_build_filter_query() {
  $filters = advuser_filters();

  // Build query
  $where = $args = $join = array();
  foreach ($_SESSION['advuser_overview_filter'] as $filter) {
    list($key, $value, $op, $qop) = $filter;
    // This checks to see if this permission filter is an enabled permission for the authenticated role.
    // If so, then all users would be listed, and we can skip adding it to the filter query.
    if ($key == 'permission') {
      $account = new stdClass();
      $account->uid = 'advuser_filter';
      $account->roles = array(DRUPAL_AUTHENTICATED_RID => 1);
      if (user_access($value, $account)) {
        continue;
      }
    }

    $where[] = $op.' '.str_replace("%op", $qop, $filters[$key]['where']);
    $args[] = $value;
    $join[] = $filters[$key]['join'];
  }
  $where = count($where) ? 'AND '. implode(' ', $where) : '';
  $join = count($join) ? ' '. implode(' ', array_unique($join)) : '';

  return array('where' => $where,
           'join' => $join,
           'args' => $args,
         );
}

/**
 * Process result from user administration filter form.
 */
function advuser_filter_form_submit($form_id, $form_values) {
  $op = $form_values['op'];
  $filters = advuser_filters();
  switch ($op) {
    case t('Filter'): case t('Refine'):
      if (isset($form_values['filter'])) {
        $filter = $form_values['filter'];
        if ($filters[$filter]['form_type'] == 'select') {
          // Merge an array of arrays into one if necessary.
          $options = $filter == 'permission' ? call_user_func_array('array_merge', $filters[$filter]['options']) : $filters[$filter]['options'];
          if (isset($options[$form_values[$filter]])) {
            $_SESSION['advuser_overview_filter'][] = array($filter, $form_values[$filter], $form_values['filters_ops'], $form_values['filters_qops']);
          }
        } else {
          if (isset($form_values[$filter])) {
            $_SESSION['advuser_overview_filter'][] = array($filter, $form_values[$filter], $form_values['filters_ops'], $form_values['filters_qops']);
          }
        }
      }
      break;
    case t('Undo'):
      array_pop($_SESSION['advuser_overview_filter']);
      break;
    case t('Reset'):
      $_SESSION['advuser_overview_filter'] = array();
      break;
    case t('Update'):
      return;
  }

  return 'admin/user/advuser';
}

/**
 * Theme user administration filter selector.
 */
function theme_advuser_filters($form) {

  $output = '<ul class="clear-block">';
  if (sizeof($form['current'])) {
    foreach (element_children($form['current']) as $key) {
      $output .= '<li>'. drupal_render($form['current'][$key]) .'</li>';
    }
  }

  $output .= '<li><dl class="multiselect">'. (sizeof($form['current']) ? '<dt><em>'. drupal_render($form['filters_ops']) .'</em> '. t('where') .'</dt>' : '') .'<dd class="a">';
  foreach (element_children($form['filter']) as $key) {
    $output .= drupal_render($form['filter'][$key]);
  }
  $output .= '</dd>';

  $output .= '<dt>'. drupal_render($form['filters_qops']) .'</dt><dd class="b">';

  foreach (element_children($form['status']) as $key) {
    $output .= drupal_render($form['status'][$key]);
  }
  $output .= '</dd>';

  $output .= '</dl>';
  $output .= '<div class="container-inline" id="advuser-admin-buttons">'. drupal_render($form['buttons']) .'</div>';
  $output .= '</li></ul>';

  return $output;
}