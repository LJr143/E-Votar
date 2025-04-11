<div class="w-full mt-0.5">
    <style>
        .iti input {
            color: #5D5D5D;
            border-color: #D9D9D9;
            padding-left: 48px !important;
            width: 100%;
        }
    </style>
    <label for="phone" class="sr-only">Phone</label>
    <input x-data="
                    {
                        input: document.getElementById('phone'),
                        phone: null,
                        validate:
                        function(input, phone) {
                            if (input.value.trim() === '') {
                                input.style.borderColor = 'rgb(239 68 68)';
                                input.setCustomValidity('Please enter your phone number.');
                                input.reportValidity();
                            }
                            else {
                                if (phone.isValidNumber()) {
                                    input.style.borderColor = 'rgb(97 255 189)';
                                    phone.setNumber(phone.getNumber());
                                    input.setCustomValidity('');
                                    input.reportValidity();
                                } else {
                                    input.style.borderColor = 'rgb(239 68 68)';
                                    input.setCustomValidity('Please enter a valid phone number.');
                                    input.reportValidity();
                                }
                            }
                        }
                    }
               " x-init="
                    phone =
                    intlTelInput(input, {
                            formatOnDisplay: false,
                            initialCountry: 'ph',
                            nationalMode: true,
                            geoIpLookup: function(callback) {
                                $.get('https://ipinfo.io', function() {}, 'jsonp').always(function(resp) {
                                    let countryCode = (resp && resp.country) ? resp.country : 'ph';
                                    callback(countryCode);
                                });
                            },
                            utilsScript: intlTelInput.utils
                    });

                    input.addEventListener('change', function() {
                        validate(input, phone);
                    });

                    input.addEventListener('keyup', function() {
                        validate(input, phone);
                    });

                    input.addEventListener('click', function() {
                        validate(input, phone);
                    });
               " placeholder="09*******38" id="phone" type="tel" required {!! $attributes->merge(['class' => '!ring-0']) !!}
    />
</div>
