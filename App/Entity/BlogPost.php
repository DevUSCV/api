<?php

namespace App\Entity;

use JsonSerializable;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="blog_post")
 */
class BlogPost implements JsonSerializable {

    /**
     * @var integer
     *
     * @Id
     * @Column(name="blog_post_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $blog_post_id;
    
    /**
     * Many Comments have One Article.
     * @ManyToOne(targetEntity="Blog", inversedBy="post")
     * @JoinColumn(name="blog_id", referencedColumnName="blog_id")
     * @OrderBy({"create_date" = "ASC"})
     */
    protected $blog;
    
        /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $title;

        /**
     * @var string
     * @Column(type="string", length=65535)
     */
    protected $content;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $author_name;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $last_editor_name;

    /** @Column(type="datetime", name="create_date") */
    protected $create_date;

    /** @Column(type="datetime", name="last_edit_date") */
    protected $last_edit_date;
    
    /**
     * One BlogPost has Many BlogPostComment.
     * @OneToMany(targetEntity="BlogPostComment", mappedBy="blog_post")
     * @OrderBy({"create_date" = "DESC"})
     */
    private $comment;
            
    public function __construct() {
        $this->comment = new ArrayCollection();
    }

    function getBlog_post_id() {
        return $this->blog_post_id;
    }

    function getBlog() {
        return $this->blog;
    }

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
    }

    function getAuthor_name() {
        return $this->author_name;
    }

    function getLast_editor_name() {
        return $this->last_editor_name;
    }

    function getCreate_date() {
        return $this->create_date;
    }

    function getLast_edit_date() {
        return $this->last_edit_date;
    }

    function getComment() {
        return $this->comment;
    }

    function setBlog_post_id($blog_post_id) {
        $this->blog_post_id = $blog_post_id;
    }

    function setBlog($blog) {
        $this->blog = $blog;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setAuthor_name($author_name) {
        $this->author_name = $author_name;
    }

    function setLast_editor_name($last_editor_name) {
        $this->last_editor_name = $last_editor_name;
    }

    function setCreate_date($create_date) {
        $this->create_date = $create_date;
    }

    function setLast_edit_date($last_edit_date) {
        $this->last_edit_date = $last_edit_date;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

    public function getExcerpt() {
	if(strlen($this->content) > 300) {
		$excerpt   = substr($this->content, 0, 300-3);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt   = substr($excerpt, 0, $lastSpace);
		$excerpt  .= '...';
	} else {
		$excerpt = $this->content;
	}
	
	return $excerpt;
}
            
    public function jsonSerialize() {
        return array(
            'blog_post_id' => $this->blog_post_id,
            'title' => $this->title,
            'content' => $this->content,
            'author_name' => $this->author_name,
            'create_date' => $this->create_date,
            'last_editor_name' => $this->last_editor_name,
            'last_edit_date' => $this->last_edit_date,
            'comment' => $this->comment->toArray()
        );
    }
    
}
