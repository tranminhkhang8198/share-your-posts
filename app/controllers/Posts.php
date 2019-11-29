<?php
    class Posts extends Controller {
        public function __construct() {
            if (!isLoggedIn()) {
                redirect('users/login');
            }

            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
            $this->commentModel = $this->model('Comment');
        }

        public function index() {
            // Get posts
            $posts = $this->postModel->getPosts();

            $data = [
                'posts' => $posts
            ];

            $this->view('posts/index', $data);
        } 

        public function add() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST array
                // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title 
                if (empty($data['title'])) {
                    $data['title_err'] = 'Please enter title';
                }

                if (empty($data['body'])) {
                    $data['body_err'] = 'Please enter body text';
                }

                // Make sure no errors
                if (empty($data['title_err']) && empty($data['body_err'])) {
                    // Validate
                    if ($this->postModel->addPost($data)) {
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    } else {
                        die('Something went wrong');
                    }

                } else {
                    $this->view('posts/add', $data);
                }

            } else {
                $data = [
                    'title' => '',
                    'body' => ''
                ];
    
                $this->view('posts/add', $data);   
            }
        }


        public function edit($id) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST array
                // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate
                if (empty($data['title'])) {
                    $data['title_err'] = 'Please enter title';
                }

                if (empty($data['body'])) {
                    $data['body_err'] = 'Please enter body text';
                }

                // Make sure no errors
                if (empty($data['title_err']) && empty($data['body_err'])) {
                    // Validate
                    if ($this->postModel->updatePost($data)) {
                        flash('post_message', 'Post Updated');
                        redirect('posts');
                    } else {
                        die('Something went wrong');
                    }

                } else {
                    $this->view('posts/edit', $data);
                }

            } else {
                // Get existing post from model
                $post = $this->postModel->getPostById($id);

                // Check for owner
                if ($post->user_id != $_SESSION['user_id']) {
                    redirect('posts');
                }

                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'body' => $post->body
                ];
    
                $this->view('posts/edit', $data);   
            }
        }

        public function delete($id) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Get existing post from model
                $post = $this->postModel->getPostById($id);

                // Check for owner
                if ($post->user_id != $_SESSION['user_id']) {
                    redirect('posts');
                }
                
                if ($this->postModel->deletePost($id)) {
                    flash('post_message', 'Post Remove');
                    redirect('posts');  
                } else {
                    die('Something went wrong');
                }
            } else {
                redirect('posts');
            }
        }


        public function show($id) {
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);
            $comments = $this->commentModel->getCommentsInfoByPostId($id);

            $data = [
                'post' => $post,
                'user' => $user,
                'comments' => $comments
            ];

            $this->view('posts/show', $data);
        }

        public function search() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $data = [
                    'search' => $_POST['search'],
                    'search_err' => ''
                ];

                // Validate title 
                if (empty($data['search'])) {
                    $data['search_err'] = 'Please enter anything to search';
                    flash('search_err_message', $data['search_err']);
                }

                // Make sure no errors
                if (empty($data['search_err'])) {
                    // Validate
                    $posts = $this->postModel->getPostsByName($data['search']);

                    if ($posts) {
                        $data['posts'] = $posts;
                    } else {
                        $data['search_err'] = 'Does not have any result match with "' . $data['search'] . '"';
                        // $data['search_err'] = 'Does not have any result match';
                        flash('search_err_message', $data['search_err']);   

                        $this->view('posts/search', $data);
                    }

                    $this->view('posts/search', $data);

                } else {
                    $this->view('posts/search', $data);
                }

            } else {
                // Init data
                $data = [
                    'search' => '',
                    'search_err' => ''
                ];

                // Load view
                $this->view('posts/search', $data);
            }
        }

        public function comment($id) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'post_id' => $id,
                    'content' => $_POST['content'],
                    'content_err' => ''
                ];

                // Validate
                if (empty($data['content'])) {
                    $data['content_err'] = 'Please enter anything to comment';
                    flash('comment_message', $data['content_err']);
                }                

                // Make sure no errors
                if (empty($data['content_err'])) {
                    // Validate
                    if ($this->commentModel->addComment($data)) {
                        flash('comment_message', 'Comment Added');
                    } else {
                        die('Something went wrong');
                    }
                }
                
                redirect('posts/show/' . $id);
                
            } else {
                redirect('posts/show/' . $id);
            }
        }
    }