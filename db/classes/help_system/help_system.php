<?php
/**
 * помощь
 */
class HelpSystem
{
  // BEGIN References
  static function getReferences($sortField, $sortType){
      $_sortField = db_real_escape_string($sortField);
      $_sortType = db_real_escape_string($sortType);

      $res = db_query("SELECT r.name, r.link_article, p.name as page_name,
              r.block_num, r.published, r.id, r.page, b.name as block_name, r.priority
              FROM reference_system r
              INNER JOIN page p ON p.key=r.page
              INNER JOIN reference_block b ON b.id=r.block_num
              ORDER BY $_sortField $_sortType "); // priority desc,

      $references = array();
      while($row = $res->fetch_assoc()){
          $references [] = $row;
      }

      if(count($references) > 0){
          return $references;
      }
      return null;
  }
}
