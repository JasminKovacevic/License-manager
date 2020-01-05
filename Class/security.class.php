<?php
/**
 * CLASS "SECURITY" 
 * Class used for security reasons like checking user input
 * @author: Jasmin Kovačević
 * @see: Bottom of file for testing examples
 */
class Security{
    /**
     **** Method to clean string from unwanted characters
     *  @param:
     *  $whatToClean (String for cleaning),
     *  $fromWhatToClean (From wich characters to clean. Can be array or regular string)
     *  @return:
     *  $this->cleaned (Cleaned string)
     */
    public function cleanString($whatToClean, $fromWhatToClean){
        $this->whatToClean = $whatToClean;
        $this->fromWhatToClean = $fromWhatToClean;
        #Split string to characters
        $this->splitToClean = str_split($this->whatToClean);
        #Check if $fromWhatToClean is array
        if(is_array($this->fromWhatToClean)){
            #Loop to cycle splited characters
            for($i = 0; $i < count($this->splitToClean); $i++){
                #Loop to cycle characters from $fromWhatToClean array
                for($z = 0; $z < count($this->fromWhatToClean); $z++){
                    #If some character is equal to the character you want to clean add "\"
                    if($this->splitToClean[$i] === $this->fromWhatToClean[$z]){
                        $this->splitToClean[$i] = "\\" . $this->splitToClean[$i];
                    }elseif($this->splitToClean[$i] === "\\"){
                        $this->splitToClean[$i] = "/\\" . $this->splitToClean[$i];
                    }else{

                    }
                }
            }
        }else{
            #If not array just check string
            for($i = 0; $i < count($this->splitToClean); $i++){
                if($this->splitToClean[$i] === $this->fromWhatToClean){
                    $this->splitToClean[$i] = "\\" . $this->splitToClean[$i];
                }elseif($this->splitToClean[$i] === "\\"){
                        $this->splitToClean[$i] = "/\\" . $this->splitToClean[$i];
                    }else{
                        
                    }
            }
        }
        #Build string from array and return the result ($this->cleaned - cleaned string)
        $this->cleaned = implode($this->splitToClean);
        return $this->cleaned;
    }
}
/**
 * Testing passed:
 * 
 * $security = new Security
 * $cleanFrom = ["'", ";"];
 * echo $security->cleanString("not se'cur'e st;ring'");
 */
?>