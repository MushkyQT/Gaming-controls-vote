<div class="container mt-5">
    <div class="row justify-content-center">
        <form class="signUpForm" method="post">
            <div class="form-group">
                <label for="signUpUsername">Username</label>
                <input type="text" name="signUpUsername" id="signUpUsername" placeholder="Username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="signUpEmail">E-mail</label>
                <input type="email" name="signUpEmail" id="signUpEmail" placeholder="E-mail" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="signUpPassword">Password</label>
                <input type="password" name="signUpPassword" id="signUpPassword" placeholder="Password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="signUpPasswordConfirm">Confirm password</label>
                <input type="password" name="signUpPasswordConfirm" id="signUpPasswordConfirm" placeholder="Confirm password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="signMeUp" class="btn lightOrange">Sign me up!</button>
            </div>
        </form>
    </div>
</div>