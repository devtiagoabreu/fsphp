<?php

namespace Source\Models;

use Source\Core\Model;

use function League\Plates\Util\id;

class Post extends Model
{

  /** @var bool  */
  private $all;

  /**
   * Post constructor
   * @param bool $all = ignore status and post_at
   */
  public function __construct(bool $all = false)
  {
    $this->all = $all;
    parent::__construct("posts",["id"], ["title", "id", "subtitle", "content"]);
  }

  public function find(?string $terms = null, ?string $params = null, string $columns = "*"): Model
  {
    if ($this->all) {
      $terms = "status = :status AND post_at <= NOW()" . ($terms ? " AND {$terms}" : "");
      $params = "status=post" . ($params ? "&{$params}" : "");
    }
    return parent::find($terms, $params, $columns);
  }

  /**
   * @param string $uri
   * @param string $columns
   * @return null|Post
   */
  public function findByUri(string $uri, string $columns = "*"): ?Post
  {
    $find = $this->find("uri = :uri", "uri={$uri}", $columns);
    return $find->fetch();
  }

  /**
   * @return null|User
   */
  public function author(): ?User
  {
    if ($this->author){
      return (new User())->findById($this->author);
    }
    return null;    
  }

  /**
   * @return null|Category
   */
  public function category(): ?Category
  {
    if ($this->author){
      return (new Category())->findById($this->category);
    }
    return null;    
  }
}