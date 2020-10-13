<div  class="ls-user-modal modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="ls-user-modal-container">
        <ul class="liststyle--none ls-switcher">
            <li><a href="javascript:void(0)">Sign-in</a></li>
            <li><a href="javascript:void(0)">New account</a></li>
        </ul>
        <div class="clearfix"></div>

        <div id="ls-login"> <!-- log in form -->
            <form class="ls-form">
                <p class="fieldset">
                    <label class="image-replace ls-email" for="signin-email"><i class="far fa-envelope"></i></label>
                    <input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="E-mail" required="required">
                </p>

                <p class="fieldset">
                    <label class="image-replace ls-password" for="signin-password"><i class="fas fa-key"></i></label>
                    <input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="Password" required="required">
                    <a href="javascript:void(0)" class="hide-password">Hide</a>
                </p>

                <p class="fieldset flex-align">
                    <input type="checkbox" id="remember-me" checked>
                    <label for="remember-me" style="margin-bottom: 0">Remember me</label>
                </p>

                <p class="fieldset">
                    <input class="full-width" type="submit" value="Login">
                </p>
            </form>
            <section class="or">
                <span>OR</span>
            </section>
            <section class="external_login">
                <div class="row">
                    <div class="col-md-6">
                       <button class="facebook--button"><i class="fab fa-facebook-f fa-2x" style="margin-right: 10px"></i>Facebook</button>
                    </div>
                    <div class="col-md-6">
                        <button class="google--button"><i class="fab fa-google fa-2x" style="margin-right: 10px"></i>Google</button>
                    </div>
                </div>

            </section>
            <p class="ls-form-bottom-message"><a href="javascript:void(0)">Forgot your password?</a></p>
            <!-- <a href="javascript:void(0)" class="ls-close-form">Close</a> -->
        </div> <!-- ls-login -->

        <div id="ls-signup"> <!-- sign up form -->
            <section class="external_login">
                <div class="row">
                    <div class="col-md-6">
                        <button class="facebook--button"><i class="fab fa-facebook-f fa-2x" style="margin-right: 10px"></i>Login with Facebook</button>
                    </div>
                    <div class="col-md-6">
                        <button class="google--button"><i class="fab fa-google fa-2x" style="margin-right: 10px"></i>Login with Google</button>
                    </div>
                </div>

            </section>
            <section class="or">
                <span>OR</span>
            </section>
            <form class="ls-form">
                <p class="fieldset">
                    <label class="image-replace ls-username" for="signup-username"><i class="fas fa-user"></i></label>
                    <input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Username" required="required">
                </p>

                <p class="fieldset">
                    <label class="image-replace ls-email" for="signup-email"><i class="far fa-envelope"></i></label>
                    <input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail" required="required">
                </p>

                <p class="fieldset">
                    <label class="image-replace ls-password" for="signup-password"><i class="fas fa-key"></i></label>
                    <input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Password" required="required">
                    <a href="javascript:void(0)" class="hide-password">Hide</a>
                </p>

                <p class="fieldset flex-align" >
                    <input type="checkbox" id="accept-terms">
                    <label for="accept-terms" style="margin-bottom: 0">I agree to the <a href="javascript:void(0)">Terms</a></label>
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Create account">
                </p>
            </form>

            <a href="javascript:void(0)" class="ls-close-form">Close</a>
        </div> <!-- ls-signup -->

        <div id="ls-reset-password"> <!-- reset password form -->
            <p class="ls-form-message">
                Lost your password? Please enter your email address. You will receive a link to create a new password.
            </p>

            <form class="ls-form">
                <p class="fieldset">
                    <label class="image-replace ls-email" for="reset-email"><i class="far fa-envelope"></i></label>
                    <input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
                    <span class="ls-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" value="Reset password">
                </p>
            </form>

            <p class="ls-form-bottom-message"><a href="javascript:void(0)">Back to log-in</a></p>
        </div> <!-- ls-reset-password -->
        
    </div>
</div>