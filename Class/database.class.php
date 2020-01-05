<?php
/**
 * CLASS "DATABASE"
 * Class for working with database data.
 * @author:Jasmin Kovačević
 * @see: Bottom of page for testing examples
 */
class Database{
    private static $instance;
    private static $connection;
    public $result;
    /**
     **** Method for connecting to the database ****
     *  @return connection to the static $connection variable 
     */
    public static function connect(){
        self::$instance = Connection::getInstance();
        self::$connection = self::$instance->getConnection();
    }
    /**
     **** Method for inserting data to the "license" table
     *  @param:
     * $name (string) - Name for new license
     * $period (int) - Period for license (in days)
     * $type (int) - Type of license
     * $creator (int) - User which is creating new license
     *  @return: 
     * "100" code - On success
     * "103" code - If insert operation failed
     */
    public function insertLicense($name, $period, $type, $creator){
        $this->name = $name;
        $this->period = $period;
        $this->type = $type;
        $this->creator = $creator;

        #Connecting to the database
        self::connect();
        #SQL Query
        $this->query = "INSERT INTO license (name, period, type_id, creator_id) VALUES ('$this->name', '$this->period', '$this->type', '$this->creator')";
        #Check if records are inserted successfully
        if(self::$connection->query($this->query)){
            #If they are inserted successfully set success code "100"
            $this->result['code'] = "100";
        }else{
            #If they are not inserted successfully set code "103"
            $this->result['code'] = "103";
        }
        #At the end return result
        return $this->result;

    }
    /**
     **** Method for upadating data inside the "license" table
     *  @param:
     * $license (int) - ID of license you want to update
     * $name (string) - New name for new license
     * $period (int) - New period for license (in days)
     * $type (int) - New type of license
     * $creator (int) - User which is editing given license
     *  @return: 
     * "100" code - On success
     * "103" code - If update operation failed
     */
    public function updateLicense($license, $name, $period, $type, $creator){
        $this->license = $license;
        $this->name = $name;
        $this->period = $period;
        $this->type = $type;
        $this->creator = $creator;

        #Connecting to the database
        self::connect();
        #SQL Query
        $this->query = "UPDATE license SET name = '$this->name', period = '$this->period', type_id = '$this->type', creator_id = '$this->creator' WHERE license_id = " . $this->license;
        #Check if records are updated successfully
        if(self::$connection->query($this->query)){
            #If they are updated successfully set success code "100"
            $this->result['code'] = "100";
        }else{
            #If they are not updated successfully set code "103"
            $this->result['code'] = "103";
        }
        #At the end return result
        return $this->result;
    }
    /**
     **** Method for deleting data inside the "license" table
     *  @param:
     * $license (int) - ID of license you want to delete
     *  @return: 
     * "100" code - On success
     * "103" code - If delete operation failed
     */
    public function deleteLicense($license){
        $this->license = $license;

        #Connecting to the database
        self::connect();
        #SQL Query
        $this->query = "DELETE FROM license WHERE license_id = " . $this->license;
        #Check if records are deleted successfully
        if(self::$connection->query($this->query)){
            #If they are deleted successfully set success code "100"
            $this->result['code'] = "100";
        }else{
            #If they are not deleted successfully set code "103"
            $this->result['code'] = "103";
        }
        #At the end return result
        return $this->result;
    }
    /**
     **** Method for selecting data inside the tables license and user
     *  @param:
     * $keyword (string) - User search value *optional
     * $type (int) - Type of license to get *optional
     *  @return: 
     * HTML output
     */
    public function showLicenses($keyword = null, $type = null){
        $this->keyword = $keyword;
        $this->type = intval($type);
        #Connecting to the database
        self::connect();
        #Building SQL query
        #Check if search keyword is set
        if($this->keyword){
            #If keyword is set check if license type is set
            if($this->type){
                #If type is set also than build query to get values by keyword and type 
                $this->query = "SELECT l.license_id AS license_id, l.name AS license_name, l.type_id, u.username AS license_creator FROM license l JOIN user u ON l.creator_id = u.user_id WHERE (u.username LIKE '$this->keyword%' OR l.name LIKE '$this->keyword%') AND l.type_id = " . $this->type;
            }else{
                #If type is not set than build query to get values by keyword
                $this->query = "SELECT l.license_id AS license_id, l.name AS license_name, u.username AS license_creator FROM license l JOIN user u ON l.creator_id = u.user_id WHERE u.username LIKE '$this->keyword%' OR l.name LIKE '$this->keyword%' ORDER BY l.license_id DESC";
            }
        #If keyword is not set than check if just type is set
        }elseif($this->type){
            #If type is set than build query to get values by type
            $this->query = "SELECT l.license_id AS license_id, l.name AS license_name, u.username AS license_creator FROM license l JOIN user u ON l.creator_id = u.user_id WHERE l.type_id = '$this->type' ORDER BY l.license_id DESC";
        }else{
            #If type is not set than build query to get all values
            $this->query = "SELECT l.license_id AS license_id, l.name AS license_name, u.username AS license_creator FROM license l JOIN user u ON l.creator_id = u.user_id ORDER BY l.license_id DESC";
        }
        $this->queryResult = self::$connection->query($this->query);
        #If we have results proceed to the output
        if($this->queryResult->num_rows > 0){
            echo "<div id='table_wrapper'>";
                echo "<table>";
                echo "<caption>LICENSES</caption>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Name</th>";
                            echo "<th>Creator name</th>";  
                            echo "<th>Edit</th>";
                            echo "<th>Delete</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
            while($this->resultRow = $this->queryResult->fetch_assoc()){
                        echo "<tr>";
                            echo "<td>" . $this->resultRow['license_name'] . "</td>";
                            echo "<td>" . $this->resultRow['license_creator'] . "</td>";
                                echo "<td><a href='update.php?license_id=" . $this->resultRow['license_id'] . "'><i class='fa fa-edit'></i></a></td>";
                                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete (" . $this->resultRow['license_name'] . ")');\" title='Delete' href='delete.php?license_id=" . $this->resultRow['license_id'] . "'><i class='fa fa-trash-o'></i></a></td>";
                        echo "<tr>";
            }
                    echo "</tbody>";
                echo "</table>";
            echo "</div>";
        }else{
            #If we don't have results output that there is no results
            echo "<div id='result'> There is no records </div>";
        }
    }
    /**
     **** Method for getting one specific row from database
     *  @param:
     * $equals (string) - $what equals to $equals
     * $value (string) - Which column to select 
     * $table (string) - From which table to select
     * $what (string) -  Where $what equals to $equals 
     *  @return: 
     * HTML output - On success
     * "103" code - Result not found
     */
    public function getRow($equals, $value, $table, $what){
        $this->table = $table;
        $this->equals = $equals;
        $this->value = $value;
        $this->what = $what;

        #Connecting to the database
        self::connect();
        #SQL Query
        $this->query = "SELECT " . $this->value . " FROM " . $this->table . " WHERE " . $this->what . " = $this->equals";
        $this->queryResult = self::$connection->query($this->query);
        #Check if we have results
        if($this->queryResult->num_rows > 0){
            $this->resultRow = $this->queryResult->fetch_assoc();
            echo $this->resultRow[$this->value];
        }else{
            return $this->result['code'] = "103";
        }
    }
    /**
     **** Method for getting all types for license from database (display inside select)
     *  @return: 
     * HTML output - On success
     * "103" code - Result not found
     */
    public function getTypes(){
         #Connecting to the database
         self::connect();
         #SQL Query
         $this->query = "SELECT type_id, type_name FROM license_type";
         $this->queryResult = self::$connection->query($this->query);
        #if we have results proceed to the output
         if($this->queryResult->num_rows > 0){
            echo "<select name='license_type'>";
            echo "<option value='' selected disabled>Select type</option>";
             while($this->resultRow = $this->queryResult->fetch_assoc()){
                echo "<option value='" . $this->resultRow['type_id'] . "'>" . $this->resultRow['type_name'] . "</option>";
            }
            echo "</select>";
         }else{
             return $this->result['code'] = "103";
         }
    }
    /**
     **** Method for getting selected type for license from database, for specific license (display inside select like selected value)
     *  @param:
     * $license (int) - ID of that specific license 
     *  @return: 
     * HTML output - On success
     * "103" code - Result not found
     */
    public function getSelectedType($license){
        $this->license = $license;

        #Connecting to the database
        self::connect();
        #SQL Query
        $this->query = "SELECT type_id, type_name FROM license_type";
        $this->queryResult = self::$connection->query($this->query);

        if($this->queryResult->num_rows > 0){
           echo "<label for='license_type'>License type</label>";
           echo "<select name='license_type'>";
           $this->query2 = "SELECT type_id FROM license WHERE license_id = " . $this->license;
           $this->queryResult2 = self::$connection->query($this->query2);
           $this->resultRow2 = $this->queryResult2->fetch_assoc(); 
            while($this->resultRow = $this->queryResult->fetch_assoc()){
                if($this->resultRow2['type_id'] === $this->resultRow['type_id']){
                    echo "<option value='" . $this->resultRow['type_id'] . "' selected>" . $this->resultRow['type_name'] . "</option>";
                }else{
                    echo "<option value='" . $this->resultRow['type_id'] . "'>" . $this->resultRow['type_name'] . "</option>";
                }
           }
           echo "</select>";
        }else{
            return $this->result['code'] = "103";
        }
    }
    /**
     **** Method for checking if license with given ID exists inside database
     *  @param:
     * $license (int) - ID of that specific license 
     *  @return: 
     * true - On success
     * false - Result not found
     */
    public function checkLicense($license){
        $this->license = $license;

        #Connecting to the database
        self::connect();
        #SQL Query
        $this->query = "SELECT license_id FROM license WHERE license_id = " . $this->license;
        $this->queryResult = self::$connection->query($this->query);
        #Check if record exists
        if($this->queryResult->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
}
/**
 * Testing passed:
 * 
 * include "connection.class.php";
 * 
 * $database = new Database;
 * 
 * var_dump($database->insertLicense("License_name", 22, 1, 1));
 * var_dump($database->updateLicense(1, "License_name_changed", 23, 2, 1));
 * var_dump($database->deleteLicense(1));
 * $database->showLicenses();
 * $database->showLicenses("License_name", null);
 * $database->showLicenses(null, 2);
 * $database->getRow(1, "name", "license", "license_id");
 * $database->getTypes();
 * $database->getSelectedType(1);
 * var_dump($database->checkLicense(1));
 */
?>