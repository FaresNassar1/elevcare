import {Formio} from 'formiojs';

import '../css/form-builder.css';

window.onload = function () {
    window.Formio = Formio;
};

document.addEventListener("DOMContentLoaded", function () {
    var dynamicCodes = findAllDynamicCodes();
    if (dynamicCodes.length > 0) {
        var bootstrapIconsLink = document.createElement('link');
        bootstrapIconsLink.rel = 'stylesheet';
        bootstrapIconsLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css';
        document.head.appendChild(bootstrapIconsLink);

        var bootstrapCSSLink = document.createElement('link');
        bootstrapCSSLink.rel = 'stylesheet';
        bootstrapCSSLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css';
        document.head.appendChild(bootstrapCSSLink);
    }
    setDiv();
    dynamicCodes.forEach(function (dynamicCode) {
        if (dynamicCode) {
            renderPage(dynamicCode);
        }
    });

    function setDiv() {
        dynamicCodes.forEach(function (dynamicCode) {
            const formioElement = document.createElement('div');
            formioElement.id = 'formio' + dynamicCode.id;
            let htmlContent = document.getElementById('content-form-builder') || document.getElementById('content-form-builder-' + dynamicCode.id);
            let newHtmlContent = htmlContent.innerHTML = htmlContent.innerHTML.replace(dynamicCode
                    .fullCode,
                formioElement
                    .outerHTML);
            htmlContent.innerHTML = newHtmlContent;

        });
    }

    async function renderPage(dynamicCode) {
        try {
            const response = await fetch(`/get-form/${dynamicCode.id}`);

            if (response.ok) {
                const formDefinitionArray = await response.json();
                const formDefinitionArrayStructure = JSON.parse(formDefinitionArray.form_definition);
                let formioElementDiv = document.getElementById('formio' + dynamicCode.id);

                await Formio.createForm(formioElementDiv, {
                    components: formDefinitionArrayStructure
                }, {
                    language: document.documentElement.getAttribute('lang'),
                    i18n: JSON.parse(formDefinitionArray.langJson)
                }).then((form) => {
                    form.on('submit', function (submission) {
                        // submission, form._form.components,
                        return Formio.fetch('save-form-submission', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json' // Specify the Accept header

                            },
                            body: JSON.stringify({
                                submission: submission,//form._form.components,
                                currentLocale: window.currentLocale,
                                dynamicCode: dynamicCode
                            }),
                        }).then(function (response) {
                            var formioId = 'formio' + dynamicCode.id;

                            if (!response.ok) {
                                return response.json().then(function (data) {
                                    var errorListDiv = document.getElementById('error-list-' + formioId);
                                    if (errorListDiv) {
                                        errorListDiv.parentNode.removeChild(errorListDiv);
                                    }
                                    var alertDiv = document.createElement('div');
                                    alertDiv.className = 'alert alert-danger';
                                    alertDiv.id = 'error-list-' + formioId; // Assuming formioId is defined
                                    var alertContent = '<p>Please fix the following errors before submitting.</p><ul>';
                                    Object.keys(data.errors).forEach(function (key) {
                                        alertContent += '<li><span data-component-key="' + key + '" ref="errorRef" tabindex="0" role="link">' + data.errors[key] + '</span></li>';
                                    });
                                    alertContent += '</ul>';
                                    alertDiv.innerHTML = alertContent;
                                    var formioContainer = document.getElementById(formioId); // Assuming the form container id starts with 'formio'
                                    formioContainer.insertBefore(alertDiv, formioContainer.firstChild);

                                });

                            } else {
                                var errorListDiv = document.getElementById('error-list-' + formioId);
                                if (errorListDiv) {
                                    errorListDiv.parentNode.removeChild(errorListDiv);
                                }
                                form.emit('resetForm')
                                form.emit('submitDone', submission)
                                response.json()
                            }
                        })
                    });


                }).catch((error) => {
                    console.error('Error creating form:', error);
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function findAllDynamicCodes() {
        var regex = /formBuilder2Yy#(\d+)!!/;
        var htmlContent = document.body.innerHTML;
        var matches = Array.from(htmlContent.matchAll(new RegExp(regex, 'g')));
        var dynamicCodes = [];

        for (const match of matches) {
            dynamicCodes.push({
                fullCode: match[0],
                id: match[1]
            });
        }
        return dynamicCodes;
    }
});
