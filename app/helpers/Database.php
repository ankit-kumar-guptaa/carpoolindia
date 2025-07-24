<?php
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            error_log("SQL: " . $sql);
            error_log("Params: " . print_r($params, true));
            throw new Exception("Database query failed");
        }
    }
    
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    public function insert($table, $data) {
        try {
            $keys = implode(',', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$placeholders})";
            $stmt = $this->query($sql, $data);
            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            error_log("Database insert error: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function update($table, $data, $where, $whereParams = []) {
        try {
            $setParts = [];
            foreach (array_keys($data) as $key) {
                $setParts[] = "{$key} = :{$key}";
            }
            $setClause = implode(', ', $setParts);
            
            $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
            
            // Merge data with where parameters
            $allParams = $data;
            if (is_array($whereParams)) {
                // If whereParams is indexed array, convert where clause to use positional parameters
                if (array_keys($whereParams) === range(0, count($whereParams) - 1)) {
                    // Convert named parameters in data to positional
                    $sql = "UPDATE {$table} SET ";
                    $setParts = [];
                    $positionIndex = 1;
                    $positionalParams = [];
                    
                    foreach ($data as $key => $value) {
                        $setParts[] = "{$key} = ?";
                        $positionalParams[] = $value;
                        $positionIndex++;
                    }
                    
                    $sql .= implode(', ', $setParts) . " WHERE {$where}";
                    $allParams = array_merge($positionalParams, $whereParams);
                } else {
                    // Named parameters
                    foreach ($whereParams as $key => $value) {
                        $allParams["where_{$key}"] = $value;
                    }
                    // Update where clause to use prefixed parameter names
                    $where = preg_replace_callback('/:\w+/', function($matches) {
                        return ':where_' . substr($matches[0], 1);
                    }, $where);
                    $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
                }
            }
            
            return $this->query($sql, $allParams);
        } catch (Exception $e) {
            error_log("Database update error: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function delete($table, $where, $params = []) {
        try {
            $sql = "DELETE FROM {$table} WHERE {$where}";
            return $this->query($sql, $params);
        } catch (Exception $e) {
            error_log("Database delete error: " . $e->getMessage());
            throw $e;
        }
    }
    
    // Test connection method
    public function testConnection() {
        try {
            $stmt = $this->connection->query("SELECT 1");
            return true;
        } catch (PDOException $e) {
            error_log("Database test failed: " . $e->getMessage());
            return false;
        }
    }
}
?>
