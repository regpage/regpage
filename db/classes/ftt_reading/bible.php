<?php
/**
 * Bible::nextChapter('Мф.', '5') Установить следующую главу или книгу библии
 */

class Bible
{
  public $books;

  function __construct()
  {
    $this->books = $this->getBooks();
  }

  function get()
  {
    return $this->books;
  }

  function getNoSpace()
  {
    return $this->noSpace();
  }

  function getBooks($book='')
  {
    global $db;
    $book = $db->real_escape_string($book);
    $condition = '';
    if (!empty($book)) {
      $condition = " WHERE `book`='{$book}' " ;
    }
    $result = [];
    $res = db_query("SELECT `book`, `chapter` FROM `bible` {$condition}");
    while ($row = $res->fetch_assoc()) $result[] = [$row['book'], $row['chapter']];

    return $result;
  }

  function getBook($book)
  {
    return $this->getBooks($book);
  }

  function nextChapter($book, $chapter)
  {
    for ($i=0; $i < count($this->books); $i++) {
      if ($book === $this->books[$i][0]) {
        if ($chapter < $this->books[$i][1]) {
          return [$book, $chapter+1];
        } elseif($chapter === $this->books[$i][1]) {
          if (isset($this->books[$i+1])) {
            return [$this->books[$i+1][0], 1];
          } else {
            return [$this->books[0][0], 1];
          }
        } else {
          // error
        }
      }
    }
  }

  function noSpace()
  {
    $booksNoSpace = [];
    for ($i=0; $i < count($this->books); $i++) {
      $temp = explode(' ', $this->books[$i][0]);
      if (count($temp) > 1) {
        $elementArr = $this->books[$i];
        $elementArr[0] = implode('&nbsp', $temp);
        $booksNoSpace[] = $elementArr;
      } else {
        $booksNoSpace[] = $this->books[$i];
      }
    }
    return $booksNoSpace;
  }
}
