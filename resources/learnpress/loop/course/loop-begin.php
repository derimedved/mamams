<?php
/**
 * Template for displaying wrap start of archive course within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/loop/course/loop-begin.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();

echo apply_filters( 'learn_press_course_loop_begin', '<div class="learn-press-courses output_wrap" data-layout="'.learn_press_get_courses_layout().'">');
?>
