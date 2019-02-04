function showValidationError(id, message) {
    hideValidationErorr(id);

    jQuery('<div/>', {
        "class": "alert alert-danger",
        "role": "alert"
    })
        .html(message)
        .appendTo("#" + id + " + p");
};

function hideValidationErorr(id) {
    jQuery("#" + id + " + p").html("");
};

function aproveCorectness(id) {
    jQuery("#" + id)
        .addClass("is-valid")
        .removeClass("is-invalid");
};

function disproveCorectness(id) {
    jQuery("#" + id)
        .addClass("is-invalid")
        .removeClass("is-valid");
};

function validateEmail(email) {
    //https://www.w3.org/TR/html5/forms.html#valid-e-mail-address
    var re = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

    return re.test(email);
};

function validatePassword(password)
{
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;

    return re.test(password);
};
