<?php

class formGenerator {
    private static $templatesPaths = [ //templates for form elements
        "text" => "/templates/text.tmpl",
        "select" => "/templates/select.tmpl",
        "date" => "/templates/date.tmpl",
        "submit" => "/templates/submit.tmpl"
    ];

    function generate($form) {
        $templatesPaths = formGenerator::$templatesPaths;
        foreach ($templatesPaths as $key => $value) {
            $templates[$key] = file_get_contents($_SERVER['DOCUMENT_ROOT'].$value);
        }
        if(empty($form["id"])) $form["id"] = "";
        if(!isset($form["needs-validation"])) $form["needs-validation"] = true;
        $form["needs-validation"] ? $form["needs-validation"] = "needs-validation" : $form["needs-validation"] = ""; //prepare needs-validation class

        $formHeader = "<h4>".$form["title"]."</h4><form id=".$form["id"]." action='".$form["action"]."' class='".$form["needs-validation"]."' novalidate>";
        $formContent = "";
        $formSubmit = $templates["submit"];
        $formFooter = "</form>";
              
        foreach ($form["formControlSet"] as $formItem) {
            $formItem = formGenerator::checkFormItem ($formItem); //prepare formItem parameters if smth is missing
            switch ($formItem["type"]) { //handle input type specific things
                case "text":
                    $tempItem = $templates["text"];
                    $tempItem = str_replace("{PLACEHOLDER}",$formItem["placeholder"],$tempItem);
                    $tempItem = str_replace("{PATTERN}",$formItem["regex"],$tempItem);
                    break;
                case "select":
                    $tempItem = $templates["select"];
                    $options = "";
                    foreach ($formItem["data"] as $dataItem) {
                        $options.="<option value='".$dataItem["name"]."'>".$dataItem["name"]."</option>";
                    }
                    $tempItem = str_replace("{OPTIONS}",$options,$tempItem);
                    $tempItem = str_replace("{DEFAULT}",$formItem["default"],$tempItem);
                    break;
                case "date":
                    $tempItem = $templates["date"];
                    $tempItem = str_replace("{DEFAULT}",$formItem["default"],$tempItem);
                    break;
            }
            $tempItem = str_replace("{INPUTID}",$formItem["name"],$tempItem); //common template fields
            $tempItem = str_replace("{TITLE}",$formItem["title"],$tempItem);
            $tempItem = str_replace("{REQUIRED}",$formItem["required"],$tempItem);
            $tempItem = str_replace("{VALIDATIONMESSAGE}",$formItem["validationmessage"],$tempItem);
            $formContent.=$tempItem;
            $tempItem = "";
        }

        return ($formHeader.$formContent.$formSubmit.$formFooter);
    }

    function checkFormItem ($formItem) { //prepare formItem parameters if smth is missing
        if(empty($formItem["type"])) $formItem["type"] = 'text';
        if(empty($formItem["placeholder"])) $formItem["placeholder"] = '';
        if(empty($formItem["validationmessage"])) $formItem["validationmessage"] = '';
        if(empty($formItem["required"])) {
            $formItem["required"] = '';
        } else {
            $formItem["required"] = 'required';
        }
        if(empty($formItem["regex"])) $formItem["regex"] = '';
        if(empty($formItem["default"])) $formItem["default"] = '';
        if(empty($formItem["name"])) $formItem["name"] = '';
        if(empty($formItem["title"])) $formItem["title"] = '';
        if(empty($formItem["data"])) $formItem["data"] = '';
        if(empty($formItem["date"])) $formItem["date"] = '';
        return $formItem;
    }
}
 
?> 