<?php
/**
 * Рендерим список
 */
class CutString {

  static function cut ($comment, $length=70 )  {

    $comment_short;
    if (mb_strlen($comment) > 30) {
      $comment_short = iconv_substr($comment, 0, $length, 'UTF-8');
      if (mb_strlen($comment) >= $length) {
        $comment_short .= '...';
      }
    } else {
      $comment_short = $comment;
    }
    return $comment_short;
  }
}
