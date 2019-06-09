<?php

namespace Tests\Unit;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchImageTest extends TestCase
{

    public function testFindUrl()
    {
        $article = new Article();
        $article->full_content = "An article with a picture inside <img src=\"MyUrl\" /> inside";
        $this->assertEquals("MyUrl", $article->findImage());

        $article->full_content = "An article with a picture inside <img class=\"test\" src=\"MyUrl\" /> inside";
        $this->assertEquals("MyUrl", $article->findImage());

        $article->full_content = "An article with a picture inside <img
 class=\"test\"
 src=\"MyUrl\"
 /> inside";
        $this->assertEquals("MyUrl", $article->findImage());
    }

    public function testtakeFirstUrl()
    {
        $article = new Article();
        $article->full_content = "An article with a picture inside <img class=\"test\" src=\"MyFirstUrl\" /> inside <img src=\"MySecondUrl\" /> it";
        $this->assertEquals("MyFirstUrl", $article->findImage());
    }

    public function testTakeUrlFromSummaryIfAvailable()
    {
        $article = new Article();
        $article->full_content = "An article with a picture inside <img src=\"SomeWeirdPicture\" /> inside";
        $article->content = "The content from the feed with a  <img src=\"TheRightPicture\" /> inside";
        $this->assertEquals("TheRightPicture", $article->findImage());
    }
}
