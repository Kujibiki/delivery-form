function checkText (element) { //input type text validator
    var required = element.prop("required")
    if (required){
        passCheck = true
        var pattern = element.attr("pattern")
        var text = element.val()

        if (required && !text) passCheck = false
        if (pattern && !text.match(pattern))  passCheck = false

        if (passCheck) {
            element.addClass("is-valid")
            element.removeClass("is-invalid")
        } else {
            element.addClass("is-invalid")
            element.removeClass("is-valid")
        }
    }
    return passCheck
}

function checkSelect (element) { //input type select validator
    var required = element.prop("required")
    if (required){
        passCheck = true
        var value = element.val()
        var defaultValue = element.attr("defaultvalue")
        if (value == defaultValue) passCheck = false
        if (passCheck) {
            element.addClass("is-valid")
            element.removeClass("is-invalid")
        } else {
            element.addClass("is-invalid")
            element.removeClass("is-valid")
        }
    }
    return passCheck
}

function checkDate (element) { //input type date validator
    passCheck = true
    var date = element.val()
    var required = element.prop("required")
    //nice date regexp
    pattern = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/
    if (required && !date) passCheck = false
    if (!date.match(pattern)) passCheck = false

    if (passCheck) {
        element.addClass("is-valid")
        element.removeClass("is-invalid")
    } else {
        element.addClass("is-invalid")
        element.removeClass("is-valid")
    }
    return passCheck
}

$(document).ready(function(){ //after page load
    var forms = document.querySelectorAll('form') //get all forms
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) { //prevent default submit
            event.preventDefault()
            event.stopPropagation() 
            if($(form).hasClass("needs-validation")) { //handle validation if needed
                validated = true
                $(form).find("[type='text']").each(function(){
                    if(!checkText($(this))) validated = false
                });
                $(form).find("select").each(function(){
                    if(!checkSelect($(this))) validated = false
                });
                $(form).find("[type='textdate']").each(function(){
                    if(!checkDate($(this))) validated = false
                });
                if (!validated) return
            } 

            $(form).find("button").prop("disabled", true) //disable submit button
            buttonText = $(form).find("button").html()
            $(form).find("button").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')

            let formData = new Object; //prepare data for sending
            $(form).find("input").each(function(){
                var name = $(this).attr("id")
                var value = $(this).val()
                formData[name] = value
            });
            $(form).find("select").each(function(){
                var name = $(this).attr("id")
                var value = $(this).val()
                formData[name] = value
            });
            
            axios({ //ajax request
                method: 'post',
                  url: form.action,
                  data: formData
                })
                .then(function (response) {
                  if (response.data) {
                    toast("Information saved") //feedback
                    $(form).find("button").html(buttonText) //enable submit button
                    $(form).find("button").prop("disabled", false)
                  }
                })
                .catch(function (error) {
                  console.log(error);
            });
        }, false)
    })

});



