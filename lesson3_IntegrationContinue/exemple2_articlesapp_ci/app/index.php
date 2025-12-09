<?php
/**
 * Articles Application - Main Entry Point
 */
header('Content-Type: application/json');

class ArticlesApp {
    private $articles = [];
    private static $instance = null;
    
    private function __construct() {
        // Initialize with sample articles
        $this->articles = [
            ['id' => 1, 'title' => 'First Article', 'content' => 'Content 1'],
            ['id' => 2, 'title' => 'Second Article', 'content' => 'Content 2']
        ];
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getAllArticles() {
        return $this->articles;
    }
    
    public function getArticle($id) {
        foreach ($this->articles as $article) {
            if ($article['id'] == $id) {
                return $article;
            }
        }
        return null;
    }
    
    public function addArticle($title, $content) {
        $newArticle = [
            'id' => count($this->articles) + 1,
            'title' => $title,
            'content' => $content
        ];
        $this->articles[] = $newArticle;
        return $newArticle;
    }
    
    public function deleteArticle($id) {
        foreach ($this->articles as $key => $article) {
            if ($article['id'] == $id) {
                array_splice($this->articles, $key, 1);
                return true;
            }
        }
        return false;
    }
}

// Handle API requests
$app = ArticlesApp::getInstance();

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($app->getArticle($_GET['id']));
        } else {
            echo json_encode($app->getAllArticles());
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($app->addArticle($data['title'], $data['content']));
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            echo json_encode(['deleted' => $app->deleteArticle($_GET['id'])]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}
?>