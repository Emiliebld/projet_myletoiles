<?php


class FormToDB extends Database {
    protected string $method = 'POST' | 'GET';
    protected array $data = [];
    protected array $defaultClass = [
        'input' => 'form-control',
        'check' => 'form-check-input',
        'error' => 'form-control is-invalid alert-danger',
        'label' => 'form-label',
        'div' => 'mb-3 row',
        'divCheck' => 'mb-3 form-check',
        'btn' => 'btn btn-success',
    ];
    protected int $defaultFileSize = 3000000; 
    protected array $defaultFileExtension = ['jpg','gif','png','jpeg'];
    protected array $input = [];    
    protected string $classForm = "form-group";

    public function __construct(?array $data=[], ?array $input = [], ?string $method = 'POST' , ?string $classForm = "form-group"){
        $this->method = $method;
        if(!empty($input)){
            $this->input = $input;
        }
        if(isset($classForm) && !empty($classForm)){
            $this->classForm = $classForm;
        }
        if(!empty($data)){
            $this->data = $data;
        }
    }
    
    // permet de generer les attribut de base pour chaque input (name type label id)
    protected function updateInputStructure()
    {
        $inputFormated = [];
        foreach($this->input as $inputK => $inputV){
            if(is_int($inputK) || !isset($inputV['type']) || !isset($inputV['name']) || !isset($inputV['label']) || !isset($inputV['id'])){
                if(isset($inputV['name'])){
                    $name = $inputV['name'];
                } else if (is_int($inputK)){
                    $name = $inputV;
                } else {
                    $name = $inputK;
                }
                $type = isset($inputV['type']) ? $inputV['type'] : 'text';
                $label = isset($inputV['label']) ? $inputV['label'] : ucfirst($name);
                $id = isset($inputV['id']) ? $inputV['id'] : $name;
                
                $inputFormated[$name] = [
                    "type" => $type,
                    "name" => $name,
                    "label" => $label,
                    "id" => $id,
                ];
                if(is_array($inputV)){
                    $inputFormated[$name] = [...$inputFormated[$name],...$inputV];
                }
            } else {
               $inputFormated[$inputK]= $inputV; 
            }
        }
        $this->input = $inputFormated;
    }

    // function qui permet 
    // soit de generer et d'afficher le formulaire
    // soit d'executer la function de success
    public function formulaire(){
        $this->updateInputStructure();
        $this->clearError();
        $this->setValue();
        $this->checkValueLength();
        $this->checkFileError();
        $this->uploadFile();
        if($this->isValid()){
            return $this->success(); 
        } else {
            $enctype= $this->haveInputFile() ? 'enctype="multipart/form-data"' :'';
            
            $form = '<form method="'.$this->method.'"class="'. $this->classForm .'" action="#"' . $enctype . '>';
            foreach($this->input as $key => $value){
                $form .= $this->generate($key);
            }
            $form .= '</form>';
            return $form;
        }
    }
    
    protected function haveInputFile():bool
    {
        foreach($this->input as $input){
            if($input['type'] === 'file'){
                return true;
            }
        }
        return false;
    }
    
    protected function uploadFile()
    {
        if($this->haveInputFile()){
            foreach($_FILES as $name => $key){
                if(isset($key) && $key['error'] === 0){
                    $size = isset($this->input[$name]['fileSize']) ? $this->input[$name]['fileSize'] : $this->defaultFileSize;
                    $extensionAutorized = isset($this->input[$name]['extension']) ? $this->input[$name]['extension'] : $this->defaultFileExtension;
                    if($key['size'] <= $size ){
                        $informationImage = pathinfo($key['name']);
                        $extensionImage = $informationImage['extension'];
                        if(in_array($extensionImage, $extensionAutorized)){
                            $nameOfFile = time().rand().'.'.$extensionImage;
                            $urlFile = 'Asset/img/Upload/'. $nameOfFile;
                            move_uploaded_file($key['tmp_name'],$urlFile );
                            $this->input[$name]['value'] = $nameOfFile;
                        } else {
                            // implode=rassemble les éléments d'un tableau en une chaîne
                            $message = " Votre fichier n'est pas de type " .implode(', ', $extensionAutorized) ." !";
                            $this->createError($name, $message);
                        }
                    } else {
                        $message = " Votre fichier depasse les ". ($size/1000000) . "mo !";
                        $this->createError($name, $message);
                    }
                }
            }
        }
    }
    
    protected function createError(string $name, string $error)
    {
        if(!empty($error)){
            $this->input[$name]['error'] = $error;
        }
    }
    
    protected function createParams(?array $additionnalValue = []):array
    {
        $input = [];
        foreach($this->input as $key => $value){
            if($value['type'] !== 'submit'){
                if($value['type'] === 'password'){
                    $input[$key] = htmlentities(password_hash($value['value'],PASSWORD_DEFAULT));
                } else if($value['type'] === 'checkbox'){
                    if($value['value']){
                        $input[$key] = htmlentities($value['value']);
                    } else {
                        $input[$key] = false;
                    }
                }else {
                    $input[$key] = htmlentities($value['value']);
                }
            }
        }
        $params = [...$additionnalValue,...$input];
        return $params;
    }
    
    protected function checkFileError()
    {
        $errorFile='';
        if($this->haveInputFile()){
            foreach($this->input as $key => $value){
                if($value['type'] === 'file' && isset($_FILES[$value['name']])){
                    $fileError = $_FILES[$value['name']]['error'];
                    if(in_array($fileError, [1,2])){
                        $errorFile = 'Fichier trop volumineux';
                    } else if(in_array($fileError, [3,6,7,8])){
                        $errorFile = 'Nous avons rencontrer une erreur lors du telechargement de votre fichier';
                    } else if($fileError === 4 && $value['required'] === true ){
                        $errorFile = 'Ce champ est requis';
                    }
                    if(!empty($errorFile)){
                        $this->createError($key, $errorFile);
                    }
                }
            }
        }
           
    }

    // check if input is empty and no respect length
    protected function checkValueLength()
    {
        if(!empty($this->data)){
            foreach($this->input as $key => $value){
                if($value['type'] !== 'file'){
                    $errorValue = '';
                    if(empty($this->data[$key]) && isset($value['required']) && $value['required'] === true){
                        $errorValue = 'Ce champ est requis';
                    } else if(isset($value['minlength']) && isset($value['maxlength']) && !empty($value['minlength']) && !empty($value['maxlength'])){
                        if(strlen($this->data[$key]) < $value['minlength'] || strlen($this->data[$key]) > $value['maxlength']){
                            $errorValue = 'Veuillez entrer une valeur entre '.$value['minlength'].' et '.$value['maxlength'].' caractères';
                        }
                    } else if(isset($value['minlength']) && !empty($value['minlength'])){
                        if(strlen($this->data[$key]) < $value['minlength']){
                            $errorValue =  'Veuillez entrer une valeur supérieure à '.$value['minlength'].' caractères';
                        }
                    } else if(isset($value['maxlength']) && !empty($value['maxlength'])){
                        if(strlen($this->data[$key]) > $value['maxlength']){
                            $errorValue = 'Veuillez entrer une valeur inférieure à '.$value['maxlength'].' caractères';
                        }
                    }
                    if(!empty($errorValue)){
                        $this->createError($key, $errorValue);
                    }
                }
            }
        }
    }
    
    // Genere le code HTML pour afficher l'erreur du input
    protected function showError(string $name):string|null
    {
        $input = $this->input[$name];
        $class = isset($input['classError']) ? $input['classError'] : $this->defaultClass['error'];
        if(!empty($input['error'])){
            return '<p class="'.$class.'">'.$input['error'].'</p>';
        }
        return null;    
    }

    // verrifie si il existe une valeur dans le data et l'assigne au input
    protected function setValue()
    {
        foreach($this->input as $key => $value){
            if(isset($this->data[$key]) && !empty($this->data[$key])){
                $this->input[$key]['value'] = htmlentities($this->data[$key]);
            }
        }
    }

    // execute la function assossier au type de "input"
    protected function generate(string $name):string
    {
        $input = $this->input[$name];
        $type = $input['type'];
        
        if($type === 'select'){
            return $this->select($name);
        } else if($type === 'submit'){
            return $this->submit($name);
        } else if($type === 'textarea'){
            return $this->textarea($name);
        } else if($type === 'checkbox' || $type === 'radio'){
            return $this->radioCheck($name);
        }
        
        return $this->input($name);
    }
    
    // permet de mettre les attributs au differents input, button, textarea
    protected function addAttribut(string $name):string
    {
        $keyExclude = ['classError', 'error', 'classLabel', 'options', 'class', 'label', 'extension'];
        $result = '';
        
        foreach($this->input[$name] as $key => $value){
            if(!in_array($key, $keyExclude) && !in_array($value, [false, 'off', ''])){
                $result .= ' '.$key.'="'.$value.'"';
            }
        }
        return $result;
    }
    
    // gébère les differents label
    protected function label(string $name):string 
    {
        $input = $this->input[$name];
        $class = isset($input['classLabel']) ? $input['classLabel'] : $this->defaultClass['label'];
        $html = '<label class="'.$class.'" for="'. $input['id'] . '">'
                . $input['label'];
        $html .= isset($input['required']) ? '*' : '';
        $html .= isset($input['minlength']) && !empty($input['minlength']) && !empty($input['maxlength']) && isset($input['maxlength']) ? '('. $input['minlength'] .' à ' . $input['maxlength'] . ' caractères)' : '';
        $html .= '</label>';
        return $html;
    }

    // génère les differents input
    protected function input(string $name):string 
    {
        $input = $this->input[$name];
        $label = $this->label($name);
        $type = $input['type'];
        $htmlSuite = '';
        $class = isset($input['class']) ? $input['class'] : $this->defaultClass['input'];
        
        $html = '<div class="'.$this->defaultClass['div'].'">';
        $html .= $label;
        $html .= '<input class="' . $class . '"'.$this->addAttribut($name).">";
        $html .= $this->showError($name) . '</div>';
        
        return $html;
    }

    // génère les differents textarea
    protected function textarea(string $name):string 
    {
        $input = $this->input[$name];
        $value = isset($input['value']) ? $input['value'] : '';
        $class = isset($input['class']) ? $input['class'] : $this->defaultClass['input'];
        
        $html = '<div class="'.$this->defaultClass['div'].'">' 
                . $this->label($name) 
                . '<textarea class="' . $class . '"';
        $html .= $this->addAttribut($name);
        $html .= ">" . $value . "</textarea>"
                . $this->showError($name) . '</div>';
        return $html;
    }
    
    // génère les differents button
    protected function submit(string $name):string 
    {
        $input = $this->input[$name];
        $class = isset($input['class']) ? $input['class'] : $this->defaultClass['btn'];
        
        $html = '<div class="'.$this->defaultClass['div'].'">'
                . '<input class="' . $class . '"';
        $html .= $this->addAttribut($name);
        $html .= '></div>';
        return $html;
    }

    // génère les differents select
    protected function select(string $name):string 
    {
        $defaultMsg = "--- Selectionner une option ---";
        $input = $this->input[$name];
        $class = isset($input['class']) ? $input['class'] : $this->defaultClass['input'];
        
        $html = '<div class="'.$this->defaultClass['div'].'">' 
                . $this->label($name) 
                . '<select class="' . $class . '"';
        $html .= $this->addAttribut($name);
        $html .= '><option value="" disabled selected>'. $defaultMsg .'</option>';
        foreach($input['options'] as $key => $value){
            $html .= '<option value="'.$key.'">'.$value.'</option>';
        }
        $html .= '</select>';
        $html .= $this->showError($name) . '</div>';
        return $html;
    }
    
    // génère les input de type text et radio
    protected function radioCheck(string $name):string
    {
        $input = $this->input[$name];
        $label = $this->label($name);
        $class = isset($input['class']) ? $input['class'] : $this->defaultClass['check'];
        
        $html = '<div class="'.$this->defaultClass['divCheck'].'">';
        $html .= '<input class="' . $class . '"'.$this->addAttribut($name).">";
        $html .= $label;
        $html .= $this->showError($name) . '</div>';
        
        return $html;
    }

    // efface les valeurs dans data
    protected function clearData()
    {
        $this->data = [];
    }

    // efface les erreurs
    protected function clearError()
    {
        foreach($this->input as $key => $value){
            $this->input[$key]['error'] = '';
        }
    }

    // permet d'ajouter un input, textarea button... après l'instanciation de la class
    public function addInput(array $input)
    {
        $this->input = [...$this->input, ...$input];
    }
    
    // la function qui s'exécute si le formulaire respecte tout les critères
    protected function success()
    {
        $this->clearData();
        return "Formulaire envoyer avec succes";
    }
    
    // vérifie s'il y a des erreurs dans les inputs
    protected function haveError():bool
    {
        if(!empty($this->data)){
            foreach($this->input as $key => $value){
                if(!empty($value['error'])){
                    return true;
                }
            }
            return false;
        } 
        return true;
    }
    
    protected function checkIfGood():array
    {
        $result = [
            !$this->haveError()
        ];
        return $result;
    }

    // la function qui vérifie si le formulaire respecte tout les critères
    protected function isValid():bool
    {
        $results = $this->checkIfGood();
        foreach($results as $result){
            if($result === false){
                return false;
            }
        }
        return true;
    }
}