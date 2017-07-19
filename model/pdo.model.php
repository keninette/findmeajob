<?php

/**
 * Connect or disconnect from database
 * @param PDOStatement $pdo : PDOStatement used for queries
 * @param bool $connect : true -> connect to database, false -> disconnect from database
 */
function pdoDbConnection(PDOStatement $pdo, bool $connect = true) {
    
    try {
        // Connect to database
        if ($connect) {

            // Get db info
            require_once 'config/db.config.php';
             // Connect to database
            $pdo = new PDO($dsn, $user, $pwd);

        // Disconnect from database    
        } else {
            $pdo = null;
        }
    } catch (PDOException $e) {
        echo('<p class="error">Erreur durant la connexion à la base de données : <br />' .$e->getMessage() .'</p>');
    }
    
}

/**
 * Execute simple query in database
 * @param String $query : query text
 * @return type
 */
function pdoQuery(String $query) : array {
    
    try {
        // Connect to database
        pdoDbConnection($pdo);

        // Execute query
        $data = $pdo->query($query)->fetchAll();

        // Disconnect from database
        pdoDbConnection($pdo, false);

        // Return dataset
        return $data;
    
        
    } catch (PDOException $e) {
        
        // Prepare full error message
        $errorMsg = '<p>
                        Error while executing query : <br />
                        query : ' .htmlspecialchars($query) .'<br />   
                        error : ' .htmlspecialchars($e->getMessage()) .'   
                    </p>';
        
        // Write error into db
        writeError(ERROR_CODE_PDO, $errorMsg);
        
        return [];
    }
    
}

function pdoPrepareQuery(String $query, array $arguments) :array {
    
    try {
        
        // Connect to database
        pdoDbConnection($pdo);
        
        // Prepare statement with query and params given in arguments
        $st = $pdo->prepare($query);
        
        foreach ($arguments as $param) {
            $st->bindParam($param[PDO_PARAM_ORDER_CODE], $param[PDO_PARAM_ORDER_VALUE], $param[PDO_PARAM_ORDER_TYPE]);
        }
        
        // execute prepared statement & return data
        $data = $st->execute();
        
        // Disconnect from database
        pdoDbConnection($pdo, false);
        
        return $data;
        
    } catch (PDOException $e) {
        
        // Prepare full error message
        $errorMsg = '<p>
                        Error while executing query : <br />
                        query : ' .htmlspecialchars($query) .'<br />
                        arguments : ' . htmlspecialchars(implode(' | ', $arguments)) .'<br />
                        error : ' .htmlspecialchars($e->getMessage()) .'    
                    </p>';
        
        // Write error into db
        writeError(ERROR_CODE_PDO, $errorMsg);
        
        return [];
    }
}

