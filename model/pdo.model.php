<?php

/**
 * Connect or disconnect from database
 * @param $pdo : variable that will be instanciated as PDOStatement and used for queries
 * @param bool $connect : true -> connect to database, false -> disconnect from database
 */
function pdoDbConnection() {
    
    try {
        // Connect to database
        // Get db info
        require 'config/db.config.php';
         // Connect to database
        $pdo = new PDO($dsn, $user, $pwd);
        
        // Return PDOStatement
        return $pdo;
        
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
        $pdo = pdoDbConnection();

        // Execute query
        $st = $pdo->query($query);
        
        // Get result
        if ($st !== false ) { 
            $data = $st->fetchAll(); 
        } else {
            $data = NULL;
        }

        // Disconnect from database
        $pdo = null;
        
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

/**
 * Prepares a query and execute it
 * @param String $query : query text with ":argument" inside
 * @param array $arguments : arguments to be written into the query
 * @return array : data returned by database
 */
function pdoPrepareQuery(String $query, array $arguments) :array {
    
    try {
        
        // Connect to database
        $pdo = pdoDbConnection();
        
        // Prepare statement with query and params given in arguments
        $st = $pdo->prepare($query);
        
        foreach ($arguments as $param) {
            $st->bindParam($param[PDO_PARAM_ORDER_CODE], $param[PDO_PARAM_ORDER_VALUE], $param[PDO_PARAM_ORDER_TYPE]);
        }
        
        // execute prepared statement & return data
        $result = $st->execute();
        
        if ($result) {
            $return = $st->fetchAll();;
        } else {
            $return = NULL;
        }
        
        // Disconnect from database
        $pdo = null;
        
        return $return;
        
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

