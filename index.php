<?php 
include dirname(__FILE__)."/php/classes.php";
$countries = json_decode(file_get_contents(dirname(__FILE__)."/json/countries.json"), true); // countries list from file

// form specification
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
        ],
        [
          "type" => "text",
          "name" => "city",
          "title" => "City",
          "placeholder" => "City",
          "required" => true,
          "validationmessage" => "Please enter city"
        ],
        [
          "type" => "text",
          "name" => "street",
          "title" => "Street",
          "placeholder" => "street",
          "required" => true,
          "validationmessage" => "Please enter street"
        ],
        [
          "type" => "text",
          "name" => "apartment",
          "title" => "Apartment №",
          "placeholder" => "Apartment №",
          "required" => false,
          "validationmessage" => "Please enter Apartment №"
        ],
        [
            "type" => "date",
            "name" => "deliverydate",
            "default" => date("m.d.Y"),
            "title" => "Delievery date",
            "required" => true,
            "validationmessage" => "Select correct date please",
        ]
      ]
    ];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/style.css">

    <title>Order details</title>
  </head>

  <body>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4"><?php echo formGenerator::generate($form) ?></div>
            <div class="col-sm-4"></div>
        </div>
        <div class="footer">
          
        </div>
    </div>
    <script src="/js/jquery-latest.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/axios.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/popups.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/script.js"></script>
  </body>
</html>
