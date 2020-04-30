// Extend the array class to merge associative array
Array.prototype.merge = (obj, src) => {
    for(var key in src) {
        if(src.hasOwnProperty(key)) obj[key] = src[key];
    }
    return obj;
};

// Helper functions to get elements from the form
const by_id = (id) => {
    return document.getElementById(id);
};

// Hide all the form input error labels
const hideErrors = (el) => {
    el.classList.remove('error');
    let label = el.labels[0];
    let error = label.getElementsByClassName('errorLabel')[0];

    error.innerHTML = '';
    error.style.display = "none";
};

// Show a specific error label
const showErrors = (el, msg) => {
    el.classList.add('error');
    let label = el.labels[0];
    let error = label.getElementsByClassName('errorLabel')[0];

    error.innerHTML = msg;
    error.style.display = "inline-block";
};


// show errors from the api
const reportWS3Errors = (msg, class_name = false) => {

    // report error to google analytics
    console.log(msg);
};



// Test the validity of a specific element
// and display or hide its error message
const validityTest = (e) => {
    let result = Validator.validateField(e.target);

    if(result.valid) {
        hideErrors(e.target);
        return false;
    } else {
        showErrors(e.target, result.message);
        return true;
    }
};

// Parses the 'full name' field into first and last
// names by trying to identify name 'parts'.  The logic
// is as follows:
//
// If there is one space, split upon the space, the resulting
// two entries are first and last name respectively.
//
// If there are no spaces the name field is taken wholesale and
// used as the first name, and last name is set to null.
//
// If there are more than one space, the first space is split upon and
// all subsequent name parts are set as the last name.
//
const parseNameField = (fieldName) => {

    // extract the value of the full name field
    let name = by_id(fieldName);

    if(name.value) {
        name = name.value.trim();
    } else {
        name = '';
    }

    // An error ocurred and we could not
    // find the supplied input field by id <fieldName>
    if(!name) {
        return {
            "firstName": '',
            "lastName": '',
        };
    } else {

        // if there are no spaces, return the
        // value as the first name with a null last name
        if(!/\s/.test(name)) {
            return {
                "firstName": name,
                "lastName": ''
            };
        } else {
            // There is at least once space, so let's split on them.
            let names = name.split(' '),
                firstName = names[0],
                lastName = names[1];

            // two names: names.length == 2
            // three names:names.length == 3
            /// names[0] = firstname
            // names[1-n] = lastname
            if(names.length > 2) {
                let lastNameParts = [];

                // Slice off the last parts of the name
                // from the array the rejoin them by
                // themselves as a string with spaces
                lastNameParts = names.slice(1);
                lastName = lastNameParts.join(' ');
            }

            return {
                "firstName": firstName,
                "lastName": lastName
            };
        }
    }
};


const post = (payload, cb) => {
    // remove html success message
    delete payload['SuccessMessage'];

    // Turn the payload (object) into a querystring
    let qs = Object.keys(payload).map(function(key) {
        return key + '=' + payload[key];
    }).join('&');

    // The payload is going to be sent as a querystring 
    // called payload as a json object.
    // 
    // The WP.leadProxy js variable is set in the 
    // plugin's enqueue scripts section.
    let url = `${WP.leadProxy}?${qs}`;


    // Use the emergency fallback
    let xhr = createCORSRequest("POST", url);

    xhr.send();

    xhr.onerror = (e) => {
        reportWS3Errors(`Oops, there was an error: ${JSON.stringify(e)}`);

        if(e.isTrusted) {
            reportWS3Errors(
                `Likely a cross domain origin problem won't
                let us save your information.
                Please try again later.`
            );
            console.log(e);
            // return; don't stop!
        }
    };

    /*
         WS3 API Response

         This is where we handle the results 
         of posting the inquiry.

         We will also track the results of the response
         to Google Analytics with high priority.
     */
    xhr.onload = (r) => {
        // get form container
        let container = window.submitedForm.parentNode;

        // hide spinner
        container.classList.remove('loading');

        // Grab the response and parse it into json
        // them quickly grab the
        let response = JSON.parse(xhr.response.trim()),
            has_errors = response.Errors && response.Errors.length > 0,
            accepted = response.IsLeadAccepted;

        // A server error happened.  This is
        // usually something like a timeout.  It 
        // is also thrown when an upstream server 
        // responds with an error message.  This 
        // specific type of message does not contain
        // the full json payload, but a completely different
        // object with one property, .message.
        if(response.message && typeof response.message != 'undefined') {
            reportWS3Errors(response.message);
            // return;
        }


        try {

            // Send GA events
            track(xhr.status, response);

        } catch (e) {

            console.log(e);

        }

        // We don't count duplicates as 'errrors' in the traditional sense.
        if(has_errors && response.Errors[0].Key != "Duplicate") {
            if(response.Errors[0].Value && typeof response.Errors[0].Value != 'undefined') {
                reportWS3Errors(JSON.stringify(response.Errors[0].Value));
                //return;
            }
        }

        // When we pass the user to the redirect page
        // we indicate whether this was a duplicate
        //if (has_errors && response.Errors[0].Key == "Duplicate") {
        // console.log( 'duplicate' );
        //} 


        // set pricing cookie with every successful lead submission
        setCookie('showPricing', 1, 43200);

        // The lead was successful
        if((typeof window.lighthouse_cptparams[window.submitedFormId]["SuccessMessage"] != 'undefined') && window.lighthouse_cptparams[window.submitedFormId]["SuccessMessage"]) {
            // show message instead of form

            // create new message node
            let message = window.lighthouse_cptparams[window.submitedFormId]['SuccessMessage'];

            // add spinner if necessary
            if((typeof window.lighthouse_cptparams[window.submitedFormId]["RedirectUrl"] != 'undefined') && window.lighthouse_cptparams[window.submitedFormId]["RedirectUrl"]) {
                message = message + '<div style="text-align:center">Redirecting please wait...<div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>';
            }

            let messageContainer = document.createElement('div');
            messageContainer.classList.add('success-message');
            messageContainer.innerHTML = message;

            // remove form and add new child
            container.removeChild(window.submitedForm);
            container.appendChild(messageContainer);
        }

        // redirect if required
        if((typeof window.lighthouse_cptparams[window.submitedFormId]["RedirectUrl"] != 'undefined') && window.lighthouse_cptparams[window.submitedFormId]["RedirectUrl"]) {
            let new_location = window.lighthouse_cptparams[window.submitedFormId]["RedirectUrl"];

            // if not complete url
            if(new_location.indexOf('http') != 0) {

                // if not slug with starting slash add slash
                if(new_location.indexOf('/') != 0) {
                    new_location = '/' + new_location;
                }
            }

            // redirect after specified timer
            let timer = window.lighthouse_cptparams[window.submitedFormId]['RedirectTimer'] ? window.lighthouse_cptparams[window.submitedFormId]['RedirectTimer'] : 5;

            setTimeout(function() {
                document.location = new_location;
            }, timer * 1000);
        }
    };
};

const initAutocomplete = () => {
    // restrict Autocomplete geo location
    // window.apfmAutocompletes = [];
    let options = {
        types: ['geocode'],
        componentRestrictions: {
            country: ["us", "ca"]
        }
    };

    // Get all the form input fields.
    const inputs = document.getElementsByClassName('locationField');

    // Wire up the events we'll use to trigger validation
    for(let i = 0; i < inputs.length; i++) {
        let lfp = inputs[i];

        let tmp_autocomplete = new google.maps.places.Autocomplete( /** @type {HTMLInputElement} */ (lfp), options);

        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        tmp_autocomplete.setFields(['address_component', 'geometry']);

        // bind to event change
        google.maps.event.addListener(tmp_autocomplete, 'place_changed', function() {
            // Get the place details from the autocomplete object.
            var place = this.getPlace();
            fillInAddress(place, lfp);
        });

        // let newsize = window.apfmAutocompletes.push(tmp_autocomplete);
        // let index = newsize-1;
    }
};

const getAddressComponent = (cmpts) => {
    let values = {};
    for(let i = 0; i < cmpts.length; i++) {
        if(cmpts[i].types && cmpts[i].types.includes('administrative_area_level_1')) {
            values.state = cmpts[i].short_name;
            values.state_long = cmpts[i].long_name;
        }
        if(cmpts[i].types && cmpts[i].types.includes('locality')) {
            values.city = cmpts[i].long_name;
        }
        if(cmpts[i].types && cmpts[i].types.includes('postal_code')) {
            values.zip = cmpts[i].long_name;
        }
        if(cmpts[i].types && cmpts[i].types.includes('country')) {
            values.country = cmpts[i].short_name;
        }
    }

    return values;
};

const fillInAddress = (place, targetInput) => {
    let parent_form = targetInput.form;

    // check if actual address was selected
    if(place && typeof place.address_components != 'undefined') {
        // mark field was filled with google api
        window.geocompleted = true;

        let locality = getAddressComponent(place.address_components);

        let fields = parent_form.getElementsByTagName('input');
        for(let i = 0; i < fields.length; i++) {
            let field = fields[i];

            if(field.name === 'DesiredCity') {
                field.value = locality.city;
            } else if(field.name === 'DesiredState') {
                field.value = locality.state;
            } else if(field.name === 'DesiredZip') {
                if(typeof locality.zip != 'undefined') {
                    field.value = locality.zip;
                }
            } else if(field.name === 'lat') {
                field.value = place.geometry.location.lat();
            } else if(field.name === 'lng') {
                field.value = place.geometry.location.lng();
            } else if(field.name === 'DesiredCountry') {
                field.value = locality.country;
            }
        }
    } else {
        if(targetInput.value) {
            // field was entered manually
            window.geocompleted = false;

            let address_string = targetInput.value.trim();

            // extract zip
            const regex = /((\d{5}-\d{4})|(\d{5})|([A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d))/gm;
            let zip = '';
            if(address_string.match(regex)) {
                let reg = regex.exec(address_string);
                // get full match
                zip = reg[0];

                // remove zip and trailing spaces
                address_string = address_string.replace(zip, '');
                address_string = address_string.trim();
            }

            let city = '',
                state = '';
            if(address_string) {
                // extract city and state
                let parts = address_string.split(',');

                city = parts[0].trim();

                if(parts.length > 1) {
                    state = parts[1].trim();
                }
            }

            // fill in the hidden fields
            let fields = parent_form.getElementsByTagName('input');

            for(let i = 0; i < fields.length; i++) {
                let field = fields[i];

                if(field.name === 'DesiredCity') {
                    field.value = city;
                } else if(field.name === 'DesiredState') {
                    field.value = state;
                } else if(field.name === 'DesiredZip') {
                    field.value = zip;
                }
            }

            if(parent_form.parentNode.classList.contains('lighthouse-cpt-location-two-step')) {
                let step1 = parent_form.getElementsByClassName('step1')[0];
                let step2 = parent_form.getElementsByClassName('step2')[0];

                step1.style.display = 'none';
                step2.style.display = 'block';
            }
        }
    }
};

const onSubmit = (e) => {
    // don't submit
    e.preventDefault();

    const frm = e.target;
    window.submitedForm = frm;
    window.submitedFormId = frm.dataset.nsFormid;

    frm.parentNode.classList.add('loading');

    if(frm == null) {
        console.log('No Lighthouse CPT form found on page.');
        return;
    }

    var payload = {};

    // form is dirty
    if(!frm.checkValidity()) return;

    // save cookies for form tracking
    let data_pa_formid = frm.dataset.paFormid;
    let data_pa_formtype = frm.dataset.paFormtype;
    let data_pa_techstack = frm.dataset.paTechstack;
    let data_pa_version = frm.dataset.paVersion;
    let form_location = window.lighthouse_cptparams[window.submitedFormId].form_location;

    setCookie('data-pa-formid', data_pa_formid, 3);
    setCookie('data-pa-formtype', data_pa_formtype, 3);
    setCookie('data-pa-techstack', data_pa_techstack, 3);
    setCookie('data-pa-version', data_pa_version, 3);
    setCookie('form-location', form_location, 3);

    var inputs = frm.getElementsByTagName('input');

    for(var i = 0; i < inputs.length; i++) {
        payload[inputs[i].name] = inputs[i].value;
    }

    // split up the name field and then assign the
    // form values to local variables

    if(window.lighthouse_cptparams[window.submitedFormId] && Array.isArray(window.lighthouse_cptparams[window.submitedFormId])) {
        payload = [].merge(payload, window.lighthouse_cptparams[window.submitedFormId]);
    }

    let name = parseNameField('leadFormFullname' + window.submitedFormId);

    payload['FirstName'] = name.firstName;
    payload['LastName'] = name.lastName;
    payload['GoogleClientId'] = getGAClientId();

    payload.xhr = true;
    post(payload);
};

const createCORSRequest = (method, url) => {

    var xhr = new XMLHttpRequest();
    if("withCredentials" in xhr) {

        // Check if the XMLHttpRequest object has a "withCredentials" property.
        // "withCredentials" only exists on XMLHTTPRequest2 objects.
        xhr.open(method, url, true);

    } else if(typeof XDomainRequest != "undefined") {

        // Otherwise, check if XDomainRequest.
        // XDomainRequest only exists in IE, and is IE's way of making CORS requests.
        xhr = new XDomainRequest();
        xhr.open(method, url);

    } else {

        // Otherwise, CORS is not supported by the browser.
        xhr = null;

    }
    return xhr;
};

const onLoad = () => {
    // init geocomplete state
    window.geocompleted = false;

    let forms = document.getElementsByClassName('LeadForm');

    if(forms == null) {
        console.log('Did not wire up. No form with the class "LeadForm" found.');
        return;
    }

    for(let i = 0; i < forms.length; i++) {
        let form = forms[i];

        form.addEventListener('submit', onSubmit);

        // Get all the form input fields.
        const inputs = form.getElementsByClassName('leadFormInput');

        // Wire up the events we'll use to trigger validation
        for(let i = 0; i < inputs.length; i++) {
            let lfp = inputs[i];

            // lfp.addEventListener('input', validityTest);
            lfp.addEventListener('blur', validityTest);
        }

        if(form.parentNode.classList.contains('lighthouse-cpt-location-two-step')) {
            // add move to step two listener on click
            form.getElementsByClassName('form-next')[0].addEventListener('click', function(e) {
                if(!window.geocompleted) {
                    let input = form.getElementsByClassName('locationField')[0];
                    fillInAddress(false, input);
                }

                let step1 = form.getElementsByClassName('step1')[0];
                let step2 = form.getElementsByClassName('step2')[0];

                step1.style.display = 'none';
                step2.style.display = 'block';
            });

            // add class to indicate js is enabled
            form.parentNode.classList.add('hasjs');
        }

    }

    initAutocomplete();
    masking.init();
};

// window.addEventListener('load', onLoad );
onLoad();