<?php

class Category
{
    public string $id;
    public string $name;
    public string  $color;
    public int  $timestamp;

    public function __construct(int $id, string $name, string $color, int $timestamp)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->timestamp = $timestamp;
    }

    public function getHtml()
    {
        return <<<HEREDOC
        <div class="btn m-1" style="background-color:$this->color" onclick="filterPosts('$this->name')"><i class="fas fa-filter"></i> $this->name</div>
        HEREDOC;
    }
}
