<?php

namespace Infrastructure;

class Repository
    implements
    \Application\Interfaces\UserRepository,
    \Application\Interfaces\ProductRepository,
    \Application\Interfaces\RatingRepository
{
    private $server;
    private $userName;
    private $password;
    private $database;

    public function __construct(string $server, string $userName, string $password, string $database)
    {
        $this->server = $server;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }

    // === private helper methods ===

    private function getConnection()
    {
        $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
        if (!$con) {
            die('Unable to connect to database. Error: ' . mysqli_connect_error());
        }
        return $con;
    }

    private function executeQuery($connection, $query)
    {
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query': " . $connection->error);
        }
        return $result;
    }

    private function executeStatement($connection, $query, $bindFunc)
    {
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }

    // === public methods ===

    public function getUserForId(int $id): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userName, passwordHash FROM users WHERE id = ?',
            function ($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );
        $stat->bind_result($id, $userName, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $userName, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getUserForUsername(string $userName): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userName, passwordHash FROM users WHERE userName = ?',
            function ($s) use ($userName) {
                $s->bind_param('s', $userName);
            }
        );
        $stat->bind_result($id, $userName, $passwordHash);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $userName, $passwordHash);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function createUser(string $userName, string $password): void
    {
        $con = $this->getConnection();
        $con->autocommit(false);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stat = $this->executeStatement(
            $con,
            'INSERT INTO users (userName, passwordHash) VALUES (?, ?)',
            function ($s) use ($userName, $passwordHash) {
                $s->bind_param('ss', $userName, $passwordHash);
            }
        );

        $stat->close();
        $con->commit();
        $con->close();
    }

    public function getAllProductsForFilter($searchString): array
    {
        $searchString = "%$searchString%";
        $products = [];
        $con = $this->getConnection();

        $stat = $this->executeStatement(
            $con,
            'SELECT id, name, manufacturer, description, createdBy FROM products WHERE name LIKE ? OR manufacturer LIKE ?',
            function ($s) use ($searchString) {
                $s->bind_param('ss', $searchString, $searchString);
            }
        );

        $stat->bind_result($id, $name, $manufacturer, $description, $createdBy);
        while ($stat->fetch()) {
            $products[] = new \Application\Entities\Product($id, $name, $manufacturer, $description, $createdBy);
        }

        $stat->close();
        $con->close();
        return $products;
    }


    public function getAllProductsForUserAndFilter($userId, $searchString): array
    {
        $searchString = "%$searchString%";
        $products = [];
        $con = $this->getConnection();

        $stat = $this->executeStatement(
            $con,
            'SELECT id, name, manufacturer, description, createdBy FROM products WHERE createdBy = ? AND (name LIKE ? OR manufacturer LIKE ?)',
            function ($s) use ($userId, $searchString) {
                $s->bind_param('iss', $userId, $searchString, $searchString);
            }
        );
        $stat->bind_result($id, $name, $manufacturer, $description, $createdBy);
        while ($stat->fetch()) {
            $products[] = new \Application\Entities\Product($id, $name, $manufacturer, $description, $createdBy);
        }

        $stat->close();
        $con->close();
        return $products;
    }

    public function getRatingsForProduct(int $productId): array
    {
        $ratings = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userId, productId, rating, comment, createdAt FROM ratings WHERE productId = ? ORDER BY createdAt DESC',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($id, $userId, $productId, $rating, $comment, $createdAt);
        while ($stat->fetch()) {
            $ratings[] = new \Application\Entities\Rating($id, $userId, $productId, $rating, $comment, date($createdAt));
        }
        $stat->close();
        $con->close();
        return $ratings;
    }

    public function createProduct($userId, $name, $manufacturer, $description): void
    {
        $con = $this->getConnection();
        $con->autocommit(false);

        $stat = $this->executeStatement(
            $con,
            'INSERT INTO products (name, manufacturer, description, createdBy) VALUES (?, ?, ?, ?)',
            function ($s) use ($name, $manufacturer, $description, $userId) {
                $s->bind_param('sssi', $name, $manufacturer, $description, $userId);
            }
        );

        $stat->close();
        $con->commit();
        $con->close();
    }

    public function getProductForId($productId): ?\Application\Entities\Product
    {
        $product = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, name, manufacturer, description, createdBy FROM products WHERE id = ?',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($id, $name, $manufacturer, $description, $createdBy);
        if ($stat->fetch()) {
            $product = new \Application\Entities\Product($id, $name, $manufacturer, $description, $createdBy);
        }
        $stat->close();
        $con->close();
        return $product;
    }

    public function updateProduct($id, $userId, $name, $manufacturer, $description): void
    {
        $con = $this->getConnection();
        $con->autocommit(false);

        $stat = $this->executeStatement(
            $con,
            'UPDATE products SET name = ?, manufacturer = ?, description = ? WHERE id = ? AND createdBy = ?',
            function ($s) use ($name, $manufacturer, $description, $id, $userId) {
                $s->bind_param('sssii', $name, $manufacturer, $description, $id, $userId);
            }
        );

        $stat->close();
        $con->commit();
        $con->close();
    }

    public function getRatingsForUser(int $userId): array
    {
        $ratings = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userId, productId, rating, comment, createdAt FROM ratings WHERE userId = ? ORDER BY createdAt DESC',
            function ($s) use ($userId) {
                $s->bind_param('i', $userId);
            }
        );
        $stat->bind_result($id, $userId, $productId, $rating, $comment, $createdAt);
        while ($stat->fetch()) {
            $ratings[] = new \Application\Entities\Rating($id, $userId, $productId, $rating, $comment, date($createdAt));
        }
        $stat->close();
        $con->close();
        return $ratings;
    }

    public function addRating(int $productId, int $userId, int $rating, string $comment): void
    {
        $con = $this->getConnection();
        $con->autocommit(false);

        $stat = $this->executeStatement(
            $con,
            'INSERT INTO ratings (userId, productId, rating, comment) VALUES (?, ?, ?, ?)',
            function ($s) use ($userId, $productId, $rating, $comment) {
                $s->bind_param('iiis', $userId, $productId, $rating, $comment);
            }
        );

        $stat->close();
        $con->commit();
        $con->close();
    }

    public function deleteRating($ratingId): void
    {
        $con = $this->getConnection();
        $con->autocommit(false);

        $stat = $this->executeStatement(
            $con,
            'DELETE FROM ratings WHERE id = ?',
            function ($s) use ($ratingId) {
                $s->bind_param('i', $ratingId);
            }
        );

        $stat->close();
        $con->commit();
        $con->close();
    }

    public function updateRating(int $id, int $productId, int $userId, int $rating, string $comment): void
    {
        $con = $this->getConnection();
        $con->autocommit(false);

        $stat = $this->executeStatement(
            $con,
            'UPDATE ratings SET rating = ?, comment = ? WHERE id = ? AND userId = ? AND productId = ?',
            function ($s) use ($rating, $comment, $id, $userId, $productId) {
                $s->bind_param('isiii', $rating, $comment, $id, $userId, $productId);
            }
        );

        $stat->close();
        $con->commit();
        $con->close();
    }

    public function getRatingForUserAndProduct($userId, $productId): ?\Application\Entities\Rating
    {
        $rating = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, userId, productId, rating, comment, createdAt FROM ratings WHERE userId = ? AND productId = ?',
            function ($s) use ($userId, $productId) {
                $s->bind_param('ii', $userId, $productId);
            }
        );
        $stat->bind_result($id, $userId, $productId, $rating, $comment, $createdAt);
        if ($stat->fetch()) {
            $rating = new \Application\Entities\Rating($id, $userId, $productId, $rating, $comment, date($createdAt));
        }
        $stat->close();
        $con->close();
        return $rating;
    }
}