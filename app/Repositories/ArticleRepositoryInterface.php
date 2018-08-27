<?php

namespace App\Repositories;

use App\Feed;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface {

    public function __construct (Feed $feed);
    public function getAll(): Collection;

}