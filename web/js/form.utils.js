// @see https://www.bibekoli.com/tools/js-packer.html
// @see http://dean.edwards.name/packer/
let SimpleFormUtils = {
    showValidationError: function (id, message) {
        this.hideValidationErorr(id);
        jQuery('<div/>', {
            class: 'alert alert-danger',
            role: 'alert'
        })
            .html(message)
            .appendTo('#' + id + ' + p');
    },
    hideValidationErorr: function (id) {
        jQuery('#' + id + ' + p').html('');
    },
    aproveCorectness: function (id) {
        jQuery('#' + id)
            .addClass('is-valid')
            .removeClass('is-invalid');
    },
    disproveCorectness: function (id) {
        jQuery('#' + id)
            .addClass('is-invalid')
            .removeClass('is-valid');
    },
    validateEmail: function (email) {
        //https://www.w3.org/TR/html5/forms.html#valid-e-mail-address
        const re = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        return re.test(email);
    },
    validatePassword: function (password) {
        const re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
        return re.test(password);
    }
};
