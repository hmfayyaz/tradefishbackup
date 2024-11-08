<?php

/**
 * Template part for displaying a post's content
 *
 * @package umetric
 */

namespace Umetric\Utility;

if (is_single()) {
	the_content(); 
	?> </div> <?php
} else {
	the_excerpt();
}
?>
