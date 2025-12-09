<?php
/**
 * Unit Tests for Article Class
 */
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Article.php';

class ArticleTest extends TestCase {
    public function testArticleCreation() {
        $article = new Article(1, 'Test Title', 'Test Content');
        
        $this->assertEquals(1, $article->getId());
        $this->assertEquals('Test Title', $article->getTitle());
        $this->assertEquals('Test Content', $article->getContent());
        $this->assertNotNull($article->getCreatedAt());
    }
    
    public function testSetters() {
        $article = new Article(1, 'Original Title', 'Original Content');
        
        $article->setTitle('New Title');
        $article->setContent('New Content');
        
        $this->assertEquals('New Title', $article->getTitle());
        $this->assertEquals('New Content', $article->getContent());
    }
    
    public function testToArray() {
        $article = new Article(1, 'Test Title', 'Test Content');
        $array = $article->toArray();
        
        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('content', $array);
        $this->assertArrayHasKey('createdAt', $array);
    }
}
?>