# delivery-form
A test task 

PHP class Generator creates form from JSON-like specification.

Example
$form = [
      "id" => "test-form",
      "title" => "Order details",
      "needs-validation" => true,
      "action" => "php/form-handler.php",
      "formControlSet" => [
        [
            "type" => "text",
            "name" => "name",
            "title" => "Name",
            "placeholder" => "Name Surname",
            "required" => true,
            "regex" => "\S \S",
            "validationmessage" => "At least two words please"
        ],
        [
            "type" => "select",
            "name" => "country",
            "title" => "Country",
            "default" => "Select a country..",
            "validationmessage" => "Select country please",
            "required" => true,
            "data" => $countries
        ]
       ]
