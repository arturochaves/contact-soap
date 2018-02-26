
$(document).ready(function () {
    //Add contact
    $('.contactForm').validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                minlength: 6,
                maxlength: 15,
                digits: true
            },
            address: {
                required: true,
                minlength: 3,
            }
        },
        submitHandler: function () { //form validated        
            $(".resultDiv").html($(".loading").html());
            var data = $('.contactForm').serializeArray();
            data.push({ name: 'type', value: 'add' });
            $.post("setcontact", data).done(function (result) {  
                if (result) {
                    $(".contactForm input[type='text']").val('');
                    $(".resultDiv").html('<span class="messages mvalid">Your contact has been added.</span>');
                } else {
                    $(".resultDiv").html('<span class="messages">SERVER ERROR when adding.</span>');
                }
            });
            return false;
        }

    });

    //show all
    $(".contentDiv").on("click", ".allSubmit", function () {
        $(".resultDiv").html($(".loading").html());
        var data = $('.searchForm').serializeArray();
        data.push({ name: 'type', value: 'search' });
        $.post("setcontact", { type: "all" }).done(function (result) {
            var resultsJ = $.parseJSON(result);
            if (!$.isEmptyObject(resultsJ)) {
                $(".resultDiv").html('');
                $.each(resultsJ, function (idx, field) {
                    $(".resultDiv").append("<div class='result'>" +
                        "<form id='contact_" + field.id + "'><span>name</span> <input type=\"text\" value=\"" + field.name + "\" name=\"name\" />" +
                        "<input type=\"hidden\" name=\"id\" value=\"" + field.id + "\" />" +
                        "<span>email</span> <input type=\"text\" value=\"" + field.email + "\" name=\"email\" />" +
                        "<span>phone</span> <input type=\"text\" value=\"" + field.phone + "\" name=\"phone\" />" +
                        "<span>address</span> <input type=\"text\" value=\"" + field.address + "\" name=\"address\" />" +
                        "<br><input type=\"submit\" value=\"update\" class=\"updateForm\" />" +
                        "<input type=\"button\" value=\"delete\" class=\"deleteForm\" />" +
                        "</form><span class=\"resultminiDiv\"></span></div>");
                    validateAndUpate(field.id);
                });

            } else {
                $(".resultDiv").html('<span class="messages">Your list of contacts is empty.</span>');
            }
        });

    });

    //search contact    
    $('.searchForm').validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function () { //form validated
            $(".resultDiv").html($(".loading").html());
            var data = $('.searchForm').serializeArray();
            data.push({ name: 'type', value: 'search' });
            $.post("setcontact", data).done(function (result) {
                var resultsJ = $.parseJSON(result);
                if (!$.isEmptyObject(resultsJ)) {
                    $(".resultDiv").html('');
                    var error = false;
                    $.each(resultsJ, function (idx, field) {

                        if (idx == "Error") {
                            error = true;
                            return false;
                        }
                        $(".resultDiv").append("<div class='result'>" +
                            "<form id='contact_" + field.id + "'><span>name</span> <input type=\"text\" value=\"" + field.name + "\" name=\"name\" />" +
                            "<input type=\"hidden\" name=\"id\" value=\"" + field.id + "\" />" +
                            "<span>email</span> <input type=\"text\" value=\"" + field.email + "\" name=\"email\" />" +
                            "<span>phone</span> <input type=\"text\" value=\"" + field.phone + "\" name=\"phone\" />" +
                            "<span>address</span> <input type=\"text\" value=\"" + field.address + "\" name=\"address\" />" +
                            "<br><input type=\"submit\" value=\"update\" class=\"updateForm\" />" +
                            "<input type=\"button\" value=\"delete\" class=\"deleteForm\" />" +
                            "</form><span class=\"resultminiDiv\"></span></div>");
                        validateAndUpate(field.id);
                    });
                    if (error) {
                        $(".resultDiv").html('<span class="messages">SERVER ERROR when searching.</span>');
                    }


                } else {
                    $(".resultDiv").html('<span class="messages">There is no contacts with that name.</span>');
                }
            });
            return false;
        }

    });

    //delete contact
    $(".resultDiv").on("click", ".deleteForm", function () {
        var form = $(this).parent('form');
        if (confirm("Are you sure you want to delete the contact of '" + form.children('input[name="name"]').val() + "'?")) {
            form.next(".resultminiDiv").html($(".loading").html());
            var data = form.serializeArray();
            data.push({ name: 'type', value: 'delete' });
            $.post("setcontact", data).done(function (result) {     
                if (result) {
                    form.html('');
                    form.next(".resultminiDiv").html('<span class="messages" style="padding-top:0;">This contact has been deleted.</span>');
                } else {
                    form.next(".resultminiDiv").html('<span class="messages">SERVER ERROR when deleting.</span>');
                }
            });
        }

    });

});

//update contact
function validateAndUpate(fieldId) {
    $("#contact_" + fieldId).validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                minlength: 6,
                maxlength: 15,
                digits: true
            },
            address: {
                required: true,
                minlength: 3,
            }
        },
        submitHandler: function () { //form validated            
            var form = $("#contact_" + fieldId);
            form.next(".resultminiDiv").html($(".loading").html());
            var data = form.serializeArray();
            data.push({ name: 'type', value: 'update' });
            $.post("setcontact", data).done(function (result) {
                if (result) {
                    form.next(".resultminiDiv").html('<span class="messages mvalid">Your contact has been update.</span>');    
                } else {
                    form.next(".resultminiDiv").html('<span class="messages">SERVER ERROR when updating.</span>');
                }
            });

            return false;
        }

    });
}