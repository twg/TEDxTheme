<?php

/*
*   Used to selectivly output only child items of the current nav.
*   Taken directly from: http://wordpress.stackexchange.com/questions/2802/display-a-portion-branch-of-the-menu-tree-using-wp-nav-menu
*/

class Selective_Walker extends Walker_Nav_Menu {
  function walk ($elements, $max_depth) {

    $args   = array_slice(func_get_args(), 2);
    $output = '';

    if ($max_depth < -1) { //invalid parameter
      return $output;
    }

    if (empty($elements)) { //nothing to walk
      return $output;
    }

    $id_field     = $this->db_fields['id'];
    $parent_field = $this->db_fields['parent'];

    // flat display
    if (-1 == $max_depth) {
      $empty_array = array();
      foreach ($elements as $e) {
        $this->display_element($e, $empty_array, 1, 0, $args, $output);
      }

      return $output;
    }

    /*
     * need to display in hierarchical order
     * separate elements into two buckets: top level and children elements
     * children_elements is two dimensional array, eg.
     * children_elements[10][] contains all sub-elements whose parent is 10.
     */
    $top_level_elements = array();
    $children_elements  = array();
    foreach ($elements as $e) {
      if (0 == $e->$parent_field) {
        $top_level_elements[] = $e;
      } else {
        $children_elements[$e->$parent_field][] = $e;
      }
    }


    /*
     * when none of the elements is top level
     * assume the first one must be root of the sub elements
     */
    if (empty($top_level_elements)) {

      $first = array_slice($elements, 0, 1);
      $root  = $first[0];

      $top_level_elements = array();
      $children_elements  = array();
      foreach ($elements as $e) {
        if ($root->$parent_field == $e->$parent_field) {
          $top_level_elements[] = $e;
        } else {
          $children_elements[$e->$parent_field][] = $e;
        }
      }
    }

    $current_element_markers = array('current-menu-item', 'current-menu-parent', 'current-menu-ancestor'); //added by continent7
    foreach ($top_level_elements as $e) { //changed by continent7


      if (!is_array($e->classes)) {
        continue;
      }

      // descend only on current tree
      $descend_test = array_intersect($current_element_markers, $e->classes);
      if (!empty($descend_test)) {
        $this->display_element($e, $children_elements, 2, 0, $args, $output);
      }
    }

    /*
     * if we are displaying all levels, and remaining children_elements is not empty,
     * then we got orphans, which should be displayed regardless
     */

    /* removed by continent7
   if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
       $empty_array = array();
       foreach ( $children_elements as $orphans )
           foreach( $orphans as $op )
               $this->display_element( $op, $empty_array, 1, 0, $args, $output );
    }
   */

    return $output;
  }
}