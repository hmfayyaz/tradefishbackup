<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package umetric
 */

namespace Umetric\Utility;

$umetric_option = get_option('umetric_options');
$row = "row";
$cflag = 1;
$sflag = 1;
$calign = "";
$salign = "";
if (isset($umetric_option['umetric_top_header_var'])) {
  $topopt = $umetric_option['umetric_top_header_var'];
  if ($topopt == 1) {
    $row = "row";
    $cflag = 1;
    $sflag = 1;
    $calign = "text-left";
    $salign = "text-right";
  }
  if ($topopt == 2) {
    $row = "row";
    $cflag = 1;
    $sflag = 0;
    $calign = "text-left";
    $salign = "text-right";
  }
  if ($topopt == 3) {
    $row = "row";
    $cflag = 0;
    $sflag = 1;
    $calign = "text-left";
    $salign = "text-right";
  }
  if ($topopt == 4) {
    $row = "row flex-row-reverse";
    $cflag = 1;
    $sflag = 1;
    $calign = "text-right";
    $salign = "text-left";
  }
  if ($topopt == 5) {
    $row = "row flex-row-reverse";
    $cflag = 1;
    $sflag = 0;
    $calign = "text-right";
    $salign = "text-left";
  }
  if ($topopt == 6) {
    $row = "row flex-row-reverse";
    $cflag = 0;
    $sflag = 1;
    $calign = "text-right";
    $salign = "text-left";
  }
}

?>
<div class="<?php echo esc_attr($row); ?> ">

  <div class="col-lg-6 <?php echo esc_attr($calign); ?>">
    <?php
    if ($cflag == 1) {
    ?>
      <div class="top-contact">
        <ul class="list-inline">
          <li class="list-inline-item">
            <a href="mail:<?php echo esc_attr($umetric_option['email']) ?>"><i class="fa fa-envelope"></i>
              <?php echo esc_html__($umetric_option['email'], 'umetric'); ?>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="tel:<?php echo esc_attr($umetric_option['phone']); ?>"><i class="fa fa-phone"></i>
              <?php echo esc_html__($umetric_option['phone'], 'umetric'); ?>
            </a>
          </li>
        </ul>
      </div>
    <?php } ?>

  </div>


  <div class="col-lg-6  <?php echo esc_attr($salign); ?>">
    <?php
    if ($sflag == 1) {
    ?>
      <div class="top-social">
        <ul class="list-inline">
          <?php
          $data = $umetric_option['social_media_options'];
          foreach ($data as $key => $options) {
            if ($options) {
              echo '<li class="list-inline-item"><a href="' . $options . '"><i class="fab fa-' . $key . '"></i></a></li>';
            }
          }
          ?>
        </ul>
      </div>
    <?php }
    ?>
  </div>

</div>