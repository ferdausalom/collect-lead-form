<div class="cl-wrapper my-4 mx-auto">

    <div class="success cl-hidden mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
        <div class="flex p-3 cl-align-center cl-relative">
            <svg aria-hidden="true" class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="normal-case message"></div>
            <div class="cl-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="m8.464 15.535l7.072-7.07m-7.072 0l7.072 7.07" />
                </svg>
            </div>
        </div>
    </div>

    <div class="error cl-hidden">
        <div class="flex p-3 cl-align-center cl-relative mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg aria-hidden="true" class="inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="normal-case err-message"></div>
            <div class="cl-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="m8.464 15.535l7.072-7.07m-7.072 0l7.072 7.07" />
                </svg>
            </div>
        </div>
    </div>

    <form id="cl-lead-form" class="border border-gray-200 mt-4 rounded shadow-md w-full" autocomplete="off">
        <?php esc_html(wp_nonce_field('wp_rest')); ?>
        <div class="cl-mb-6">
            <label class="block normal-case text-gray-600 font-medium mb-2">Name <span class="text-red-500">*</span></label>
            <input name="name" id="name" type="text" placeholder="Name" class="rounded border border-1 border-gray-300 focus:border-indigo-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 cl-px-3 cl-py-3 rounded-md shadow-sm w-full">
            <p id="name_err" class="normal-case text-red-500 text-error italic error mt-2"></p>
        </div>

        <div class="cl-mb-6">
            <label class="block normal-case text-gray-600 font-medium mb-2 mt-4">Email <span class="text-red-500">*</span></label>
            <input name="email" id="email" type="email" placeholder="Email" class="rounded border border-1 border-gray-300 focus:border-indigo-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 cl-px-3 cl-py-3 rounded-md shadow-sm w-full">
            <p id="email_err" class="normal-case text-red-500 text-error italic error mt-2"></p>
        </div>

        <div class="cl-mb-6">
            <label for="message" class="block normal-case mb-2 font-medium text-gray-600">Your message</label>
            <textarea name="message" id="message" rows="6" class="py-2 rounded border border-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50 cl-px-3 rounded-md shadow-sm w-full" placeholder="Write your thoughts here..."></textarea>
        </div>

        <button type="submit" class="btn-grad bg-gradient-to-r dark:focus:ring-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-300 font-medium from-teal-400 hover:bg-gradient-to-br mb-2 mr-2 px-6 cl-py-3 rounded-md text-center text-white to-teal-600 via-teal-500">Submit</button>

        <div class="cl-loader-spinner">
            <img src="<?php echo CLCF__PLUGIN_URL; ?>assets/img/balls-line.gif" alt="Loading...">
        </div>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {

        $("#name").on("input", function() {
            checkName();
        });

        $("#email").on("input", function() {
            checkEmail();
        });

        function checkName() {
            const pattern = /^[A-Za-z0-9_ -]+$/;
            const name = $("#name").val();
            const validname = pattern.test(name);
            if (name == "") {
                $("#name_err").html("Name is required.");
                return false;
            } else if ($("#name").val().length < 4) {
                $("#name_err").html("Name length is too short.");
                return false;
            } else if (!validname) {
                $("#name_err").html("Name should be a-z or 0-9 only.");
                return false;
            } else {
                $("#name_err").html("");
                return true;
            }
        }

        function checkEmail() {
            const pattern1 = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            const email = $("#email").val();
            const validemail = pattern1.test(email);
            if (email == "") {
                $("#email_err").html("Email is required.");
                return false;
            } else if (email.length < 8) {
                $("#email_err").html("Email length is too short.");
                return false;
            } else if (!validemail) {
                $("#email_err").html("Invalid email.");
                return false;
            } else {
                $("#email_err").html("");
                return true;
            }
        }

        $("#cl-lead-form").submit(function(e) {

            e.preventDefault();
            $(".error").fadeOut();
            $(".success").fadeOut();

            if (!checkName() || !checkEmail()) {
                $(".error").fadeIn();
                $(".err-message").html('Please fill all required fields.').fadeIn();
            } else {

                const form = $(this).serialize();

                $.ajax({
                    method: "post",
                    url: "<?php echo esc_url(get_rest_url(null, 'clcf/v1/collect-lead-form')); ?>",
                    data: form,
                    beforeSend: function() {
                        $(".cl-loader-spinner").fadeIn(800);
                    },
                    success: function(res) {
                        if (res.success) {
                            $(".error").slideUp();
                            $("#name").val('');
                            $("#email").val('');
                            $("#message").val('');
                            $(".cl-loader-spinner").slideUp(800);
                            $(".success").slideDown(800);
                            $(".message").html(res.message).slideDown(800);
                        } else {
                            $(".success").slideUp();
                            $(".cl-loader-spinner").slideUp(800);
                            $(".error").slideDown(800);
                            $(".err-message").html(res.message).slideDown(800);
                        }

                    }
                });
            }
        });

        $(document).on('click', '.cl-close', function() {
            $('.error').slideUp();
            $('.success').slideUp();
        });
    });
</script>