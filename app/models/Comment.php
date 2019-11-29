<?php
    class Comment {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        // Get User by ID
        public function getCommentsInfoByPostId($id) {
            $this->db->query('SELECT
                                users.name,
                                comments.content, posts.id AS postId,
                                users.id AS userId,
                                comments.id AS commentId,
                                posts.created_at AS postCreated,
                                users.created_at AS userCreated,
                                comments.created_at AS commentCreated
                                FROM
                                    comments
                                INNER JOIN
                                    posts
                                ON
                                    comments.post_id = posts.id
                                INNER JOIN
                                    users
                                ON
                                    comments.user_id = users.id
                                WHERE 
                                    comments.post_id = :id
                                ORDER BY comments.created_at
                                DESC;
                                ');
            
            $this->db->bind(':id', $id);

            $result = $this->db->resultSet();

            return $result;
        }

        public function addComment($data) {
            $this->db->query('INSERT INTO comments (user_id, post_id, content) VALUES (:user_id, :post_id, :content)');

            // Bind values
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':post_id', $data['post_id']);
            $this->db->bind(':content', $data['content']);

            // Execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }