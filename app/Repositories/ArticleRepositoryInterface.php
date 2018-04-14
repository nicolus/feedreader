<?php

namespace App\Repositories;

use App\Feed;

interface ArticleRepositoryInterface {

    public function __construct (Feed $feed);
    public function getAll();

}