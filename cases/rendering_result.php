<?php
/**
 *
 */
class RenderingResult
{
  static function ok($case)
  {
    echo "<div>{$case} is <strong style='display: inline-block; color:lightgrey; background-color: green; border-radius: 15px; padding:4px; margin: 2px;'>OK</strong></div>";
  }
  static function failure($case, $expected, $result)
  {
    echo "<div>{$case} is <strong style='display: inline-block; color:lightgrey; background-color: red; border-radius: 15px; padding:4px;'>FAILURE</strong>";
    echo "<br>Expected:<br>{$expected};";
    echo "<br>Result: </div>";
    print_r($result);
  }
}
