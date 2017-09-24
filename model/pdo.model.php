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
            $data["error"] = false;
        } else {
            $data["error"] = true;
        }

        // Disconnect from database
        $pdo = null;
        
        // Return dataset
        return $data;
    
        
    } catch (PDOException $e) {
        
        // Prepare full error message
        $errorMsg = '<p>
                        Error while executing query : <br />
                        query : ' .addslashes($query) .'<br />   
                        error : ' .addslashes($e->getMessage()) .'   
                    </p>';
        
        // Write error into db
        writeError(ERROR_CODE_PDO, $errorMsg);
        
        return array("error" => true);
    }
    
}

/**
 * Prepares a query and execute it
 * @param String $query : query text with ":argument" inside
 * @param array $arguments : arguments to be written into the query, following this pattern
 *      array(
 *          PDO_PARAM_ORDER_CODE            => ":code_param"
 *          , PDO_PARAM_ORDER_VALUE         => "param_value"
 *          , PDO_PARAM_ORDER_TYPE          => PDO::PARAM_...
 *      );
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
        if ($st->execute()) {
            $return = $st->fetchAll();
            $return["error"] = false;
        } else {
            $return = array("error" => true);
        }
        
        // Disconnect from database
        $pdo = null;
        
        return $return;
        
    } catch (PDOException $e) {
        
        // Prepare full error message
        $errorMsg = '<p>
                        Error while executing query : <br />
                        query : ' .addslashes($query) .'<br />
                        arguments : ' . addslashes(implode(' | ', $arguments)) .'<br />
                        error : ' .addslashes($e->getMessage()) .'    
                    </p>';
        
        // Write error into db
        writeError(ERROR_CODE_PDO, $errorMsg);
        
        return array("error" => true);
    }
}

