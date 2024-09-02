<?php 

declare(strict_types=1);

namespace App\Controller;

use HibouTech\Framework\Http\Response;

class PostsController
{
  public function show(int $id): Response
  {
    $content = "This is <b>post $id</b>";

    return new Response($content);
  }
}
