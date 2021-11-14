<?php

class Post
{
    public string $id;
    public string $title;
    public string $description;
    public string $category;
    public int  $timestamp;

    public function __construct(int $id, string $title, string $description, string $category, int $timestamp)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->timestamp = $timestamp;
    }

    public function getDateAddedComment($context)
    {
        $date = date("d-m-Y", $this->timestamp);
        $time = date("h:ia", $this->timestamp);
        switch ($context) {
            case 'date':
                return "created on $date";
                break;
            case 'time':
                return "created at $date";
                break;
            case 'complete':
                return "created at $time on $date";
                break;
        }
    }

    public function getCategoryColor($incCategory)
    {
        $storedJsonData = file_get_contents('./data/categories.json');
        $storedDataArray = json_decode($storedJsonData, true);
        $color = "";
        if ($storedDataArray != null) {
            foreach ($storedDataArray as $category) {
                if ($category['name'] == $incCategory) {
                    $color = $category['color'];
                }
            }
        }
        return $color;
    }

    public function getHtml()
    {
        $addedComment = $this->getDateAddedComment('complete');
        $color = $this->getCategoryColor($this->category);
        $category = $this->category;
        return <<<HEREDOC
            <div class="post card $category" style="background-color:$color" id="post$this->id">
                <div class="card-body">
                    <div class="card-title title"><strong>$this->title</strong></div>
                    <div class="card-text description">$this->description</div>
                    <div class="card-text description"><strong>category : </strong>$this->category</div>
                    <hr>
                    <div class="buttonContainer d-flex justify-content-around">
                        <button class="btn bg-dark text-light mx-2"><i class="fas fa-glasses" title="read post" data-bs-toggle="modal" data-bs-target="#postDisplayModal" onclick="displayPost($this->id)"></i></button>
                        <button class="btn bg-dark text-light mx-2"><i class="fas fa-pencil-alt" title="edit post" data-bs-toggle="modal" data-bs-target="#postModal" onclick="populateAndDisplayPostForm($this->id)"></i></button>                        
                        <form action="./Http/Controllers/PostController.php" method="post" style="">
                            <input type="text" name="id" value="$this->id" hidden>
                            <input type="text" name="action" value="delete" hidden>
                            <button type="submit" class="btn bg-dark text-light mx-2" onclick="return confirm('Click ok to delete the post!')">
                                <i class="fas fa-trash-alt" title="delete post" ></i>
                            </button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-around">$addedComment</div>
                </div>
            </div>
        HEREDOC;
    }
}
