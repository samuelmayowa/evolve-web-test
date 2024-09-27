<?php

class Controller
{
    private $db;

    public function __construct()
    {
        // Establish a database connection using MySQLi
        $this->db = new mysqli('localhost', 'root', '', 'hospital_appointment');

        // Check for connection errors and throw an exception if any
        if ($this->db->connect_error) {
            throw new Exception("Database connection failed: " . $this->db->connect_error);
        }
    }

    /**
     * Fetch all hospitals from the database.
     * 
     * @return array An associative array of hospitals.
     * @throws Exception If the query fails.
     */
    public function getHospitals()
    {
        $result = $this->db->query("SELECT * FROM hospitals");

        // Check for query errors
        if (!$result) {
            throw new Exception("Query failed: " . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Fetch all purposes from the database.
     * 
     * @return array An associative array of purposes.
     * @throws Exception If the query fails.
     */
    public function getPurposes()
    {
        $result = $this->db->query("SELECT * FROM purposes");

        // Check for query errors
        if (!$result) {
            throw new Exception("Query failed: " . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Close the database connection.
     */
    public function close()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}

// Usage example
try {
    $controller = new Controller();
    $hospitals = $controller->getHospitals();
    $purposes = $controller->getPurposes();
    // Use the fetched data...
} catch (Exception $e) {
    // Handle exceptions appropriately
    echo "Error: " . $e->getMessage();
} finally {
    // Ensure the controller is closed properly
    $controller->close();
}
